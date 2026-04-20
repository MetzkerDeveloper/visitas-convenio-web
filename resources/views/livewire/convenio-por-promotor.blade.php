<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-600 leading-tight dark:text-gray-300">
            {{ __('Convênios para visitar') }}
        </h2>
        
    </x-slot>
    
    <div class="flex flex-row items-center mt-4 w-full gap-2 px-8">
     
        <x-slide title="Convênios por Promotor" wire="slide" >
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
             Importar Convênios por Promotor
            </x-button>

            @if(auth()->user()->can('isAdmin'))
             <x-button wire:click="verificarVisitas" color="gray">
                <i class="fa-solid fa-check mr-2"></i>
                Verificar Visitas
             </x-button>
             @endif
        @endif
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

    <!-- Lista de Convênios Por Promotor -->
    <div class="text-gray-900 dark:text-gray-200">
        <div class="overflow-x-auto mt-6 px-8 py-2">
           <x-table :headers="$headers" :rows="$this->rows" filter paginate :quantity="[5,10,15,20]" id="convenios-promotor-table">
            
                @interact('column_id_promotor', $row)
                    {{ $row->promotor ? $row->promotor->name : 'N/A' }}
                @endinteract

                @interact('column_status_visita', $row)
                    @if($row->status_visita)
                        <span class="text-green-600 font-semibold">Sim</span>
                    @else
                        <span class="text-red-600 font-semibold">Não</span>
                    @endif
                @endinteract
                
                @interact('column_action', $row)
                    <x-select.styled
                        wire:model.live="promotores.{{ $row->id }}"
                        :request="[
                            'url' => route('api.users'),
                            'method' => 'get',
                        ]"
                    />
                @endinteract


             </x-table>

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