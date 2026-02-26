<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <title>Sản phẩm yêu thích - MyShop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/public/css/nav.css">
  <link rel="stylesheet" href="/public/css/product_page.css">
</head>
<body>

@include('layout.nav')

<main class="container py-5 min-vh-100">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h1 class="h3 fw-bold text-uppercase mb-0"><i class="fas fa-heart text-danger me-2"></i> Sản phẩm yêu thích</h1>
    </div>

    @if(isset($_SESSION['success']))
        <div class="alert alert-success alert-dismissible fade show rounded-0" role="alert">
            {{ $_SESSION['success'] }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php unset($_SESSION['success']); ?>
        </div>
    @endif

    <div class="row g-4">
        @if(isset($products) && count($products) > 0)
            @foreach($products as $sp)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card border-0">
                    <div class="product-img-container position-relative">
                        <a href="/view/chitiet/{{ $sp['id'] }}">
                            <img src="/uploads/{{ $sp['img'] }}" alt="{{ $sp['name'] }}" class="img-fluid w-100 h-100 object-fit-cover">
                        </a>
                        <a href="/view/thetym/{{ $sp['id'] }}" class="position-absolute top-0 end-0 m-2 btn btn-light btn-sm rounded-circle shadow-sm text-danger" title="Bỏ yêu thích">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                    
                    <div class="card-body text-center pt-4 d-flex flex-column h-100">
                        <div class="text-muted small mb-2 text-uppercase">{{ $sp['tendanhmuc'] ?? 'Danh mục' }}</div>
                        <h5 class="card-title fw-bold px-2 mb-0">
                            <a href="/view/chitiet/{{ $sp['id'] }}" class="text-dark text-decoration-none">{{ $sp['name'] }}</a>
                        </h5>
                        
                        <div class="mt-auto pt-3">
                            <p class="price-tag text-dark mb-3">{{ number_format($sp['price']) }} VNĐ</p>
                            <div class="d-grid gap-2">
                                <a href="/view/chitiet/{{ $sp['id'] }}" class="btn btn-outline-dark rounded-0 btn-sm fw-bold">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12 text-center py-5">
                <div class="text-muted mb-3"><i class="far fa-heart fa-4x text-light"></i></div>
                <h5 class="text-muted">Bạn chưa có sản phẩm yêu thích nào.</h5>
                <a href="/view/sanpham" class="btn btn-dark rounded-0 mt-3 px-4 py-2 text-uppercase fw-bold">Khám phá ngay</a>
            </div>
        @endif
    </div>
</main>

@include('layout.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>