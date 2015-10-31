<?php
namespace Home\Controller;

class SalesController extends BaseController {
    public function index(){
        A('Secure/Action')->is_login();

        if(! empty(session('?shop_cat'))){
            $this->assign('shop_cat',$this->get_sale_items());
        }
        print_r(session("shop_cat"));
        $this->display();
    }

    public function find_item(){
        $fstr = I('fstr','');
        $fileds = "item_id as id,item_number,description,name";
        $kit_fileds = "item_kit_id as id,description,name";
        $id_not_in = "";
        $return_data = array();

        if(! empty($fstr)) {
            $re = M('items')->where('item_number like \'%'.$fstr.'%\'')->field($fileds)->select();
            $kit_re = M('ItemKits')->where('name like \'%'.$fstr.'%\'')->field($kit_fileds)->select();
            if( is_array($re) || is_array($kit_re) ) {
                foreach($re as $item){
                    $id_not_in .= $item['id'] . ",";
                }
                $id_not_in = rtrim($id_not_in,",");

                foreach($kit_re as $item_kit){
                    $kit_id_not_in .= $item_kit['id'] . ",";
                }
                $kit_id_not_in = rtrim($kit_id_not_in,",");
            }

            $return_data = array_merge($return_data,$re,$kit_re);

            $where = 'name like \'%'.$fstr.'%\'';
            $kit_where = 'name like \'%'.$fstr.'%\'';
            if( ! empty($id_not_in)){
                $where = 'name like \'%'.$fstr.'%\' AND item_id not in ('. $id_not_in .')';
            }
            if( ! empty($kit_id_not_in)){
                $kit_where = 'name like \'%'.$fstr.'%\' AND item_kit_id not in ('. $kit_id_not_in .')';
            }
            $re = M('items')->where($where)->field($fileds)->select();
            $kit_re = M('ItemKits')->where($kit_where)->field($kit_fileds)->select();
            $return_data = array_merge($return_data,$re,$kit_re);

            $this->ajaxReturn($return_data,'JSON');
        }
    }

    public function alter_item(){
        $id = I('id','intval');
        $new_count = I('count','intval');
        $new_unit_price = I('unit_price','intval');

        if(! empty(session('?shop_cat'))){
            $sale_array = session('shop_cat');
            for($i = 0; $i < count($sale_array); $i++){
                if($sale_array[$i]['id'] == $id){
                    $sale_array[$i]['count'] = $new_count;
                }

                if($sale_array[$i]['id'] == $id){
                    $sale_array[$i]['unit_price'] = number_format($new_unit_price,2);
                }
            }
        session('shop_cat',$sale_array,3600);
        $this->ajaxReturn("true");
        }
    }

    public function add_item(){
        $id = I('id','intval');
        $is_new = true;
        $sale_array = array();

        //session('shop_cat',null);

        if(empty(session('?shop_cat'))){
            $sale_array[0]['id'] = $id;
            $sale_array[0]['count'] = 1;
        } else {
            $sale_array = session('shop_cat');
            for($i = 0; $i < count($sale_array); $i++){
                if($sale_array[$i]['id'] == $id){
                    $sale_array[$i]['count'] += 1;
                    $is_new = false;
                }
            }

            if($is_new) {
                $temp_array['id'] = $id;
                $temp_array['count'] = 1;
                array_push($sale_array,$temp_array);
            }
        }
        session('shop_cat',$sale_array,3600);
        $this->ajaxReturn("true");
    }

    public function show_item(){
        $this->ajaxReturn($this->get_sale_items());
    }

    public function get_sale_items(){
        $fileds = "id,unit_price,percent,item_number,description,name";
        $kit_fileds = "id,unit_price,percent,item_number,description,name";
        $sale_item_array = array();
        $sale_array = session('shop_cat');

        if(is_array($sale_array)){
            foreach($sale_array as $sale){
                $re = D('ItemsView')->field($fileds)->find($sale['id']);
                $kit_re = D('ItemKitsView')->field($kit_fileds)->find($sale['id']);

                if(is_array($kit_re)){
                    $kit_re['count'] = $sale['count'];
                    if(! is_null($sale['unit_price'])) { $kit_re['unit_price'] = $sale['unit_price']; }
                    array_push($sale_item_array,$kit_re);
                }

                if(is_array($re)){
                    $re['count'] = $sale['count'];
                    if(! is_null($sale['unit_price'])) { $re['unit_price'] = $sale['unit_price']; }
                    array_push($sale_item_array,$re);
                }
            }
        }

        return $sale_item_array;
    }

    public function shop_cat_clean(){
        session('shop_cat',null);

        $this->success(L('sale_clean_success'),U('Sales/index'));
    }
}
