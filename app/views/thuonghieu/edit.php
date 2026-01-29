<h2>Thêm sản phẩm</h2>
<form action="/thuonghieu/luu<?= $thuonghieu['id']?>" method="POST"  >
    <label>Tên danh mục</label>
    <input type="text" name="tendanhmuc" value="<?= $thuonghieu['tenthuonghieu'] ?>" required><br>
    <label>Ảnh</label>
    <input type="file" name="img" required><br>
    <button type="submit">Lưu</button>
</form>