<h2>Sửa sản phẩm</h2>
<form action="/products/update_product/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
    <label>Tên:</label>
    <input type="text" name="name" value="<?= $product['name'] ?>" required><br>
    <label>Giá:</label>
    <input type="number" name="price" value="<?= $product['price'] ?>" required><br>
    <label>Ảnh:</label>
    <input type="file" name="img" value="<?= $product['img'] ?>"><br>
       <Label>Danh Mục</Label>
    <select name="danhmuc_id" id="">
        <?php foreach ($danhmuc as $dm): ?>
            <option value="<?= $dm['id'] ?>"><?= $dm['tendanhmuc'] ?></option>
        <?php endforeach; ?>
    </select>
       <Label>Thương hiệu</Label>
    <select name="thuonghieu_id" id="">
        <?php foreach ($thuonghieu as $th): ?>
            <option value="<?= $th['id'] ?>"><?= $th['tenthuonghieu'] ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <button type="submit">Cập nhật</button>
</form>