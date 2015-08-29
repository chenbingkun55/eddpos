<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
        $this->show("<a href='".U('Login/handler')."'>Login</a>");
    }

    public function handler(){
        session('is_login','1');
        $this->success(L('login_success'),U('Home/index'));
    }
}
