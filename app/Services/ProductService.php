<?php

namespace App\Services;

use App\Services\Contracts\ProductInterface;

class ProductService
{
    protected $apiService;

    public function __construct(ProductInterface $apiService)
    {
        $this->apiService = $apiService;
    }

    public function addProduct(array $data)
    {
        return $this->apiService->addProduct($data);
    }

    public function getAllProduct()
    {
        return $this->apiService->getAllProduct();
    }

    public function getSingleProduct($id)
    {
        return $this->apiService->getSingleProduct($id);
    }
}
