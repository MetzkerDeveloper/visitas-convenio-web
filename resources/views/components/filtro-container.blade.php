  @props([
    'title'
    ])

  <!-- Filtros -->
    <div  {{ $attributes->merge(['class' => 'relative mt-4 mb-4']) }} >
        <button id="dropdownButton" class="bg-blue-500 text-white px-4 py-2 rounded">
            {{$title}}
        </button>
        <div id="dropdownMenu" class="dropdown-content absolute mt-2 max-w-max bg-white border border-gray-200 rounded shadow-lg hidden">
            <div class="max-w-auto mx-auto sm:px-6 lg:px-8 mt-4">
                <div class="dark:bg-gray-800 sm:rounded-lg p-4">
                    <div class="flex flex-wrap gap-4 items-center">
                        {{$slot}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Seleciona o botão e o menu dropdown
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        // Adiciona um evento de clique ao botão
        dropdownButton.addEventListener('click', function() {
            // Alterna a visibilidade do menu dropdown
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });

        // Fecha o dropdown se clicar fora dele
        window.addEventListener('click', function(event) {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.style.display = 'none';
            }
        });
    </script>
