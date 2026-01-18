<?php

use Dba\Connection;

class sinhvien
{
  public $mssv;
  public $ten;
  public $diem;

  public function __construct($mssv, $ten, $diem)
  {

    $this->mssv = $mssv;
    $this->ten = $ten;
    $this->diem = $diem;
  }
  public function inSV()
  {
    echo "Thông tin sinh viên";
    echo  "MSSV" . $this->mssv;
    echo "Tên " . $this->ten;

    echo "Điểm" . $this->diem;
  }
  public function xeploai()
  {
    if ($this->diem >= 9) {
      echo "Xuất sắc";
    } elseif ($this->diem >= 8) {
      echo "Giỏi";
    }elseif ($this->diem >= 7){
      echo "Khá";
    }elseif ($this->diem >= 5){
      echo "Trung bình";
    }else{
      echo "  Yếu";
    }
  }

};
$sv1 = new sinhvien('pk01', 'huy', 7);

// $sv1->inSV();
// $sv1->xeploai();


require 'database.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $mssv = $_POST['mssv'];
  $ten = $_POST['ten'];
  $diem = $_POST['diem'];

  if (isset($mssv, $ten, $diem)){
    echo "Sinh vien da ton tai";
    return false;
  }
  
}


?>


<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Form Thêm Sinh Viên</title>
</head>

<body>
  <h2>Thêm Sinh Viên</h2>
  <form action="/them-sinh-vien" method="post">
    <label for="mssv">MSSV:</label>
    <input type="text" id="mssv" name="mssv" required><br><br>

    <label for="ten">Tên:</label>
    <input type="text" id="ten" name="ten" required><br><br>

    <label for="diem">Điểm:</label>
    <input type="number" id="diem" name="diem" step="0.1" min="0" max="10" required><br><br>

    <button type="submit">Thêm</button>
  </form>
</body>

</html>