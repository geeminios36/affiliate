<?php

namespace App\Http\Repository;

use App\User;

class UserRepository
{
    public function __construct()
    {
        $this->model = new User();
    }

    public function getStaff()
    {
        return $this->model->where('banned', 0)->whereHas('staff')->select('id', 'name')->get();
    }
}
