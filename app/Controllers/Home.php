<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        echo 'baseURL: ' . config('App')->baseURL;
        echo '<br>env: ' . env('app.baseURL');
        die();
    }
}
