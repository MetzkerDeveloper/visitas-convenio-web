<div class="bg-white p-6 rounded-2xl shadow h-[350px]">
    <h3 class="font-semibold mb-4">Visitas por Região</h3>

    <div wire:ignore>
        <canvas id="graficoVisitas"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@script
<script>
    let chart;

    const ctx = document.getElementById('graficoVisitas');

    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Visitas',
                data: [],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    $wire.on('graficoAtualizado', (event) => {
        chart.data.labels = event.labels;
        chart.data.datasets[0].data = event.dados;
        chart.update();
    });
</script>
@endscript