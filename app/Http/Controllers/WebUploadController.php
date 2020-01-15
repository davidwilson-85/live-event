<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;

class WebUploadController extends BaseController
{
    public function index() {

    	return view('web_upload_view');

    }

    public function subirImagen(Request $request) {
	    
	    $this->validate($request, [
	        'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
	    ]);

	    if ($request->hasFile('imagen')) {

	    	// Procesar imagen, cambiarle el nombre y guardarla en carpeta /imagenes
	        $imagen = $request->file('imagen');
	        $imagen_nombre = 'imagen_perfil_id_'. auth()->user()->id .'.'. $imagen->getClientOriginalExtension();
	        $dir_destino = public_path('/images');
	        $imagen->move($dir_destino, $imagen_nombre);

	        // El nombre de las imagenes siempre va a ser 'imagen_perfil_id_{{id}}', pero la extensión es variable, y eso crea la necesidad de guardala en la base de datos para consultarla cada vez que se solicite la vista'
	        $descripcion = Description::updateOrCreate([
				'id_usuario' => auth()->user()->id], [ 
			    'imagen_perfil' => $imagen_nombre
			]);
			$descripcion->save();

			// Por hacer: en caso de que el archivo de imagen no sobreescriba al preexistente, podría eliminarlo aquí.

	        return back();
	    }

	}
}
