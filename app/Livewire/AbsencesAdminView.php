<?php

namespace App\Livewire;

use App\Livewire\Absences;
use App\Models\Absence;
use Illuminate\Support\Facades\DB;

class AbsencesAdminView extends Absences
{

    public $absences;
    public $absence;
    public $add_admin_absence = false;
    public $teachers;
    public function render()
    {
        return view('livewire.absences-admin-view');
    }
    public function mount(){
        $this->absences = $this->allcolumnsquery()->where('date', '=', date('Y/m/d'))->get();
        $this->teachers = DB::table('users')->whereNotLike('id', 1)->get();
        $this->created = false;
    }
    public function editAbsence(){
        $this->closeDetailsModal();
        return 0;
    }
    //Delete absence
    public function deleteAbsence(){
        DB::table('absences')->where('id', '=', $this->absence[0]->absence_id)->delete();
        $this->absences = $this->allcolumnsquery()->where('date', '=', date('Y/m/d'))->get();
        $this->closeDetailsModal();
    }
    //Open create foreign absence
    public function openCreateAdminAbsence()
    {
        $this->add_admin_absence = true;
    }
    //Cloes create foreign absence
    public function closeCreateAdminAbsence()
    {
        $this->add_admin_absence = false;
        $this->clearadminfields();
    }
    public function clearadminfields(){
        $this->clearfields();
        $this->filter->teacher = "";
        $this->filter->reason = "";
    }
    public function createAdminAbsence(){

        $teacher_id = DB::table('users')->where("name", "=", $this->filter->teacher)->select("id")->get();
        foreach ($this->times as $time) {
            Absence::create([
                'user_id' => $teacher_id[0]->id,
                'date' => $this->filter->date,
                'time' => $time,
                'reason' => $this->filter->reason
            ]);
        }
        $this->absences = $this->allcolumnsquery()->where('date', '=', date('Y/m/d'))->get();
        $this->closeCreateAdminAbsence();
        $this->created = true;
    }
}
