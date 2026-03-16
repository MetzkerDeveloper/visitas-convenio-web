<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-600 leading-tight dark:text-gray-300">
            {{ __('Agenda') }}
        </h2>
        
    </x-slot>
    
    <div class="flex flex-row items-center mt-4 w-full gap-2 px-8">
     
        <!-- Botão de Agendamento -->
        <x-primary-button wire:click="setShow(true)" wire:key="btn-agendamento" 
        class="bg-blue-500 px-4 py-3 hover:bg-blue-500 text-white font-bold rounded-lg order-last sm:order-first transition">
            <i class="fa-solid fa-plus mr-2"></i>
            <span >Agendamento</span>
        </x-primary-button>

        <x-slide title="Agenda de Visitas" wire="slide" >
            <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-4">Upload de Arquivo</h2>
                 {{-- <x-upload  wire:model="file"/> --}}

                 <x-upload wire:model="files" :multiple="true" accept=".xlsx,.xls,.csv,.ods">
                    <x-slot:footer when-uploaded> 
                        <x-button class="w-full" wire:click="importar" color="blue">
                            Importar
                        </x-button>
                    </x-slot:footer>
                </x-upload>
                 
            </div>
        </x-slide>

        @if (!$isMobile)
            <x-button wire:click="$toggle('slide')" color="gray" class="order-last sm:order-first transition">
             <i class="fa-solid fa-upload mr-2"></i>
             Agenda
            </x-button>
        @endif
    
        <x-filtro-container class="w-full" wire:ignore wire:key="filtro-agendamentos">
            <div class="flex flex-col sm:flex-row gap-4 w-full">
                <div class="flex-1">
                    <label for="data_ini" class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-1">Data Inicial</label>
                    <input type="date" id="data_ini" wire:model="data_ini" class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 dark:bg-gray-700 dark:border-gray-600 transition">
                </div>
                <div class="flex-1">
                    <label for="data_fim" class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-1">Data Final</label>
                    <input type="date" id="data_fim" wire:model="data_fim" class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 dark:bg-gray-700 dark:border-gray-600 transition">
                </div>
                <div class="flex-1 flex items-end">
                    <button type="button" wire:click="pesquisar" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg w-full sm:w-auto transition">
                        Buscar
                    </button>
                </div>
            </div>
        </x-filtro-container>
    </div>

    <!-- Modal de Agendamento -->
    <x-modal id="create-agenda" name="create-agenda" :show="$show" focusable class="flex flex-wrap px-8 mt-2" wire="show">
        <form wire:submit.prevent="store" class="w-full bg-white dark:bg-gray-800 p-8 rounded-xl shadow mt-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="date" :value="__('Data')" class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-1"/>
                    <x-text-input id="date" name="date" wire:model='form.date' type="date" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded py-2 px-3"/>
                    <x-input-error class="mt-1" :messages="$errors->get('form.date')" />
                </div>
                <div>
                    <x-input-label for="cidade_empresa" :value="__('Cidade Empresa')" class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-1"/>
                    <x-text-input id="cidade_empresa" name="cidade_empresa" wire:model='form.city' autocomplete="off" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded py-2 px-3" />
                    <x-input-error class="mt-1" :messages="$errors->get('form.city')" />
                </div>
                <div class="md:col-span-2">
                    <x-input-label for="observacoes" :value="__('Observações')" class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-1"/>
                    <textarea id="observacoes" name="observacoes" wire:model="form.observation" autocomplete="off" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded py-2 px-3 dark:text-gray-200 transition"></textarea>
                    <x-input-error class="mt-1" :messages="$errors->get('form.observation')" />
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <x-secondary-button wire:click="setShow(false)">Cancelar</x-secondary-button>
                <x-primary-button class="bg-blue-500 px-4 py-3 hover:bg-blue-400 text-white font-bold rounded-lg">Salvar</x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Lista de Visitas -->
    <div class="text-gray-900 dark:text-gray-200">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 px-8 mt-6 mb-6">
            @foreach ($visitas as $i)
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow flex flex-col min-h-40 h-full justify-between transition-colors">
                    <h2 class="text-lg font-semibold text-blue-600 dark:text-blue-400 mb-2">
                        {{$i->promotor->name}}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{\Carbon\Carbon::parse($i->date)->format('d/m/Y')}}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-4 mb-2">{{$i->city}}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 flex-1">{{$i->observation}}</p>
                </div>
            @endforeach
        </div>
        <div class="px-8 mb-8">
            {{$visitas->links()}}
        </div>
    </div>
</div>


<script>
    // Detecta o tamanho da tela e altera o título do filtro
    if (window.innerWidth < 640) { // Menor que a largura do tamanho 'sm' do Tailwind

        document.getElementById('dropdownButton').innerHTML = '<i class="fa-solid fa-filter"></i>';
    }else{
        document.getElementById('dropdownButton').innerHTML = '<i class="fa-solid fa-filter"></i> Filtros';
    }
    
</script>
@script
<script>
    const isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
    $wire.set('isMobile', isMobile, true);
</script>
@endscript