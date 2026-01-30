<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Trang chủ - MyShop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
  <style>
      /* --- Custom Banner Styles --- */
      .hero-banner {
          background-color: #000;
          color: #fff;
          position: relative;
          overflow: hidden;
          padding: 80px 0;
      }
      
      /* Tạo hiệu ứng đường kẻ sọc mờ để banner đỡ đơn điệu */
      .hero-banner::before {
          content: "";
          position: absolute;
          top: 0; left: 0; width: 100%; height: 100%;
          background: repeating-linear-gradient(
              45deg,
              transparent,
              transparent 10px,
              rgba(255, 255, 255, 0.03) 10px,
              rgba(255, 255, 255, 0.03) 20px
          );
          pointer-events: none;
      }

      .hero-title {
          font-size: 3.5rem;
          font-weight: 800;
          letter-spacing: 2px;
          text-transform: uppercase;
          margin-bottom: 1rem;
      }

      .hero-subtitle {
          font-size: 1.2rem;
          font-weight: 300;
          opacity: 0.9;
          margin-bottom: 2rem;
      }

      .btn-bw {
          background-color: #fff;
          color: #000;
          border: 2px solid #fff;
          padding: 12px 35px;
          font-weight: 700;
          text-transform: uppercase;
          border-radius: 0; /* Bo góc vuông vức */
          transition: all 0.3s ease;
      }

      .btn-bw:hover {
          background-color: transparent;
          color: #fff;
      }

      /* --- Product Card Styles --- */
      .product-card {
          transition: transform 0.3s ease, box-shadow 0.3s ease;
          border: 1px solid #eee;
      }
      
      .product-card:hover {
          transform: translateY(-5px);
          box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
          border-color: #000;
      }

      .product-img-container {
          height: 300px;
          overflow: hidden;
          background-color: #f8f9fa;
          position: relative;
      }

      .product-img-container img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: transform 0.5s ease;
      }

      .product-card:hover .product-img-container img {
          transform: scale(1.1);
      }

      .price-tag {
          font-weight: 700;
          font-size: 1.1rem;
      }
  </style>
</head>

<body class="bg-white d-flex flex-column min-vh-100">

  @include('layout.nav')

  <header class="hero-banner text-center d-flex align-items-center">
    <div class="container position-relative z-1">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <span class="badge border border-white text-white px-3 py-2 mb-3 rounded-0">NEW COLLECTION 2026</span>
          <h1 class="hero-title">Monochrome Est.</h1>
          <p class="hero-subtitle">Sự tối giản là đỉnh cao của sự sành điệu. Khám phá bộ sưu tập thời trang đen trắng độc quyền.</p>
          <a href="#new-arrival" class="btn btn-bw">
            Mua Ngay <i class="fas fa-arrow-right ms-2"></i>
          </a>
        </div>
      </div>
    </div>
  </header>

  <main class="flex-grow-1 py-5" id="new-arrival">
    <div class="container">
      
      <div class="d-flex justify-content-between align-items-end mb-5 border-bottom pb-2">
        <div>
            <h2 class="fw-bold text-uppercase mb-0">Sản phẩm mới</h2>
            <small class="text-muted">Cập nhật những xu hướng mới nhất</small>
        </div>
        <a href="/products/index" class="text-decoration-none text-dark fw-bold mb-1">
            Xem tất cả <i class="fas fa-chevron-right small"></i>
        </a>
      </div>

      <div class="row g-4">
        @if(isset($products) && count($products) > 0)
            @foreach($products as $product)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100 product-card border-0">
                    <div class="product-img-container position-relative">
                        @if(!empty($product['img']))
                            <img src="/uploads/{{ $product['img'] }}" alt="{{ $product['name'] }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted bg-light">
                                <i class="fas fa-image fa-2x"></i>
                            </div>
                        @endif
                        
                        </div>

                    <div class="card-body text-center pt-4">
                        <div class="text-muted small mb-1 text-uppercase">{{ $product['tendanhmuc'] ?? 'FASHION' }}</div>
                        <h5 class="card-title fw-bold text-truncate px-2">{{ $product['name'] }}</h5>
                        <p class="price-tag text-dark mb-3">{{ number_format($product['price']) }} VNĐ</p>
                        
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-outline-dark rounded-0 btn-sm">
                                <i class="fas fa-shopping-bag me-1"></i> Thêm vào giỏ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12 text-center py-5">
                <p class="text-muted">Chưa có sản phẩm nào được cập nhật.</p>
            </div>
        @endif
      </div>

      <div class="row mt-5 pt-4">
          <div class="col-md-6 mb-3 mb-md-0">
              <div class="bg-light p-5 text-center h-100 d-flex flex-column justify-content-center align-items-center border">
                  <h3 class="fw-bold">MEN'S BASICS</h3>
                  <p>Thời trang nam tối giản</p>
                  <a href="#" class="text-dark fw-bold text-decoration-underline">Khám phá</a>
              </div>
          </div>
          <div class="col-md-6">
              <div class="bg-dark text-white p-5 text-center h-100 d-flex flex-column justify-content-center align-items-center">
                  <h3 class="fw-bold">WOMEN'S TREND</h3>
                  <p>Phong cách nữ hiện đại</p>
                  <a href="#" class="text-white fw-bold text-decoration-underline">Khám phá</a>
              </div>
          </div>
      </div>

    </div>
  </main>

  @include('layout.footer')

  
</body>
</html>