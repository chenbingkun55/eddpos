<?php
namespace Home\Controller;

class ReceivingsController extends BaseController {
    public function index(){
        A('Secure/Action')->is_login();

        //if(! empty(session('?shop_cat'))){
            //$this->assign('shop_cat',$this->get_sale_items());
        //}
        $this->display();
    }

    //public function find_item(){
        //$fstr = I('fstr','');
        //$fileds = "item_id as id,item_number,description,name";
        //$id_not_in = "";
        //$return_data = array();

        //if(! empty($fstr)) {
            //$re = M('items')->where('item_number like \'%'.$fstr.'%\'')->field($fileds)->select();
            //if( is_array($re) ) {
                //foreach($re as $item){
                    //$id_not_in .= $item['id'] . ",";
                //}
                //$id_not_in = rtrim($id_not_in,",");
            //}

            //$return_data = array_merge($return_data,$re);

            //$where = 'name like \'%'.$fstr.'%\'';
            //if( ! empty($id_not_in)){
                //$where = 'name like \'%'.$fstr.'%\' AND item_id not in ('. $id_not_in .')';
            //}
            //$re = M('items')->where($where)->field($fileds)->select();
            //$return_data = array_merge($return_data,$re);

            //$this->ajaxReturn($return_data,'JSON');
        //}
    //}

    //public function add_item(){
        //$id = I('id','intval');
        //$fileds = "item_id as id,unit_price,percent,item_number,description,name";
        //$is_new = true;
        //$sale_array = array();

        ////session('shop_cat',null);

        //if(empty(session('?shop_cat'))){
            //$sale_array[0]['id'] = $id;
            //$sale_array[0]['count'] = 1;
        //} else {
            //$sale_array = session('shop_cat');
            //for($i = 0; $i < count($sale_array); $i++){
                //if($sale_array[$i]['id'] == $id){
                    //$sale_array[$i]['count'] += 1;
                    //$is_new = false;
                //}
            //}

            //if($is_new) {
                //$temp_array['id'] = $id;
                //$temp_array['count'] = 1;
                //array_push($sale_array,$temp_array);
            //}
        //}
        //session('shop_cat',$sale_array,3600);
    //}

    //public function show_item(){
        //$this->ajaxReturn($this->get_sale_items());
    //}

    //public function get_sale_items(){
        //$sale_item_array = array();
        //$sale_array = session('shop_cat');

        //if(is_array($sale_array)){
            //foreach($sale_array as $sale){
                //$re = D('ItemsView')->find($sale['id']);
                //$re['count'] = $sale['count'];

                //array_push($sale_item_array,$re);
            //}
        //}

        //return $sale_item_array;
    //}

    //public function shop_cat_clean(){
        //session('shop_cat',null);

        //$this->success(L('sale_clean_success'),U('Sales/index'));
    //}
}
