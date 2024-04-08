<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskCategory extends Model
{
    use HasFactory;
    protected $table = 'task_categories';
    public $timestamps = true;

    protected $fillable = [
        'name'
    ];

    public function Task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
