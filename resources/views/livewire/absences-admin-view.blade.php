<div wire:poll class="text-[7px] md:text-[10px] lg:text-[12px] xl:text-[14px] 2xl:text-[16px]">
    <h2 class="text-center text-[12px] md:text-[14px] lg:text-[16px] xl:text-[18px] 2xl:text-[22px]">ESTO ES UNA VISTA PRIVADA QUE SOLO VERÁ EL <b class="text-red-500">ADMINISTRADOR</b></h2>
    <button wire:click="openCreateAdminAbsence" class="btn-default overflow-hidden relative bg-sky-300 text-gray-900 p-2 mb-5 rounded-lg font-bold uppercase transition-all duration-100 -- hover:shadow-md border border-neutral-100 hover:bg-gradient-to-t hover:from-sky-400 before:to-sky-50 0 dark:border-gray-700 hover:-translate-y-[3px]">Añadir una falta</button>
    <div class="text-gray-900 dark:text-gray-100 text-center"">
        <form wire:submit="submitform" action="#">
            <div id="Inputs" class="flex justify-evenly p-10">
                <div class="text-center">
                    <label for="time">Hora</label><br>
                    <select id="time" name="time" wire:model="filter.time" class="bg-neutral-50 text-[7px] md:text-[10px] lg:text-[12px] xl:text-[14px] 2xl:text-[16px] dark:bg-slate-600 dark:text-white text-gray-900 p-1 rounded-lg transition-all duration-100 -- hover:shadow-md border border-neutral-200 dark:border-gray-700 hover:dark:from-slate-900 before:dark:to-slate-700 hover:-translate-y-[3px]">
                        <option value={{null}}>Filtrar por hora</option>
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
            <div class="text-center mb-2">
                <button type="submit" class="btn-default overflow-hidden relative bg-neutral-200 dark:bg-slate-600 dark:text-white text-gray-900 p-2 rounded-lg font-bold uppercase transition-all duration-100 -- hover:shadow-md border border-neutral-100 dark:border-gray-700 hover:bg-gradient-to-t hover:from-neutral-300 before:to-neutral-50 hover:dark:from-slate-900 before:dark:to-slate-700 hover:-translate-y-[3px]">
                    <span class="relative">Buscar por filtros</span>
                </button>
            </div>
            <button wire:click.prevent="resetfilters" class="mb-8 btn-default overflow-hidden relative bg-green-200 dark:bg-green-600 dark:text-white text-gray-900 p-2 rounded-lg font-bold uppercase transition-all duration-100 -- hover:shadow-md border border-green-100 dark:border-gray-700 hover:bg-gradient-to-t hover:from-green-300 before:to-green-50 hover:dark:from-green-900 before:dark:to-green-700 hover:-translate-y-[3px]">
                <span class="relative">Reiniciar filtros</span>
            </button>
        </form>
        @if ($created)
        <p class="mb-6">Se han creado las ausencias</p>   
        @endif
    </div>
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
                    <button wire:click.prevent="deleteAbsence" wire:confirm.prevent="¿Está seguro de que desea eliminar esta ausencia?" class="btn-default overflow-hidden relative bg-red-500 dark:bg-red-500 text-white p-2 rounded-lg font-bold uppercase transition-all duration-100 -- hover:shadow-md border border-red-500 hover:bg-gradient-to-t  hover:from-red-500 before:to-red-600 hover:-translate-y-[3px]">
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
    @if ($add_admin_absence)
        <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 py-10">
            <div class="max-h-full w-full lg:max-w-xl lg:p-0 px-10 max-w-fit overflow-y-auto sm:rounded-2xl dark:bg-slate-800 bg-gray-100">
                <div class="w-full">
                    <div class="py-12 max-w-[400px] mx-auto">
                        <h1 class="mb-5 text-center font-bold underline">Campos para rellenar ausencia ajena</h1>
                        <form wire:submit="submitform" action="#">
                            <div id="Inputs" class="flex justify-evenly p-5">
                                <div class="text-center w-full">
                                    <label for="teacher">Profesor</label><br>
                                    <select id="teacher" name="teacher" wire:model="filter.teacher" class="bg-neutral-50 text-[7px] md:text-[10px] lg:text-[12px] xl:text-[14px] 2xl:text-[16px] dark:bg-slate-600 dark:text-white text-gray-900 p-1 rounded-lg transition-all duration-100 -- hover:shadow-md border border-neutral-200 dark:border-gray-700 hover:dark:from-slate-900 before:dark:to-slate-700 hover:-translate-y-[3px]">
                                        <option selected value={{null}}>Profesores</option>
                                        @foreach ($this->teachers as $teacher)
                                            <option value='{{$teacher->name}}'>{{$teacher->name}}</option>
                                        @endforeach
                                    </select><br><br>
                                    <label for="time">Hora</label><br>
                                    <div id="time" name="time" class="flex justify-evenly">
                                        <div class="text-left">
                                            <input type="checkbox" name="M1" wire:model="times" id="M1" value="M1">
                                            <label for="M1">M1 (Mañana)</label><br>
                                            <input type="checkbox" name="M2" wire:model="times" id="M2" value="M2">
                                            <label for="M2">M2 (Mañana)</label><br>
                                            <input type="checkbox" name="M3" wire:model="times" id="M3" value="M3">
                                            <label for="M3">M3 (Mañana)</label><br>
                                            <input type="checkbox" name="R1" wire:model="times" id="R1" value="R1">
                                            <label for="R1">R1 (Recreo Mañana)</label><br>
                                            <input type="checkbox" name="M4" wire:model="times" id="M4" value="M4">
                                            <label for="M4">M4 (Mañana)</label><br>
                                            <input type="checkbox" name="M5" wire:model="times" id="M5" value="M5">
                                            <label for="M5">M5 (Mañana)</label><br>
                                            <input type="checkbox" name="M6" wire:model="times" id="M6" value="M6">
                                            <label for="M6">M6 (Mañana)</label><br>
                                        </div>
                                        <div class="text-left">
                                            <input type="checkbox" name="T1" wire:model="times" id="T1" value="T1">
                                            <label for="T1">T1 (Tarde)</label><br>
                                            <input type="checkbox" name="T2" wire:model="times" id="T2" value="T2">
                                            <label for="T2">T2 (Tarde)</label><br>
                                            <input type="checkbox" name="T3" wire:model="times" id="T3" value="T3">
                                            <label for="T3">T3 (Tarde)</label><br>
                                            <input type="checkbox" name="R2" wire:model="times" id="R2" value="R2">
                                            <label for="R2">R2 (Recreo Tarde)</label><br>
                                            <input type="checkbox" name="T4" wire:model="times" id="T4" value="T4">
                                            <label for="T4">T4 (Tarde)</label><br>
                                            <input type="checkbox" name="T5" wire:model="times" id="T5" value="T5">
                                            <label for="T5">T5 (Tarde)</label><br>
                                            <input type="checkbox" name="T6" wire:model="times" id="T6" value="T6">
                                            <label for="T6">T6 (Tarde)</label><br>
                                        </div>
                                    </div><br><br>
                                    <label for="date">Fecha</label><br>
                                    <input type="date" id="date" name="date" wire:model="filter.date"  class="bg-neutral-50 text-[7px] md:text-[10px] lg:text-[12px] xl:text-[14px] 2xl:text-[16px] dark:bg-slate-600 dark:text-white text-gray-900 p-1 rounded-lg transition-all duration-100 -- hover:shadow-md border border-neutral-200 dark:border-gray-700 hover:dark:from-slate-900 before:dark:to-slate-700 hover:-translate-y-[3px]">
                                    <br><br>
                                    <label for="razon">Razón</label><br>
                                    <textarea id="razon" name="razon" wire:model="filter.reason" placeholder="Razón por la que faltará" class="w-full bg-neutral-50 text-[7px] md:text-[10px] lg:text-[12px] xl:text-[14px] 2xl:text-[16px] dark:bg-slate-600 dark:text-white text-gray-900 p-1 rounded-lg transition-all duration-100 -- hover:shadow-md border border-neutral-200 dark:border-gray-700 hover:dark:from-slate-900 before:dark:to-slate-700 hover:-translate-y-[3px]"></textarea>
                                </div>
                            </div>
                        </form>
                        <div class="space-y-4 ">
                            <div class="text-center">
                                <button wire:click="createAdminAbsence" class="btn-default overflow-hidden relative bg-red-500 text-white p-2 rounded-lg font-bold uppercase transition-all duration-100 -- hover:shadow-md border border-red-500 dark:border-gray-700 hover:bg-gradient-to-t hover:from-red-400 before:to-red-700 hover:dark:from-red-700 before:dark:to-red-700 hover:-translate-y-[3px]">
                                    Añadir falta
                                </button>
                                <button wire:click="closeCreateAdminAbsence" class="btn-default overflow-hidden relative bg-neutral-200 dark:bg-slate-600 dark:text-white text-gray-900 p-2 rounded-lg font-bold uppercase transition-all duration-100 -- hover:shadow-md border border-neutral-100 dark:border-gray-700 hover:bg-gradient-to-t hover:from-neutral-300 before:to-neutral-50 hover:dark:from-red-600 before:dark:to-slate-700 hover:-translate-y-[3px]">
                                    Salir de añadir ausencia
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
