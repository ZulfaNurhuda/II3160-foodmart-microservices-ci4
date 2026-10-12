<?php
namespace App\Models;
use CodeIgniter\Model;

class StoreModel extends Model{
    protected $table = 'store';
    protected $primaryKey = 'store_id';

    public function getStores(){
        return $this->select('store_id, store_name, store_type, store_city, store_state, store_country, store_manager')->orderBy('store_id')->findAll(100);
    }

    public function getStore($id){
        return $this->join('region', 'region.region_id = store.region_id', 'left')->find($id);
    }
}
