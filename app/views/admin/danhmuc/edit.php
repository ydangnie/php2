<h2>Thêm sản phẩm</h2>
<form action="/thuonghieu/luu<?= $danhmuc['id']?>" method="POST"  >
    <label>Tên danh mục</label>
    <input type="text" name="tendanhmuc" value="<?= $danhmuc['tendanhmuc'] ?>" required><br>
    <label>Ảnh</label>
    <input type="file" name="img" required><br>
    <button type="submit">Lưu</button>
</form>