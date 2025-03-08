<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agenda') }}
        </h2>
    </x-slot>
    <x-filtro-container title="Filtros Agenda" class="px-8">

        <!-- Filtro de Promotor -->
        {{-- <div class="w-full sm:w-1/2 lg:w-1/3">
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
       </div> --}}

       <!-- Filtro de Data -->
        <div class="w-full sm:w-1/2 lg:w-1/3">
            <label for="data_ini" class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-1">
                        Data Inicial
            </label>
            <input type="date" id="data_ini" wire:model="data_ini"
                        class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 dark:bg-gray-700 dark:border-gray-600">
        </div>
        <div class="w-full sm:w-1/2 lg:w-1/3">
        <label for="data_fim" class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-1">
                    Data Final
        </label>
        <input type="date" id="data_fim" wire:model="data_fim"
                    class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 dark:bg-gray-700 dark:border-gray-600">
    </div>

       <!-- Botão de busca -->
       <div class="w-full sm:w-1/3">
           <button type="button" wire:click="pesquisar"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded-lg w-full sm:w-auto">
               Buscar
           </button>
       </div>
   </x-filtro-container>

    <div class="flex flex-wrap px-8 mt-2">
        <form wire:submit.prevent="store" class="w-full bg-white p-8  mt-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <div>
                    <x-input-label for="date" :value="__('Data')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1"/>
                    <x-text-input id="date" name="date" wire:model='form.date' type="date" class="w-full bg-gray-50 border border-gray-200 rounded py-1 px-2"/>
                    <x-input-error class="mt-1" :messages="$errors->get('form.date')" />
                </div>
                <div>
                    <x-input-label for="cidade_empresa" :value="__('Cidade Empresa')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1"/>
                    <x-text-input id="cidade_empresa" name="cidade_empresa" wire:model='form.city' autocomplete="off" class="w-full bg-gray-50 border border-gray-200 rounded py-1 px-2" />
                    <x-input-error class="mt-1" :messages="$errors->get('form.city')" />
                </div>
                <div>
                    <x-input-label for="observacoes" :value="__('Observações')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-1"/>
                    <textarea id="observacoes" name="observacoes" wire:model="form.observation" autocomplete="off" class="w-full bg-gray-50 border border-gray-200 rounded py-1 px-2" ></textarea>
                    <x-input-error class="mt-1" :messages="$errors->get('form.observation')" />
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-2">
                <x-secondary-button type="reset" >Cancelar</x-secondary-button>
                <x-primary-button type="submit">Registrar</x-primary-button>
            </div>
        </form>
    </div>

<div class="p-6 text-gray-900 dark:text-gray-100">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 px-8 mt-8 mb-4">
        @foreach ($visitas as $i)
            <div class="bg-white p-4 rounded-lg shadow-md min-h-40 h-full flex flex-col justify-between">
                <h2 class="text-base font-semibold">
                    {{$i->promotor->name}}
                </h2>
                <p class="text-xs text-gray-500">{{\Carbon\Carbon::parse($i->date)->format('d/m/Y')}}</p>
                <p class="text-xs text-gray-500 mt-6 mb-6">{{$i->city}}</p>
                <p class="text-xs text-gray-500 flex-1">{{$i->observation}}</p>
            </div>
        @endforeach
    </div>
    {{$visitas->links()}}
</div>

</div>
