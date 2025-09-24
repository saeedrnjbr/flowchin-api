<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workspace extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "name",
        "description",
        "user_id"
    ];

    public function setNameAttribute($value)
    {
        $this->attributes["name"] = htmlspecialchars(strip_tags($value));
    }

    public function flows()
    {
        return $this->hasMany(Flow::class);
    }
}
