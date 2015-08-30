<?PHP
namespace Home\Model;
use Think\Model\RelationModel;

class ItemsModel extends RelationModel{
    protected $_link = array(
        'Items_taxes'=>array(
            'mapping_type'  => self::HAS_ONE,
            'class_name'    => 'Items_taxes',
            'foreign_key'   => 'item_id',
            ),
        'Item_quantities'=>array(
            'mapping_type'  => self::HAS_ONE,
            'class_name'    => 'Item_quantities',
            'foreign_key'   => 'item_id',
            ),
        );
}
