<?PHP
namespace Home\Model;
use Think\Model\RelationModel;

class ItemKitsModel extends RelationModel{
    protected $_link = array(
        'Item_kit_items'=>array(
            'mapping_type'  => self::HAS_ONE,
            'class_name'    => 'Item_kit_items',
            'foreign_key'   => 'item_kit_id',
            ),
        'Items'=>array(
            'mapping_type'  => self::HAS_ONE,
            'class_name'    => 'Items',
            'foreign_key'   => 'item_id',
            ),
        );
}
