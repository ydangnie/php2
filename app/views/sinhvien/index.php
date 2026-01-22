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
    echo "Thông tin sinh viên</br>";
    echo  "MSSV " . $this->mssv;
    echo "</br>Tên " . $this->ten;

    echo "</br>Điểm  " . $this->diem;
  }
  public function xeploai()
  {
    if ($this->diem >= 9) {
      echo "Xuất sắc";
    } elseif ($this->diem >= 8) {
      echo "Giỏi ";
    }elseif ($this->diem >= 7){
      echo " Khá ";
    }elseif ($this->diem >= 5){
      echo "Trung bình";
    }else{
      echo "  Yếu";
    }
  }

};
$sv1 = new sinhvien('pk01', 'huy', 7);

$sv1->inSV();

$sv1->xeploai();


?>
<h2>Danh sách sinh viên</h2>
<?php if(isset($_SESSION['thongbao'])): ?>
<div style="
        background-color: #d4edda; 
        color: #155724; 
        padding: 10px; 
        margin-bottom: 20px; 
        border: 1px solid #c3e6cb; 
        border-radius: 5px;">
        
        <?= $_SESSION['thongbao']; ?>
        
    </div>

<?php unset($_SESSION['thongbao'])?>
<?php endif; ?>




<form action="/sinhvien/index" method="GET" style="margin-bottom: 20px;">
    <input type="text" name="tukhoa" 
           placeholder="Nhập MSSV, Tên hoặc Ngành..." 
           style="padding: 5px; width: 300px;">
    <button type="submit" style="padding: 5px 10px;">Tìm kiếm</button>
</form>

<a href="/sinhvien/them">Thêm sinh viên mới</a> 





<table border="1">
    <tr>
        <th>MSSV</th>
        <th>Họ tên sinh viên</th>
        <th>Ngành</th>
        <th>Hành động</th>
    </tr>
    
    <?php if (empty($sinhvien)): ?>
        <tr>
            <td colspan="5" style="text-align: center; color: red;">Không tìm thấy kết quả nào phù hợp!</td>
        </tr>
    <?php else: ?>
        <?php foreach ($sinhvien as $sv): ?>
        <tr>
           
            <td><?= $sv['mssv'] ?></td>
            <td><?= $sv['hotensv'] ?></td>
            <td><?= $sv['nganh'] ?></td>
            <td>
                <a href="/sinhvien/edit/<?= $sv['id'] ?>">Sửa</a> | 
                <a href="/sinhvien/delete/<?= $sv['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>