<?php

namespace App\Controllers;

use Framework\Viewer;

class Home
{
    public function index()
    {
        $title = 'Home';
        $viewer = new Viewer();

        echo $viewer->render('shared/header', compact('title'));
        echo $viewer->render('Home/index');
        echo $viewer->render('shared/footer');
    }
}
