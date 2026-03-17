<?php
// app/Controllers/ServicesController.php
namespace App\Controllers;

class ServicesController extends BaseController
{
    public function index(): string
    {
        return view('layouts/main', [
            'content' => view('services/index'),
            'title'   => 'Layanan - Mentality',
        ]);
    }
}
