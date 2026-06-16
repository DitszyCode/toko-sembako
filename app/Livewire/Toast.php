<?php

namespace App\Livewire;

use Livewire\Component;

class Toast extends Component
{
    public $type = 'success';
    public $message = '';
    public $show = false;

    protected $listeners = [
        'showToast' => 'show',
        'hideToast' => 'hide',
    ];

    public function show($params)
    {
        $this->type = $params['type'] ?? 'success';
        $this->message = $params['message'] ?? '';
        $this->show = true;

        $this->dispatch('toastShown');

        $this->autoHide();
    }

    public function hide()
    {
        $this->show = false;
    }

    public function autoHide()
    {
        $this->dispatch('hideAfterDelay');
    }

    public function getTypeClassesProperty()
    {
        return match ($this->type) {
            'success' => 'bg-green-500 text-white',
            'error' => 'bg-red-500 text-white',
            'warning' => 'bg-yellow-500 text-white',
            'info' => 'bg-blue-500 text-white',
            default => 'bg-gray-800 text-white',
        };
    }

    public function getIconProperty()
    {
        return match ($this->type) {
            'success' => '✓',
            'error' => '✕',
            'warning' => '⚠',
            'info' => 'ℹ',
            default => '•',
        };
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
