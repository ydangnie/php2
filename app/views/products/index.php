<h2>Danh sách sản phẩm</h2>
<a href="/products/add">Thêm sản phẩm mới</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Ảnh</th>
        <th>Tên</th>
        <th>Giá</th>
        <th>Mô tả</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($products as $product): ?>
    <tr>
        <td><?= $product['id'] ?></td>
        <td><?= $product['img'] ?></td>
        <td><?= $product['name'] ?></td>
    
        <td><?= $product['price'] ?></td>
        <td><?= $product['mota'] ?></td>
        <td>
            <a href="/products/edit/<?= $product['id'] ?>">Sửa</a> | 
            <a href="/products/delete/<?= $product['id'] ?>" onclick="return confirm('Xóa hả?')">Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>