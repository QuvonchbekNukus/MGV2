<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use App\Traits\LogsActivity;

class Role extends SpatieRole
{
    use LogsActivity;

    // Role modeli uchun qo'shimcha funksiyalar
}

