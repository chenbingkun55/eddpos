<?PHP
namespace Home\Model;
use Think\Model\RelationModel;

class EmployeesModel extends RelationModel{
    protected $_link = array(
        'People'=>array(
            'mapping_type'  => self::HAS_ONE,
            'class_name'    => 'People',
            'foreign_key'   => 'person_id',
            ),
        );

    public function check_login(){
        $username = trim(I('username'));
        $password = trim(I('password'));

        if(empty($username) || empty($password)){
            $this->error(L('login_failed'),U('Employees/login'));
        }

        $re = M('Employees')->field('username,person_id,deleted')->where('username = \''.$username.'\' AND password = md5(\''.$password.'\') AND deleted = 0')->find();

        if(empty($re)) {
            return -1;
        }

        session('PERSON',$re);
    }
}
