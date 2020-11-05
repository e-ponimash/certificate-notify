<?php

namespace App\Http\Controllers;

use App\Certificate;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $certificates = Certificate::all();
        return view('status.index', ['certificates' => $certificates]);
    }

}
