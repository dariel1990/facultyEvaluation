<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;

    public $table = 'questions';

    protected $fillable = [
        'criteria_id',
        'question',
    ];

    public function class()
    {
        return $this->belongsTo(Criteria::class, 'criteria_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(Answers::class, 'question_id', 'id');
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class, 'criteria_id', 'id');
    }
}
