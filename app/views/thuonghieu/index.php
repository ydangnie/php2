<h2>Danh sách danh mục</h2>
<a href="/thuonghieu/them">Thêm danh mục</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Tên thương hiệu</th>
        <th>Ảnh</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($thuonghieu as $th): ?>
    <tr>
        <td><?= $th['id'] ?></td>
        <td><?= $th['tenthuonghieu'] ?></td>
         <td> <img src="/uploads/<?= $th['img'] ?>" alt="" width="50px"></td>
          <td>
            <a href="/thuonghieu/edit/<?= $th['id'] ?>">Sửa</a> | 
            <a href="/thuonghieu/delete/<?= $th['id'] ?>" onclick="return confirm('Xóa hả?')">Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>