<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
        $this->display();
    }

    public function handler(){
        if(empty($_POST['username']) || empty($_POST['password'])){
            $this->error(L('login_failed'),U('Login/index'));
        }

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $return_num = M('Employees')->where('username = \''.$username.'\' AND password = md5(\''.$password.'\') AND deleted = 0')->count();

        //测试--------------------------------------------------------
        $return_num = 1;
        //--------------------------------------------------------

        if($return_num == 1){
            session('is_login','1');
            $this->success(L('login_success'),U('Home/index'));
        } else {
            session('is_login','0');
            $this->error(L('login_error'),U('Login/index'));
        }
    }
}
