<?php
namespace Home\Controller;
use Think\Controller;
class ItemsController extends Controller {
    public function index(){
        $tag = I('tag', $tag); // $tag 控制动作.

        switch($tag){
            case 'a':
                $this->view('a');
                break;
            case 'd':
                $id = I('id',0,'intval');
                if( D('Items')->relation(true)->where('item_id = '.$id)->setField('deleted','1')){
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
                $up_data = D('ItemsView')->where('deleted = 0')->find($id);
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
                            'supplier_id',
                            '供应商',
                            'type' => array(
                                'input' => 'select',
                                'selected' => $up_data['supplier_id'],
                                'value' => M('Suppliers')->getField('person_id,company_name'),
                            ),
                        ),
                       array(
                            'item_number',
                            '数量',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['item_number'],
                            ),
                        ),
                       array(
                            'name',
                            '名称',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['name'],
                            ),
                        ),
                       array(
                            'category',
                            '类别',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['category'],
                            ),
                        ),
                       array(
                            'cost_price',
                            '成本价',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['cost_price'],
                            ),
                        ),
                       array(
                            'unit_price',
                            '单价',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['unit_price'],
                            ),
                        ),
                       array(
                            'quantity',
                            '库存',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['quantity'],
                            ),
                        ),
                       array(
                            'percent',
                            '税率',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['percent'],
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
                $field = array('item_id' => 'id','item_number','name','category','cost_price','unit_price','quantity','percent');

                $this->data = array(
                    'title' => '产品列表',
                    'url' => U('index',array('tag' => a),''),
                    'col' => 8,
                    'table' => D('ItemsView')->field($field)->where('deleted = 0')->select(),
                    'th' => array(
                        'ID',
                        '数量',
                        '名称',
                        '类别',
                        '成本价',
                        '单价',
                        '税率',
                        '库存',
                        '操作',
                    ),
                    'hiddens' => array(),
                    'function' => array(),
                    'option' => array(
                        '修改' => U('index',array('tag' => 'u'),''),
                        '复制' => U('index',array('tag' => 'c'),''),
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
            "supplier_id" => I('supplier_id'),
            "item_number" => I('item_number'),
            "name" => I('name'),
            "category" => I('category'),
            "cost_price" => I('cost_price'),
            "unit_price" => I('unit_price'),
            "Items_taxes" => array(
                "percent" => I('percent'),
            ),
            "Item_quantities" => array(
                "location_id" => I('location_id',0,intval),
                "quantity" => I('quantity'),
            ),
        );
        if($id != 0) { 
            $data["item_id"] = $id;
        }

        $re_text = $update ? "修改" : "添加";

        if($update){
            $re = 1;
            D('Items')->relation(true)->where(array('item_id' => $id))->save($data);
        } else {
            $data['Items_taxes']["item_id"] = $data['Item_quantities']['item_id'] = M('Items')->add($data);
            if(empty($data['Items_taxes']['item_id']) || $data['Items_taxes']['item_id'] == 0 ){
                $this->error($re_text."失败");
            }
            $re = M('Items_taxes')->add($data['Items_taxes']);
            $re = M('Item_quantities')->add($data['Item_quantities']);
        }

        if ( $re ) {
            $this->success( $re_text."成功",U("index"));
        } else {
            $this->error($re_text."失败");
        }
    }
}
