<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'link_type',
        'link_id',
        'is_active',
        'sort_order',
        'start_date',
        'end_date',
        'button_text',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Link type constants.
     */
    const LINK_TYPE_PRODUCT = 'product';
    const LINK_TYPE_CATEGORY = 'category';
    const LINK_TYPE_URL = 'url';

    /**
     * Scope a query to only include active banners.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include currently valid banners.
     */
    public function scopeValid($query)
    {
        $now = now();
        return $query
            ->where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', $now);
            });
    }

    /**
     * Scope a query to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Check if banner is currently valid based on dates.
     */
    public function isCurrentlyValid(): bool
    {
        $now = now();

        if ($this->start_date && $now < $this->start_date) {
            return false;
        }

        if ($this->end_date && $now > $this->end_date) {
            return false;
        }

        return $this->is_active;
    }

    /**
     * Get the link type label.
     */
    public function getLinkTypeLabelAttribute(): string
    {
        return match ($this->link_type) {
            self::LINK_TYPE_PRODUCT => 'Produk',
            self::LINK_TYPE_CATEGORY => 'Kategori',
            self::LINK_TYPE_URL => 'URL Eksternal',
            default => 'Tidak Ada',
        };
    }
}