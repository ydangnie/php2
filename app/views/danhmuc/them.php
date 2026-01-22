<h2>Thêm danh mục</h2>
<form action="/danhmuc/luu" method="POST" enctype="multipart/form-data">
    <label>Tên danh mục:</label>
    <input type="text" name="tendanhmuc" required><br>
    <label>Ảnh:</label>
    <input type="file" name="img" required><br>
    <button type="submit">Thêm</button>
</form>