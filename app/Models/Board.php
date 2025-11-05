<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class Board extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = ['title', 'description', 'created_by', 'status'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'board_user', 'board_id', 'user_id');
    }
}
