<?php 
// app/controller/ViewController.php

class ViewController extends Controller {
    
    private $productModel;
    private $DanhMucModel;

    public function __construct()
    {
        $this->productModel = $this->model('ProductModel');
        $this->DanhMucModel = $this->model('DanhMucModel');
    }
public function index()
    {
        $danhmuc = $this->DanhMucModel->all(); 
        $products = $this->productModel->all(); 
        $this->view('view.index', ['products' => $products, 'danhmuc' => $danhmuc]);
    }
    public function chitiet(){
          $this->view('view.chitiet', []);

    }

}
?>