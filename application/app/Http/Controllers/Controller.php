<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $activeTemplate;
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->activeTemplate = activeTemplate();
        $this->productService = $productService;

        $className = get_called_class();
    }
}
