<?php
namespace Home\Controller;

class ReceivingsController extends BaseController {
    public function index(){
        A('Secure/Action')->is_login();

        if(! empty(session('?receiving_cat'))){
            $this->assign('receiving_cat',$this->get_receiving_items());
        }
        $this->display();
    }

    public function find_item(){
        $fstr = I('fstr','');
        $fileds = "item_id as id,item_number,description,name";
        $id_not_in = "";
        $return_data = array();

        if(! empty($fstr)) {
            $re = M('items')->where('item_number like \'%'.$fstr.'%\'')->field($fileds)->select();
            if( is_array($re) ) {
                foreach($re as $item){
                    $id_not_in .= $item['id'] . ",";
                }
                $id_not_in = rtrim($id_not_in,",");
            }

            $return_data = array_merge($return_data,$re);

            $where = 'name like \'%'.$fstr.'%\'';
            if( ! empty($id_not_in)){
                $where = 'name like \'%'.$fstr.'%\' AND item_id not in ('. $id_not_in .')';
            }
            $re = M('items')->where($where)->field($fileds)->select();
            $return_data = array_merge($return_data,$re);

            $this->ajaxReturn($return_data,'JSON');
        }
    }

    public function add_item(){
        $id = I('id','intval');
        $fileds = "item_id as id,unit_price,percent,item_number,description,name";
        $is_new = true;
        $receiving_array = array();

        //session('receiving_cat',null);

        if(empty(session('?receiving_cat'))){
            $receiving_array[0]['id'] = $id;
            $receiving_array[0]['count'] = 1;
        } else {
            $receiving_array = session('receiving_cat');
            for($i = 0; $i < count($receiving_array); $i++){
                if($receiving_array[$i]['id'] == $id){
                    $receiving_array[$i]['count'] += 1;
                    $is_new = false;
                }
            }

            if($is_new) {
                $temp_array['id'] = $id;
                $temp_array['count'] = 1;
                array_push($receiving_array,$temp_array);
            }
        }
        session('receiving_cat',$receiving_array,3600);
    }

    public function show_item(){
        $this->ajaxReturn($this->get_receiving_items());
    }

    public function get_receiving_items(){
        $receiving_item_array = array();
        $receiving_array = session('receiving_cat');

        if(is_array($receiving_array)){
            foreach($receiving_array as $receiving){
                $re = D('ItemsView')->find($receiving['id']);
                $re['count'] = $receiving['count'];

                array_push($receiving_item_array,$re);
            }
        }

        return $receiving_item_array;
    }

    public function receiving_cat_clean(){
        session('receiving_cat',null);

        $this->success(L('receiving_clean_success'),U('Receivings/index'));
    }
}
