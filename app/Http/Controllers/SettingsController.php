<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware(["auth","role:supervisor"]);
    }

   

    public function usersettings(Request $request) {
    	




    	
	}

	
	public  function saveRoleForm(Request $request){
		
		$user = User::findOrFail($request->input('user_id'));

		$role = Role::findOrFail($request->input('role_id'));

		if(!$user->hasRole($role->name)){
			$user->attachRole($role);
		}

		return redirect()->route('home');
	}


	public  function showRoleForm(){
		$users = User::all();
    	$roles = Role::all();
    	return view('settings.users',['users'=>$users,'roles'=>$roles]);
	}

}
