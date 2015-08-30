<?PHP
namespace Home\Model;
use Think\Model\ViewModel;

class ItemsViewModel extends ViewModel {
    public $viewFields = array(
        'Items' => array('item_id' => 'id','name','category','supplier_id','item_number','description','cost_price','unit_price','reorder_level','receiving_quantity','allow_alt_description','is_serialized','deleted','_type' => 'LEFT'),
        'Items_taxes' => array('percent','_on' => 'Items.item_id = Items_taxes.item_id'),
        'Item_quantities' => array('quantity','location_id','_on' => 'Items.item_id = Item_quantities.item_id'),
    );
}
