<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {
    Public function login(){
        $this->display();
    }

    public function logout(){
        session('emp_data',NULL);
        session('cart_data',NULL);
        $this->redirect('Base/login');
    }

    public function p($p_array = array()){
        echo '<PRE>';
        print_r($p_array);
        echo '</PRE>';
    }
    //Public function regist(){
        //$this->display();
    //}
}
