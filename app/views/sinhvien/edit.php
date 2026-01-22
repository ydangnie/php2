<h2>Sửa sinh viên</h2>
<form action="/sinhvien/update_sinhvien/<?= $sinhvien['id'] ?>" method="POST">
    <label>MSSV</label>
    <input type="text" name="name" value="<?= $sinhvien['mssv'] ?>" required><br>
    <label>Họ tên</label>
    <input type="text" name="hotensv" value="<?= $sinhvien['hotensv'] ?>" required><br>
    <label>Ngành</label>
    <input type="text" name="nganh" value="<?= $sinhvien['nganh'] ?>" required><br>
    <button type="submit">Cập nhật</button>
</form>
