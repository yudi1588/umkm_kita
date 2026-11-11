<?php
namespace App\Http\Controllers;

class StatistikController extends Controller
{
    public function index()
    {
        return view('user.statistiks', [
            'title' => 'Statistik - UMKM Kita'
        ]);
    }
}