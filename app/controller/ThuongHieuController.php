<?php

class ThuongHieuController extends Controller {
    private $ThuongHieuModel;
    

    public function __construct() {
        $this->ThuongHieuModel = $this->model('ThuongHieuModel');
    }

    public function index() {
        $thuonghieu = $this->ThuongHieuModel->all();


         $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
        $totalUsers = $this->ThuongHieuModel->countAll();
        $totalPages = ceil($totalUsers / $limit);

        if (isset($_GET['tukhoa']) && !empty($_GET['tukhoa'])) {
            $tukhoa = $_GET['tukhoa'];
            $thuonghieu = $this->ThuongHieuModel->timKiem($tukhoa);
        } else {

            $thuonghieu = $this->ThuongHieuModel->all();

            $tukhoa = "";


            $thuonghieu = $this->ThuongHieuModel->phantrang($offset, $limit);
        }
         $data = ['thuonghieu' => $thuonghieu];
        if (isset($tukhoa)) {
            $data['tukhoa'] = $tukhoa;
        }
        // Sửa 'product' thành 'products'
        $this->view('admin/thuonghieu/index', ['thuonghieu' => $thuonghieu,
             'tukhoa' => $tukhoa,
            'totalPages' => $totalPages,
            'page' => $page]); 
    }

    public function them() {
      
        $this->view('admin/thuonghieu/them', []); 
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
        $this->view('admin/thuonghieu/edit', ['thuonghieu' => $thuonghieu]); 
    }

    public function update($id) {
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