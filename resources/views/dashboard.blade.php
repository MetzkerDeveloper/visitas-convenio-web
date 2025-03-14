<x-app-layout>
    <div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Menu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex flex-wrap justify-center gap-4 p-4">

                        <x-nav-link :href="route('visitas')" class="w-full sm:w-1/2 md:w-1/4 lg:w-1/5 p-2">
                            <div class="bg-white shadow-lg rounded-lg p-4 flex flex-col items-center justify-center w-full h-48">
                                <img src="{{asset('assets/images/visita.png')}}" alt="Relatório" class="w-20 h-20">
                                <p class="mt-2 font-semibold text-center">VISITAS</p>
                            </div>
                        </x-nav-link>
                        <x-nav-link  :href="route('agenda')" class="w-full sm:w-1/2 md:w-1/4 lg:w-1/5 p-2"  >
                            <div class="bg-white shadow-lg rounded-lg p-4 flex flex-col  items-center justify-center w-full h-48">
                                <img src="{{asset('assets/images/agenda.png')}}" alt="Agenda" class="w-20 h-20">
                                <p class="mt-2 font-semibold text-center">AGENDA DE VISITAS</p>
                            </div>
                        </x-nav-link>
                    @can('isAdmin')
                    <x-nav-link :href="route('comissao')" class="w-full sm:w-1/2 md:w-1/4 lg:w-1/5 p-2" >
                        <div class="bg-white shadow-lg rounded-lg p-4 flex flex-col items-center justify-center w-full h-48">
                            <img src="{{asset('assets/images/comissao.png')}}" alt="Combustível" class="w-20 h-20">
                            <p class="mt-2 font-semibold text-center">COMISSÃO VISITAS</p>
                        </div>
                    </x-nav-link>

                    @endcan
   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
