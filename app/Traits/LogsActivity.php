<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            if ($userId = auth('sanctum')->id()) { // هنا استخدمنا الـ Sanctum guard
                ActivityLog::create([
                    'user_id' => $userId,
                    'model_type' => get_class($model),
                    'model_id' => $model->id,
                    'action' => 'created',
                    'changes' => json_encode($model->getAttributes()),
                ]);
            }
        });

        static::updated(function ($model) {
            if ($userId = auth('sanctum')->id()) {
                ActivityLog::create([
                    'user_id' => $userId,
                    'model_type' => get_class($model),
                    'model_id' => $model->id,
                    'action' => 'updated',
                    'changes' => json_encode($model->getChanges() ?: $model->getAttributes()),
                ]);
            }
        });

        static::deleted(function ($model) {
            if ($userId = auth('sanctum')->id()) {
                ActivityLog::create([
                    'user_id' => $userId,
                    'model_type' => get_class($model),
                    'model_id' => $model->id,
                    'action' => 'deleted',
                    'changes' => null,
                ]);
            }
        });
    }
}
