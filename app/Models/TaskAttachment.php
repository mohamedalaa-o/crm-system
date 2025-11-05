<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;


class TaskAttachment extends Model
{
    use  LogsActivity;
    protected $fillable = ['task_id', 'path'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
