<?php
namespace Home\Controller;

class ConfigController extends BaseController {
    public function index(){
        A('Secure/Action')->is_login();

        $this->show("配置显示.");
    }
}
