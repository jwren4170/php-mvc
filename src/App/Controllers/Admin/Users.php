<?php

namespace App\Controllers\Admin;

class Users
{
    public function index()
    {
        $hello = "\nHello from Admin Users controller";
        echo nl2br($hello);
    }
}
