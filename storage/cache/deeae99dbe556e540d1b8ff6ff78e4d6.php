<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <title><?php echo e($product['name']); ?> - MyShop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/app/views/layout/css/nav.css">
  <link rel="stylesheet" href="/app/views/layout/css/product_page.css">
</head>
<body>

<?php echo $__env->make('layout.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<main class="page-chitiet-wrap py-5">
    <div class="container">
        
        <nav aria-label="breadcrumb" class="mb-5">
          <ol class="breadcrumb text-uppercase small fw-bold">
            <li class="breadcrumb-item"><a href="/" class="text-dark text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/sanpham" class="text-dark text-decoration-none">Sản phẩm</a></li>
            <li class="breadcrumb-item text-muted" aria-current="page"><?php echo e($product['name']); ?></li>
          </ol>
        </nav>

        <div class="row g-5">
            <div class="col-md-3">
                <div class="ct-image-frame">
    <img src="/uploads/<?php echo e($product['img']); ?>" alt="<?php echo e($product['name']); ?>" class="img-fluid w-100 h-100 object-fit-cover" width="50px">
</div>
            </div>

            <div class="col-md-6">
                <h1 class="ct-title text-uppercase mb-3"><?php echo e($product['name']); ?></h1>
                <div class="mb-4">
                    <span class="ct-price"><?php echo e(number_format($product['price'])); ?> VNĐ</span>
                </div>
                
                <div class="mb-4 text-muted" style="line-height: 1.8;">
                    <p><?php echo e($product['mota']); ?></p>
                </div>

                <form action="/cart/add/<?php echo e($product['id']); ?>" method="POST">
                    <?php if(!empty($bienthe)): ?>
                        <div class="mb-4">
                            <label class="fw-bold mb-2 text-uppercase small">Phân loại hàng</label>
                            <select name="bienthe_id" class="form-select rounded-0 border-dark shadow-none p-3">
                                <?php $__currentLoopData = $bienthe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($bt['id']); ?>">
                                        Size: <?php echo e($bt['size']); ?> - Màu: <?php echo e($bt['color']); ?> (Kho: <?php echo e($bt['soluong']); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex gap-3 mb-4 mt-4">
                        <div style="width: 120px;">
                            <input type="number" name="quantity" class="form-control ct-quantity-input p-3" value="1" min="1">
                        </div>
                        <button type="submit" class="btn btn-ct-add flex-grow-1 text-uppercase p-3">
                            Thêm vào giỏ hàng
                        </button>
                    </div>
                </form>
                
                <div class="ct-policy-box small">
                    <p class="mb-2 fw-bold"><i class="fas fa-truck me-2"></i> Giao hàng tận nơi toàn quốc (Miễn phí đơn từ 500k)</p>
                    <p class="mb-0 fw-bold"><i class="fas fa-undo me-2"></i> Đổi trả dễ dàng trong vòng 7 ngày</p>
                </div>
            </div>
        </div>

        <?php if(isset($relatedProducts) && count($relatedProducts) > 0): ?>
        <div class="mt-5 pt-5 border-top">
            <h3 class="fw-bold text-uppercase mb-4 text-center">Có thể bạn sẽ thích</h3>
            <div class="row g-4">
                <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card h-100 product-card border-0">
                        <div class="product-img-container position-relative">
                             <a href="/chitiet/<?php echo e($rel['id']); ?>">
                                <img src="/uploads/<?php echo e($rel['img']); ?>" alt="<?php echo e($rel['name']); ?>" class="img-fluid w-100 h-100 object-fit-cover">
                            </a>
                        </div>
                        <div class="card-body text-center pt-4">
                            <div class="text-muted small mb-1 text-uppercase"><?php echo e($rel['tendanhmuc'] ?? 'Danh mục'); ?></div>
                            <h5 class="card-title fw-bold text-truncate px-2">
                                <a href="/chitiet/<?php echo e($rel['id']); ?>" class="text-dark text-decoration-none"><?php echo e($rel['name']); ?></a>
                            </h5>
                            <p class="price-tag text-dark mb-3"><?php echo e(number_format($rel['price'])); ?> VNĐ</p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</main>

<?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\all_php\php11\app\views/view/chitiet.blade.php ENDPATH**/ ?>