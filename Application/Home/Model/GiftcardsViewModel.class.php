<?PHP
namespace Home\Model;
use Think\Model\ViewModel;

class GiftcardsViewModel extends ViewModel {
    public $viewFields = array(
        'Giftcards' => array('giftcard_id' => 'id','person_id','record_time','giftcard_number','value','_type' => 'LEFT'),
        'Customers' => array('account_number','taxable','_on' => 'Giftcards.person_id = Customers.person_id','_type' => 'LEFT'),
        'People' => array('first_name','last_name','phone_number','email','address_1','_on' => 'Customers.person_id = People.person_id'),
    );
}
