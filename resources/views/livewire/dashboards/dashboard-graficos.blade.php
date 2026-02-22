<div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow h-[350px] transition-colors">
    <h3 class="font-semibold mb-4 text-gray-700 dark:text-gray-200">Visitas por Região</h3>

    <div wire:ignore>
        <canvas id="graficoVisitas"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@script
<script>
    let chart;

    const ctx = document.getElementById('graficoVisitas').getContext('2d');

    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Visitas',
                data: [],
                backgroundColor: [
                    '#3b82f6', // blue-500
                    '#10b981', // green-500
                    '#f59e42', // yellow-500
                    '#a78bfa', // purple-400
                    '#f87171', // red-400
                    '#fbbf24', // amber-400
                ],
                borderRadius: 8,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: document.documentElement.classList.contains('dark') ? '#d1d5db' : '#374151'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: document.documentElement.classList.contains('dark') ? '#d1d5db' : '#374151'
                    }
                }
            }
        }
    });

    $wire.on('graficoAtualizado', (event) => {
        chart.data.labels = event.labels;
        chart.data.datasets[0].data = event.dados;
        chart.update();
    });

    // Atualiza as cores dos ticks ao trocar o tema
    window.addEventListener('dark-mode-toggled', () => {
        chart.options.scales.x.ticks.color = document.documentElement.classList.contains('dark') ? '#d1d5db' : '#374151';
        chart.options.scales.y.ticks.color = document.documentElement.classList.contains('dark') ? '#d1d5db' : '#374151';
        chart.update();
    });
</script>
@endscript