<?php
namespace App\Repositories\Interfaces;

Interface Datainterface{
    public function all();
    public function addb($data);
    public function del($id);
    public function viewUpdate($id);
    public function updateSubmit($id);
    public function Profile($email);
    public function editProfile($email);
    public function saveProfile($req);
    public function changePic($email);
    public function changePicsave($req);
    public function Logout();
    public function Register($req);

}