<h2>Thêm sản phẩm</h2>
<form action="/products/them" method="POST" enctype="multipart/form-data">
    <label>Tên:</label>
    <input type="text" name="name" required><br>
    <label>Giá:</label>
    <input type="number" name="price" required><br>
    <label>Mô tả:</label>
    <input type="text" name="mota" required><br>
    <label>Ảnh:</label>
    <input type="file" name="img" required><br>
    <button type="submit">Lưu</button>
</form>