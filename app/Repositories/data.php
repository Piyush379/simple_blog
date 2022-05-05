<?php
namespace App\Repositories;
use App\Repositories\Interfaces\Datainterface;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreUser;
use App\Http\Requests\logincheck;



class data implements Datainterface{

    public function all(){
        return Blog::where('email',session('key'))->paginate(20);
    }

    public function addb($req){
        $data= new Blog;
        $data->email=session("key");
        $data->blog=$req->blog;
        $data->save();
    }

    public function del($id){
        $data=Blog::find($id);
        $data->delete();
    }

    public function viewUpdate($id){
        return $data=Blog::find($id);
    } 

    public function updateSubmit($req){
        $data=Blog::find($req->id);
        $data->blog=$req->blog;
        $data->save();
    }

    public function Profile($email){
        return User::where('email', $email)->first();
    }

    public function editProfile($email){
        return User::where('email', $email)->first();
    }

    public function saveProfile($req){
        $data=User::where('email',$req->email)->first();
        $data->name=$req->name;
        $data->email=$req->email;
        $data->password=$req->password;
        $data->save();
        return $data;
    }
// ////////////////////
    public function changePic($email){
        return User::where('email',$email)->first();
    }

    public function changePicsave($req){
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
    }

    public function Logout(){
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_EMAIL');
        session()->forget('key');
    }

    public function Register($req){
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
    }
    }

    public function Login($req){
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
}