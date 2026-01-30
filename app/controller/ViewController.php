<?php 

// 1. Phải kế thừa Controller để dùng được $this->view và $this->model
class ViewController extends Controller {
    
    private $productModel;
    private $DanhMucModel;

    public function __construct()
    {
        $this->productModel = $this->model('ProductModel');
          $this->DanhMucModel = $this->model('DanhMucModel');
    }

    public function trangchu()
    {
   $danhmuc = $this->DanhMucModel->all(); 

        $products = $this->productModel->all(); 

        $this->view('view.trangchu', ['products' => $products, 'danhmuc' => $danhmuc]);
    }
}
?>