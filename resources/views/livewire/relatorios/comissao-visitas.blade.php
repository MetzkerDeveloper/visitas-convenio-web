<div class="p-4">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Relatório de Visitas / Comissão') }}
        </h2>
    </x-slot>

    <x-filtro-container title="Ações" class="px-2">
        <div class="w-full sm:w-1/3">
            <button type="button" wire:click="download"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-2 rounded-lg w-full sm:w-auto transition">
                Download
            </button>
        </div>
    </x-filtro-container>

    <div class="flex flex-col sm:flex-row sm:items-end gap-4 mt-4">
        <div class="flex-1">
            <x-input-label for="dataIni" :value="__('Data Inicial')" class="block uppercase tracking-wide text-gray-700 dark:text-gray-300 text-xs font-bold mb-2"/>
            <x-text-input id="dataIni" name="dataIni" wire:model='dataIni' type="date" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg py-2 px-3 text-gray-700 dark:text-gray-200"/>
            <x-input-error class="mt-2" :messages="$errors->get('dataIni')" />
        </div>
        <div class="flex-1">
            <x-input-label for="dataFim" :value="__('Data Final')" class="block uppercase tracking-wide text-gray-700 dark:text-gray-300 text-xs font-bold mb-2"/>
            <x-text-input id="dataFim" name="dataFim" wire:model='dataFim' type="date" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg py-2 px-3 text-gray-700 dark:text-gray-200"/>
            <x-input-error class="mt-2" :messages="$errors->get('dataFim')" />
        </div>
        <div class="sm:w-auto w-full">
            <button type="button" wire:click="pesquisar"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg w-full sm:w-auto transition">
                Buscar
            </button>
        </div>
    </div>

    @if ($dataIni && $dataFim)
    <div class="overflow-x-auto mt-6">
        <table class="w-full min-w-[600px] border border-gray-300 dark:border-gray-700 rounded-xl overflow-hidden">
            <thead class="text-center bg-gray-100 dark:bg-gray-900">
                <tr>
                    <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Promotor</th>
                    <th class="px-4 py-2 text-green-600 dark:text-green-400">Captação</th>
                    <th class="px-4 py-2 text-blue-600 dark:text-blue-400">Loja</th>
                    <th class="px-4 py-2 text-purple-600 dark:text-purple-400">Manutenção</th>
                    <th class="px-4 py-2 text-yellow-600 dark:text-yellow-400">Total a Pagar</th>
                </tr>
            </thead>
            <tbody class="text-center bg-white dark:bg-gray-800">
                @forelse($comissoes as $comissao)
                    <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                        <td class="px-4 py-2 font-semibold text-gray-700 dark:text-gray-200">{{ $comissao->promotor }}</td>
                        <td class="px-4 py-2 text-green-600 dark:text-green-400">{{ $comissao->captacao }}</td>
                        <td class="px-4 py-2 text-blue-600 dark:text-blue-400">{{ $comissao->loja }}</td>
                        <td class="px-4 py-2 text-purple-600 dark:text-purple-400">{{ $comissao->manutencao }}</td>
                        <td class="px-4 py-2 text-yellow-600 dark:text-yellow-400 font-bold">{{ $comissao->total_a_pagar }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-400 dark:text-gray-500">
                            Não foram encontrados dados referentes ao período selecionado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif
</div>