<?php

namespace Captain\module\models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role  extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    public $table = "roles";

    protected $primaryKey = "id";

    protected $fillable = [
        "name",
        "guard_name"
    ];
}
