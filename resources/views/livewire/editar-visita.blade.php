<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Relatório de Visita') }}
            </h2>
            <button type="button" onclick="history.go(-1)" class="bg-blue-500 text-white py-2 px-4 rounded-md">Voltar</button>
        </div>
    </x-slot>

    {{-- @if ($visita->objetivo->id == 1)
    <x-filtro-container title="Ações">
        <!-- Gerar Contrato -->
        <div class="w-full sm:w-1/3">
            <button type="button" wire:click="pesquisar"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded-lg w-full sm:w-auto">
            Ligar Empresa
            </button>
        </div>
    </x-filtro-container>
    @endif --}}
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="promotor" :value="__('Promotor')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                            <p class="text-gray-700 dark:text-gray-300">{{ $visita->promotor->name }}</p>
                        </div>
                        <div>
                            <x-input-label for="regiao" :value="__('Região')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                            <p class="text-gray-700 dark:text-gray-300">{{ $visita->regiao->name }}</p>
                        </div>
                        <div>
                            <x-input-label for="data" :value="__('Data')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                            <p class="text-gray-700 dark:text-gray-300"> {{ \Carbon\Carbon::parse($visita->date)->format('d/m/Y') }} </p>
                        </div>
                        <div>
                            <x-input-label for="start_time" :value="__('Horário de Início')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                            <p class="text-gray-700 dark:text-gray-300">{{ $visita->start_time }}</p>
                        </div>
                        <div>
                            <x-input-label for="end_time" :value="__('Horário de Término')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                            <p class="text-gray-700 dark:text-gray-300">{{ $visita->end_time }}</p>
                        </div>
                        <div>
                            <x-input-label for="objetivo" :value="__('Objetivo')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                            <p class="text-gray-700 dark:text-gray-300">
                                @if ($visita->objetivo->id == 1)
                                    CAPTAÇÃO
                                @elseif ($visita->objetivo->id == 2)
                                    {{$visita->objetivo->name}}
                                @else
                                    MANUTENÇÃO
                                @endif
                            </p>

                            </p>
                        </div>

                        @if ($visita->id_objective == 3)
                            <div>
                                <x-input-label for="code_conv" :value="__('Código Convênio')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                                <p class="text-gray-700 dark:text-gray-300">{{ $visita->code_conv }}</p>
                            </div>
                        @endif

                        <div>
                            <x-input-label for="empresa" :value="__('Empresa')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                            <p class="text-gray-700 dark:text-gray-300">{{ $visita->enterprise }}</p>
                        </div>
                        <div>
                            <x-input-label for="cnpj_empresa" :value="__('CNPJ Empresa')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                            <p class="text-gray-700 dark:text-gray-300">{{ $visita->cnpj }}</p>
                        </div>
                        <div>
                            <x-input-label for="ramo_empresa" :value="__('Ramo de Atividade')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                            <p class="text-gray-700 dark:text-gray-300">{{ $visita->activity_branch }}</p>
                        </div>
                        <div>
                            <x-input-label for="responsavel_empresa" :value="__('Responsável Empresa')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                            <p class="text-gray-700 dark:text-gray-300">{{ $visita->responsable }}</p>
                        </div>
                        <div>
                            <x-input-label for="telefone_empresa" :value="__('Telefone Empresa')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                            <p class="text-gray-700 dark:text-gray-300">{{ $visita->company_phone }}</p>
                        </div>
                        <div>
                            <x-input-label for="cidade_empresa" :value="__('Cidade Empresa')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                            <p class="text-gray-700 dark:text-gray-300">{{ $visita->city }}</p>
                        </div>
                        <div>
                            <x-input-label for="observacoes" :value="__('Observações')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                            <p class="text-gray-700 dark:text-gray-300">{{ $visita->observation }}</p>
                        </div>
                    </div>
                </div>
                @can('isAdmin')
                    <div id="map" style="width: 100%; height: 250px;"></div>
                @endcan
            </div>
        </div>
    </div>

    <script>
    
      maptilersdk.config.apiKey='{{ env('MAPS_APIKEY')}}'; // Pegue um API Key grátis no site deles
      
      var cords = '{{ $visita->location }}';
        cords = cords.split(',');
        
      var map = new maptilersdk.Map({
       container: 'map',
       style: maptilersdk.MapStyle.STREETS, 
       center: [cords[0],cords[1]], 
       zoom: 12
     });
    
       map.on('load', function () {
       // Adiciona um Marker simples na localização
       new maptilersdk.Marker({ color: "red" }) 
         .setLngLat([cords[0],cords[1]]) 
         .addTo(map);
     });
    </script>

</x-app-layout>

