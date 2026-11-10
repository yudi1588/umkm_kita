<?php
namespace App\Http\Controllers;


class Dashboard_pemilik extends Controller
{
    public function index()
    {
        // Masuk ke folder layouts, lalu memanggil file dashboard_admin
        return view('layouts.dashboard_pemilik');
    }
}
