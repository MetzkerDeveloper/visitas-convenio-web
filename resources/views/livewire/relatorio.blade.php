<div>
    <x-slot name="header">
        <div class="flex justify-between items-center justify-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Relatório de Visitas') }}
            </h2>
            <livewire:registrar-visita />
        </div>
    </x-slot>
    <x-filtro-container title="Filtros" class="px-8">
        <!-- Filtro de Região -->
        <div class="w-full sm:w-1/2 lg:w-1/3">
           <label for="regiao" class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-1">
               Região
           </label>
           <select id="regiao" wire:model="regiao"
               class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 dark:bg-gray-700 dark:border-gray-600">
               <option value="">Selecionar</option>
               @foreach($regioes as $regiao)
                   <option value="{{ $regiao->id }}">{{ $regiao->name }}</option>
               @endforeach
           </select>
       </div>

        <!-- Filtro de Objetivos -->
        <div class="w-full sm:w-1/2 lg:w-1/3">
           <label for="regiao" class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-1">
               Objetivo
           </label>
           <select id="regiao" wire:model="objetivo"
               class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 dark:bg-gray-700 dark:border-gray-600">
               <option value="">Selecionar</option>
               @foreach($objetivos as $item)
                   <option value="{{ $item->id }}">{{ $item->name }}</option>
               @endforeach
           </select>
       </div>

       <!-- Filtro de Data -->
       <div class="w-full sm:w-1/2 lg:w-1/3">
          <label for="data" class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-1">
                       Data
           </label>
           <input type="date" id="data" wire:model="data"
                       class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 dark:bg-gray-700 dark:border-gray-600">
       </div>

       <!-- Botão de busca -->
       <div class="w-full sm:w-1/3">
           <button type="button" wire:click="pesquisar"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 mt-4 rounded-lg w-full sm:w-auto">
               Buscar
           </button>
       </div>

       {{-- <!-- Botão de busca -->
       <div class="w-full sm:w-1/3">
            <button type="button" wire:click="download"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded-lg w-full sm:w-auto">
                Download
            </button>
        </div> --}}
   </x-filtro-container>

    <!-- Resultados -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex flex-wrap justify-center gap-4 p-4">

                    @forelse ($visitas as $item)
                        <x-card-visita :visita="$item" route="{{ route('editar-visita', ['id' => $item->id]) }}" wire:key="{{ $item->id }}" />

                    @empty
                        <div class="text-center w-full">
                            <p class="text-gray-400">Nenhuma visita encontrada</p>
                        </div>
                    @endforelse
                </div>
                {{$visitas->links()}}
            </div>
        </div>
    </div>
</div>


