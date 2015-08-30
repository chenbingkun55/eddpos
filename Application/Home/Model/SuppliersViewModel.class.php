<?PHP
namespace Home\Model;
use Think\Model\ViewModel;

class SuppliersViewModel extends ViewModel {
    public $viewFields = array(
        'Suppliers' => array('person_id' => 'id','company_name','account_number','_type' => 'LEFT'),
        'People' => array('first_name','last_name','phone_number','email','address_1','_on' => 'Suppliers.person_id = People.person_id'),
    );
}
