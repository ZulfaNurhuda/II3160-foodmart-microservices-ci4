<?php
namespace App\Models;
use CodeIgniter\Model;

class ProductModel extends Model{
    protected $table = 'product';
    protected $primaryKey = 'product_id';

    public function getProducts($ids, $limit, $offset){
        $this->select('product.product_id, product_name, brand_name, SRP, product_family, product_department, product_category, product_subcategory')
            ->join('product_class', 'product_class.product_class_id = product.product_class_id')
            ->orderBy('product.product_id');
        if ($ids) { $this->whereIn('product.product_id', $ids); }
        return $this->findAll($limit, $offset);
    }

    public function getProduct($id){
        return $this->join('product_class', 'product_class.product_class_id = product.product_class_id')->find($id);
    }

    public function getCategories(){
        return $this->db->query('SELECT DISTINCT product_family, product_department, product_category FROM product_class ORDER BY 1, 2, 3')->getResultArray();
    }
}
