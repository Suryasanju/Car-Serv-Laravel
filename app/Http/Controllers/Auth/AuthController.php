<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\{User,Country,State,City};
use App\Models\UserVerify;
use Hash;
use Mail;
use Str;
use DB;

class AuthController extends Controller
{
    public function login()
    {
        if(Auth::check()) {
            return redirect('myprofile');
        }
        return view('login');
    }
    public function register()
    {
        if(Auth::check()) {
            return redirect('myprofile');
        }
        $data['countries'] = Country::get(['country_id','country_name']);
        return view('register',$data);
    }
    public function getState(Request $request)
    {
        $data['states'] = State::where('country_id',$request->country_id)->get(['state_id','state_name']);
        return response()->json($data);
    }
    public function getCity(Request $request)
    {
        $data['cities'] = City::where('state_id',$request->state_id)->get(['city_id','city_name']);
        return response()->json($data);

        // select city_id,city_name from cities where state_id=$request->state_id;
    }
    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }
    public function saveUser(Request $request)
    {
        //dd($request->all());

        $request->validate(
            [
                'name'=>'required',
                'email'=>'required|email|max:50|unique:users',
                'password'=>'required|min:6|same:confirm_password',
                //'confirm_password'=>'required|same:password'
                'photo' =>'required|image|mimes:jpeg,jpg,png,gif|max:1024',
                'captcha' => 'required|captcha'
            ]
        );

        $photoName = time().'.'.$request->photo->extension();

        $request->photo->move(public_path('uploads'),$photoName);


        $data = $request->all();
        $createuser = $this->create($data,$photoName);
        $token = Str::random(64);

        $insertUserverify = UserVerify::create([
            'user_id' => $createuser->id,
            'token' => $token
        ]);

        Mail::send('emails.activationEmail',['token'=>$token],function($message) use($request){
            $message->to($request->email);
            $message->subject('Activation Account Email from CarServCrud');
        });

        return redirect('login')->withSuccess('You have registered successfully. Please Activate your account before login.');
    }
    public function create(array $data, string $photoName)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'password' => $data['password'],
            'photo' => $photoName,
            'gender' => $data['gender'],
            'country' => $data['country'],
            'state' => $data['state'],
            'city' => $data['city'],
            'address' => $data['address'],
            'dob' =>  $data['dob'],
        ]);
    }
    public function postLogin(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
            ]);
        $checkLoginCredentials = $request->only('email','password');
        if(Auth::attempt($checkLoginCredentials)){
            if(auth()->user()->user_type == 0) {
                return redirect('myprofile')->withSuccess('Loggedin successfully.');
            } else {
                return redirect('admin/dashboard');
            }



            
        }
        return redirect('login')->withSuccess('Please provide correct login credentials.');
    }

    public function myprofile()
    {
        if(Auth::check()) {
            $user = Auth::user();
            return view('myprofile',compact('user'));
        }
        return redirect('login')->withSuccess('Not authorized to access this page without login.');
    }
    public function editProfile()
    {
        if(!Auth::check()) {
            return redirect('login');
        } else {
            $user = Auth::user();
            return view('editprofile',compact('user'));
        }
    }

    public function updateUser(Request $request)
    {
        //dd($request->all());

        $request->validate(
            [
                'name'=>'required',
            ]
        );

        $id = $request->id;
        User::where('id','=',$id)->update(
            [
                'name' => $request->name,
                'dob' => $request->dob,
                'address' => $request->address,
                'gender' => $request->gender,
            ]
        );

        return redirect('myprofile')->withSuccess('your details is updated successfully.');
    }

    public function changePassword()
    {
        if(!Auth::check()) {
            return redirect('login');
        } else {
            $user = Auth::user();
            return view('changepassword',compact('user'));
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate(
            [
                'current_password'=>'required',
                'password'=>'required|min:6|same:confirm_password',
            ]
        );

        #check with old pwd
        if(!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect('change-password')->withSuccess('Current password not match.!');
        }

        #update new password
        $id = $request->id;
        User::where('id','=',$id)->update(
            [
                'password' => Hash::make($request->password)
            ]
        );
        return redirect('myprofile')->withSuccess('Password change successfullly.!');
    }


    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('login')->with('success','You are logout successfully-chirag.');
    }

    public function VerifyAccount($token)
    {
        $verifyUser = UserVerify::where('token',$token)->first();
        $message = "Your detail is not registered with us.";
        if(!is_null($verifyUser)){
            $user = $verifyUser->user;
            if(!$user->is_active) {
                $verifyUser->user->is_active=1;
                $verifyUser->user->save();
                $message = "Your account is activated successfully.";
            } else {
                $message = "Your account is already activated.";
            }
        }
        return redirect('login')->with('success',$message);
    }
    public function forgotPassword()
    {
        if(Auth::check()) {
            return redirect('myprofile');
        }
        return view('forgotpassword');
    }
    public function forgotPasswordSubmit(Request $request)
    {
        $request->validate([
            'email'=>'required|email|max:50',
        ]);
        $token = Str::random(64);
        DB::table('resetpasword')->insert([
            'email' => $request->email,
            'token' => $token
        ]);

        Mail::send('emails.resetPasswordEmail',['token'=>$token],function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password Email from CarServCrud');
        });

        return redirect('forgot-password')->withSuccess('Reset password link sent to your email address. Please check your Inbox/Spam Folder for reset password link.');
    }

    public function resetPassword($token) 
    {
        if(Auth::check()) {
            return redirect('myprofile');
        }
        return view('resetpassword',['token'=>$token]);
    }
    public function resetPasswordSubmit(Request $request) 
    {

        //dd($request->all());
        $request->validate([
            'email'=>'required|email|max:50',
            'password' => 'required|min:6|same:confirm_password',
            'confirm_password' => 'required'
        ]);

        $resetPasswordCheck = DB::table('resetpasword')
                            ->where([
                                'email' => $request->email,
                                'token'=> $request->token
                            ])->first();

        if(!$resetPasswordCheck) {
            return redirect('reset-password/'.$request->token)->withSuccess('Reset Password Link is expired.');
        }

        $userPasswordUpdate  = User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        //delete reset password data from resetpasword table
        DB::table('resetpasword')->where(['email'=>$request->email])->delete();

        return redirect('login')->withSuccess('your password is reset successfully. Please login with new password.');

    }
    public function gallery()
    {
        if(!Auth::check()) {
            return redirect('login');
        } else {
            $user = Auth::user();
            return view('gallery',compact('user'));
        }
    }
}
