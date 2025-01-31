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
        $this->filter->date = date('Y-m-d');
        $this->created = false;
        $this->inserterror = false;
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
        $this->clearadminfields();
    }
    //Cloes create foreign absence
    public function closeCreateAdminAbsence()
    {
        $this->add_admin_absence = false;
        $this->filter->date = date('Y-m-d');
    }
    public function clearadminfields(){
        $this->clearfields();
        $this->filter->teacher = "";
        $this->filter->comment = "";
    }
    public function resetfiltersadmin(){
        $this->absences = $this->allcolumnsquery()->where('date', '=', date('Y/m/d'))->get();
        $this->clearfields();
        $this->filter->date = date('Y-m-d');
    }
    public function createAdminAbsence(){

        if (($this->filter->teacher == null || $this->filter->teacher == "") || ($this->filter->date == null || $this->filter->date == "") || ($this->times == null || $this->times == "")) {
            $this->filter->teacher = null;
            $this->filter->date = null;
            $this->times =  [];
            $this->inserterror = true;
            $this->closeCreateAdminAbsence();
        }else{
            $teacher_id = DB::table('users')->where("name", "=", $this->filter->teacher)->select("id")->get();
            
    
            foreach ($this->times as $time) {
                Absence::create([
                    'user_id' => $teacher_id[0]->id,
                    'date' => $this->filter->date,
                    'time' => $time,
                    'comment' => $this->filter->comment
                ]);
            }
            $this->absences = $this->allcolumnsquery()->where('date', '=', date('Y/m/d'))->get();
            $this->closeCreateAdminAbsence();
            $this->created = true;
        }
        
    }
}
