<?php
namespace Home\Controller;

class SalesController extends BaseController {
    public function index(){
        $this->display();
    }

    public function find_item(){
        $fstr = I('fstr','');
        $fileds = "item_id as id,item_number,description,name";
        $return_data = array();

        if(! empty($fstr)) {
            $re = M('items')->where('item_number like \''.$fstr.'%\'')->field($fileds)->select();
            if( is_array($re) ) {
                foreach($re as $item){
                    $id_not_in .= $item['id'] . ",";
                }
                $id_not_in = rtrim($id_not_in,",");
            }

            $return_data = array_merge($return_data,$re);
            $re = M('items')->where('name like \'%'.$fstr.'%\' AND item_id not in ('. $id_not_in .')')->field($fileds)->select();
            $return_data = array_merge($return_data,$re);

            $this->ajaxReturn($return_data,'JSON');
        }
    }
}
