<?PHP
namespace Secure\Model;

class ActionModel extends BaseModel {
    protected $tableName = 'employees';

    public function login_handle() {
        $username = I('username');
        $password = I('password');

        $sql = 'select username,person_id,deleted from __PREFIX__employees where username = \''.$username.'\' AND password = \''.sha1($password.C('SECURE_KEY')).'\'';

        $re = $this->query($sql);
        if(count($re) == 1){
            session('emp_data',$re[0]);
            return true;
        }

        if(count($re) > 1){
            return -1;
        }
    }
}
