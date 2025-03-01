<?php

namespace App\Traits;

use DateTime;

trait Functions
{
    private function validateVisitDate($visitDate)
    {
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
    
        // Se a data da visita for do mês passado, só bloqueia se hoje for maior que dia 5
        $previousMonth = $currentMonth - 1;
        $previousYear = $currentYear;
    
        if ($previousMonth === 0) {
            $previousMonth = 12;
            $previousYear--;
        }
    
        if ($visitMonth === $previousMonth && $visitYear === $previousYear) {
            return $currentDay <= 5; // Se for maior que dia 5, bloqueia, senão permite
        }
    
        
        return false;
    }
}