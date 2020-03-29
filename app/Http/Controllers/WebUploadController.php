<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;

use App\UploadedImage;
use App\UploadedText;

class WebUploadController extends BaseController
{
    public function index($event_alias) {

    	// Check if there is an event in the DB with the requested alias
    	$events = \DB::table('events')
                ->select('id', 'event_alias', 'id')
                ->where('event_alias', $event_alias)
                ->get();

        if (count($events) == 1) {

        	    return view('web_upload_view', [
		    		'event_alias' => $event_alias,
		    		'event_id' => $events[0]->id
		    	]);

        } else {

        	return('Sorry, this page doesn\'t exist. Do you mean ...?Here find similar events in the DB to suggest to user.');
        
        }

    }

    public function uploadImage(Request $request) {

    	// ====================================
    	// TO DO:
    	// * Add validation of uploaded image
    	// * What if same image is uploaded several times? Inspiration: https://stackoverflow.com/questions/18849927/verifying-that-two-files-are-identical-using-pure-php 
    	// ====================================
/*	    
	    $this->validate($request, [
	        'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
	    ]);
*/
	    if ($request->hasFile('image')) {

	    	// Process image, change name, save in folder public/uploadedImages
	        $image = $request->file('image');
	        $image_name = 'img_'. time() .'_'. mt_rand() .'.'. $image->getClientOriginalExtension();
	        $destination_directory = public_path('/uploadedImages');
	        $image->move($destination_directory, $image_name);
/*
	        // Add info of uploaded image to database
	        $description = Description::updateOrCreate([
				'image_name' => $image_name
			]);
			$description->save();
*/
			$newImage = new UploadedImage;
			$newImage->event_id = $request->event_id;
			$newImage->file_name = $image_name;
			$newImage->caption = 'no caption';
			$newImage->nbr_views = 0;
	        $newImage->save();

	        return back();
	    }

	}

	public function uploadText() {

		$newText = new uploadedText;
		$newText->event_id = request('event_id');
		$newText->text_contents = request('text_contents');
		$newText->nbr_views = 0;
	    $newText->save();

	    return back();

	}
}
