<?php
namespace Home\Controller;
use Think\Controller;
class ItemKitsController extends Controller {
    public function index(){
        $tag = I('tag', $tag); // $tag 控制动作.

        switch($tag){
            case 'a':
                $this->view('a');
                break;
            case 'd':
                $id = I('id',0,'intval');
                if( D('ItemKits')->relation('Item_kits')->delete($id) && D('ItemKitItems')->where(array('item_kit_id' => $id))->delete()){
                    $this->success("删除成功",U("index"));
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

        switch($tag){
            case 'c':
                $clone = 1;
            case 'u':
                $id = I('id',0,'intval');
                $up_data = D('ItemKitsView')->find($id);
                if($clone) { $up_data['id'] = 0; }
            case 'a':
                $this->data = array(
                    'title' => is_array($up_data) ? $clone ? '复制产品套件' : '修改产品套件' : '添加产品套件',
                    'col' => '2',
                    'head' => array(
                        'id' => 'add_item_kits',
                        'type' => 'form',
                        'handle' => is_array($up_data) ? $clone ? U('handle',array('c' => 1),'') : U('handle',array('u' => 1),'') : U('handle',0,''),
                        'submit' =>  is_array($up_data) ? $clone ? '复制' : '修改' : '添加',
                    ),
                    'table' => array(
                       array(
                            'name',
                            '名称',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['name'],
                            ),
                        ),
                       array(
                            'description',
                            '描述',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['description'],
                            ),
                        ),
                       array(
                            'clone_id',
                            '',
                            'type' => array(
                                'input' => 'hidden',
                                'value' => $id,
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
                $field = array('id','name','description');

                $this->data = array(
                    'title' => '产品套件列表',
                    'url' => U('index',array('tag' => a),''),
                    'col' => 8,
                    'table' => D('ItemKitsView')->field($field)->group('id')->select(),
                    'th' => array(
                        'ID',
                        '名称',
                        '描述',
                        '操作',
                    ),
                    'hiddens' => array(),
                    'function' => array(),
                    'option' => array(
                        '修改' => U('index',array('tag' => 'u'),''),
                        '复制' => U('index',array('tag' => 'c'),''),
                        '删除' => U('index',array('tag' => 'd'),''),
                        '查看组合' => U('ItemkitItems/index',array('tag' => 'v'),''),
                    ),
                );
        }

        $this->display("Public/table");
    }

    public function handle() {
        $id = I('id',0,'intval');
        $clone_id = I('clone_id',0,'intval');
        $update = $_GET['u'] ? $_GET['u'] : 0;

        $data = array(
            "name" => I('name'),
            "description" => I('description'),
        );
        if($id != 0) {
            $data["item_kit_id"] = $id;
        }

        $re_text = $update ? "修改" : "添加";

        if($update){
            $re = D('ItemKits')->relation(true)->where(array('item_kit_id' => $id))->save($data);
        } else {
            $re = $kit_new_id = M('Item_kits')->add($data);

            if($clone_id){
                $clone_data = M('ItemKitItems')->where(array('item_kit_id' => $clone_id))->select();

                foreach($clone_data as $cdata){
                    $cdata['item_kit_id'] = $kit_new_id;
                    $re_clone = M('ItemKitItems')->add($cdata);
                }
            }
        }

        if ( $re ) {
            $this->success( $re_text."成功",U("index"));
        } else {
            $this->error($re_text."失败");
        }
    }
}
