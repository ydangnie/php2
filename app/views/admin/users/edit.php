<h2>Sửa sinh viên</h2>
<form action="/users/update/<?= $users['id'] ?>" method="POST">
    <label>Email </label>
    <input type="text" name="email" value="<?= $users['email'] ?>" required><br>
    <label>Mô tả</label>
    <input type="text" name="mota" value="<?= $users['mota'] ?>" required><br>

    <button type="submit">Cập nhật</button>
</form>
