<?PHP
namespace Home\Model;
use Think\Model\ViewModel;

class ItemKitsViewModel extends ViewModel {
    public $viewFields = array(
        'Item_kits' => array('item_kit_id' => 'id','name','description','_type' => 'LEFT'),
        'Item_kit_items' => array('quantity','_on' => 'Item_kits.item_kit_id = Item_kit_items.item_kit_id','_type' => 'LEFT'),
        'Items' => array('item_id','name' => 'item_name','category','supplier_id','item_number','description' => 'item_description','cost_price','unit_price','reorder_level','receiving_quantity','allow_alt_description','is_serialized','deleted','_on' => 'Item_kit_items.item_id = Items.item_id'),
    );
}
