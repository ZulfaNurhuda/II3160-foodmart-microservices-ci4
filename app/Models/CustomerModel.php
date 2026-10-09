<?php
namespace App\Models;
use CodeIgniter\Model;

class CustomerModel extends Model{
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';

    public function getCustomers($ids, $limit, $offset){
        $this->select('customer_id, fullname, city, state_province, country, member_card, yearly_income, gender')->orderBy('customer_id');
        if ($ids) { $this->whereIn('customer_id', $ids); }
        return $this->findAll($limit, $offset);
    }

    public function getSummary($id){
        return $this->db->query('SELECT SUM(n) AS items, SUM(u) AS total_units, SUM(r) AS total_spent FROM (
            SELECT COUNT(*) AS n, SUM(unit_sales) AS u, SUM(store_sales) AS r FROM sales_fact_1997 WHERE customer_id = ?
            UNION ALL
            SELECT COUNT(*), SUM(unit_sales), SUM(store_sales) FROM sales_fact_1998 WHERE customer_id = ?) s', [$id, $id])->getRowArray();
    }
}
