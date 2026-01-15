<h2>Danh sách sản phẩm</h2>
<a href="/product/add">Thêm sản phẩm mới</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>Giá</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($products as $product): ?>
    <tr>
        <td><?= $product['id'] ?></td>
        <td><?= $product['name'] ?></td>
        <td><?= $product['price'] ?></td>
        <td>
            <a href="/product/edit/<?= $product['id'] ?>">Sửa</a> | 
            <a href="/product/delete/<?= $product['id'] ?>" onclick="return confirm('Xóa hả?')">Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>