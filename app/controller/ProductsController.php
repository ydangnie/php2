<?php

class ProductsController extends Controller {
    private $productModel;

    public function __construct() {
        $this->productModel = $this->model('ProductModel');
    }

    public function index() {
        $products = $this->productModel->all();
        // Sửa 'product' thành 'products'
        $this->view('products/index', ['products' => $products]); 
    }

    public function add() {
      
        $this->view('products/add', []); 
    }

    public function them() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $mota = $_POST['mota'];
            $img = $_POST['img'];
            $this->productModel->create(['name' => $name, 'price' => $price, 'mota' => $mota, 'img' => $img]);
        
            $this->redirect('http://localhost:8000/products/index'); 
        }
    }

    public function edit($id) {
        $product = $this->productModel->find($id);
        // Sửa 'product' thành 'products'
        $this->view('products/edit', ['product' => $product]); 
    }

    public function update_product($id) {
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
              $mota = $_POST['mota'];
            $img = $_POST['img'];
            $this->productModel->update(['name' => $name, 'price' => $price, 'mota' => $mota, 'img' => $img], $id);
            // Sửa đường dẫn redirect
            $this->redirect('http://localhost:8000/products/index');
        }
    }

    public function delete($id) {
        $this->productModel->delete($id);
        // Sửa đường dẫn redirect
        $this->redirect('http://localhost:8000/products/index');
    }
}