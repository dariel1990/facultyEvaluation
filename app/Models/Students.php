<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Observers\StudentObserver;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Students extends Model
{
    use HasFactory;

    public $table = 'students';

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'course',
        'year_level',
        'section',
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
        return $this->belongsToMany(Subjects::class, 'subject_students', 'student_id', 'subject_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function assignments()
    {
        return $this->hasMany(StudentAssignedEvaluation::class, 'student_id', 'id');
    }

    protected static function booted(): void
    {
        static::created(function (Students $student) {
            $username = str_replace(' ', '', strtolower($student->last_name.''.$student->id));
            $password = 'NEMSULianga';
            $user = User::create([
                'username'      => $username,
                'password'      => bcrypt($password),
                'email'         => $username.'@nemsu.edu.ph',
            ]);

            $student->update(['user_id' => $user->id]);
            $role = Role::where('name', 'Student')->first();

            $user->assignRole([$role->id]);
        });
    }

}
