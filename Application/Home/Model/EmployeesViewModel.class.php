<?PHP
namespace Home\Model;
use Think\Model\ViewModel;

class EmployeesViewModel extends ViewModel {
    public $viewFields = array(
        'Employees' => array('person_id' => 'id','username','_type' => 'LEFT'),
        'People' => array('first_name','last_name','phone_number','email','address_1','_on' => 'Employees.person_id = People.person_id'),
    );
}
