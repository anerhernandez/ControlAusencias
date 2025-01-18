<?php

namespace App\Livewire;

use App\Models\Absence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Absences extends Component
{
    public $absences;


    public function render()
    {
        return view('livewire.absences');
    }
    public function mount()
    {
        $this->absences = DB::table('absences')
        ->join('users', 'users.id', '=', 'absences.user_id')
        ->join('departments', 'users.department_id', '=', 'departments.id')
        ->get();
        
    }
    public function createAbsence(){
        Absence::create([
            'user_id' => Auth::id(),
            'date' => $this->date,
            'time' => $this->time,
            'reason' => $this->reason
        ]);
        $this->absences = Absence::all();
    }
}
