<?php

namespace App\Livewire;

use App\Livewire\Absences;
use App\Models\Absence;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AbsencesAdminView extends Absences
{

    public $absences;
    public $absence;
    public $add_admin_absence = false;
    public $teachers;
    public $view_admin = true;
    public $view_add_teachers = false;
    public $departments;

    public $teacher_name;
    public $teacher_email;
    public $teacher_dp;
    public $createdt = false;

    public $admininserted = false;
    public function viewadmin()
    {
        $this->view_admin = true;
        $this->view_add_teachers = false;
    }
    public function viewaddteachers()
    {
        $this->view_admin = false;
        $this->view_add_teachers = true;
    }
    public function render()
    {
        return view('livewire.absences-admin-view');
    }
    
    public function mount(){
        $this->absences = $this->allcolumnsquery()->where('date', '=', date('Y/m/d'))->get();
        $this->teachers = DB::table('users')->whereNotLike('id', 1)->get();
        $this->filter->date = date('Y-m-d');
        $this->created = false;
        $this->createdt = false;
        $this->inserterror = false;
        $this->departments = DB::table('departments')->whereNot('id', '=', 1)->get();
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


    //Teacher methods
    public function insertTeacher(){
        if (($this->teacher_name == null || $this->teacher_name == "") || ($this->teacher_email == null || $this->teacher_email == "") || ($this->teacher_dp == null || $this->teacher_dp == "")) {
            $this->teacher_name = null;
            $this->teacher_email = null;
            $this->teacher_dp = null;
            $this->inserterror = true;
        }else{
            if($this->teacher_dp == 1){
                $this->admininserted = true;
            }
            User::updateOrInsert([
                'email' => $this->teacher_email
            ],[
                'name' => $this->teacher_name,
                'email' => $this->teacher_email,
                'password' => Hash::make('D3f_aUlT_/7pA$S$W0r*D'),
                'department_id' => $this->teacher_dp
            ]);
            $restofTeachers = User::where('id', '!=' , 1)->get();
            foreach ($restofTeachers as $teacher) {
                $teacher->assignRole("teacher");
            }
            $this->teacher_name = null;
            $this->teacher_email = null;
            $this->teacher_dp = null;
            $this->createdt = true;
        }
    }
}
