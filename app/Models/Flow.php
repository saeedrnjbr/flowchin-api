<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Flow extends Model
{

    protected $appends = ["updated_at_fa", "icon_url"];

    protected $casts = ["has_marketplace" => "integer"];

    protected $fillable = [
        "unique_id",
        "name",
        "description",
        "logo",
        "price",
        "discount",
        "has_marketplace",
        "pattern",
        "user_id",
        "workspace_id",
        "price",
        "discount",
        "content",
        "icon",
    ];

    public function setNameAttribute($value)
    {
        $this->attributes["name"] = htmlspecialchars(strip_tags($value));
    }

    public function setContentAttribute($value)
    {
        $this->attributes["content"] = htmlspecialchars(strip_tags($value));
    }

    public function getIconUrlAttribute()
    {
        return implode("/uploads/", [url("/"), $this->icon]);
    }

    public function nodes()
    {
        return $this->hasMany(FlowNode::class);
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function getPatternAttribute()
    {

        $pattern = json_decode($this->attributes["pattern"]);

        if (!empty($pattern->nodes)) {

            foreach ($pattern->nodes as $n => $node) {

                $node->data->meta = Integration::find($node->data->meta);

                $pattern->nodes[$n] = $node;
            }
        }

        return $pattern;
    }


    public function getUpdatedAtFaAttribute()
    {
        return Jalalian::forge($this->updated_at)->format('%A, %d %B %y');
    }
}
