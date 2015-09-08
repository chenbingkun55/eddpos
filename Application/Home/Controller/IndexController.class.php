<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends BaseController{
    public function index(){
        A('Secure/Action')->is_login();

        $this->p(session('emp_data'));
        $this->display();
    }


}
