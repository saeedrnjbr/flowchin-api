<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlowNode extends Model
{
    protected $fillable = [
        "flow_id",
        "integration_id",
        "params"
    ];

    public function integration()
    {
        return $this->belongsTo(Integration::class);
    }
}
