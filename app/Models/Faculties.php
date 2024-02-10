<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculties extends Model
{
    use HasFactory;

    public $table = 'faculties';

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'contact_no',
        'department_id',
        'employment_status',
    ];

    public $appends = [
        'fullname',
    ];

    public function getFullnameAttribute()
    {
        return Str::upper($this->last_name) . ', ' . Str::upper($this->first_name) . ' ' . Str::upper($this->middle_name) . ' ' . Str::upper($this->suffix);
    }

    public function subjects()
    {
        return $this->hasMany(Subjects::class, 'faculty_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id', 'id');
    }

    public function assignments()
    {
        return $this->hasMany(PeerAssignedEvaluation::class, 'faculty_id', 'id');
    }

    protected static function booted(): void
    {
        static::created(function (Faculties $faculty) {
            $fmLetters = substr($faculty->first_name, 0, 1) . substr($faculty->middle_name, 0, 1);
            $username = str_replace(' ', '', strtolower($fmLetters . $faculty->last_name));
            $password = 'NEMSULiangaPeer';
            $user = User::create([
                'username'      => $username,
                'password'      => bcrypt($password),
                'email'         => $username.'@nemsu.edu.ph',
            ]);

            $faculty->update(['user_id' => $user->id]);
            $role = Role::where('name', 'Peer')->first();

            $user->assignRole([$role->id]);
        });
    }

}
