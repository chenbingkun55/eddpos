<?php
namespace Home\Controller;
use Think\Controller;
class ItemkitItemsController extends Controller {
    public function index(){
        $tag = I('tag', $tag); // $tag 控制动作.

        switch($tag){
            case 'a':
                $this->view('a');
                break;
            case 'd':
                $kit_id = I('kit_id',0,'intval');
                $id = I('id',0,'intval');
                if( D('ItemKitItems')->where('item_kit_id = '.$kit_id.' AND item_id = '.$id)->delete()){
                    $this->success( "删除成功",U("index",array('tag' => 'v','id' => $kit_id)));
                } else {
                    $this->error("删除失败");
                }
                break;
            case 'u':
                $this->view('u');
                break;
            case 'c':
                $this->view('c');
                break;
            case 'v':
            default :
                $this->view('v');
        }
    }

    public function view( $tag = null ) {
        $tag = I('tag', $tag); // $tag 控制view函数动作.

        $kit_id = I('kit_id',0,'intval');
        switch($tag){
            case 'c':
                $clone = 1;
            case 'u':
                $id = I('id',0,'intval');
                $up_data = D('ItemKitItemsView')->where(array('item_kit_id' => $kit_id,'id' => $id))->find();
                if($clone) { $up_data['id'] = 0; }
            case 'a':
                $this->data = array(
                    'title' => is_array($up_data) ? $clone ? '复制产品' : '修改产品' : '添加产品',
                    'col' => '2',
                    'head' => array(
                        'id' => 'add_items',
                        'type' => 'form',
                        'handle' => is_array($up_data) ? $clone ? U('handle',array('c' => 1),'') : U('handle',array('u' => 1),'') : U('handle',0,''),
                        'submit' =>  is_array($up_data) ? $clone ? '复制' : '修改' : '添加',
                    ),
                    'table' => array(
                       array(
                            'item_id',
                            '产品',
                            'type' => array(
                                'input' => 'select',
                                'selected' => $up_data['id'],
                                'value' => M('Items')->getField('item_id,name'),
                            ),
                        ),
                       array(
                            'quantity',
                            '数量',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['quantity'],
                            ),
                        ),
                       array(
                            'id',
                            '',
                            'type' => array(
                                'input' => 'hidden',
                                'value' => $kit_id,
                            ),
                        ),
                    ),
                );
                break;
            case 'v':
            default :
                $item_kit_id = I('id',0,'intval');
                $field = array('id','quantity','name');

                $this->data = array(
                    'title' => '套件组合列表',
                    'url' => U('index',array('tag' => a,'kit_id' => $item_kit_id),''),
                    'col' => 8,
                    'table' => D('ItemKitItemsView')->where('item_kit_id = '. $item_kit_id)->field($field)->select(),
                    'th' => array(
                        'ItemID',
                        '数量',
                        '名称',
                        '操作',
                    ),
                    'hiddens' => array(),
                    'function' => array(),
                    'option' => array(
                        '修改' => U('index',array('tag' => 'u','kit_id' => $item_kit_id),''),
                        '删除' => U('index',array('tag' => 'd','kit_id' => $item_kit_id),''),
                    ),
                );
        }

        $this->display("Public/table");
    }

    public function handle() {
        $kit_id = I('id',0,'intval');
        $item_id = I('item_id');
        $update = $_GET['u'] ? $_GET['u'] : 0;

        $data = array(
            "item_kit_id" => $kit_id,
            "item_id" => $item_id,
            "quantity" => I('quantity'),
        );
        if($kit_id == 0) { 
            $this->error($re_text."失败");
        }

        $re_text = $update ? "修改" : "添加";

        if($update){
            $re = M('ItemKitItems')->save($data);
        } else {
            $re = M('ItemKitItems')->add($data);
        }

        if ( $re ) {
            $this->success( $re_text."成功",U("index",array('tag' => 'v','id' => $kit_id)));
        } else {
            $this->error($re_text."失败");
        }
    }
}
