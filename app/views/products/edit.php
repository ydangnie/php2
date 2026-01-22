<h2>Sửa sản phẩm</h2>
<form action="/products/update_product/<?= $product['id'] ?>" method="POST">
    <label>Tên:</label>
    <input type="text" name="name" value="<?= $product['name'] ?>" required><br>
    <label>Giá:</label>
    <input type="number" name="price" value="<?= $product['price'] ?>" required><br>
    <label>Giá:</label>
    <input type="file" name="img" value="<?= $product['img'] ?>" required><br>
    <button type="submit">Cập nhật</button>
</form>