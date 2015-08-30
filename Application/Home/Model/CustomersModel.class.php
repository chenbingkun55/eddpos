<?PHP
namespace Home\Model;
use Think\Model\RelationModel;

class CustomersModel extends RelationModel{
    protected $_link = array(
        'People'=>array(
            'mapping_type'  => self::HAS_ONE,
            'class_name'    => 'People',
            'foreign_key'   => 'person_id',
            ),
        );
}
