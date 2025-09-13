<?php

namespace App\Http\Controllers;

use App\Models\Packages;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(){
        $packages = Packages::with('destination')->get();

        return view('welcome',compact('packages'));
    }
}
