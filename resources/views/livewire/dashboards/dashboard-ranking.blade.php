<div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow transition-colors">
    <h3 class="font-semibold mb-4 text-gray-700 dark:text-gray-200">Ranking</h3>

    <table class="w-full text-left">
        <thead>
            <tr class="text-gray-500 dark:text-gray-400 text-sm border-b border-gray-200 dark:border-gray-700">
                <th class="py-2">Posição</th>
                <th>Promotor</th>
                <th>Visitas</th>
                <th>Produtividade/h</th>
            </tr>
        </thead>

        <tbody class="text-sm">
        @forelse($ranking as $index => $item)
            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                <td class="py-2 font-bold text-blue-600 dark:text-blue-400">
                    {{ $index + 1 }}º
                </td>
                <td class="text-gray-700 dark:text-gray-200">
                    {{ $item->promotor->name ?? '—' }}
                </td>
                <td class="text-green-600 dark:text-green-400 font-semibold">
                    {{ $item->total_visitas }}
                </td>
                <td class="text-purple-600 dark:text-purple-400 font-semibold">
                    {{ $item->produtividade }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="py-4 text-center text-gray-400 dark:text-gray-500">
                    Nenhum dado no período
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>