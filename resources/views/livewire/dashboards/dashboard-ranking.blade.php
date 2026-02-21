<div class="bg-white p-6 rounded-2xl shadow">
    <h3 class="font-semibold mb-4">Ranking</h3>

    <table class="w-full text-left">
        <thead>
            <tr class="text-gray-500 text-sm border-b">
                <th class="py-2">Posição</th>
                <th>Promotor</th>
                <th>Visitas</th>
                <th>Produtividade/h</th>
            </tr>
        </thead>

        <tbody class="text-sm">
        @forelse($ranking as $index => $item)
            <tr class="border-b">
                <td class="py-2 font-bold">
                    {{ $index + 1 }}º
                </td>
                <td>
                    {{ $item->promotor->name ?? '—' }}
                </td>
                <td>
                    {{ $item->total_visitas }}
                </td>
                <td>
                    {{ $item->produtividade }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="py-4 text-center text-gray-400">
                    Nenhum dado no período
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>