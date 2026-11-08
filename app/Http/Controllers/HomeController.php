<?php
namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('user.index', [
            'title' => 'Beranda - UMKM Kita'
        ]);
    }
}