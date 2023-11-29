<?php

namespace app\Controller;

use app\Models\Product;
use app\Traits\ApiResponseFormatter;

class ProductController
{
    use ApiResponseFormatter;
    
    public function index()
    {
        $productModel = new Product();
        $response = $productModel->findAll();
        return $this->apiResponse(200, "success", $response);
    }

    public function getById($id)
    {
        $productModel = new Product();
        $response = $productModel->findById($id);

        if ($response) {
            return $this->apiResponse(200, "success", $response);
        } else {
            return $this->apiResponse(404, "error not found", null);
        }
    }

    public function insert()
    {
        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($inputData['product_name'])) {
            return $this->apiResponse(400, "error invalid input", null);
        }

        $productModel = new Product();
        $response = $productModel->create([
            "product_name" => $inputData['product_name']
        ]);

        if ($response) {
            return $this->apiResponse(200, "success", $response);
        } else {
            return $this->apiResponse(500, "error creating product", null);
        }
    }

    public function update($id)
    {
        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($inputData['product_name'])) {
            return $this->apiResponse(400, "error invalid input", null);
        }

        $productModel = new Product();
        $response = $productModel->update([
            "product_name" => $inputData['product_name']
        ], $id);

        if ($response) {
            return $this->apiResponse(200, "success", $response);
        } else {
            return $this->apiResponse(500, "error updating product", null);
        }
    }

    public function delete($id)
    {
        $productModel = new Product();
        $response = $productModel->destroy($id);

        if ($response) {
            return $this->apiResponse(200, "success", $response);
        } else {
            return $this->apiResponse(500, "error deleting product", null);
        }
    }
}
