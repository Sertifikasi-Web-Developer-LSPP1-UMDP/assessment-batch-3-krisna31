<?php

namespace App\Models;

use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    public $guarded = [];

    const MAHASISWA = 1;
    const ADMIN = 2;
}
