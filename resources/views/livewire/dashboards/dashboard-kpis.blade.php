<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow flex flex-col items-center transition-colors">
        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Visitas</p>
        <h2 class="text-4xl font-bold mt-2 text-blue-600 dark:text-blue-400">{{ $this->getVisitasHoje() }}</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow flex flex-col items-center transition-colors">
        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Média Visitas</p>
        <h2 class="text-3xl font-bold mt-2 text-green-600 dark:text-green-400">{{ $this->getMediaVisitas() }}</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow flex flex-col items-center transition-colors">
        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Tempo Médio / Visita</p>
        <h2 class="text-4xl font-bold mt-2 text-purple-600 dark:text-purple-400">{{ $this->getTempoMedioVisita() }}</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow flex flex-col items-center transition-colors">
        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">% Planejamento</p>
        <h2 class="text-4xl font-bold mt-2 text-yellow-600 dark:text-yellow-400">{{ $this->getPercentualPlanejamento()}}</h2>
    </div>

</div>