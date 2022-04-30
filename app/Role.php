<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission;

class Role extends Permission\Models\Role
{
    use HasFactory;
}
