<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;

class WebUploadController extends BaseController
{
    public function index() {

    	return view('web_upload_view');

    }

    public function uploadImage(Request $request) {

    	// ====================================
    	// TO DO:
    	// * Add validation of uploaded image
    	// * What if same iamge is uploaded several times? Inspiration: https://stackoverflow.com/questions/18849927/verifying-that-two-files-are-identical-using-pure-php 
    	// ====================================
/*	    
	    $this->validate($request, [
	        'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
	    ]);
*/
	    if ($request->hasFile('image')) {

	    	// Process image, change name, save in folder public/uploadedImages
	        $image = $request->file('image');
	        $image_name = 'img_'. time() . '_'. mt_rand() .'.'. $image->getClientOriginalExtension();
	        $destination_directory = public_path('/uploadedImages');
	        $image->move($destination_directory, $image_name);
/*
	        // Add info of uploaded image to database
	        $description = Description::updateOrCreate([
				'image_name' => $image_name
			]);
			$description->save();
*/
	        return back();
	    }

	}
}
