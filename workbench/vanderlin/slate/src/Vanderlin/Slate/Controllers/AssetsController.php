<?php namespace Vanderlin\Slate\Controllers;

use Vanderlin\Slate\Asset;
use Intervention\Image\Facades\Image;
use Response;

class AssetsController extends \BaseController {

	// ------------------------------------------------------------------------
	public function index() {
		return 'No Image Found';
	}

	// ------------------------------------------------------------------------	
	public function resize($id, $size=null) {
		
		$asset = Asset::find($id);
		if($asset == null) return '';
		$url   = $asset->relativeURL();
		$w     = null;
		$h 	   = null;
		$s     = null;

		if($size != null) {

			preg_match('/w(\d+)/', $size, $wMatch);
			preg_match('/h(\d+)/', $size, $hMatch);
			preg_match('/s(\d+)/', $size, $sMatch);

			if(count($wMatch)>=2) {
				$w = $wMatch[1];
			}
			if(count($hMatch)>=2) {
				$h = $hMatch[1];
			}
			if(count($sMatch)>=2) {
				$s = $sMatch[1];
			}
			
		}

		$img = Image::cache(function($image) use($url, $w, $h, $s) {
			$image->make($url);
			if($s!=null) {
				$image->resize($s, null, function ($constraint) {
    				$constraint->aspectRatio();
				})->crop($s, $s);
			}
			else if($w!=null||$h!=null) {
				$image->resize($w, $h, function ($constraint) {
    				$constraint->aspectRatio();
				});
			}
			return $image;
		});

		$file = new \Symfony\Component\HttpFoundation\File\File($url);
        $mime = $file->getMimeType();

		return Response::make($img, 200, array('Content-Type' => $mime));

			
	}

	// ------------------------------------------------------------------------
	public function edit($id) {
		$asset = Asset::find($id);
		if($asset == null) return Redirect::back()->with(['error'=>'No asset found']);

		$file = Input::file('file');

		if($file) {
			$old_file = "{$asset->path}/{$asset->filename}";
			$destination = 'assets/uploads';
			$asset->filename = "{$asset->uid}.{$file->getClientOriginalExtension()}";
			$asset->org_filename = $file->getClientOriginalName();
			$asset->path = $destination;
		
			File::delete($old_file);		
			$file->move($destination, $asset->filename);

		}
		
		if(Input::has('name')) {
			$asset->name = Input::get('name');
		}


		if(Input::has('id') && Input::has('type')) {
			$asset->assetable_id = Input::get('id');
			$asset->assetable_type = Input::get('type');
		}
		$asset->save();
		return Redirect::back()->with(['notice'=>'Asset updated']);
	}

	// ------------------------------------------------------------------------
	public function upload() {
		
		$file = Input::file('file');

		if($file) {


			$destination = 'assets/uploads';
			$asset = new Asset;
			$asset->filename = "{$asset->uid}.{$file->getClientOriginalExtension()}";
			$asset->org_filename = $file->getClientOriginalName();
			$asset->path = $destination;

			$file->move($destination, $asset->filename);

			if(Input::has('name')) {
				$asset->name = Input::get('name');
			}

			if(Input::has('id') && Input::has('type')) {
				$asset->assetable_id = Input::get('id');
				$asset->assetable_type = Input::get('type');
			}
			
			$asset->save();

			return Redirect::back();
		}

		return Redirect::back()->with(['error'=>'Missing file to upload']);
		
	}
}