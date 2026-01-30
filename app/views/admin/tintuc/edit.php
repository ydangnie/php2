<h2>Sửa sinh viên</h2>
<form action="/tintuc/update_tintuc/<?= $tintuc['id'] ?>" method="POST">
    <label>Tiêu đề </label>
    <input type="text" name="tieude" value="<?= $tintuc['tieude'] ?>" required><br>
    <label>Mô tả</label>
    <input type="text" name="mota" value="<?= $tintuc['mota'] ?>" required><br>

    <button type="submit">Cập nhật</button>
</form>
