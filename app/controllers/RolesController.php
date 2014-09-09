<?php

class RolesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /roles
	 *
	 * @return Response
	 */
	public function index() {
		return View::make('admin.index', ['page'=>'roles']);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /roles/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /roles
	 *
	 * @return Response
	 */
	public function store() {

		if(Input::has('role-name')) {
			$role = new Role;
			$role->name = Input::get('role-name');
			$role->save();

			return Redirect::back()->with(['notice'=>'new role created']);
		}
		return Redirect::back()->with(['notice'=>'Missing a role name']);

		
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /roles/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {

		$role = Role::findOrFail($id);
		if($role) {
			$perms = Input::get('perms');
			$permsToAttach = [];
			foreach ($perms as $key => $value) {
				$perm = Permission::where('id', '=', $key)->first();
				if($perm) {
					array_push($permsToAttach, $perm->id);
				}
			}
			$role->perms()->sync($permsToAttach);
			return Redirect::back()->with(['roles-notice'=>'Role has been updated']);
		}

		return Redirect::back()->with(['roles-notice'=>'Error updating role']);
		

	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /roles/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}