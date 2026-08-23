<footer class="bg-primary-theme text-white pt-5 pb-3 mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-shop me-2"></i>ហាងរបស់ខ្ញុំ</h5>
                <p class="text-white-50">ផ្តល់ជូននូវបទពិសោធន៍ទិញទំនិញអនឡាញដ៏ល្អបំផុត ជាមួយនឹងផលិតផលមានគុណភាព និងតម្លៃសមរម្យ។</p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white fs-5"><i class="bi bi-telegram"></i></a>
                    <a href="#" class="text-white fs-5"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">តំណភ្ជាប់រហ័ស</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none hover-white">ទំព័រដើម</a></li>
                    <li class="mb-2"><a href="{{ route('cart.index') ?? '#' }}" class="text-white-50 text-decoration-none hover-white">កន្ត្រកទំនិញ</a></li>
                    <li class="mb-2"><a href="{{ route('login') }}" class="text-white-50 text-decoration-none hover-white">ចូលគណនី</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-white">អំពីយើង</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">ទំនាក់ទំនង</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> រាជធានីភ្នំពេញ, កម្ពុជា</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2"></i> 012 345 678</li>
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i> info@myshop.com</li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary">
        <div class="text-center text-white-50">
            <small>&copy; {{ date('Y') }} ហាងរបស់ខ្ញុំ. រក្សាសិទ្ធិគ្រប់យ៉ាង។</small>
        </div>
    </div>
</footer>

<!-- Cart Toast Notification -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="cartToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle me-2"></i> បានបញ្ចូលទៅក្នុងកន្ត្រកទំនិញដោយជោគជ័យ!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<style>
    .hover-white:hover {
        color: #fff !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        
        if(searchInput) {
            searchInput.addEventListener('input', function() {
                let query = this.value;
                if(query.length > 1) {
                    fetch(`/api/search?q=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            searchResults.innerHTML = '';
                            if(data.length > 0) {
                                data.forEach(item => {
                                    let href = `/products/${item.id}`;
                                    searchResults.innerHTML += `
                                        <a class="dropdown-item d-flex align-items-center py-2" href="${href}">
                                            <img src="${item.image_url}" width="40" height="40" class="object-fit-cover rounded me-3" onerror="this.src='https://via.placeholder.com/40'">
                                            <div>
                                                <div class="fw-bold">${item.name}</div>
                                                <div class="text-danger small">$${item.price}</div>
                                            </div>
                                        </a>
                                    `;
                                });
                                searchResults.style.display = 'block';
                            } else {
                                searchResults.innerHTML = '<span class="dropdown-item text-muted">មិនមានលទ្ធផល</span>';
                                searchResults.style.display = 'block';
                            }
                        });
                } else {
                    searchResults.style.display = 'none';
                }
            });

            document.addEventListener('click', function(e) {
                if(!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.style.display = 'none';
                }
            });
        }
    });
</script>
