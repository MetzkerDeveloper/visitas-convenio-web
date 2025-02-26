<div class="p-4">

        <x-filtro-container title="Ações">

        <!-- Botão de busca -->
        <div class="w-full sm:w-1/3">
            <button type="button" wire:click="download"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-3 rounded-lg w-full sm:w-auto">
                Download
            </button>
        </div>

        </x-filtro-container>
   

    <div class="flex flex-col sm:flex-row sm:items-end gap-4">
        <div class="flex-1">
            <x-input-label for="dataIni" :value="__('Data Inicial')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
            <x-text-input id="dataIni" name="dataIni" wire:model='dataIni' type="date" class="w-full bg-gray-50 border border-gray-200 rounded py-2 px-3"/>
            <x-input-error class="mt-2" :messages="$errors->get('dataIni')" />
        </div>
        <div class="flex-1">
            <x-input-label for="dataFim" :value="__('Data Final')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
            <x-text-input id="dataFim" name="dataFim" wire:model='dataFim' type="date" class="w-full bg-gray-50 border border-gray-200 rounded py-2 px-3"/>
            <x-input-error class="mt-2" :messages="$errors->get('dataFim')" />
        </div>
        <div class="sm:w-auto w-full">
            <button type="button" wire:click="pesquisar"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg w-full sm:w-auto">
                Buscar
            </button>
        </div>
    </div>

    @if ($dataIni && $dataFim)
    <div class="overflow-x-auto mt-6">
        <table class="w-full min-w-[600px] border border-gray-300">
            <thead class="text-center bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Promotor</th>
                    <th class="px-4 py-2">Captação</th>
                    <th class="px-4 py-2">Loja</th>
                    <th class="px-4 py-2">Manutenção</th>
                    <th class="px-4 py-2">Total a Pagar</th>
                </tr>
            </thead>
            <tbody class="text-center bg-white">
                @forelse($comissoes as $comissao)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $comissao->promotor }}</td>
                        <td class="px-4 py-2">{{ $comissao->captacao }}</td>
                        <td class="px-4 py-2">{{ $comissao->loja }}</td>
                        <td class="px-4 py-2">{{ $comissao->manutencao }}</td>
                        <td class="px-4 py-2">{{ $comissao->total_a_pagar }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">Não foram encontrado dados referentes ao período selecionado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif
</div>
