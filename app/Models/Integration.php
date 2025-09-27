<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Integration extends Model
{
    use SoftDeletes;

    protected $appends = ["icon_url", "colors", "unique_id"];

    protected $fillable = [
        "name",
        "background",
        "description",
        "loop",
        "slug",
        "icon",
        "parent_id",
        "type",
        "input",
        "output",
        "is_mcp_server",
        "orders",
    ];

    public function getIconUrlAttribute()
    {
        return implode("/uploads/", [url("/"), $this->icon]);
    }

    public function getUniqueIdAttribute()
    {
        return uniqid();
    }

    public function getBackgroundAttribute()
    {
        if (!empty($this->attributes["background"])) {
            return   $this->attributes["background"];
        }

        if (!empty($this->parent->background)) {
            return $this->parent->background;
        }

        return  $this->attributes["background"];
    }

    public function getColorsAttribute()
    {

        if (!empty($this->background)) {
            return [
                $this->background => config("colors")[$this->background]
            ];
        }

        if (!empty($this->parent->background)) {
            return [
                $this->parent->background => config("colors")[$this->parent->background]
            ];
        }

        return [];
    }

    public function children()
    {
        return $this->hasMany(Integration::class, "parent_id");
    }

    public function parent()
    {
        return $this->belongsTo(Integration::class, "parent_id");
    }
}
