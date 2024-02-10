<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supervisor extends Model
{
    use HasFactory;

    public $table = 'supervisors';

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'contact_no',
    ];

    public $appends = [
        'fullname',
    ];

    public function getFullnameAttribute()
    {
        return Str::upper($this->last_name) . ', ' . Str::upper($this->first_name) . ' ' . Str::upper($this->middle_name) . ' ' . Str::upper($this->suffix);
    }

    public function assignments()
    {
        return $this->hasMany(SupervisorAssignedEvaluation::class, 'supervisor_id', 'id');
    }

    protected static function booted(): void
    {
        static::created(function (Supervisor $supervisor) {
            $fmLetters = substr($supervisor->first_name, 0, 1) . substr($supervisor->middle_name, 0, 1);
            $username = str_replace(' ', '', strtolower($fmLetters . $supervisor->last_name));
            $password = 'NEMSULiangaSupervisor';
            $user = User::create([
                'username'      => $username,
                'password'      => bcrypt($password),
                'email'         => $username.'@nemsu.edu.ph',
            ]);

            $supervisor->update(['user_id' => $user->id]);
            $role = Role::where('name', 'Supervisor')->first();

            $user->assignRole([$role->id]);
        });
    }
}
