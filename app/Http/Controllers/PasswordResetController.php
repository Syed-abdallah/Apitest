<?php

namespace App\Http\Controllers;
use App\Models\user;
use App\Models\password_reset;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\reset_password;
use Mail;
class PasswordResetController extends Controller
{
    public function reset_email_password(Request $request){
        $user = user::where('email',$request->email)->first();

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
public function updated_reset_password(Request $request)
{
    $data = $request->all();

    $request->validate([
        'email'=>'required|email|exists:admin,email',
        'password'=>'required|min:5|confirmed',
        'cpassword'=>'required',
    ]);

    $check_token = DB::table('users')->where([
        'email' => $request->email,
       
    ])->first();

    if (!$check_token) {

        return back()->withInput()->with('fail', 'Invalid token');
    } else {

        user::where('email', $request->email)->update([
            'password' => \Hash::make($request->password),
        ]);

        password_reset::where('token', $request->token)->delete();

        // return redirect('admin/login')->with('info', 'Your password has been changed! You can login with new password')->with('verifiedEmail', $request->email);
    }

}

}
