<div>
    <div class="flex justify-center items-center w-full">
        <x-secondary-button wire:click="setShow(true)">
            <div class="flex items-center gap-2">
                <span wire:loading.remove wire:target="setShow">Registrar Visita</span>
                <div wire:loading wire:target="setShow" class="spinner-border spinner-border-sm fs-4 text-gray-300" role="status">
                    <span class="visually-hidden">...</span>
                </div>
            </div>
        </x-secondary-button>
    </div>

    <x-modal name="create-user" :show="$show" focusable>
        <section class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto p-6">
            <header class="text-center mb-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Registrar Visita') }}
                </h2>
            </header>

            <form wire:submit.prevent="store" class="w-full space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                    <div>
                        <x-input-label for="date" :value="__('Data')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
                        <x-text-input id="date" name="date" wire:model='form.date' type="date" class="w-full bg-gray-50 border border-gray-200 rounded py-2 px-3"/>
                        <x-input-error class="mt-2" :messages="$errors->get('form.date')" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="start_time" :value="__('Horário de Início')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                            <input type="time" id="start_time" wire:model='form.start_time' class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 dark:bg-gray-600 dark:border-gray-500" min="08:00" max="18:00" />
                            <x-input-error class="mt-2" :messages="$errors->get('form.start_time')" />
                        </div>
                        <div>
                            <x-input-label for="end_time" :value="__('Horário de Término')" class="block text-sm font-medium text-gray-900 dark:text-white" />
                            <input type="time" id="end_time"  wire:model='form.end_time' class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 dark:bg-gray-600 dark:border-gray-500" min="08:00" max="18:00" />
                            <x-input-error class="mt-2" :messages="$errors->get('form.end_time')" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="objetivo" :value="__('Objetivo')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
                        <select id="objetivo" wire:model.live="form.id_objective" class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 dark:bg-gray-700 dark:border-gray-600">
                            <option value="">Selecione o objetivo</option>
                            @foreach($objetivos as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('form.id_objective')" />
                    </div>

                    @if ($form->id_objective == 3)
                        <div>
                            <x-input-label for="code_conv" :value="__('Código Convênio')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
                            <x-text-input id="code_conv"
                                name="code_conv"
                                wire:model='form.code_conv'
                                class="w-full bg-gray-50 border border-gray-200 rounded py-2 px-3"
                                :value="old('code_conv')"

                            />
                            <x-input-error class="mt-2" :messages="$errors->get('form.code_conv')" />
                        </div>
                    @endif

                    <div>
                        <x-input-label for="empresa" :value="__('Empresa')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
                        <x-text-input id="empresa" name="empresa" wire:model='form.enterprise' autocomplete="off" class="w-full bg-gray-50 border border-gray-200 rounded py-2 px-3" :value="old('empresa')" />
                        <x-input-error class="mt-2" :messages="$errors->get('form.enterprise')" />
                    </div>
                    <div>
                        <x-input-label for="cnpj_empresa" :value="__('CNPJ Empresa')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
                        <x-text-input id="cnpj_empresa" name="cnpj_empresa" wire:model='form.cnpj' autocomplete="off" class="w-full bg-gray-50 border border-gray-200 rounded py-2 px-3" :value="old('empresa')" />
                        <x-input-error class="mt-2" :messages="$errors->get('form.cnpj')" />
                    </div>
                    <div>
                        <x-input-label for="ramo_empresa" :value="__('Ramo Atividade')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
                        <x-text-input id="ramo_empresa" name="ramo_empresa" wire:model='form.activity_branch' autocomplete="off" class="w-full bg-gray-50 border border-gray-200 rounded py-2 px-3" :value="old('empresa')" />
                        <x-input-error class="mt-2" :messages="$errors->get('form.activity_branch')" />
                    </div>
                    <div>
                        <x-input-label for="responsavel_empresa" :value="__('Responsavel Empresa')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
                        <x-text-input id="responsavel_empresa" name="responsavel_empresa" wire:model='form.responsable' autocomplete="off" class="w-full bg-gray-50 border border-gray-200 rounded py-2 px-3" :value="old('empresa')" />
                        <x-input-error class="mt-2" :messages="$errors->get('form.responsable')" />
                    </div>
                    <div>
                        <x-input-label for="telefone_empresa" :value="__('Telefone Empresa')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
                        <x-text-input id="telefone_empresa" name="telefone_empresa" wire:model='form.company_phone' autocomplete="off" class="w-full bg-gray-50 border border-gray-200 rounded py-2 px-3" :value="old('empresa')" />
                        <x-input-error class="mt-2" :messages="$errors->get('form.company_phone')" />
                    </div>
                    <div>
                        <x-input-label for="cidade_empresa" :value="__('Cidade Empresa')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
                        <x-text-input id="cidade_empresa" name="cidade_empresa" wire:model='form.city' autocomplete="off" class="w-full bg-gray-50 border border-gray-200 rounded py-2 px-3" :value="old('empresa')" />
                        <x-input-error class="mt-2" :messages="$errors->get('form.city')" />
                    </div>
                    <div>
                        <x-input-label for="observacoes" :value="__('Observações')" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"/>
                        <textarea id="observacoes" name="observacoes" wire:model="form.observation" autocomplete="off" class="w-full bg-gray-50 border border-gray-200 rounded py-2 px-3" ></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('form.observation')" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <x-secondary-button wire:click="setShow(false)">Cancelar</x-secondary-button>
                    <x-primary-button type="submit">Registrar</x-primary-button>
                </div>
            </form>
        </section>
    </x-modal>

</div>
