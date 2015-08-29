<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->check_is_login();
        $this->display();
    }

    public function logout(){
       // $data = NULL
        session('is_login','0');
        $this->redirect('Login/index');
    }

    public function check_is_login(){
        $sec_env = A('Secure/Environment');
        if($sec_env->is_login()){
            //echo 'Check is Login';
            return true;
        } else {
            $this->error(L('no_login'),U('Home/Login'));
        }
    }
}
