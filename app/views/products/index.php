<h2>Danh sách sản phẩm</h2>
<a href="/products/add">Thêm sản phẩm mới</a>

<?php if(isset($_SESSION['thongbao'])): ?>
<div style="
        background-color: #d4edda; 
        color: #155724; 
        padding: 10px; 
        margin-bottom: 20px; 
        border: 1px solid #c3e6cb; 
        border-radius: 5px;">
        
        <?= $_SESSION['thongbao']; ?>
        
    </div>

<?php unset($_SESSION['thongbao'])?>
<?php endif; ?>


<form action="/products/index" method="GET" style="margin-bottom: 20px;">
    <input type="text" name="tukhoa" 
           placeholder="Nhập Tên sản phẩm" 
           style="padding: 5px; width: 300px;">
    <button type="submit" style="padding: 5px 10px;">Tìm kiếm</button>
</form>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Ảnh</th>
        <th>Tên</th>
        <th>Giá</th>
        <th>Mô tả</th>
        <th>Hành động</th>
    </tr>
        <?php if (empty($products)): ?>
        <tr>
            <td colspan="5" style="text-align: center; color: red;">Không tìm thấy kết quả nào phù hợp!</td>
        </tr>
    <?php else: ?>
    <?php foreach ($products as $product): ?>
    <tr>
        <td><?= $product['id'] ?></td>
        <td> <img src="/uploads/<?= $product['img'] ?>" alt="" width="50px"></td>
        <td><?= $product['name'] ?></td>
    
        <td><?= $product['price'] ?></td>
        <td><?= $product['mota'] ?></td>
        <td>
            <a href="/products/edit/<?= $product['id'] ?>">Sửa</a> | 
            <a href="/products/delete/<?= $product['id'] ?>" onclick="return confirm('Xóa hả?')">Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
</table>