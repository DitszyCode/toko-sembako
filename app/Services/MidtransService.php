<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class MidtransService
{
    protected $serverKey;
    protected $clientKey;
    protected $isProduction;
    protected $snapUrl;
    protected $apiUrl;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->clientKey = config('midtrans.client_key');
        $this->isProduction = config('midtrans.is_production', false);

        if ($this->isProduction) {
            $this->snapUrl = 'https://app.midtrans.com/snap/v1/transactions';
            $this->apiUrl = 'https://api.midtrans.com/v1';
        } else {
            $this->snapUrl = 'https://app.sandbox.midtrans.com/snap/v1/transactions';
            $this->apiUrl = 'https://api.sandbox.midtrans.com/v1';
        }
    }

    /**
     * Get client key for frontend
     */
    public function getClientKey(): string
    {
        return $this->clientKey;
    }

    /**
     * Check if production mode
     */
    public function isProduction(): bool
    {
        return $this->isProduction;
    }

    /**
     * Create Snap transaction
     */
    public function createTransaction(Order $order, array $items): array
    {
        $customer = $order->user;

        $transactionData = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->recipient_name,
                'email' => $customer ? $customer->email : 'guest@example.com',
                'phone' => $order->recipient_phone,
                'shipping_address' => [
                    'address' => $order->shipping_address,
                    'city' => 'Surabaya',
                    'postal_code' => '60173',
                    'country_code' => 'IDN',
                ],
            ],
            'item_details' => $this->formatItemDetails($items),
            'credit_card' => [
                'secure' => true,
            ],
            'callbacks' => [
                'finish' => route('checkout.finish', $order->id),
                'error' => route('checkout.error', $order->id),
                'unfinish' => route('checkout.unfinish', $order->id),
            ],
        ];

        return $this->sendRequest($transactionData);
    }

    /**
     * Format item details for Midtrans
     */
    protected function formatItemDetails(array $items): array
    {
        $formattedItems = [];

        foreach ($items as $item) {
            $formattedItems[] = [
                'id' => $item['product_id'] ?? Str::random(8),
                'price' => (int) $item['product_price'],
                'quantity' => (int) $item['quantity'],
                'name' => $item['product_name'],
            ];
        }

        // Add shipping as item if > 0
        $order = Order::where('order_number', request()->input('order_number') ?? '' )->first();
        if ($order && $order->total_amount > 500000) {
            $formattedItems[] = [
                'id' => 'SHIPPING',
                'price' => 0,
                'quantity' => 1,
                'name' => 'Pengiriman Gratis',
            ];
        }

        return $formattedItems;
    }

    /**
     * Send request to Midtrans API
     */
    protected function sendRequest(array $data): array
    {
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic ' . base64_encode($this->serverKey . ':'),
        ];

        $ch = curl_init($this->snapUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception('Midtrans API Error: ' . $error);
        }

        $result = json_decode($response, true);

        if ($httpCode != 201 && isset($result['error_messages'])) {
            throw new \Exception('Midtrans Error: ' . implode(', ', $result['error_messages']));
        }

        return $result;
    }

    /**
     * Get transaction status from Midtrans
     */
    public function getTransactionStatus(string $orderId): array
    {
        $headers = [
            'Accept: application/json',
            'Authorization: Basic ' . base64_encode($this->serverKey . ':'),
        ];

        $ch = curl_init($this->apiUrl . '/status/' . $orderId);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [
            'http_code' => $httpCode,
            'response' => json_decode($response, true),
        ];
    }

    /**
     * Handle payment notification from Midtrans
     */
    public function handleNotification(array $notification): array
    {
        $orderId = $notification['order_id'];
        $transactionStatus = $notification['transaction_status'];
        $fraudStatus = $notification['fraud_status'] ?? null;

        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            return ['success' => false, 'message' => 'Order not found'];
        }

        // Update payment status based on transaction status
        switch ($transactionStatus) {
            case 'capture':
                if ($fraudStatus == 'challenge') {
                    $order->payment_status = 'challenge';
                    $order->status = 'pending';
                } else if ($fraudStatus == 'accept') {
                    $order->payment_status = 'paid';
                    $order->status = 'processing';
                }
                break;

            case 'settlement':
                $order->payment_status = 'paid';
                $order->status = 'processing';
                break;

            case 'pending':
                $order->payment_status = 'pending';
                $order->status = 'pending';
                break;

            case 'deny':
                $order->payment_status = 'failed';
                $order->status = 'cancelled';
                break;

            case 'cancel':
            case 'expire':
                $order->payment_status = 'expired';
                $order->status = 'cancelled';
                break;

            case 'refund':
                $order->payment_status = 'refunded';
                $order->status = 'refunded';
                break;
        }

        $order->payment_method = $notification['payment_type'] ?? null;
        $order->save();

        return [
            'success' => true,
            'message' => 'Payment status updated',
            'order' => $order,
        ];
    }
}
