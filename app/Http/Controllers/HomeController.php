<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\userCity;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $gSub =  DB::table('user_city')
            ->select('*')
            ->where('email','=',Auth::user()->email)
            ->get();
        if ($gSub->count('id')!=null) {
            return view('home',['status'=>true]);
        }
        else {
            return view('home',['status'=>false]);
        }
        
    }
    
    public function insertList(Request $request)
    {
        $userCity=userCity::updateOrCreate(
            ['email' => Auth::user()->email],
            ['city' => $request->input("inputCity")]
        );
        try {
            if ($userCity->save()) {
                return redirect('/home');
            }
            else {
                echo "Error";
            }
        } 
        catch (\Throwable $th) {
            
        }
        
    }
}
