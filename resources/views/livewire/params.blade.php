<div>
   <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
         {{ __('Parâmetros') }}
      </h2>
   </x-slot>

  <div class="overflow-x-auto mt-6 px-8 py-2">
    <table class="w-full min-w-[600px] border border-gray-300 dark:border-gray-700 rounded-xl overflow-hidden">
        <thead class="text-center bg-gray-100 dark:bg-gray-900">
            <tr>
                <th class="px-4 py-2 text-gray-600 dark:text-gray-300">#</th>
                <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Nome</th>
                <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Descrição</th>
                <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Valor</th>
            </tr>
        </thead>
        <tbody class="text-center bg-white dark:bg-gray-800">
            @forelse($parametros as $parametro)
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                    <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $parametro->id }}</td>
                    <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $parametro->name }}</td>
                    <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $parametro->description }}</td>
                    <td class="px-4 py-2">
                        <div class="flex items-center justify-center">
                            <form wire:submit.prevent="update('{{ $parametro->id }}')" class="w-full flex gap-3 items-center justify-center">
                                <input type="text"
                                       name="valor"
                                       wire:model="valores.{{ $parametro->id }}"
                                       wire:key="param-{{$parametro->id}}"
                                       class="border border-gray-300 rounded text-gray-600 dark:text-gray-300 bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 dark:bg-gray-700 dark:border-gray-600 transition"
                                       value="{{ $parametro->value }}">
                                    <div>
                                        <x-button type="submit">Atulizar</x-button>
                                    </div>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-2 text-center">Não foram encontrados parametros cadastrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</div>
