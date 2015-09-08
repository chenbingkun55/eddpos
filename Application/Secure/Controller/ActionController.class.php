<?php
namespace Secure\Controller;

class ActionController extends BaseController {
    public function login() {
        $re = D('Action')->login_handle();

        if($re == true){
            $this->success(L('login_success'),U('Home/Index/index'));
        }

        $this->error(L('login_error'),U('Home/Base/login'));
    }

    public function is_login(){
        if(! A('Secure/Environment')->check_login()){
            $this->error(L('login_none'),U('Home/Base/login'));
        }
    }
}
