<?php
session_start(); 
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