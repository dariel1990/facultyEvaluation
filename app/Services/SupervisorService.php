<?php

namespace App\Services;

use App\Models\Supervisor;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Validator;

class SupervisorService
{
    public function getAllSupervisors()
    {
        return Supervisor::all();
    }

    public function getSupervisorById($id)
    {
        return Supervisor::findOrFail($id);
    }

    public function createSupervisor(array $data)
    {
        $validationSucceeds = !$this->supervisorExists($data);
        if($validationSucceeds) return Supervisor::create($data);
    }

    public function updateSupervisor($id, array $data)
    {
        $supervisor = Supervisor::findOrFail($id);
        $supervisor->update($data);

        return $supervisor;
    }

    public function deleteSupervisor($id)
    {
        Supervisor::findOrFail($id)->delete();
    }

    //Duplication Validation
    protected function supervisorExists(array $data)
    {
        return Supervisor::where([
            'last_name' => $data['last_name'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
        ])->exists();
    }

}
