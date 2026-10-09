<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\CustomerModel;

class Customers extends ResourceController{
    public function index(){
        $model = model(CustomerModel::class);
        $ids = array_slice(array_filter(array_map('intval', explode(',', (string) $this->request->getGet('ids')))), 0, 50);
        $page = max(1, (int) $this->request->getGet('page'));
        $data = ['message' => 'success', 'page' => $page, 'data' => $model->getCustomers($ids, 50, ($page - 1) * 50)];
        return $this->respond($data, 200);
    }

    public function show($id = null){
        $model = model(CustomerModel::class);
        $customer = $model->find($id);
        if (!$customer) { return $this->failNotFound(); }
        return $this->respond(['message' => 'success', 'data' => $customer], 200);
    }

    public function summary($id = null){
        $model = model(CustomerModel::class);
        if (!$model->find($id)) { return $this->failNotFound(); }
        return $this->respond(['message' => 'success', 'data' => $model->getSummary($id)], 200);
    }
}
