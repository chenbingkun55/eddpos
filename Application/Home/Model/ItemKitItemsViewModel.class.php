<?PHP
namespace Home\Model;
use Think\Model\ViewModel;

class ItemKitItemsViewModel extends ViewModel {
    public $viewFields = array(
        'Item_kit_items' => array('item_kit_id','item_id' => 'id','quantity','_type' => 'LEFT'),
        'Items' => array('name','category','supplier_id','item_number','description' => 'item_description','cost_price','unit_price','reorder_level','receiving_quantity','allow_alt_description','is_serialized','deleted','_on' => 'Item_kit_items.item_id = Items.item_id'),
    );
}
