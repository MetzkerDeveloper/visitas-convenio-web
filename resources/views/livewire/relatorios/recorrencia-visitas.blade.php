<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Recorrência Visitas') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex flex-col sm:flex-row sm:items-end gap-4 p-8">
        <div class="flex-1">
            <x-input-label for="data_ini" :value="__('Data Inicial')" class="block uppercase tracking-wide text-gray-700 dark:text-gray-300 text-xs font-bold mb-2"/>
            <x-text-input id="data_ini" name="data_ini" wire:model='data_ini' type="date" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg py-2 px-3 text-gray-700 dark:text-gray-200"/>
            <x-input-error class="mt-2" :messages="$errors->get('data_ini')" />
        </div>
        <div class="flex-1">
            <x-input-label for="data_fim" :value="__('Data Final')" class="block uppercase tracking-wide text-gray-700 dark:text-gray-300 text-xs font-bold mb-2"/>
            <x-text-input id="data_fim" name="data_fim" wire:model='data_fim' type="date" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg py-2 px-3 text-gray-700 dark:text-gray-200"/>
            <x-input-error class="mt-2" :messages="$errors->get('data_fim')" />
        </div>
        <div class="flex-1">
            <x-input-label for="meses" :value="__('Qtd. Meses')" class="block uppercase tracking-wide text-gray-700 dark:text-gray-300 text-xs font-bold mb-2"/>
            <select id="meses" name="meses" wire:model='meses' class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg py-2 px-3 text-gray-700 dark:text-gray-200">
                <option value="">Selecione</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('meses')" />
        </div>
        <div class="flex-1">
            <x-input-label for="promotor" :value="__('Promotor')" class="block uppercase tracking-wide text-gray-700 dark:text-gray-300 text-xs font-bold mb-2"/>
            <select id="promotor" name="promotor" wire:model='promotor' class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg py-2 px-3 text-gray-700 dark:text-gray-200">
                <option value="">Selecione</option>
                @foreach ($users as $promotor)
                    <option value="{{ $promotor['id'] }}">{{ $promotor['name'] }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('promotor')" />
        </div>
        <div class="sm:w-auto w-full">
            <button type="button" wire:click.prevent="pesquisar"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg w-full sm:w-auto transition">
                Buscar
            </button>
        </div>
    </div>

    @if (!empty($recorrencias))
        <div class="overflow-x-auto mt-2 p-8">
            <table class="w-full min-w-[600px] border border-gray-300 dark:border-gray-700 rounded-xl overflow-hidden">
                <thead class="text-center bg-gray-100 dark:bg-gray-900">
                    <tr>
                        <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Promotor</th>
                        <th class="px-4 py-2 text-gray-600 dark:text-gray-300">CNPJ</th>
                        <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Empresa</th>
                        <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Última Visita</th>
                        <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Qtd. Visitas Período</th>
                        <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Visitada Últimos {{ $meses }} Meses</th>
                    </tr>
                </thead>
                <tbody class="text-center bg-white dark:bg-gray-800">
                    @forelse($recorrencias as $recorrencia)
                        <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                            <td class="px-4 py-2 text-gray-600 dark:text-gray-300 font-semibold">{{ $recorrencia->promotor }}</td>
                            <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $recorrencia->cnpj }}</td>
                            <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $recorrencia->enterprise }}</td>
                            <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($recorrencia->data_ultima_visita)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $recorrencia->visitas_no_periodo }}</td>
                            <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $recorrencia->visitada_ultimos_meses }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-2 text-center text-gray-400 dark:text-gray-500">
                                Não foram encontrados dados referentes ao período selecionado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>