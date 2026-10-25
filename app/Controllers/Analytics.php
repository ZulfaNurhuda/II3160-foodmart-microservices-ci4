<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Analytics extends ResourceController{
    private function unavailable(){
        return $this->fail('sales-service unavailable', 502);
    }

    public function topProducts(){
        $rows = api('SALES', '/sales/top-products');
        if ($rows === null) { return $this->unavailable(); }
        return $this->respond(['message' => 'success', 'data' => attach($rows, 'product_id', 'PRODUCT', '/products', 'product')], 200);
    }

    public function topCustomers(){
        $rows = api('SALES', '/sales/top-customers');
        if ($rows === null) { return $this->unavailable(); }
        return $this->respond(['message' => 'success', 'data' => attach($rows, 'customer_id', 'CUSTOMER', '/customers', 'customer')], 200);
    }

    public function salesTrend(){
        $trend = api('SALES', '/sales/trend');
        if ($trend === null) { return $this->unavailable(); }
        return $this->respond(['message' => 'success', 'data' => $trend], 200);
    }

    public function dashboard(){
        $trend = api('SALES', '/sales/trend');
        $products = api('SALES', '/sales/top-products');
        $customers = api('SALES', '/sales/top-customers');
        if ($trend === null || $products === null || $customers === null) { return $this->unavailable(); }
        $data = [
            'total_revenue' => array_sum(array_column($trend, 'revenue')),
            'total_units'   => array_sum(array_column($trend, 'units')),
            'top_products'  => attach($products, 'product_id', 'PRODUCT', '/products', 'product'),
            'top_customers' => attach($customers, 'customer_id', 'CUSTOMER', '/customers', 'customer'),
            'sales_trend'   => $trend,
        ];
        return $this->respond(['message' => 'success', 'data' => $data], 200);
    }
}
