<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\user;

use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Student::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
        "name"=> 'required',
        "city"=> 'required',
        "fee"=> 'required',
        ]);
      return student::create($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Student::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $id  = Student::find($id);
        $id->update(
           $request->all()
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Student::find($id)->delete();
    }
    public function search($city)
    {
      return Student::where('city' , $city)->get();
    }
    public function register(Request $request)
    {
   
        $request->validate([
            'name'=>'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);
           $user = user::create([
           'name'=>$request->name,
           'email'=>$request->email,
           'password'=>hash::make($request->password),
       

    
        ]);
        $randomNumber = str_pad(rand(0, pow(10, 12)-1), 12, '0', STR_PAD_LEFT);
        $token = $user->createToken($randomNumber)->plainTextToken;
        return response([

            'user'=>$user,
            'token'=>$token,
        ],200);

    }
    public function logout(){
        Auth()->user()->tokens()->delete();
        return response([
            'message'=>'token sussessfully delete'
        ]);
    }
    public function user_logged(){
       $user =  Auth()->user();
        return response([
            'user'=>$user,
        ],200);
    }
    public function login(Request $request){
  
        $request->validate([
        
            'email' => 'required',
            'password' => 'required',
        ]);

       $user = User::where('email',$request->email)->first();
   
       if(!$user || !Hash::check($request->password , $user->password) ){
        return response([
            'message'=>'not available'
          ], 401);
        }else{

            
            $randomNumber = str_pad(rand(0, pow(10, 12)-1), 12, '0', STR_PAD_LEFT);
        $token = $user->createToken($randomNumber)->plainTextToken;
        return response([
            
            'user'=>$user,
            'token'=>$token,
        ],201);
        
    }
}
}
     
    


