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
    public $add_absence = false;

    public $timerelations = [
        'M1' => '08:55',
        'M2' => '09:50',
        'M3' => '10:45',
        'R1' => '11:15',
        'M4' => '12:10',
        'M5' => '13:05',
        'M6' => '14:00',

        'T1' => '14:55',
        'T2' => '15:50',
        'T3' => '16:45',
        'R2' => '17:15',
        'T4' => '18:10',
        'T5' => '19:05',
        'T6' => '20:00',
    ];
    public $timerelationstuesdays = [
        'M1' => '08:55',
        'M2' => '09:50',
        'M3' => '10:45',
        'R1' => '11:15',
        'M4' => '12:10',
        'M5' => '13:05',
        'M6' => '14:00',

        'T1' => '15:45',
        'T2' => '16:30',
        'T3' => '17:15',
        'R2' => '17:45',
        'T4' => '18:30',
        'T5' => '19:15',
        'T6' => '20:00',
    ];


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
        $this->absences = $this->getCurrentAbsences();
        $this->filter->time = $this->currenttime();
        $this->filter->date = date('d/m/Y');
    }
    public function getCurrentAbsences(){
        return $this->allcolumnsquery()
        ->where('time', '=', $this->currenttime())
        ->where('date', '=', date('Y/m/d'))
        ->get();
    }
    public function resetfilters(){
        $this->absences = $this->getCurrentAbsences();
        $this->clearfields();
    }
    public function clearfields(){
        $this->filter->time = null;
        $this->filter->date = null;
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
    //Open and close create foreign absence
    public function openCreateAbsence()
    {
        $this->add_absence = true;
    }
    public function closeCreateAbsence()
    {
        $this->add_absence = false;
        $this->clearfields();
    }
    public function createAbsence()
    {
        Absence::create([
            'user_id' => Auth::id(),
            'date' => $this->filter->date,
            'time' => $this->filter->time,
            'reason' => $this->filter->reason
        ]);
        $this->absences = $this->allcolumnsquery()->get();
        $this->closeCreateAbsence();
    }
    //Function to show specific absence
    public function showspecificabsence($absence_id)
    {
        $this->absence = $this->allcolumnsquery()->where('absences.id', $absence_id)->get();
    }
    public function currenttime(){
        //Checks if today is a Tuesday, to use Tuesday times
        if (date("w") === 2) {
            foreach ($this->timerelationstuesdays as $key => $value) {
                if (date('H:i') <= $value) {
                    return $key;
                }
            }
        }else{
            foreach ($this->timerelations as $key => $value) {
                if (date('H:i') <= $value) {
                    return $key;
                }
            }
        }
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
                break;
            case '01': // time == null && date != null
                $this->absences = $this->allcolumnsquery()
                    ->where('date', $this->filter->date)
                    ->get();
                break;
            case '10': // time != null && date == null
                $this->absences = $this->allcolumnsquery()
                    ->where('time', $this->filter->time)
                    ->get();
                break;
            case '00': // time == null && date == null
            default:
                $this->absences = $this->allcolumnsquery()
                    ->where('date', '=', date('Y/m/d'))
                    ->get();
                    $this->clearfields();
                break;
        }
    }
}
