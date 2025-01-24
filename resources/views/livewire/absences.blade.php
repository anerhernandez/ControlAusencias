<div class="text-[7px] md:text-[10px] lg:text-[12px] xl:text-[14px] 2xl:text-[16px]">
    <div class=" text-gray-900 dark:text-gray-100 text-center"> 
        
        <form wire:submit="submitform" action="#">
            <div id="Inputs" class="flex justify-evenly p-10">
                <div class="text-center">
                    <label for="time">Hora</label><br>
                    <select id="time" name="time" wire:model="filter.time" class="bg-neutral-50 text-[7px] md:text-[10px] lg:text-[12px] xl:text-[14px] 2xl:text-[16px] dark:bg-slate-600 dark:text-white text-gray-900 p-1 rounded-lg transition-all duration-100 -- hover:shadow-md border border-neutral-200 dark:border-gray-700 hover:dark:from-slate-900 before:dark:to-slate-700 hover:-translate-y-[3px]">
                        <option selected value={{null}}>Filtrar por hora</option>
                        <option value="M1">M1 (Mañana)</option>
                        <option value="M2">M2 (Mañana)</option>
                        <option value="M3">M3 (Mañana)</option>
                        <option value="R1">R1 (Recreo Mañana)</option>
                        <option value="M4">M4 (Mañana)</option>
                        <option value="M5">M5 (Mañana)</option>
                        <option value="M6">M6 (Mañana)</option>
                        <option value="T1">T1 (Tarde)</option>
                        <option value="T2">T2 (Tarde)</option>
                        <option value="T3">T3 (Tarde)</option>
                        <option value="R2">R2 (Recreo Tarde)</option>
                        <option value="T4">T4 (Tarde)</option>
                        <option value="T5">T5 (Tarde)</option>
                        <option value="T6">T6 (Tarde)</option>
                      </select>
                </div>
                <div class="text-center">
                    <label for="date">Fecha</label><br>
                    <input type="date" id="date" name="date" wire:model="filter.date"  class="bg-neutral-50 text-[7px] md:text-[10px] lg:text-[12px] xl:text-[14px] 2xl:text-[16px] dark:bg-slate-600 dark:text-white text-gray-900 p-1 rounded-lg transition-all duration-100 -- hover:shadow-md border border-neutral-200 dark:border-gray-700 hover:dark:from-slate-900 before:dark:to-slate-700 hover:-translate-y-[3px]">
                </div>
            </div>
            <div class="text-center mb-8">
                <button type="submit" class="btn-default overflow-hidden relative bg-neutral-200 dark:bg-slate-600 dark:text-white text-gray-900 p-2 rounded-lg font-bold uppercase transition-all duration-100 -- hover:shadow-md border border-neutral-100 dark:border-gray-700 hover:bg-gradient-to-t hover:from-neutral-300 before:to-neutral-50 hover:dark:from-slate-900 before:dark:to-slate-700 hover:-translate-y-[3px]">
                    <span class="relative">Buscar por filtros</span>
                  </button>
            </div>
        </form>
    </div>
    @if ($absences->isEmpty())
        <p colspan="4">No absences found.</p>
    @else
    @if ($currentabsences)
    <p class="text-lg lg:text-xl xl:text-2xl 2xl:text-3xl underline text-center pb-2"> <b>Ausencias encontradas para el día de hoy {{date('Y/m/d')}}</b></p>
    @else
    <p class="text-lg lg:text-xl xl:text-2xl 2xl:text-3xl underline text-center pb-2"> <b>Ausencias encontradas</b></p>
    @endif

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
    <!-- Modal -->
    @if ($details_modal)
    <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 py-10">
        <div class="max-h-full w-full max-w-xl overflow-y-auto  sm:rounded-2xl dark:bg-slate-800 bg-gray-100">
          <div class="w-full">
            <div class="py-12 max-w-[400px] mx-auto">
                <h1 class="mb-5 text-2xl text-center font-bold underline">Detalles de ausencia</h1>
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

