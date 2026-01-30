<h2>Thêm sản phẩm</h2>

<form action="/products/them" method="POST" enctype="multipart/form-data">
    <label>Tên:</label>
    <input type="text" name="name"><br>
    <label>Giá:</label>
    <input type="number" name="price"><br>
    <label>Mô tả:</label>
    <input type="text" name="mota"><br>
    <Label>Danh Mục</Label>
    <select name="danhmuc_id" id="">
        <?php foreach ($danhmuc as $dm): ?>
            <option value="<?= $dm['id'] ?>"><?= $dm['tendanhmuc'] ?></option>
        <?php endforeach; ?>
    </select>


    <Label>Thương hiệu</Label>
<select name="thuonghieu_id">
    <?php foreach ($thuonghieu as $th): ?>
        <option value="<?= $th['id'] ?>"><?= $dm['tendanhmuc'] ?></option> <?php endforeach; ?>
</select>
    <br>
    <label>Ảnh:</label>
    <input type="file" name="img"><br>
    <button type="submit">Lưu</button>
</form>