<?PHP
namespace Home\Model;
use Think\Model\ViewModel;

class CustomersViewModel extends ViewModel {
    public $viewFields = array(
        'Customers' => array('person_id' => 'id','account_number','taxable','_type' => 'LEFT'),
        'People' => array('first_name','last_name','phone_number','email','address_1','_on' => 'Customers.person_id = People.person_id'),
    );
}
