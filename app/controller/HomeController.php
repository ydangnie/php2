<?php

class HomeController
{
    private $productModel;
    private $ThuongHieuModel;
    private $DanhMucModel;
    public function __construct()
    {
        
        $this->productModel = $this->model('ProductModel');
    }
    public function index()
{
    // Lấy dữ liệu sản phẩm (Giả sử bạn muốn lấy 8 sản phẩm mới nhất)
    $products = $this->productModel->all(); 
    
    // Truyền biến 'products' ra view
    $this->view('home/index', ['products' => $products]);
}
}
