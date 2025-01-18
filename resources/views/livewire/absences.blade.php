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
                <tr class="flex w-full mb-4">
                    <th class="p-4 w-1/4">Teacher</th>
                    <th class="p-4 w-1/4">Date</th>
                    <th class="p-4 w-1/4">Time</th>
                    <th class="p-4 w-1/4">Reason</th>
                </tr>
            </thead>
            <tbody class="bg-slate-700 flex flex-col items-center justify-between overflow-y-scroll w-full" style="height: 50vh;">
            @foreach ($absences as $absence)
                <tr class="flex w-full mb-4 border border-gray-900">
                    <td class="p-4 w-1/4 border border-slate-800 overflow-hidden">{{ $absence->name}}</td>
                    <td class="p-4 w-1/4 border border-slate-800 overflow-hidden">{{ $absence->date }}</td>
                    <td class="p-4 w-1/4 border border-slate-800 overflow-hidden">{{ $absence->time }}</td>
                    <td class="p-4 w-1/4 border border-slate-800 overflow-hidden">{{ $absence->reason }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
