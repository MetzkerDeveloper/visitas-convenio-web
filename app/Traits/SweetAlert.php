<?php

namespace App\Traits;

trait SweetAlert
{
    public function success(string $text): void
    {
        $this->js("
        Swal.fire({
            text: '$text',
            icon: 'success',
            timer: 4000,
            buttonsStyling: true,
            confirmButtonText: 'Ok',
            customClass: {
            confirmButton: 'btn btn-primary'
        }
        });
    ");
    }

    public function error(string $text)
    {
        $this->js(
            "
              Swal.fire({
                    title: 'Atenção',
                    text: '$text',
                    icon: 'error',
                    buttonsStyling: true,
                    showConfirmButton: true,
                    confirmButtonText: 'Voltar',
                    confirmButtonColor: '#d33',
                    timer: 4000,
                    timerProgressBar: false,
                    allowOutsideClick: false,
                    didOpen: function (toast) {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                            window.location.href = window.location.href;
                        return;
                    }
                });
              "
        );
    }

}
