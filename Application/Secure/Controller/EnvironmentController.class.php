<?php
namespace Secure\Controller;

class EnvironmentController extends BaseController {
    public function __construct(){
        parent::__construct();
        // Initialized Secure Environment
        //$this->show('Secure init');
    }

    public function check_login(){
        $emp_data = session('emp_data');

        if(! empty($emp_data) && $emp_data['deleted'] == 0 ){
            return true;
        }

        return false;
    }
}
