<?php

// enforce strict types
declare(strict_types=1);

namespace App\Controllers\Admin;

class Users
{
    public function index()
    {
        $hello = "\nHello from Admin Users controller";
        echo nl2br($hello);
    }
}