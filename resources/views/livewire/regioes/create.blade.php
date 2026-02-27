<div>
   <x-button :text="__('Adicionar Região')" icon="plus" wire:click="$set('show', true)" />

   <x-modal wire="show" maxWidth="sm">
       <x-slot name="title">
           Adicionar Região
       </x-slot>

       <div>
           <form wire:submit.prevent="create">
               <div class="mb-4">
                   <label for="name" class="block text-sm font-medium text-gray-700">Nome da Região</label>
                   <input type="text" id="name" wire:model.defer="name" 
                   class="mt-1 block w-full border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600" 
                   autocomplete="off" 
                   required>
               </div>

               <div class="flex justify-end">
                   <x-button type="submit">Criar</x-button>
               </div>
           </form>
       </div>
   </x-modal>
</div>
