<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\PromotionModel;

class Promotions extends ResourceController{
    public function index(){
        $model = model(PromotionModel::class);
        $page = max(1, (int) $this->request->getGet('page'));
        $data = ['message' => 'success', 'page' => $page, 'data' => $model->orderBy('promotion_id')->findAll(50, ($page - 1) * 50)];
        return $this->respond($data, 200);
    }

    public function show($id = null){
        $model = model(PromotionModel::class);
        $promotion = $model->find($id);
        if (!$promotion) { return $this->failNotFound(); }
        return $this->respond(['message' => 'success', 'data' => $promotion], 200);
    }
}
