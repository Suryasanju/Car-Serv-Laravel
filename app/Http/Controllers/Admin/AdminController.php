<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use DB;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }
    public function adminRegister()
    {
        return view('admin.register');
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function users()
    {
        $data = User::get();
        return view('admin.users',compact('data'));
    }
    
    public function editUser($id)
    {
        $data = User::where('id',$id)->first();
        return view('admin.editUser',compact('data'));
    }

    public function updateUser(Request $request) 
    {
        //dd($request->all());
        $request->validate([
            'name'=>'required',
        ]);

        $id = $request->id;
        $name = $request->name;

        User::where('id',$id)->update([
            'name' => $name
        ]);
        return redirect('admin/edit-user/'.$id)->withSuccess('User details updated successfully.');
    }

    public function products(){
        $data = Product::get();
        return view('admin.products',compact('data'));
    }

    public function add_product(){
        return view('admin.add_product');
    }
    public function saveProduct(Request $request){

        $photoName = time().'.'.$request->photo->extension();
        $request->photo->move(public_path('uploads/products'),$photoName);

        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'photo' => $photoName,
            'price' => $request->price,
            'seller' => $request->seller,
        ]);
        return redirect('admin/add-product')->withSuccess('Product added successfully.');
    }

    public function postAdminLogin(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
            ]);
        $checkLoginCredentials = $request->only('email','password');
        if(Auth::attempt($checkLoginCredentials)){
            if(auth()->user()->user_type == 1) {
                return redirect('admin/dashboard');
            } else {
                return redirect('admin-login')->withSuccess('Please provide correct admin login credentials.');
            }
        }
        return redirect('login')->withSuccess('Please provide correct login credentials.');
    }

    public function orders(){
        $data = DB::table('orders')->get();
        return view('admin.orders',compact('data'));
    }
}
