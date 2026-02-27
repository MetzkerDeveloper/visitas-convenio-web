<div>
    <div class="mb-4 flex w-full justify-end">
        <livewire:regioes.create />
    </div>
    <x-table :headers="$headers" :rows="$this->rows" filter paginate :quantity="[5,10,15,20]" id="regioes">
            @interact('column_action', $row)
                <livewire:regioes.update :regiao="$row" :key="uniqid()" />
            @endinteract
    </x-table>
</div>
