<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Ecommerce Dashboard &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/modules/fontawesome/css/all.min.css')}}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('assets/modules/jqvmap/dist/jqvmap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/modules/summernote/summernote-bs4.css')}}">
  <link rel="stylesheet" href="{{asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css')}}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/components.css')}}">
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
        @include('panel control.components.header')

        @include('panel control.components.sidebar')
        
      </div class="main-content">
         @yield('content')

      </div>

      @include('panel control.components.footer')

        </div>
      </footer>

      
      <!-- General JS Scripts -->
  <script src="{{asset('assets/modules/jquery.min.js')}}"></script>
  <script src="{{asset('assets/modules/popper.js')}}"></script>
  <script src="{{asset('assets/modules/tooltip.js')}}"></script>
  <script src="{{asset('assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{asset('assets/modules/moment.min.js')}}"></script>
  <script src="{{asset('assets/js/stisla.js')}}"></script>
  
  <!-- JS Libraies -->
  <script src="{{asset('assets/modules/jquery.sparkline.min.js')}}"></script>
  <script src="{{asset('assets/modules/chart.min.js')}}"></script>
  <script src="{{asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js')}}"></script>
  <script src="{{asset('assets/modules/summernote/summernote-bs4.js')}}"></script>
  <script src="{{asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>

  <!-- Page Specific JS File -->
  <script src="{{asset('assets/js/page/index.js')}}"></script>
  
  <!-- Template JS File -->
  <script src="{{asset('assets/js/scripts.js')}}"></script>
  <script src="{{asset('assets/js/custom.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    const year = document.getElementById('year');
    year.innerHTML = new Date().getFullYear();
  </script>

  {{-- Pagination pembatasan halaman --}}
@isset($total)
    @if($total > 10)
        @php
            $currentPage = (int) request('page', 1);
            $totalPages = (int) ceil($total / 10);
        @endphp
        <div class="d-flex justify-content-center mt-4">
            <nav>
                <ul class="pagination">
                    {{-- Prev --}}
                    <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ route('movies.search', ['keyword' => request('keyword'), 'page' => $currentPage - 1]) }}">
                            &laquo;
                        </a>
                    </li>

                    {{-- Page Numbers --}}
                    @for($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++)
                        <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ route('movies.search', ['keyword' => request('keyword'), 'page' => $i]) }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor

                    {{-- Next --}}
                    <li class="page-item {{ $currentPage >= $totalPages ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ route('movies.search', ['keyword' => request('keyword'), 'page' => $currentPage + 1]) }}">
                            &raquo;
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    @endif
@endisset

{{-- Script Favorite --}}
<script>
const favoriteButtons = document.querySelectorAll('.favorite-btn');

if (favoriteButtons.length) {
    favoriteButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const imdbId = btn.dataset.imdb;
            const title  = btn.dataset.title;
            const year   = btn.dataset.year;
            const poster = btn.dataset.poster;
            const type   = btn.dataset.type;
            const isFavorite = btn.classList.contains('btn-danger');
            const icon = btn.querySelector('i');
            const text = btn.querySelector('span');

            function updateButtonState(favorite) {
                btn.classList.toggle('btn-danger', favorite);
                btn.classList.toggle('btn-outline-danger', !favorite);

                if (icon) {
                    icon.classList.toggle('fas', favorite);
                    icon.classList.toggle('far', !favorite);
                }

                if (text) {
                    text.textContent = favorite ? 'Remove from Favorites' : 'Add to Favorites';
                }
            }

            if (!imdbId) {
                return;
            }

            if (isFavorite) {
                fetch(`/panel control/favorites/${imdbId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        updateButtonState(false);
                        Swal.fire({
                            text: data.message,
                            icon: 'success',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else {
                        Swal.fire({
                            text: data.message,
                            icon: 'error',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        text: 'Terjadi kesalahan.',
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
            } else {
                fetch('/panel control/favorites', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ imdb_id: imdbId, title, year, poster, type }),
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        updateButtonState(true);
                        Swal.fire({
                            text: data.message,
                            icon: 'success',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else {
                        Swal.fire({
                            text: data.message,
                            icon: 'warning',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        text: 'Terjadi kesalahan.',
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
            }
        });
    });
}
</script>
</body>
</html>


