<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function gerarContratoPDF()
    {
        $pdf = Pdf::loadView('contrato');
    
        return $pdf->stream('contrato.pdf'); // Exibe no navegador
        // return $pdf->download('contrato.pdf'); // Para baixar o arquivo
    }
}
