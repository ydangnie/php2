<?php

class ThuongHieuController extends Controller {
    private $ThuongHieuModel;

    public function __construct() {
        $this->ThuongHieuModel = $this->model('ThuongHieuModel');
    }

    public function index() {
        $thuonghieu = $this->ThuongHieuModel->all();
        // Sửa 'product' thành 'products'
        $this->view('thuonghieu/index', ['thuonghieu' => $thuonghieu]); 
    }

    public function them() {
      
        $this->view('thuonghieu/them', []); 
    }

    public function luu() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tenthuonghieu = $_POST['tenthuonghieu'];
            if(isset($_FILES['img']) && $_FILES['img']['error'] === 0){
                $img =  $_FILES['img']['name'];
                $thumuc = "uploads/";
                $thumucluu = $thumuc . basename($img);
                move_uploaded_file($_FILES['img']['tmp_name'], $thumucluu);



            }
            $this->ThuongHieuModel->create(['tenthuonghieu' => $tenthuonghieu, 'img' => $img]);
        
            $this->redirect('http://localhost:8000/thuonghieu/index'); 
        }
    }

    public function edit($id) {
        $thuonghieu = $this->ThuongHieuModel->find($id);
        // Sửa 'product' thành 'products'
        $this->view('thuonghieu/edit', ['thuonghieu' => $thuonghieu]); 
    }

    public function update_product($id) {
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tenthuonghieu = $_POST['tenthuonghieu'];
            $img = "";
            if(isset($_FILES['img']) && $_FILES['img']['error'] === 0){
                $img =  $_FILES['img']['name'];
                $thumuc = "uploads/";
                $thumucluu = $thumuc . basename($img);
                move_uploaded_file($_FILES['img']['tmp_name'], $thumucluu);



            }



            $this->ThuongHieuModel->update(['tenthuonghieu' => $tenthuonghieu, 'img' => $img], $id);
            // Sửa đường dẫn redirect
            $this->redirect('http://localhost:8000/thuonghieu/index');
        }
    }

    public function delete($id) {
        $thuonghieu = $this->ThuongHieuModel->find($id);
        $this->ThuongHieuModel->delete($id);
        // Sửa đường dẫn redirect
        if($thuonghieu){
            if(!empty($thuonghieu['img'])){
                $hinhanhxoa = 'uploads/' . $thuonghieu['img'];
                if(file_exists($hinhanhxoa)){
                    unlink($hinhanhxoa);
                }
            }
        }
        
        $this->redirect('http://localhost:8000/thuonghieu/index');
    }
}