  <main class="container py-4">
    <div class="row g-4">

      <!-- Sidebar Categories -->
      <aside class="col-12 col-lg-3">
        <div class="card shadow-sm">
          <div class="card-header bg-white fw-semibold">Categories</div>
          <div class="list-group list-group-flush">
            <a href="#" class="list-group-item list-group-item-action active">All</a>
            <a href="#" class="list-group-item list-group-item-action">Phones</a>
            <a href="#" class="list-group-item list-group-item-action">Laptops</a>
            <a href="#" class="list-group-item list-group-item-action">Accessories</a>
            <a href="#" class="list-group-item list-group-item-action">Gaming</a>
          </div>
        </div>

        <div class="card shadow-sm mt-3">
          <div class="card-body">
            <div class="fw-semibold mb-2">Price</div>
            <div class="d-flex gap-2">
              <input class="form-control" placeholder="Min" />
              <input class="form-control" placeholder="Max" />
            </div>
            <button class="btn btn-primary w-100 mt-3">Apply</button>
          </div>
        </div>
      </aside>

      <!-- Products -->
      <section class="col-12 col-lg-9">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h1 class="h4 mb-0">Products</h1>

          <div class="d-flex gap-2">
            <select class="form-select" style="max-width: 190px;">
              <option selected>Sort: Featured</option>
              <option>Price: Low to High</option>
              <option>Price: High to Low</option>
              <option>Newest</option>
            </select>
            <button class="btn btn-outline-secondary">Filter</button>
          </div>
        </div>

        <div class="row g-3">
          <!-- Product Card -->
          <div class="col-12 col-sm-6 col-xl-4">
            <div class="card h-100 shadow-sm">
              <img src="https://picsum.photos/600/400?random=1" class="card-img-top" alt="Product">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <h5 class="card-title mb-1">iPhone 15</h5>
                  <span class="badge text-bg-primary">Phones</span>
                </div>
                <p class="card-text text-muted small mb-2">Short product description goes here.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="fw-semibold">$999</div>
                  <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-xl-4">
            <div class="card h-100 shadow-sm">
              <img src="https://picsum.photos/600/400?random=2" class="card-img-top" alt="Product">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <h5 class="card-title mb-1">MacBook Air</h5>
                  <span class="badge text-bg-success">Laptops</span>
                </div>
                <p class="card-text text-muted small mb-2">Short product description goes here.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="fw-semibold">$1,199</div>
                  <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-xl-4">
            <div class="card h-100 shadow-sm">
              <img src="https://picsum.photos/600/400?random=3" class="card-img-top" alt="Product">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <h5 class="card-title mb-1">Wireless Headset</h5>
                  <span class="badge text-bg-warning">Accessories</span>
                </div>
                <p class="card-text text-muted small mb-2">Short product description goes here.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="fw-semibold">$79</div>
                  <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-xl-4">
            <div class="card h-100 shadow-sm">
              <img src="https://picsum.photos/600/400?random=4" class="card-img-top" alt="Product">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <h5 class="card-title mb-1">Android Phone</h5>
                  <span class="badge text-bg-primary">Phones</span>
                </div>
                <p class="card-text text-muted small mb-2">Short product description goes here.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="fw-semibold">$399</div>
                  <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-xl-4">
            <div class="card h-100 shadow-sm">
              <img src="https://picsum.photos/600/400?random=5" class="card-img-top" alt="Product">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <h5 class="card-title mb-1">Gaming Mouse</h5>
                  <span class="badge text-bg-warning">Accessories</span>
                </div>
                <p class="card-text text-muted small mb-2">Short product description goes here.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="fw-semibold">$49</div>
                  <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-xl-4">
            <div class="card h-100 shadow-sm">
              <img src="https://picsum.photos/600/400?random=6" class="card-img-top" alt="Product">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <h5 class="card-title mb-1">Ultrabook</h5>
                  <span class="badge text-bg-success">Laptops</span>
                </div>
                <p class="card-text text-muted small mb-2">Short product description goes here.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="fw-semibold">$899</div>
                  <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <nav class="mt-4">
          <ul class="pagination">
            <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
          </ul>
        </nav>
      </section>

    </div>
  </main>