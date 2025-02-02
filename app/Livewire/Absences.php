<?php

namespace App\Livewire;

use App\Livewire\Forms\Filter;
use App\Models\Absence;
use Carbon\Carbon;

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
    public $times = [];
    public $created = false;
    public $inserterror = false;
    public $date_error = false;
    public $expire = false;
    public $openSedit = false;

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
        $this->inserterror = false;
        $this->date_error = false;
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
                'absences.comment',
                'absences.created_at'
            );
    }
    //Mount
    public function mount()
    {
        $this->absences = $this->getCurrentAbsences();
        $this->filter->time = $this->currenttime();
        $this->filter->date = date('Y-m-d');
        $this->created = false;
    }
    //Returns all current (this day and time) absences
    public function getCurrentAbsences(){
        return $this->allcolumnsquery()
        ->where('time', '=', $this->currenttime())
        ->where('date', '=', date('Y/m/d'))
        ->get();
    }
    //Resets all parameters of searching and inserting
    public function resetfilters(){
        $this->absences = $this->getCurrentAbsences();
        $this->clearfields();
        $this->filter->time = $this->currenttime();
        $this->filter->date = date('Y-m-d');
    }
    //Clears searching fields
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
        $this->clearfields();
        $this->add_absence = true;
    }
    public function closeCreateAbsence()
    {
        $this->add_absence = false;
        $this->clearfields();
        $this->filter->time = $this->currenttime();
        $this->filter->date = date('Y-m-d');
        $this->times = [];
    }
    public function createAbsence()
    {

        if (($this->filter->date == null || $this->filter->date == "") || ($this->times == null || $this->times == "")) {
            $this->filter->date = null;
            $this->times =  [];
            $this->inserterror = true;
            $this->closeCreateAbsence();
        }else{
            if ($this->filter->date < date('Y-m-d')) {
                $this->date_error = true;
            }else{
                foreach ($this->times as $time) {
                    Absence::create([
                        'user_id' => Auth::id(),
                        'date' => $this->filter->date,
                        'time' => $time,
                        'comment' => $this->filter->comment
                    ]);
                }
                $this->absences = $this->getCurrentAbsences();
                $this->closeCreateAbsence();
                $this->filter->time = $this->currenttime();
                $this->created = true;
            }
        }
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
    public function expiration ($hora){
        $fecha_insercion = Carbon::parse($hora);
        // Añadirle 10 minutos
        $diez_min_despues = $fecha_insercion->addMinutes(10);
        if (Carbon::now()->greaterThanOrEqualTo($diez_min_despues)) {
            //No se puede editar, han pasado mas de 10 minutos
            return true;
        } else {
            return false;
        }
    }


    public function openSelfEditAbsence($absence){
        $this->closeDetailsModal();
        $this->openSedit = true;
    }
    public function closeSelfEditAbsence(){
        $this->openSedit = false;
    }
    public function editSelfAbsence($absence){


        // Absence::where('id', $id)->update([
        //     'date' => $newDate,
        //     'time' => $newTime,
        //     'comment' => $newComment
        // ]);
        $this->closeDetailsModal();
    }


    public function deleteSelfAbsence($absence){

    }
}