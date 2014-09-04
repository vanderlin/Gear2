<?php

class Asset extends \Eloquent {
	protected $fillable = [];


    // ------------------------------------------------------------------------
    static function imageSizes() {
      return array(

        );
    }

	  // ------------------------------------------------------------------------
  	public function assetable() {
        return $this->morphTo();
    }


  	// ------------------------------------------------------------------------
  	public function saveRemoteImage($url, $save_path, $filename) {

  		$this->filename = $filename;
		  $this->path = $save_path; 

  		if(!File::exists($save_path)) {
  			File::makeDirectory($save_path, 0755, true);			
  		}
      file_put_contents($save_path.'/'.$filename, file_get_contents($url));
  	}

    // ------------------------------------------------------------------------
    public function resizeImageURL($options=array()) {
      return URL::to('images/'.$this->id.(is_string($options)?'/'.$options:''));  
    }

    // ------------------------------------------------------------------------
    public function getUrlAttribute() {
      return URL::to($this->path.'/'.$this->filename);
    }

	  // ------------------------------------------------------------------------
  	public function url($options=array()) {
      return URL::to('images/'.$this->id.(is_string($options)?'/'.$options:''));  
  	}

    // ------------------------------------------------------------------------
    public function relativeURL($options=array()) {
      return $this->path.'/'.$this->filename;
    }




}