<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'date',
        'category_id',
        'user_id',
        'urgency',
    ];

    public function TaskCategory(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(TaskCategory::class,'task_categories','id');
    }

    public function User(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class,'user_id','id');
    }
}
