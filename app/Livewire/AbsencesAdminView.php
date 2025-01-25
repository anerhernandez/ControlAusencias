<?php

namespace App\Livewire;

use App\Livewire\Absences;
use Illuminate\Support\Facades\DB;

class AbsencesAdminView extends Absences
{

    public $absences;
    public $absence;

    public function render()
    {
        return view('livewire.absences-admin-view');
    }
    public function mount(){
        $this->absences = $this->allcolumnsquery()
        ->get();
    }
    public function editabsence(){
        $this->closeDetailsModal();
        return 0;
    }
    public function deletebsence(){
        DB::table('absences')->where('id', '=', $this->absence[0]->absence_id)->delete();
        $this->closeDetailsModal();
    }}
