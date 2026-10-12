<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\StoreModel;

class Stores extends ResourceController{
    public function index(){
        $model = model(StoreModel::class);
        return $this->respond(['message' => 'success', 'data' => $model->getStores()], 200);
    }

    public function show($id = null){
        $model = model(StoreModel::class);
        $store = $model->getStore($id);
        if (!$store) { return $this->failNotFound(); }
        return $this->respond(['message' => 'success', 'data' => $store], 200);
    }
}
