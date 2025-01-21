<div>
    @if ($absences->isEmpty())
        <P colspan="4">No absences found.</P>
    @else
    <div class="container overflow-hidden rounded-lg border border-slate-800">
        <h2 class="text-2xl mb-10 text-gray-900 dark:text-gray-100"> 
            Absences table
        </h2>
        <table class="text-left w-full border-collapse rounded">
            <thead class="bg-gray-900 flex text-white w-full ">
                <tr class="flex w-full text-center mr-4">
                    <th class="p-4 w-1/5">Teacher</th>
                    <th class="p-4 w-1/5">Date</th>
                    <th class="p-4 w-1/5">Time</th>
                    <th class="p-4 w-1/5">Reason</th>
                    <th class="p-4 w-1/5">Details</th>
                </tr>
            </thead>
            <tbody class="bg-slate-700 flex flex-col overflow-y-scroll w-full" style="height: 50vh;">
            @foreach ($absences as $absence)
                <tr class="flex w-full border border-gray-900 text-center">
                    <td class="p-4 w-1/5 place-content-center border-slate-800 overflow-hidden">{{ $absence->user_name}}</td>
                    <td class="p-4 w-1/5 place-content-center border-slate-800 overflow-hidden">{{ $absence->date }}</td>
                    <td class="p-4 w-1/5 place-content-center border-slate-800 overflow-hidden">{{ $absence->time }}</td>
                    <td class="p-4 w-1/5 place-content-center border-slate-800 overflow-hidden">{{ $absence->reason }}</td>
                    <td class="p-4 w-1/5 place-content-center border-slate-800 overflow-hidden">
                        <button wire:click="openDetailsModal({{ $absence->absence_id }})" class="p-2 group relative overflow-hidden rounded-lg bg-teal-300 text-lg shadow">
                            <div class="absolute inset-0 w-0 bg-teal-700 transition-all duration-[300ms] ease-out group-hover:w-full"></div>
                            <span class="relative text-black group-hover:text-white duration-500">Details</span>
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
        <div class="max-h-full w-full max-w-xl overflow-y-auto sm:rounded-2xl bg-slate-800">
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
                <button wire:click="closeDetailsModal" class="border rounded-full w-full font-semibold p-2 group relative overflow-hidden bg-white text-lg shadow">
                    <div class="absolute inset-0 w-0 bg-black transition-all duration-[300ms] ease-in-out group-hover:w-full"></div>
                    <span class="relative text-black group-hover:text-white duration-500">Exit details</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
</div>

