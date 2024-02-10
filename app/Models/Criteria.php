<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    public $table = 'criterias';

    protected $fillable = [
        'criteria',
        'order_by',
        'percentage',
    ];

    public function question()
    {
        return $this->hasMany(Questions::class, 'criteria_id', 'id');
    }
}
