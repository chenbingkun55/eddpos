<?php
namespace Home\Controller;

class ReportsController extends BaseController {
    public function index(){
        A('Secure/Action')->is_login();

        $this->show("报表显示.");
    }
}
