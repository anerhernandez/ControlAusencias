<div>
    @if ($absences->isEmpty())
        <p colspan="4">No absences found.</p>
    @else
    <div class=" text-gray-900 dark:text-gray-100 text-center"> 
        <b class="text-2xl underline">Tabla de ausencias</b>
        <div id="Inputs" class="flex justify-evenly p-10">
            <div class="text-center">
                <label for="time">Hora</label>
                <select id="time" name="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Filtrar por hora</option>
                    <option value="M1">M1 (Mañana)</option>
                    <option value="M2">M2 (Mañana)</option>
                    <option value="M3">M3 (Mañana)</option>
                    <option value="B1">R1 (Recreo Mañana)</option>
                    <option value="M4">M4 (Mañana)</option>
                    <option value="M5">M5 (Mañana)</option>
                    <option value="M6">M6 (Mañana)</option>
                    <option value="T1">A1 (Tarde)</option>
                    <option value="T2">A2 (Tarde)</option>
                    <option value="T3">A3 (Tarde)</option>
                    <option value="B2">R2 (Recreo Tarde)</option>
                    <option value="T4">A4 (Tarde)</option>
                    <option value="T5">A5 (Tarde)</option>
                    <option value="T6">A6 (Tarde)</option>
                  </select>
            </div>
            <div class="text-center">
                <label for="date">Fecha</label><br>
                <input type="date" name="date" id="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 ">
            </div>
        </div >
        <div class="text-center mb-8">
            <button class="btn-default overflow-hidden relative w-52 bg-stone-50 dark:bg-gray-700 dark:text-white text-gray-900 py-4 px-4 rounded-xl font-bold uppercase transition-all duration-100 -- hover:shadow-md border border-stone-100 dark:border-gray-700 hover:bg-gradient-to-t hover:from-stone-100 before:to-stone-50 hover:dark:from-gray-800 before:dark:to-gray-900 hover:-translate-y-[3px]">
                <span class="relative">Buscar por filtros</span>
              </button>
        </div>
    </div>
    <div class="container overflow-hidden dark:rounded-lg dark:border dark:border-slate-800 border border-gray-250 rounded">
        <table class="text-left w-full border-collapse rounded bg-gray-50">
            <thead class="dark:bg-gray-900 flex dark:text-white w-full ">
                <tr class="flex w-full text-center mr-4">
                    <th class="p-4 w-1/5">Profesor</th>
                    <th class="p-4 w-1/5">Fecha</th>
                    <th class="p-4 w-1/5">Hora</th>
                    <th class="p-4 w-1/5">Razón</th>
                    <th class="p-4 w-1/5">Detalles</th>
                </tr>
            </thead>
            <tbody class="dark:bg-slate-700  flex flex-col overflow-y-scroll w-full" style="height: 50vh;">
            @foreach ($absences as $absence)
                <tr class="flex w-full border dark:border-slate-800 border-gray-250 text-center">
                    <td class="p-4 w-1/5 place-content-center dark:border-slate-800 overflow-hidden">{{ $absence->user_name}}</td>
                    <td class="p-4 w-1/5 place-content-center dark:border-slate-800 overflow-hidden">{{ $absence->date }}</td>
                    <td class="p-4 w-1/5 place-content-center dark:border-slate-800 overflow-hidden">{{ $absence->time }}</td>
                    <td class="p-4 w-1/5 place-content-center dark:border-slate-800 overflow-hidden">{{ $absence->reason }}</td>
                    <td class="p-4 w-1/5 place-content-center dark:border-slate-800 overflow-hidden">
                        <button wire:click="openDetailsModal({{ $absence->absence_id }})" class="btn-default overflow-hidden relative w-52 bg-stone-100 dark:bg-slate-600 dark:text-white text-gray-900 py-4 px-4 rounded-xl font-bold uppercase transition-all duration-100 -- hover:shadow-md border border-stone-100 dark:border-gray-700 hover:bg-gradient-to-t hover:from-stone-100 before:to-stone-50 hover:dark:from-slate-900 before:dark:to-slate-700 hover:-translate-y-[3px]">
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
        <div class="max-h-full w-full max-w-xl overflow-y-auto sm:rounded-2xl dark:bg-slate-800 bg-gray-100">
          <div class="w-full">
            <div class="py-12 max-w-[400px] mx-auto">
                <h1 class="mb-5 text-2xl text-center font-bold underline">Absence details</h1>
              <div class="space-y-4">
                <table>
                    <tr>
                        <td class="p-2">Teacher:</td>
                        <td class="p-2">{{$this->absence[0]->user_name}}</td>
                    </tr>
                    <tr>
                        <td class="p-2">Department:</td>
                        <td class="p-2">{{$this->absence[0]->department_name}}</td>
                    </tr>
                    <tr>
                        <td class="p-2">Date:</td>
                        <td class="p-2">{{$this->absence[0]->date}}</td>
                    </tr>
                    <tr>
                        <td class="p-2">Time:</td>
                        <td class="p-2">{{$this->absence[0]->time}}</td>
                    </tr>
                    <tr>
                        <td class="p-2">Reason:</td>
                        <td class="p-2">{{$this->absence[0]->reason}}</td>
                    </tr>

                </table>
                <div class="text-center">
                    <button wire:click="closeDetailsModal" class="btn-default overflow-hidden relative w-52 bg-stone-50 dark:bg-gray-700 dark:text-white text-gray-900 py-4 px-4 rounded-xl font-bold uppercase transition-all duration-100 -- hover:shadow-md border border-stone-100 dark:border-gray-700 hover:bg-gradient-to-t hover:from-stone-100 before:to-stone-50 hover:dark:from-gray-800 before:dark:to-gray-900 hover:-translate-y-[3px]">
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

