<?php

namespace App\Controller;

use App\Entity\Role;

class RoleController {
    
    public function __invoke(Role $data): Role
    {
        $rr = $data;
        dd($rr);
    }
}