<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Liveevent_config;

class LiveViewController extends Controller
{
    public function index() {

    	//Liveevent_config::write('uploadedImages', 'true');

    	return Liveevent_config::read('uploadedImages');

    }
}
