<?php

namespace App\Livewire;

use App\Models\Absence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Absences extends Component
{
    public $absences;
    public $details_modal = false;
    public $absence;
    public $column;
    public function render()
    {
        return view('livewire.absences');
    }
    // Query to get all important columns from all tables
    public function allcolumnsquery(){
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
    public function mount()
    {
        $this->absences = $this->allcolumnsquery()->get();
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
    public function closeDetailsModal()
    {
        $this->details_modal = false;
        $this->absence = null;
    }
    public function showspecificabsence($absence_id)
    {
        $this->absence = $this->allcolumnsquery()->where('absences.id', $absence_id)->get();
    }
}
