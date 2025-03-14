<?php

namespace App\Services\Contracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

interface ProductInterface
{
    public function addProduct(array $data): JsonResponse;
    public function getAllProduct(): JsonResponse;
    public function getSingleProduct($id): JsonResponse;
}
