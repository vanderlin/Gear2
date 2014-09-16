<?php namespace Vanderlin\Slate\Controllers;

use Permission;
use Input;
use Redirect;
use View;

class PermissionsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /permissions
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /permissions/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /permissions
	 *
	 * @return Response
	 */
	public function store() {
		$permission = new Permission;
		$permission->name = Input::get('name');
		$permission->display_name = Input::get('display_name');
		if($permission->save()) {
		    return Redirect::back()->with('permissions-notice', '"'.Input::get('display_name').'" has been created.');
        } 
        else {
            return Redirect::back()->with('permissions-errors', $permission->errors());
        }
	}

	/**
	 * Display the specified resource.
	 * GET /permissions/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		return Redirect::to('/');
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /permissions/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {
		return View::make('slate::admin.permissions.edit-modal', ['permission'=>Permission::find($id)]);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /permissions/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		$permission = Permission::find($id);
		if(!$permission) {
			return Redirect::back()->with(['errors'=>'Missing permissions']);
		}
		

		if(Input::has('name')) $permission->name = Input::get('name');
		if(Input::has('display_name')) $permission->display_name = Input::get('display_name');
		if($permission->save()) {
		    return Redirect::back()->with('permissions-notice', '"'.Input::get('display_name').'" has been updated.');
        } 
        else {
            return Redirect::back()->with('permissions-errors', $permission->errors());
        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /permissions/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		$perm = Permission::find($id);
		if($perm) {
			$perm->delete();
		}
		return Redirect::back()->with(['errors'=>'Missing permissions']);
	}

}