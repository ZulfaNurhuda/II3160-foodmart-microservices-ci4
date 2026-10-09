<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ProductModel;

class Products extends ResourceController{
    public function index(){
        $model = model(ProductModel::class);
        $ids = array_slice(array_filter(array_map('intval', explode(',', (string) $this->request->getGet('ids')))), 0, 50);
        $page = max(1, (int) $this->request->getGet('page'));
        $data = ['message' => 'success', 'page' => $page, 'data' => $model->getProducts($ids, 50, ($page - 1) * 50)];
        return $this->respond($data, 200);
    }

    public function show($id = null){
        $model = model(ProductModel::class);
        $product = $model->getProduct($id);
        if (!$product) { return $this->failNotFound(); }
        return $this->respond(['message' => 'success', 'data' => $product], 200);
    }

    public function categories(){
        $model = model(ProductModel::class);
        return $this->respond(['message' => 'success', 'data' => $model->getCategories()], 200);
    }
}
