<?php
namespace Home\Controller;
use Think\Controller;
class GiftcardsController extends Controller {
    public function index(){
        A('Secure/Action')->is_login();

        $tag = I('tag', $tag); // $tag 控制动作.

        switch($tag){
            case 'a':
                $this->view('a');
                break;
            case 'd':
                $id = I('id',0,'intval');
                if( D('Giftcards')->relation(true)->where('giftcard_id = '.$id)->setField('deleted','1')){
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
                $up_data = D('GiftcardsView')->where('deleted = 0')->find($id);
            case 'a':
                $this->data = array(
                    'title' => is_array($up_data) ? '修改礼品券' : '添加礼品券',
                    'col' => '2',
                    'head' => array(
                        'id' => 'add_giftcards',
                        'type' => 'form',
                        'handle' => is_array($up_data) ? U('handle',array('u' => 1),'') : U('handle',0,''),
                        'submit' =>  is_array($up_data) ? '修改' : '添加',
                    ),
                    'table' => array(
                       array(
                            'giftcard_number',
                            '礼品卡号',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['giftcard_number'],
                            ),
                        ),
                       array(
                            'value',
                            '金额',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['value'],
                            ),
                        ),
                       array(
                            'person_id',
                            '发给顾客',
                            'type' => array(
                                'input' => 'select',
                                'selected' => $up_data['person_id'],
                                'value' => M('Customers')->where('deleted = 0')->getField('person_id,account_number'),
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
                $field = array('id','record_time','giftcard_number','value','account_number','last_name');

                $this->data = array(
                    'title' => '礼品卡列表',
                    'url' => U('index',array('tag' => a),''),
                    'col' => 6,
                    'table' => D('GiftcardsView')->field($field)->where('Giftcards.deleted = 0')->select(),
                    'th' => array(
                        'ID',
                        '时间',
                        '礼品卡号',
                        '金额',
                        '顾客卡号',
                        '顾客名称',
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
            "giftcard_number" => I('giftcard_number'),
            "person_id" => I('person_id'),
            "value" => I('value'),
        );
        if($id != 0) { $data["giftcard_id"] = $id; }

        $re_text = $update ? "修改" : "添加";

        if($update){
            $re = D('Giftcards')->relation(true)->where(array('giftcard_id' => $id))->save($data);
        } else {
            $re = M('Giftcards')->add($data);
        }

        if ( $re ) {
            $this->success( $re_text."成功",U("index"));
        } else {
            $this->error($re_text."失败");
        }
    }
}
