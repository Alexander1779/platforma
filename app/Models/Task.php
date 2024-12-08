<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'start',
        'end',
        'status',
        'public',
    ];

    public function taskUsers():HasMany
    {
        return $this->hasMany(TaskUser::class, 'task_id', 'id');
    }
}
