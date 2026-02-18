<div class="flex justify-center">
    <!-- Botão para abrir modal -->
    <x-secondary-button wire:click="setShow(true)" class="flex items-center">
        <span wire:loading.remove wire:target="setShow">Editar</span>
        <div wire:loading wire:target="setShow" class="spinner-border spinner-border-sm text-gray-300 ml-2" role="status">
            <span class="visually-hidden">...</span>
        </div>
    </x-secondary-button>

    <!-- Modal Responsivo -->
    <x-modal id="edit-user" name="edit-user" :show="$show" wire="show" focusable class="z-30">
        <section class="p-5 max-w-lg mx-auto dark:text-gray-600">
            <header class="mb-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Editar Cadastro') }}
                </h2>
            </header>

            <div class="space-y-4">
                <div>
                    <x-input-label for="name" :value="__('Nome')" />
                    <x-text-input
                        id="name"
                        name="name"
                        wire:model="nome"
                        type="text"
                        class="mt-1 block w-full"
                        :value="old('name', $user->name)"
                        required
                        readonly
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="nivel" :value="__('Nível Acesso')" />
                    <select class="form-select w-full border border-gray-300 rounded mt-1" name="nivel" wire:model="nivel">
                        <option value="0">0 - Não Definida</option>
                        @foreach ($niveis as $niv)
                            <option value="{{ $niv->id }}" {{ $niv->id == $nivel ? 'selected' : '' }}>
                                {{ $niv->id }} - {{ $niv->descricao }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('nivel_acesso')" />
                </div>

                <div>
                    <x-input-label for="regiao" :value="__('Região')" />
                    <select class="form-select w-full border border-gray-300 rounded mt-1" name="regiao" wire:model="regiao">
                        <option value="0">0 - Não Definida</option>
                        @foreach ($regioes as $r)
                            <option value="{{ $r->id }}" {{ $r->id == $regiao ? 'selected' : '' }}>
                                {{ $r->id }} - {{ $r->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('regiao')" />
                </div>


            </div>

            <!-- Botões responsivos -->
            <div class="mt-6 flex flex-wrap gap-4 justify-end">
                <x-secondary-button wire:click="setShow(false)">
                    <span wire:loading.remove wire:target="setShow">{{ __('Cancelar') }}</span>
                    <div wire:loading wire:target="setShow" class="spinner-border spinner-border-sm text-gray-300 ml-2" role="status">
                        <span class="visually-hidden">...</span>
                    </div>
                </x-secondary-button>

                <x-danger-button wire:click="edit">
                    {{ __('Atualizar') }}
                </x-danger-button>
            </div>
        </section>
    </x-modal>
</div>
