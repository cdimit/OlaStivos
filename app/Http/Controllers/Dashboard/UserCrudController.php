<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //GET all the users
        $users = User::all();

        return view('dashboard.user.index')->with('users',$users);    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();

        return view('dashboard.user.edit')->with('user',$user)->with('roles',$roles);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['name'=>'required|string']);
        
        $user = User::find($id);

        $user->name = $request->name;
        
        $user->save();
        //
        //EDIT Roles
        //
        // 1. Detach all roles from user
        $user->roles()->detach();
        // 2. Add new role if they exist
        if($request->roles){
            foreach($request->roles as $role){
                //atach result with record and event
                $user->roles()->attach(Role::find($role));
            }
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->roles()->detach();
        $user->delete();
        return redirect('/dashboard');

    }
}
