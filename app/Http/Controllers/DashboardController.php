<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('permission:Dashboard-View', ['index']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Totalusers = User::count();
        return view('dashboard.index', compact('Totalusers'));
    }
}
