<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = User::all();
        return response()->json($admin);
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try { $validator=$request->validate([
            'email'=>'required|string|max:255|email',
            'password'=>'required|string|max:30',
          ]);
        $email = $request->email;
        $password = $request->password;
        // check if user exists in database

        if(User::where('email', $email)->exists()){
            $user = User::where('email', $email)->first();
             $id=User::where('email', $email)->first()->user_id;
            if ($user && Hash::check($password, $user->password)) {
                return response()->json(['exists' => true,'id'=>$id],200);
            }}
        else {
            return response()->json(['exists' => false]);
        }}catch(ValidationException $e){
            return response()->json(['errors' => $e->validator->errors()], 422);
        }

    }
     /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try { $validator=$request->validate([
        'name'=>'required|string|max:30',
        'telefone'=>'required|string|min:10',
        'address'=>'required|string|max:100',
        'email'=>'required|string|max:255|email|unique:users',
        'password'=>'required|string|max:30',
      ]);

       $pass=Hash::make($request->password);
       $admin = new User();
       $admin->name= $request->name;
       $admin->phoneNumber= $request->telefone;
       $admin->address= $request->address;
       $admin->email= $request->email;
       $admin->password = $pass;
       $admin->save();
       return $admin;
    }catch(ValidationException $e) {
        return response()->json(['errors' => $e->validator->errors()], 422);
    }
}
}
