<?php namespace Vanderlin\Slate;

class Theme extends \Eloquent {
	protected $fillable = [];

	public function getCodeAttribute($value) {
		return urldecode($value);
	}

	public function getHeadCodeAttribute() {
		$html = $this->code;
		$domain = URL::to($this->path).'/';
		preg_match_all('/href\="(.*?)"/im', $html, $matches);
		foreach($matches[1] as $n=>$link) {
		    if(substr($link, 0, 4) != 'http') {
		        $html = str_replace($matches[1][$n], $domain . $matches[1][$n], $html);
		    }
		}
		return $html;
	}

	static public function activeTheme() {
		return Theme::where('active', '=', '1')->first();
	}

}