<?php

class TinTucController extends Controller
{
    private $tintucmodel;

    public function __construct()
    {
        $this->tintucmodel = $this->model('TinTucModel');
    }

    public function index()
    {
        // Kiểm tra xem có từ khóa tìm kiếm trên URL không
        if (isset($_GET['tukhoa']) && !empty($_GET['tukhoa'])) {
            $tukhoa = $_GET['tukhoa'];
            $tintuc = $this->tintucmodel->timKiem($tukhoa);
        } else {
            // Nếu không tìm kiếm, lấy tất cả danh sách
            $tintuc = $this->tintucmodel->all();
            $tukhoa = "";
        }

        // Truyền biến $keyword qua view để giữ lại giá trị trong ô input sau khi tìm (UX tốt hơn)
        $data = ['tintuc' => $tintuc];
        if (isset($tukhoa)) {
            $data['tukhoa'] = $tukhoa;
        }

        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
        $totalProduct = $this->tintucmodel->countAll();
        $totalPages = ceil($totalProduct / $limit);
        $tintuc = $this->tintucmodel->paginate($offset, $limit);

        $this->view('tintuc/index', [
            'tintuc' => $tintuc,
            'tukhoa' => $tukhoa,
            'totalPages' => $totalPages,
            'page' => $page
        ]);
    }

    public function them()
    {

        $this->view('tintuc/them', []);
    }

    public function luu()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tieude = $_POST['tieude'];
     
            $mota = $_POST['mota'];
            $this->tintucmodel->create(['tieude' => $tieude,'mota' => $mota]);
            $_SESSION['thongbao'] = "Thêm sản phẩm thành công";
            $this->redirect('http://localhost:8000/tintuc/index');
        }
    }
    public function edit($id)
    {
        $tintuc = $this->tintucmodel->find($id);
        $this->view('tintuc/edit', ['tintuc' => $tintuc]);
    }

    public function update_tintuc($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tieude = $_POST['tieude'];
         
            $mota = $_POST['mota'];
            $img = "";
            if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
                $img =  $_FILES['img']['name'];
                $thumuc = "uploads/";
                $thumucluu = $thumuc . basename($img);
                move_uploaded_file($_FILES['img']['tmp_name'], $thumucluu);
            }
            $this->tintucmodel->update(['tieude' => $tieude,'mota' => $mota], $id);
            $_SESSION['thongbao'] = "Cập nhật sản phẩm thành công";
            $this->redirect('http://localhost:8000/products/index');
        }
    }

    public function delete($id)
    {
        $tintuc = $this->tintucmodel->find($id);
        $this->tintucmodel->delete($id);
       

        $this->redirect('http://localhost:8000/tintuc/index');
    }
}
