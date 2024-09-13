<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
class CarServController extends Controller
{
    public function index()
    {
        $user = array();
        if(!Auth::check()) {
            $user = array();
        } else {
            $user = Auth::user();
        }

        
        return view('home');
    }
    public function booking()
    {
        return view('booking');
    }

    public function saveBooking(Request $request)
    {
        //dd($request->all());

        $request->validate(
            [
                'chirag'=>'required',
                'surya'=>'required|email',
                'service'=>'required',
                'service_date'=>'required',
                'special_request'=>'required',
                //'pancard' => 'required|regex:/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}$/'
                //BGFPM 2519 H
            ]
        );

        $booking = new Booking();
        $booking->name = $request->chirag;
        $booking->email = $request->surya;
        $booking->amit = $request->service;
        $booking->service_date = $request->service_date;
        $booking->special_request = $request->special_request;
        $booking->save();
        return redirect()->back()->with('success','You have booked successfully.');
    }



}
