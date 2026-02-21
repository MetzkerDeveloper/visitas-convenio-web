<div class="bg-white p-4 rounded-2xl shadow flex flex-col lg:flex-row gap-4 items-end">

    <div>
        <label class="text-sm text-gray-500">Período</label>
        <select wire:model.live="periodo"
                class="border rounded-lg px-3 py-2 w-48">
            <option value="hoje">Hoje</option>
            <option value="semana">Esta Semana</option>
            <option value="mes">Este Mês</option>
        </select>
    </div>

    <div>
        <label class="text-sm text-gray-500">Promotor</label>
        <select wire:model.live="promotor"
                class="border rounded-lg px-3 py-2 w-48">
            <option value="">Todos</option>
            @foreach($promotores as $user)
                <option value="{{ $user->id }}">
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

</div>