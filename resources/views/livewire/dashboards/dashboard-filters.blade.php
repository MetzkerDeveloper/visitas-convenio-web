<div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow flex flex-col
 lg:flex-row gap-6 items-end justify-between transition-colors">

    <div>
        <label class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Período</label>
        <select wire:model.live="periodo"
                class="border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900  
                rounded-lg px-4 py-2 lg:w-48 text-gray-700 dark:text-gray-200 
                focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition ">
            <option value="hoje">Hoje</option>
            <option value="semana">Esta Semana</option>
            <option value="mes">Este Mês</option>
        </select>
    </div>

    <div>
        <label class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Promotor</label>
        <select wire:model.live="promotor"
                class="border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900  
                rounded-lg px-4 py-2 lg:w-48 text-gray-700 dark:text-gray-200 
                focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition ">
            <option value="">Todos</option>
            @foreach($promotores as $user)
                <option value="{{ $user->id }}">
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

</div>
