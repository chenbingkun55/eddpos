<?php
namespace Home\Controller;

class AppConfigController extends BaseController {
    public function index(){
        $tag = I('tag', $tag); // $tag 控制动作.
        $key = I('id');

        switch($tag){
            case 'a':
                $this->view('a');
                break;
            case 'd':
                if( D('AppConfig')->where('`key` = \''.$key.'\'')->delete()){
                    $this->success( "删除成功",U("index",array('tag' => 'v','key' => $key)));
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
        $key = I('id');

        switch($tag){
            case 'c':
                $clone = 1;
            case 'u':
                $up_data = D('AppConfig')->where(array('key' => $key))->find();
                if($clone) { $up_data['id'] = 0; }
            case 'a':
                $this->data = array(
                    'title' => is_array($up_data) ? $clone ? '复制配置' : '修改配置' : '添加配置',
                    'col' => '2',
                    'head' => array(
                        'id' => 'add_config',
                        'type' => 'form',
                        'handle' => is_array($up_data) ? $clone ? U('handle',array('c' => 1),'') : U('handle',array('u' => 1),'') : U('handle',0,''),
                        'submit' =>  is_array($up_data) ? $clone ? '复制' : '修改' : '添加',
                    ),
                    'table' => array(
                       array(
                            'key',
                            '名称',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['key'],
                            ),
                        ),
                       array(
                            'value',
                            '配置',
                            'type' => array(
                                'input' => 'text',
                                'value' => $up_data['value'],
                            ),
                        ),
                       array(
                            'id',
                            '',
                            'type' => array(
                                'input' => 'hidden',
                                'value' => $key,
                            ),
                        ),
                    ),
                );
                break;
            case 'v':
            default :
                $field = array('key' => 'id','value');

                $this->data = array(
                    'title' => '配置列表',
                    'url' => U('index',array('tag' => a,'key' => $key),''),
                    'col' => 2,
                    'table' => D('AppConfig')->field($field)->select(),
                    'th' => array(
                        '名称',
                        '值',
                        '操作',
                    ),
                    'hiddens' => array(),
                    'function' => array(),
                    'option' => array(
                        '修改' => U('index',array('tag' => 'u','key' => $key),''),
                        '删除' => U('index',array('tag' => 'd','key' => $key),''),
                    ),
                );
        }

        $this->display("Public/table");
    }

    public function handle() {
        $key = I('key');
        $update = $_GET['u'] ? $_GET['u'] : 0;

        $data = array(
            "key" => $key,
            "value" => I('value'),
        );
        if($key == "") { 
            $this->error($re_text."失败");
        }

        $re_text = $update ? "修改" : "添加";

        if($update){
            $re = M('AppConfig')->save($data);
        } else {
            $re = M('AppConfig')->add($data);
        }

        if ( $re ) {
            $this->success( $re_text."成功",U("index",array('tag' => 'v','id' => $key)));
        } else {
            $this->error($re_text."失败");
        }
    }
}
