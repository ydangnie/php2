<?php

class DanhMucController extends Controller {
    private $DanhMucModel;

    public function __construct() {
        $this->DanhMucModel = $this->model('DanhMucModel');
    }

    public function index() {
        $danhmuc = $this->DanhMucModel->all();
        // Sửa 'product' thành 'products'
        $this->view('admin/danhmuc/index', ['danhmuc' => $danhmuc]); 
    }

    public function them() {
      
        $this->view('danhmuc/them', []); 
    }

    public function luu() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tendanhmuc = $_POST['tendanhmuc'];
            if(isset($_FILES['img']) && $_FILES['img']['error'] === 0){
                $img =  $_FILES['img']['name'];
                $thumuc = "uploads/";
                $thumucluu = $thumuc . basename($img);
                move_uploaded_file($_FILES['img']['tmp_name'], $thumucluu);



            }
            $this->DanhMucModel->create(['tendanhmuc' => $tendanhmuc, 'img' => $img]);
        
            $this->redirect('http://localhost:8000/danhmuc/index'); 
        }
    }

    public function edit($id) {
        $danhmuc = $this->DanhMucModel->find($id);
        // Sửa 'product' thành 'products'
        $this->view('danhmuc/edit', ['danhmuc' => $danhmuc]); 
    }

    public function update_product($id) {
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tendanhmuc = $_POST['tendanhmuc'];
            $img = "";
            if(isset($_FILES['img']) && $_FILES['img']['error'] === 0){
                $img =  $_FILES['img']['name'];
                $thumuc = "uploads/";
                $thumucluu = $thumuc . basename($img);
                move_uploaded_file($_FILES['img']['tmp_name'], $thumucluu);



            }



            $this->DanhMucModel->update(['tendanhmuc' => $tendanhmuc, 'img' => $img], $id);
            // Sửa đường dẫn redirect
            $this->redirect('http://localhost:8000/danhmuc/index');
        }
    }

    public function delete($id) {
        $danhmuc = $this->DanhMucModel->find($id);
        $this->DanhMucModel->delete($id);
        // Sửa đường dẫn redirect
        if($danhmuc){
            if(!empty($danhmuc['img'])){
                $hinhanhxoa = 'uploads/' . $danhmuc['img'];
                if(file_exists($hinhanhxoa)){
                    unlink($hinhanhxoa);
                }
            }
        }
        
        $this->redirect('http://localhost:8000/danhmuc/index');
    }
}