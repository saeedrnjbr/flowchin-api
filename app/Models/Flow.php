<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Flow extends Model
{

    protected $appends = ["updated_at_fa"];

    protected $fillable = [
        "unique_id",
        "name",
        "pattern",
        "user_id",
        "workspace_id"
    ];


    public function nodes()
    {
        return $this->hasMany(FlowNode::class);
    }


    public function getPatternAttribute()
    {
        return json_decode($this->attributes["pattern"]);
    }

    public function getUpdatedAtFaAttribute()
    {
        return Jalalian::forge($this->updated_at)->format('%A, %d %B %y');
    }
}
