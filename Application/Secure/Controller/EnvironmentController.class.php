<?php
namespace Secure\Controller;
use Think\Controller;
class EnvironmentController extends Controller {
    public function __construct(){
        parent::__construct();
        // Initialized Secure Environment
        //$this->show('Secure init');
    }

    public function is_login(){
        if(session('is_login') == 1){
            return true;
        } else {
            return false;
        }
    }
}
