<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
// use Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
       $users = User::orderBy('created_at','DESC')->paginate(10);
       return view('admin.users.list', [
             'users' => $users,
       ]);
    }
    public function edit($id){
         $user = User::findOrFail($id);

         return view('admin.users.edit',[
             'user' => $user,
         ]);
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'name'=> ['required','string','max:255'],
            'email'=> ['required','email','unique:users,email,'.$id],
        ]);

        if($validator->passes()){
          $user = User::find($id);

          $user->name = $request->name;
          $user->email = $request->email;
          $user->mobile = $request->mobile;
          $user->designation = $request->designation;
          $user->save();

          session()->flash('success','User information updated successfully.');

        //   return redirect()->route('admin.users');


          return response()->json([
             'status' => true,
              'errors' => []
          ]);

        }else{
          return response()->json([
              'status' => false,
              'errors' => $validator->errors()
          ]);
        }
    }

    public function destroy(Request $request){

      $id = $request->id;
       $user = User::find($id);

       if($user == null){
        session()->flash('error','User not found');
         return response()->json([
             'status' => false,
          ]);

       }

       $user->delete();

       session()->flash('success','User deleted successfully.');

          return response()->json([
           'status' => true,
         ]);

    }
}
