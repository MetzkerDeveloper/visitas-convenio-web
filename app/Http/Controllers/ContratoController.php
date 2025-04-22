<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

class ContratoController extends Controller
{
    public function gerarContratoPDF()
    {
        $pdf = Pdf::loadView('contrato');

        return $pdf->stream('contrato.pdf'); // Exibe no navegador
        // return $pdf->download('contrato.pdf'); // Para baixar o arquivo
    }
}
