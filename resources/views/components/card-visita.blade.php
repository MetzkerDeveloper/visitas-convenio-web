@props([
        'visita' => '',
        'route' => ''
])


<a href="{{$route}}" class="bg-white shadow-lg rounded-lg p-4 flex flex-col w-full h-48 sm:w-1/2 md:w-1/4 lg:w-1/5 dark:text-gray-600">
    <h4 class="text-sm font-semibold">{{$visita->promotor->name}}</h4>
    <span class="text-sm font-semibold mb-4">{{$visita->regiao->name}}</span>
    <h2 class="text-2xl">{{$visita->enterprise}}</h2>
    <span class="text-sm">{{$visita->cnpj}}</span>
    <p class="text-sm mt-2">
        @if ($visita->objetivo->id == 1)
            CAPTAÇÃO
        @elseif ($visita->objetivo->id == 2)
            {{$visita->objetivo->name}}
        @else
            MANUTENÇÃO
        @endif
</p>
    <p class="text-sm mt-2 font-semibold">{{$visita->start_time}}</p>
</a>
