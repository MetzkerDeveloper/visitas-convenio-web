<?php

namespace App\Traits;

use App\Models\Parametro;
use DateTime;
use Illuminate\Support\Facades\DB;

trait Functions
{


    private function validateVisitDate($visitDate)
    {
        $paramBloqDia = Parametro::where('id', '=', 2)->first();

        $visitDateTime = new DateTime($visitDate);
        $currentDateTime = new DateTime();
    
        $visitMonth = (int) $visitDateTime->format('m');
        $visitYear = (int) $visitDateTime->format('Y');
    
        $currentMonth = (int) $currentDateTime->format('m');
        $currentYear = (int) $currentDateTime->format('Y');
    
        $currentDay = (int) $currentDateTime->format('d');
        
        // BLOQUEIA se a data for de um mês futuro
        if ($visitYear > $currentYear || ($visitYear === $currentYear && $visitMonth > $currentMonth)) {
            return false;
        }
        
        // Se a data da visita for do mês atual, é válida
        if ($visitMonth === $currentMonth && $visitYear === $currentYear) {
            return true;
        }
    
        // Se a data da visita for do mês passado, só bloqueia Se for maior que dia determinado no parametro, senão permite
        $previousMonth = $currentMonth - 1;
        $previousYear = $currentYear;
    
        if ($previousMonth === 0) {
            $previousMonth = 12;
            $previousYear--;
        }
    
        if ($visitMonth === $previousMonth && $visitYear === $previousYear) {
            return $currentDay <= +$paramBloqDia->value; 
        }
    
        
        return false;
    }
}