<?php

namespace App\Http\Controllers;
use Mail;
use Carbon\Carbon;
use App\Models\user;
use App\Mail\reset_password;
use Illuminate\Http\Request;
use App\Models\password_reset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetController extends Controller
{
    
    public function reset_email_password(Request $request){
        $request->validate([
            // 'email' => 'required|email|unique:users,email',
        ]);
    
        $user = User::where('email',$request->email)->first();

     if(!$user){
    return response([
        'msg'=>'user not found',
       ]);
    }else{
        $token = hash('sha256', \Str::random(120));

      
        password_reset::create([
           
         
            'email'=>$request->email,
            'token'=>$token,
            'create_at'=>carbon::now(),
     
         ]);
          $verifyUrl = route('update_reset_password', compact('token'));
    
         $mail_data = [
            'email' => $request->email,
            'name' => $user->name,

            'subject' => 'Password Updates',
            'actionLink' => $verifyUrl,
        ];
        MAIL::to($request->email)->send(new reset_password($mail_data));

         return response([
            'msg'=>'send..',
           ]);
    
    }
       
}
public function update_reset_password(Request $request, $token = null)
{
    $password_reset = password_reset::where('token', $token)->first();

    return view('update_reset_password',compact('password_reset'));

}
public function reset(Request $request, $token)
{
    // delete the token Older than 1 minute
    $formatted = Carbon::now()->subMinutes(2)->toDateTimeString();
    password_reset::where('created_at','<=',$formatted)->delete();

    $request->validate([
        'password'=>'required|confirmed',
    ]);

    $passwordReset = password_reset::where('token',$token)->first();

    if (!$passwordReset) {

        return response([
            'msg' => 'Invalid token or Expired',
            'status' => 'Failed'
        ],404);
    } 
   $user = User::where('email',$passwordReset->email)->first();
    $user->password = Hash::make($request->password);
    $user->save();

    // deleting token after resetting password
    password_reset::where('email',$user->email)->delete();

    return response([
        'msg' => 'Password Change Successfully',
        'status' => 'success'
    ],200);
}

}
