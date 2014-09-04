<?php

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
		if($size != null) {

			preg_match('/w(\d+)/', $size, $wMatch);
			preg_match('/h(\d+)/', $size, $hMatch);

			if(count($wMatch)>=2) {
				$w = $wMatch[1];
			}
			if(count($hMatch)>=2) {
				$h = $hMatch[1];
			}
			
		}

		$img = Image::cache(function($image) use($url, $w, $h) {
			$image->make($url);
			if($w!=null||$h!=null) {
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

}