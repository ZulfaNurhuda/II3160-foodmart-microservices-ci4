<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\SaleModel;

class Sales extends ResourceController{
    private function transactions($customer){
        $model = model(SaleModel::class);
        $page = max(1, (int) $this->request->getGet('page'));
        $data = ['message' => 'success', 'page' => $page, 'data' => $model->getSales($customer, 50, ($page - 1) * 50)];
        return $this->respond($data, 200);
    }

    public function index(){
        return $this->transactions(null);
    }

    public function customer($id = null){
        return $this->transactions($id);
    }

    public function show($time = null, $customer = null, $store = null){
        $model = model(SaleModel::class);
        $items = $model->getSale($time, $customer, $store);
        if (!$items) { return $this->failNotFound(); }
        $data = [
            'id'       => "$time-$customer-$store",
            'customer' => api('CUSTOMER', '/customers/' . $customer),
            'store'    => api('STORE', '/stores/' . $store),
            'items'    => attach($items, 'product_id', 'PRODUCT', '/products', 'product'),
        ];
        return $this->respond(['message' => 'success', 'data' => $data], 200);
    }

    public function topProducts(){
        $model = model(SaleModel::class);
        return $this->respond(['message' => 'success', 'data' => $model->getTopProducts()], 200);
    }

    public function topCustomers(){
        $model = model(SaleModel::class);
        return $this->respond(['message' => 'success', 'data' => $model->getTopCustomers()], 200);
    }

    public function trend(){
        $model = model(SaleModel::class);
        return $this->respond(['message' => 'success', 'data' => $model->getTrend()], 200);
    }
}
