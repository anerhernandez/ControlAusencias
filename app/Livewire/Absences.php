<?php

namespace App\Livewire;

use App\Livewire\Forms\Filter;
use App\Models\Absence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Absences extends Component
{
    public Filter $filter;
    public $absences;
    public $details_modal = false;
    public $absence;
    public $column;
    public $currentabsences = true;
    public function render()
    {
        return view('livewire.absences');
    }
    // Query to get all important columns from all tables
    public function allcolumnsquery()
    {
        return DB::table('users')
            ->join('absences', 'users.id', '=', 'absences.user_id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->select(
                'absences.id as absence_id',
                'users.name as user_name',
                'users.email as user_email',
                'users.id as user_id',
                'departments.id as department_id',
                'departments.dp_name as department_name',
                'absences.date',
                'absences.time',
                'absences.reason'
            );
    }
    //Mount
    public function mount()
    {
        $this->absences = $this->allcolumnsquery()->where('date', '=', date('Y/m/d'))->get();
    }
    public function createAbsence()
    {
        Absence::create([
            'user_id' => Auth::id(),
            'date' => $this->date,
            'time' => $this->time,
            'reason' => $this->reason
        ]);
        $this->absences = Absence::all();
    }
    // Function to open the details modal
    public function openDetailsModal($absence_id)
    {
        $this->details_modal = true;
        $this->absence = $this->allcolumnsquery()->where('absences.id', $absence_id)->get();
    }
    //Function to close the details modal
    public function closeDetailsModal()
    {
        $this->details_modal = false;
        $this->absence = null;
    }
    //Function to show specific absence
    public function showspecificabsence($absence_id)
    {
        $this->absence = $this->allcolumnsquery()->where('absences.id', $absence_id)->get();
    }
    public function submitform()
    {
        
        $times = ['M1','M2','M3','M4','M5','M6','R1','R2','T1','T2','T3','T4','T5','T6'];
        $switchCondition = (in_array($this->filter->time, $times) ? '1' : '0') . ($this->filter->date != null && $this->filter->date != "" ? '1' : '0');
        switch ($switchCondition) {
            case '11': // time != null && date != null
                $this->absences = $this->allcolumnsquery()
                    ->where('date', $this->filter->date)
                    ->where('time', $this->filter->time)
                    ->get();
                    $this->currentabsences = false;
                break;

            case '01': // time == null && date != null
                $this->absences = $this->allcolumnsquery()
                    ->where('date', $this->filter->date)
                    ->get();
                    if($this->filter->date == date('Y-m-d')){
                        $this->currentabsences = true;
                    }
                    else{
                        $this->currentabsences = false;
                    }
                break;

            case '10': // time != null && date == null
                $this->absences = $this->allcolumnsquery()
                    ->where('time', $this->filter->time)
                    ->get();
                    $this->currentabsences = false;
                break;

            case '00': // time == null && date == null
            default:
                $this->absences = $this->allcolumnsquery()
                    ->where('date', '=', date('Y/m/d'))
                    ->get();
                    $this->currentabsences = true;
                break;
        }
    }
}
