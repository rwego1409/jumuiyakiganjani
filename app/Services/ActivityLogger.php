<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;

class ActivityLogger
{    public static function log($performedOn, $action, array $properties = [])
    {
        $user = auth()->user();
        $model = $performedOn instanceof Model ? get_class($performedOn) : null;
        $modelId = $performedOn instanceof Model ? $performedOn->id : null;
        
        return \App\Models\Activity::create([
            'user_id' => $user ? $user->id : null,
            'action' => $action,
            'properties' => $properties,
            'description' => "User {$user->name} performed {$action} on {$model} #{$modelId}",
            'target_type' => $model,
            'target_id' => $modelId
        ]);
    }
}
