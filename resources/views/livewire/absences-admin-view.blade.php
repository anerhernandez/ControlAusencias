<div wire:poll class="text-[7px] md:text-[10px] lg:text-[12px] xl:text-[14px] 2xl:text-[16px]">
    @if ($absences->isEmpty())
        <p colspan="4">No se han encontrado ausencias</p>
    @else
    <div class="container overflow-hidden dark:rounded-lg rounded">
        <table class="text-left w-full border-collapse rounded ">
            <thead class="dark:bg-gray-900 flex bg-neutral-200 dark:text-white w-full ">
                <tr class="flex w-full text-center mr-4">
                    <th class="p-1 w-1/5">Profesor</th>
                    <th class="p-1 w-1/5">Fecha</th>
                    <th class="p-1 w-1/5">Hora</th>
                    <th class="p-1 w-1/5">Razón</th>
                    <th class="p-1 w-1/5">Detalles</th>
                </tr>
            </thead>
            <tbody class="dark:bg-slate-700 flex flex-col overflow-y-scroll w-full" style="height: 50vh;">
            @foreach ($absences as $absence)
                <tr class="flex w-full border-[0.5px] dark:border-slate-800 text-center">
                    <td class="p-1 w-1/5 place-content-center overflow-hidden">{{ $absence->user_name}}</td>
                    <td class="p-1 w-1/5 place-content-center overflow-hidden">{{ $absence->date }}</td>
                    <td class="p-1 w-1/5 place-content-center overflow-hidden">{{ $absence->time }}</td>
                    <td class="p-1 w-1/5 place-content-center overflow-hidden">{{ $absence->reason }}</td>
                    <td class="p-1 w-1/5 place-content-center overflow-hidden">
                        <button wire:click="openDetailsModal({{ $absence->absence_id }})" class="btn-default overflow-hidden relative bg-neutral-200 dark:bg-slate-600 dark:text-white text-gray-900 p-2 rounded-lg font-bold uppercase transition-all duration-100 -- hover:shadow-md border border-neutral-100 dark:border-gray-700 hover:bg-gradient-to-t hover:from-neutral-300 before:to-neutral-50 hover:dark:from-slate-900 before:dark:to-slate-700 hover:-translate-y-[3px]">
                            Detalles
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
    @if ($details_modal)
    <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 py-10">
        <div class="max-h-full w-full lg:max-w-xl lg:p-0 px-10 max-w-fit overflow-y-auto  sm:rounded-2xl dark:bg-slate-800 bg-gray-100">
          <div class="w-full">
            <div class="py-12 max-w-[400px] mx-auto">
                <h1 class="mb-5 text-center font-bold underline">Detalles de ausencia</h1>
              <div class="space-y-4 ">
                <table class="place-self-center">
                    <tr>
                        <td class="p-2 ">Profesor:</td>
                        <td class="p-2">{{$this->absence[0]->user_name}}</td>
                    </tr>
                    <tr>
                        <td class="p-2">Departamento:</td>
                        <td class="p-2">{{$this->absence[0]->department_name}}</td>
                    </tr>
                    <tr>
                        <td class="p-2">Fecha:</td>
                        <td class="p-2">{{$this->absence[0]->date}}</td>
                    </tr>
                    <tr>
                        <td class="p-2">Hora:</td>
                        <td class="p-2">{{$this->absence[0]->time}}</td>
                    </tr>
                </table>
                <p class="text-center font-bold">Razón:</p>
                <p class="bg-zinc-200 dark:dark:bg-slate-700 dark:text-white text-black rounded-md p-2 break-words text-center">{{$this->absence[0]->reason}}</p>
                <div class="text-center justify-center flex gap-4">
                    <button wire:click="editabsence" class="btn-default overflow-hidden relative bg-yellow-300 dark:bg-yellow-300 text-gray-900 p-2 rounded-lg font-bold uppercase transition-all duration-100 -- hover:shadow-md border border-yellow-300 hover:bg-gradient-to-t  hover:from-yellow-400 before:to-yellow-100 hover:-translate-y-[3px]">
                        Editar
                    </button>
                    <button wire:click="deletebsence" wire:confirm.prevent="¿Está seguro de que desea eliminar esta ausencia?" class="btn-default overflow-hidden relative bg-red-500 dark:bg-red-500 text-white p-2 rounded-lg font-bold uppercase transition-all duration-100 -- hover:shadow-md border border-red-500 hover:bg-gradient-to-t  hover:from-red-500 before:to-red-600 hover:-translate-y-[3px]">
                        Eliminar
                    </button>
                </div>
                <div class="text-center">
                    <button wire:click="closeDetailsModal" class="btn-default overflow-hidden relative bg-neutral-200 dark:bg-slate-600 dark:text-white text-gray-900 p-2 rounded-lg font-bold uppercase transition-all duration-100 -- hover:shadow-md border border-neutral-100 dark:border-gray-700 hover:bg-gradient-to-t hover:from-neutral-300 before:to-neutral-50 hover:dark:from-slate-900 before:dark:to-slate-700 hover:-translate-y-[3px]">
                        Salir de detalles
                    </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
</div>
