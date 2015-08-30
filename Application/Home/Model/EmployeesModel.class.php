<?PHP
namespace Home\Model;
use Think\Model\RelationModel;

class EmployeesModel extends RelationModel{
    protected $_link = array(
        'People'=>array(
            'mapping_type'  => self::HAS_ONE,
            'class_name'    => 'People',
            'foreign_key'   => 'person_id',
            'as_fields' => 'first_name,last_name,phone_number,email,address_1,address_2,city,state,zip,country,comments,person_id:id',
            ),
        );
}
