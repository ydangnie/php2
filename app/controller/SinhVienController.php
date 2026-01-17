<?php
class SinhVienController extends Controller {
    private $SinhVienModel;

    public function __construct() {
        $this->SinhVienModel = $this->model('SinhVienModel');
    }

    public function index() {
        $sinhvien = $this->SinhVienModel->all();
        
        $this->view('sinhvien/index', ['sinhvien' => $sinhvien]); 
    }

    public function add() {
      
        $this->view('sinhvien/them', []); 
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $mssv = $_POST['mssv'];
            $hotensv = $_POST['hotensv'];
            $nganh = $_POST['nganh'];
            $this->SinhVienModel->create(['mssv' => $mssv, 'hotensv' => $hotensv, 'nganh' => $nganh]);
        
            $this->redirect('localhost:8000/sinhvien/index'); 
        }
    }

    public function edit($id) {
        $sinhvien = $this->SinhVienModel->find($id);
   
        $this->view('sinhvien/edit', ['sinhvien' => $sinhvien]); 
    }

    public function update_sinhvien($id) {
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           $mssv = $_POST['mssv'];
            $hotensv = $_POST['hotensv'];
            $nganh = $_POST['nganh'];
            $this->SinhVienModel->create(['mssv' => $mssv, 'hotensv' => $hotensv, 'nganh' => $nganh]);
            
            $this->redirect('sinhvien/index'); 
        }
    }

    public function delete($id) {
        $this->SinhVienModel->delete($id);
        $this->redirect('localhost:8000/sinhvien/index'); 
    }
}