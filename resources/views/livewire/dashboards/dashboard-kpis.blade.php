<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-white p-5 rounded-2xl shadow">
        <p class="text-gray-500 text-sm">Visitas</p>
        <h2 class="text-3xl font-bold mt-2">{{ $this->getVisitasHoje() }}</h2>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow">
        <p class="text-gray-500 text-sm">Média Mensal</p>
        <h2 class="text-2xl font-bold mt-2">{{ $this->getMediaMensalVisitas() }}</h2>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow">
        <p class="text-gray-500 text-sm">Tempo Médio / Visita</p>
        <h2 class="text-3xl font-bold mt-2">{{ $this->getTempoMedioVisita() }}</h2>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow">
        <p class="text-gray-500 text-sm">% Planejamento</p>
        <h2 class="text-3xl font-bold mt-2">{{ $this->getPercentualPlanejamento()}}</h2>
    </div>

</div>