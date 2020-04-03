<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

/**
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index', [
            'links' => DB::table('links')
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get()
        ]);
    }
}
