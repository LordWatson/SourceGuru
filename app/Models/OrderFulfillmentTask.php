<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderFulfillmentTask extends Model
{
    protected $casts = [
        'params' => 'array',
        'output' => 'array'
    ];

    public function dependencies(): HasMany
    {
        return $this->hasMany(TaskDependency::class, 'task_id');
    }

    public function step(): BelongsTo
    {
        return $this->belongsTo(FulfillmentStep::class, 'fulfillment_step_id');
    }

    public function paramMappings(): HasMany
    {
        return $this->hasMany(TaskParamMapping::class, 'task_id');
    }

    public function resolveParams(): array
    {
        $resolved = $this->params ?? [];

        foreach($this->paramMappings as $map){
            $sourceOutput = $map->sourceTask->output ?? [];

            if(isset($sourceOutput[$map->source_output_key])){
                $resolved[$map->param_key] = $sourceOutput[$map->source_output_key];
            }
        }

        return $resolved;
    }
}
