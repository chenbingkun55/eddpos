<?php
namespace Home\Controller;
use Think\Controller;
class EmployeesController extends Controller {
    public function index(){
        $tag = I('tag', $tag); // $tag 控制Member类动作.

        switch($tag){
            case 'a':
                $this->view('a');
                break;
            case 'd':
                $id = I('id',0,'intval');
                if( D('Employees')->relation(true)->where('person_id = '.$id)->setField('deleted','1')){
                    $this->success("删除成功",U("index"));
                } else {
                    $this->error("删除失败");
                }
                break;
            case 'u':
                $this->view('u');
                break;
            case 'v':
            default :
                $this->view('v');
        }
    }

    public function view( $tag = null ) {
        $tag = I('tag', $tag); // $tag 控制view函数动作.

        switch($tag){
            case 'u':
                $id = I('id',0,'intval');
                $up_data = D('employees')->relation(true)->find($id);
            case 'a':
                $this->data = array(
                    'title' => is_array($up_data) ? '修改成员' : '添加成员',
                    'col' => '2',
                    'head' => array(
                        'id' => 'add_employee',
                        'type' => 'form',
                        'handle' => is_array($up_data) ? U('handle',array('u' => 1),'') : U('handle',0,''),
                        'submit' =>  is_array($up_data) ? '修改' : '添加',
                    ),
                    'table' => array(
                       array(
                            'person_id',
                            '成员ID',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['person_id'],
                            ),
                        ),
                       array(
                            'username',
                            '用户名',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['username'],
                            ),
                        ),
                       array(
                            'password',
                            '密码',
                            'type' => array(
                                'input' => 'password',
                                'value' => '',
                            ),
                        ),
                       array(
                            'phone_number',
                            '电话号码',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['phone_number'],
                            ),
                        ),
                       array(
                            'email',
                            '邮箱',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['email'],
                            ),
                        ),
                       array(
                            'address',
                            '地址',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['address_1'],
                            ),
                        ),
                       array(
                            'id',
                            '',
                            'type' => array(
                                'input' => 'hidden',
                                'value' => $up_data['person_id'],
                            ),
                        ),
                    ),
                );
                break;
            case 'v':
            default :
                //$field = array('id','person_id','username','email','address_1');

                $this->data = array(
                    'title' => '员工列表',
                    'url' => U('index',array('tag' => a),''),
                    'col' => 5,
                    'table' => D('employees')->relation(true)->where('deleted = 0')->select(),
                    'th' => array(
                        '用户名',
                        'ID',
                        '电话号码',
                        '邮箱',
                        '地址',
                        '操作',
                    ),
                    'hiddens' => array('password','deleted','first_name','last_name','address_2','city','state','zip','country','comments','id'),
                    'function' => array(
                    ),
                    'option' => array(
                        '修改' => U('index',array('tag' => 'u'),''),
                        '删除' => U('index',array('tag' => 'd'),''),
                    ),
                );
        }

        $this->display("Public/table");
    }

    public function handle() {
        $person_id = I('person_id',0,'intval');
        $password = I('password','','md5');
        $update = $_GET['u'] ? $_GET['u'] : 0;

        $employee = D('employees');
        $data = array(
            "person_id" => $person_id,
            "username" => I('username'),
            empty($password) ? '' : 'password' => $password,
            "People" => array(
                "first_name" => 'Test',
                "last_name" => 'Tes',
                "person_id" => $person_id,
                "phone_number" => I('phone_number'),
                "email" => I('email'),
                "address_1" => I('address'),
            ),
        );

        $re = $update ? $employee->relation(true)->where(array('person_id' => $person_id))->save($data) : $employee->relation(true)->add($data);

        $re_text = $update ? "修改" : "添加";

        if ( $re ) {
            $this->success( $re_text."成功",U("index"));
        } else {
            $this->error($re_text."失败");
        }
    }
}
