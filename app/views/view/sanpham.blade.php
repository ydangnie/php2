<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <title>Sản Phẩm - MyShop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/app/views/layout/css/nav.css">
  <link rel="stylesheet" href="/app/views/layout/css/product_page.css">
</head>
<body>

@include('layout.nav')

<main class="page-sanpham-wrap py-5">
  <div class="container">
      <div class="row g-4">
        
        <aside class="col-12 col-lg-3">
          <form method="GET" action="/sanpham">
              
              <div class="card sp-filter-box mb-4">
                <div class="card-header sp-filter-header">Danh mục</div>
                <div class="list-group list-group-flush rounded-0">
                  <a href="/sanpham" class="list-group-item list-group-item-action sp-filter-item {{ empty($category_id) ? 'active' : '' }}">Tất cả</a>
                  @foreach($danhmuc as $dm)
                    <a href="/sanpham?category={{ $dm['id'] }}" class="list-group-item list-group-item-action sp-filter-item {{ (isset($category_id) && $category_id == $dm['id']) ? 'active' : '' }}">
                        {{ $dm['tendanhmuc'] }}
                    </a>
                  @endforeach
                </div>
              </div>

              <div class="card sp-filter-box">
                <div class="card-body">
                  <div class="fw-bold text-uppercase mb-3 border-bottom pb-2">Mức giá (VNĐ)</div>
                  <div class="d-flex gap-2 mb-3">
                    <input type="number" name="min_price" class="form-control rounded-0 border-dark" placeholder="Từ" value="{{ $min_price ?? '' }}">
                    <input type="number" name="max_price" class="form-control rounded-0 border-dark" placeholder="Đến" value="{{ $max_price ?? '' }}">
                  </div>
                  @if(!empty($category_id))
                    <input type="hidden" name="category" value="{{ $category_id }}">
                  @endif
                  <button type="submit" class="btn btn-sp-filter w-100 py-2">Áp dụng lọc</button>
                </div>
              </div>
          </form>
        </aside>

        <section class="col-12 col-lg-9">
           <h1 class="h3 mb-4 fw-bold text-uppercase border-bottom pb-2">Tất cả sản phẩm</h1>
           
           <div class="row g-4">
              @if(count($products) > 0)
                  @foreach($products as $sp)
                 <div class="col-12 col-sm-6 col-lg-4">
    <div class="card h-100 product-card border-0">
        <div class="product-img-container">
            <a href="/view/chitiet/{{ $sp['id'] }}">
                <img src="/uploads/{{ $sp['img'] }}" alt="{{ $sp['name'] }}" class="img-fluid w-100 h-100 object-fit-cover">
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
                  <a href="/view/thetym/{{$sp['id']}}" class="btn btn-outline-dark rounded-0 btn-sm fw-bold">Thêm vào yêu thích❤️</a>
                    <a href="/view/chitiet/{{ $sp['id'] }}" class="btn btn-outline-dark rounded-0 btn-sm fw-bold">Xem chi tiết</a>
                </div>
            </div>
        </div>
    </div>
</div>
                  @endforeach
              @else
                  <div class="col-12 text-center py-5">
                      <p class="text-muted">Không tìm thấy sản phẩm nào.</p>
                  </div>
              @endif
           </div>

           <nav class="mt-5 d-flex justify-content-center">
              <ul class="pagination sp-pagination">
                @if(isset($totalPages) && $totalPages > 1)
                    @for($i = 1; $i <= $totalPages; $i++)
                        <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                            <a class="page-link" href="?page={{ $i }}&category={{ $category_id }}&min_price={{ $min_price }}&max_price={{ $max_price }}">
                               {{ $i }}
                            </a>
                        </li>
                    @endfor
                @endif
              </ul>
           </nav>
        </section>

      </div>
  </div>
</main>

@include('layout.footer')
</body>
</html>