<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{

    protected $appends = ["icon_url", "label", "attributes"];

    protected $fillable = [
        "name",
        "icon",
        "type",
    ];

    public function getIconUrlAttribute()
    {
        return implode("/uploads/", [url("/"), $this->icon]);
    }

    public function getLabelAttribute()
    {
        return "";
    }

    public function getAttributesAttribute()
    {
        return "";
    }
}
