<div>

    <div class="flex justify-between items-center justify-center w-full mt-2 px-8 ">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Usuários Sistema') }}
            </h2>
            <x-secondary-button wire:click="setShow(true)">
                <div class="flex items-center gap-2">
                    <span wire:loading.remove wire:target="setShow">Cadastrar Usuário</span>
                    <div wire:loading wire:target="setShow" class="spinner-border spinner-border-sm fs-4 text-gray-300" role="status">
                        <span class="visually-hidden">...</span>
                    </div>
                </div>
            </x-secondary-button>

    </div>

    <x-modal id="create-user" name="create-user" :show="$show"  wire="show" focusable>
        <section class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto p-6">
            <header class="text-center mb-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Cadastrar Usuário') }}
                </h2>
            </header>

            <form wire:submit.prevent="store" class="w-full space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Regiao --}}
                    <div>
                        <x-input-label for="regiao" :value="__('Região')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
                        <select id="regiao" wire:model='form.id_region' class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 dark:bg-gray-700 dark:border-gray-600">
                            <option value="">Selecione a região</option>
                            @foreach($regioes as $regiao)
                                <option value="{{ $regiao->id }}">{{ $regiao->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('form.id_region')" />
                    </div>

                        {{-- Nivel Acesso --}}
                    <div>
                        <x-input-label for="nivel" :value="__('Nível Acesso')" />
                        <select class="form-select w-full border border-gray-300 rounded mt-1" name="nivel" wire:model="form.nivel_acesso">
                            <option value="">Selecione nivel de acesso</option>
                            @foreach ($niveis as $niv)
                                <option value="{{ $niv->id }}">
                                    {{ $niv->id }} - {{ $niv->descricao }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('form.nivel_acesso')" />
                    </div>
                        {{-- Nome --}}
                    <div>
                        <x-input-label for="name" :value="__('Nome')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
                        <x-text-input id="name" name="name" wire:model='form.name' type="text" class="w-full bg-gray-50 border border-gray-200 rounded py-2 px-3"/>
                        <x-input-error class="mt-2" :messages="$errors->get('form.name')" />
                    </div>
                        {{-- Email --}}
                    <div>
                        <x-input-label for="email" :value="__('E-mail')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
                        <x-text-input id="email" type="email" name="email" wire:model='form.email' autocomplete="off" class="w-full bg-gray-50 border border-gray-200 rounded py-2 px-3" :value="old('empresa')" />
                        <x-input-error class="mt-2" :messages="$errors->get('form.email')" />
                    </div>
                    {{-- Senha --}}
                    <div>
                        <x-input-label for="password" :value="__('Senha')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
                        <x-text-input id="password" name="cnpj_empresa" type="password" wire:model='form.password' autocomplete="off" class="w-full bg-gray-50 border border-gray-200 rounded py-2 px-3" :value="old('empresa')" />
                        <x-input-error class="mt-2" :messages="$errors->get('form.password')" />
                    </div>
                    {{-- Confirm Senha --}}
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirme a Senha')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" wire:model='form.password_confirmation'  autocomplete="off" class="w-full bg-gray-50 border border-gray-200 rounded py-2 px-3" :value="old('empresa')" />
                        <x-input-error class="mt-2" :messages="$errors->get('form.password_confirmation')" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <x-secondary-button wire:click="setShow(false)" type="reset">Cancelar</x-secondary-button>
                    <x-button type="submit">Registrar</x-button>
                </div>
            </form>
        </section>
    </x-modal>



    <div class="overflow-x-auto px-6 py-6">
        <table class="min-w-full table-auto border border-gray-300 mt-8 ">
            <thead class="text-center bg-gray-100">
                <tr>
                    <th class="px-4 py-2 cursor-pointer" >Id </th>
                    <th class="px-4 py-2 cursor-pointer" >Região </th>
                    <th class="px-4 py-2 cursor-pointer" >Nome </th>
                    <th class="px-4 py-2 cursor-pointer" >Nível Acesso </th>
                    <th class="px-4 py-2 cursor-pointer" >Status Usuário </th>
                    <th class="px-4 py-2">Editar Cadastro</th>
                </tr>
            </thead>
            <tbody class="text-center bg-white dark:bg-gray-800 dark:text-gray-200">
                @forelse($users as $user)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $user->id }}</td>
                        <td class="px-4 py-2">{{ $user->regiao->name }}</td>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->nivel_acesso == null ? 'Atualize os dados' : $user->nivel->descricao }}</td>
                        <td class="px-4 py-2"><x-toggle color="blue" label="{{$user->status ? 'Ativo' : 'Inativo' }}" :checked="(bool) $user->status" wire:change="updateStatus({{$user->id}}, $event.target.checked )"/> </td>
                        <td class="px-4 py-2"><livewire:editar-usuario :user="$user" :key="$user->id"/></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center">Nenhum usuário encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Paginação -->
    <div class="mt-4">
        {{$users->links()}}
    </div>
</div>
