<?php
namespace App\Models;
use CodeIgniter\Model;

class SaleModel extends Model{
    private function facts($cols, $where = ''){
        return "(SELECT $cols FROM sales_fact_1997 $where UNION ALL SELECT $cols FROM sales_fact_1998 $where) s";
    }

    public function getSales($customer, $limit, $offset){
        $where = $customer ? 'WHERE customer_id = ?' : '';
        $binds = $customer ? [$customer, $customer, $limit, $offset] : [$limit, $offset];
        return $this->db->query("SELECT CONCAT(g.time_id, '-', g.customer_id, '-', g.store_id) AS id, t.the_date, g.customer_id, g.store_id, g.items, g.total
            FROM (SELECT time_id, customer_id, store_id, COUNT(*) AS items, SUM(store_sales) AS total
                  FROM " . $this->facts('time_id, customer_id, store_id, store_sales', $where) . "
                  GROUP BY time_id, customer_id, store_id ORDER BY time_id, customer_id, store_id LIMIT ? OFFSET ?) g
            JOIN time_by_day t ON t.time_id = g.time_id
            ORDER BY g.time_id, g.customer_id, g.store_id", $binds)->getResultArray();
    }

    public function getSale($time, $customer, $store){
        $where = 'WHERE time_id = ? AND customer_id = ? AND store_id = ?';
        return $this->db->query('SELECT product_id, promotion_id, unit_sales, store_sales, store_cost FROM '
            . $this->facts('product_id, promotion_id, unit_sales, store_sales, store_cost', $where) . ' ORDER BY product_id',
            [$time, $customer, $store, $time, $customer, $store])->getResultArray();
    }

    public function getTopProducts(){
        return cache()->remember('top_products', 3600, fn () => $this->db->query('SELECT product_id, SUM(unit_sales) AS units, SUM(store_sales) AS revenue FROM '
            . $this->facts('product_id, unit_sales, store_sales') . ' GROUP BY product_id ORDER BY units DESC LIMIT 10')->getResultArray());
    }

    public function getTopCustomers(){
        return cache()->remember('top_customers', 3600, fn () => $this->db->query('SELECT customer_id, SUM(unit_sales) AS units, SUM(store_sales) AS revenue FROM '
            . $this->facts('customer_id, unit_sales, store_sales') . ' GROUP BY customer_id ORDER BY revenue DESC LIMIT 10')->getResultArray());
    }

    public function getTrend(){
        return cache()->remember('trend', 3600, fn () => $this->db->query('SELECT t.the_year, t.month_of_year, SUM(d.units) AS units, SUM(d.revenue) AS revenue
            FROM (SELECT time_id, SUM(unit_sales) AS units, SUM(store_sales) AS revenue FROM ' . $this->facts('time_id, unit_sales, store_sales') . ' GROUP BY time_id) d
            JOIN time_by_day t ON t.time_id = d.time_id
            GROUP BY t.the_year, t.month_of_year ORDER BY t.the_year, t.month_of_year')->getResultArray());
    }
}
