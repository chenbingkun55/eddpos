<?php
namespace Home\Controller;
use Think\Controller;
class SuppliersController extends Controller {
    public function index(){
        $tag = I('tag', $tag); // $tag 控制动作.

        switch($tag){
            case 'a':
                $this->view('a');
                break;
            case 'd':
                $id = I('id',0,'intval');
                if( D('Suppliers')->relation(true)->where('person_id = '.$id)->setField('deleted','1')){
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
                $up_data = D('SuppliersView')->where('deleted = 0')->find($id);
            case 'a':
                $this->data = array(
                    'title' => is_array($up_data) ? '修改供应商' : '添加供应商',
                    'col' => '2',
                    'head' => array(
                        'id' => 'add_suppliers',
                        'type' => 'form',
                        'handle' => is_array($up_data) ? U('handle',array('u' => 1),'') : U('handle',0,''),
                        'submit' =>  is_array($up_data) ? '修改' : '添加',
                    ),
                    'table' => array(
                       array(
                            'first_name',
                            '姓',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['first_name'],
                            ),
                        ),
                       array(
                            'last_name',
                            '名',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['last_name'],
                            ),
                        ),
                       array(
                            'company_name',
                            '公司名称',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['company_name'],
                            ),
                        ),
                       array(
                            'account_number',
                            '卡号',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['account_number'],
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
                                'value' => $up_data['id'],
                            ),
                        ),
                    ),
                );
                break;
            case 'v':
            default :
                $field = array('id','company_name','account_number','phone_number','email','address_1');

                $this->data = array(
                    'title' => '供应商列表',
                    'url' => U('index',array('tag' => a),''),
                    'col' => 6,
                    'table' => D('SuppliersView')->field($field)->where('deleted = 0')->select(),
                    'th' => array(
                        'ID',
                        '公司名称',
                        '账号',
                        '电话号码',
                        '邮箱',
                        '地址',
                        '操作',
                    ),
                    'hiddens' => array(),
                    'function' => array(),
                    'option' => array(
                        '修改' => U('index',array('tag' => 'u'),''),
                        '删除' => U('index',array('tag' => 'd'),''),
                    ),
                );
        }

        $this->display("Public/table");
    }

    public function handle() {
        $id = I('id',0,'intval');
        $update = $_GET['u'] ? $_GET['u'] : 0;

        $data = array(
            "account_number" => I('account_number'),
            "company_name" => I('company_name'),
            "People" => array(
                "first_name" => I('first_name'),
                "last_name" => I('last_name'),
                "phone_number" => I('phone_number'),
                "email" => I('email'),
                "address_1" => I('address'),
            ),
        );
        if($id != 0) { $data["person_id"] = $id; }

        $re_text = $update ? "修改" : "添加";

        if($update){
            $re = D('Suppliers')->relation(true)->where(array('person_id' => $id))->save($data);
        } else {
            $data["person_id"] = M('People')->add($data["People"]);
            if(empty($data['person_id']) || $data['person_id'] == 0 ){
                $this->error($re_text."失败");
            }
            $re = M('Suppliers')->add($data);
        }

        if ( $re ) {
            $this->success( $re_text."成功",U("index"));
        } else {
            $this->error($re_text."失败");
        }
    }
}
