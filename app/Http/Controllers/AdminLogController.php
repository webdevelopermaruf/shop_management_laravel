<?php

namespace App\Http\Controllers;

use App\Models\AdminlogModel;
use App\Models\SiteSettings;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{
    public function viewLogin()
    {
        $site = SiteSettings::where('site_no',1)->first();
        return view('Auth.login',['site'=>$site]);
    }
    public function Login(Request $req)
    {
        $hashPass = md5($req->admin_password);
        $get = AdminlogModel::where('admin_phone', $req->admin_phone)
                            ->where('admin_password', $hashPass)
                            ->get();

        if(count($get) == 1){
            session()->put('role', $get[0]->admin_role );
            session()->put('name', $get[0]->admin_name );
            session()->put('phone', $get[0]->admin_phone );
            session()->put('email', $get[0]->admin_email );
            session()->put('auth.token', sha1($get[0]->admin_email.$get[0]->admin_phone) );
            return redirect()->to('/');

        }else{
            return redirect()->back()->withErrors(['error' => 'You\'re Username Or Password is Not Matched']);
        }
    }
    public function LogOut()
    {
        
        session()->flush();
        return redirect()->to('/auth/login');
    }
}
