<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Storage;
use App\Models\Blog;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WelcomeNotification;
use App\Http\Requests\StoreUser;
use App\Http\Requests\logincheck;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\Datainterface;

class maincontroller extends Controller
{
    private $data;
    public function __construct(Datainterface $data){
        $this->data=$data;
    } 


    public function register(StoreUser $req){
        $this->data->Register($req);
        return redirect("login");    
    }

    public function logincheck(logincheck $req){
        $this->data->Login($req);
        $email=$req->email;
        $password=$req->password;
        $result=User::where(['email'=>$email])->first();
        // return $result;
        if($result!=null && Hash::check($req->password,$result->password)){
                $req->session()->put('ADMIN_LOGIN',true);
                $req->session()->put('ADMIN_EMAIL',$req->email);
                session(['key' => $req->email]);
                Log::channel('mydailylogs')->info('login by:'.$email);
                return redirect('dashboard');
        }
        else{
            $req->session()->flash('error','Please enter a valid details');
            return redirect("/login");
        }
    }

    public function logout(){
        $this->data->Logout();
        return redirect('/login');
    }

    public function addblog(Request $req){

        $this->data->addb($req);
        
        return redirect("dashboard");
    }

    function showblogs(){

        $data=$this->data->all();
        // $data=Blog::where('email',session('key'))->paginate(20);
        return view("dashboard",['blogs'=>$data]);
    }

    public function delete($id){
        $this->data->del($id);
        
        return redirect("dashboard");
    }

    public function update($id){
        $data=$this->data->viewUpdate($id);
        return view('update',['data'=>$data]);
    }

    public function updatesubmit(Request $req){
        $this->data->updateSubmit($req);
        return redirect("dashboard");
    }

    public function profile($email){
        $data=$this->data->Profile($email);
        return view('profile',['data'=>$data]);
    }


    public function editprofile($email){
        $data = $this->data->editProfile($email);
        return view('editprofile',['data'=>$data]);
    }

    public function saveedit(Request $req){
        $data=$this->data->saveProfile($req);
        return redirect('profile/'.$data->email);
    }

    public function deletepic($email){
        $data=User::where('email',$email)->first();
        return redirect('profile/editprofile/'.$email);
    }

    public function changepic($email){
        $data=$this->data->changePic($email);
        
        return view('changepic',['data'=>$data]);
    }

    public function changepicsave(Request $req){
        $this->data->changePicsave($req);
        return redirect('profile/editprofile/'.$req->email);
        }
    
}
