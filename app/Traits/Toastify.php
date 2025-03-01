<?php

namespace App\Traits;

trait Toastify
{
    public function success(string $text, $url = ''): void
    {
        $this->js("
            Toastify({
                text: '$text',
                duration: 4000,
                destination: '$url',
                gravity: 'top',
                position: 'right',
                backgroundColor: 'linear-gradient(to right, #96c93d, #96c93d)',
                stopOnFocus: true,
                close: true
            }).showToast();
    ");
    }

    public function error(string $text)
    {
        $this->js(
            "
            Toastify({
                text: '$text',
                duration: 4000,
                gravity: 'top',
                position: 'right',
                backgroundColor: 'linear-gradient(to right, #ff416c, #ff4b2b)',
                stopOnFocus: true,
                close: true
            }).showToast();
            "
        );
    }
}