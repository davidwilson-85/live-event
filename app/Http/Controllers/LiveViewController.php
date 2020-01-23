<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class LiveViewController extends Controller
{
    public function index() {

    	return ('Served from LiveViewController');

    }
}
