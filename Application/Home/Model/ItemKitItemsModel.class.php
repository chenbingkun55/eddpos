<?PHP
namespace Home\Model;
use Think\Model\RelationModel;

class ItemKitItemsModel extends RelationModel{
    protected $_link = array(
        'Items'=>array(
            'mapping_type'  => self::HAS_ONE,
            'class_name'    => 'Items',
            'foreign_key'   => 'item_id',
            ),
        'Item_kits'=>array(
            'mapping_type'  => self::HAS_ONE,
            'class_name'    => 'Item_kits',
            'foreign_key'   => 'item_kit_id',
            ),
        );
}
