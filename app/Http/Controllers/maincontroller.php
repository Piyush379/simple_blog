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

class maincontroller extends Controller
{
    
    public function register(StoreUser $req){
        
        $result=User::where(['email'=>$req->email])->first();
        // return $result;
        if($result!=null){
            $req->session()->flash('error','Please enter an new email');
            return redirect("register");
        }
        else{
        $data=new User;
        
        $data->name=$req->name;
        $data->email=$req->email;
        $data->password=$req->password;
        $data->password=Hash::make($data['password']);  //by hashing
        if($req->hasfile("pic")){
            $new=$req->file('pic');
        
            $extension=$new->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $new->storeAs('public/images',$filename);
            $data->pic=$filename;
        }

        Notification::send($data,new WelcomeNotification);

        $data->save();

        return redirect("login");
    }
    }

    public function logincheck(logincheck $req){
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
        // session(['ADMIN_LOGIN'=>null]);
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_EMAIL');
        session()->forget('key');
        return redirect('/login');
    }

    public function addblog(Request $req){
        $data= new Blog;
        $data->email=session("key");
        $data->blog=$req->blog;
        $data->save();
        return redirect("dashboard");
    }

    function showblogs(){
        $data=Blog::where('email',session('key'))->paginate(20);
        return view("dashboard",['blogs'=>$data]);
    }

    public function delete($id){
        $data=Blog::find($id);
        $data->delete();
        return redirect("dashboard");
    }

    public function update($id){
        $data=Blog::find($id);
        return view('update',['data'=>$data]);
    }

    public function updatesubmit(Request $req){
        // dump($req->id);
        $data=Blog::find($req->id);
        // return $data;
        $data->blog=$req->blog;
        $data->save();
        return redirect("dashboard");
    }

    public function profile($email){
        $data = User::where('email', $email)->first();
        // $data=Register::find($email);
        return view('profile',['data'=>$data]);
    }


    public function editprofile($email){
        $data = User::where('email', $email)->first();
        return view('editprofile',['data'=>$data]);
    }

    public function saveedit(Request $req){
        $data=User::where('email',$req->email)->first();
        $data->name=$req->name;
        $data->email=$req->email;
        $data->password=$req->password;
        $data->save();
        return redirect('profile/'.$data->email);
    }

    public function deletepic($email){
        $data=User::where('email',$email)->first();
        
        
        return redirect('profile/editprofile/'.$email);
    }

    public function changepic($email){
        $data=User::where('email',$email)->first();
        
        return view('changepic',['data'=>$data]);
    }

    public function changepicsave(Request $req){
        $data=User::find($req->id);
        if($req->hasfile("pic")){

            $destination = 'storage/images/'.$data->pic;
            // return $destination;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $new=$req->file('pic');
        
            $extension=$new->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $new->storeAs('public/images',$filename);
            $data->pic=$filename;
        }
        $data->save();
        
        return redirect('profile/editprofile/'.$req->email);
        }
    

}
