<h2>Danh sách sản phẩm</h2>
<a href="/sinhvien/add">Thêm sản phẩm mới</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>MSSV</th>
        <th>Họ tên sinh viên</th>
        <th>Ngành</th>
    </tr>
    <?php foreach ($sinhvien as $sv): ?>
    <tr>
        <td><?= $sv['id'] ?></td>
        <td><?= $sv['mssv'] ?></td>
        <td><?= $sv['hotensv'] ?></td>
        <td><?= $sv['nganh'] ?></td>
        <td>
            <a>Sửa</a> | 
            <a>Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>