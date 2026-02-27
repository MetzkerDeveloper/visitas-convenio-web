<div>

    <div class="flex gap-1">
    <x-button :text="__('Editar')" icon="pencil" wire:click="$set('show', true)" />
    </div>

    <x-modal wire="show" id="update-regiao-modal">
        <x-slot name="title">
            Atualizar Região {{ $regiao->name }}
        </x-slot>

        <div>
            <form wire:submit.prevent="update">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Região</label>
                    <input type="text" id="name" wire:model.live="newName"
                     class="mt-1 block w-full border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600" 
                     autocomplete="off">
                </div>

                <div class="flex justify-end">
                    <x-button type="submit">Salvar</x-button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
