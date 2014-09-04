<?php

class GoogleMapsController extends \BaseController {


	// ------------------------------------------------------------------------
	static function getCreds() {
		return (object)Config::get('config.'.Config::get('config.google_creds'));
	}


	// ------------------------------------------------------------------------
	static function map() {


		$creds = GoogleMapsController::getCreds();

		$html = '';
		$html .= '<iframe';
			$html .= 'width="600"';
			$html .= 'height="450"';
			$html .= 'frameborder="0" style="border:0"';
			$html .= 'src="https://www.google.com/maps/embed/v1/place?key='.$creds->api_key.'&q=Space+Needle,Seattle+WA">';
		$html .= '</iframe>';

		return $html;

	}


	// ------------------------------------------------------------------------
	/**
	 * Display a listing of the resource.
	 * GET /googlemaps
	 *
	 * @return Response
	 */
	public function index() {
		
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /googlemaps/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /googlemaps
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /googlemaps/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /googlemaps/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /googlemaps/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /googlemaps/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}