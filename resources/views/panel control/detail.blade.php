@extends('panel control.components.main')
@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Movie Detail</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item">
                    <a href="{{ route('movies.search') }}">Movies</a>
                </div>
                <div class="breadcrumb-item">Movie Detail</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">

                {{-- Poster --}}
                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <img
                                src="{{ isset($movie['Poster']) && $movie['Poster'] !== 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/300x450?text=No+Image' }}"
                                alt="{{ $movie['Title'] ?? 'Movie' }}"
                                class="img-fluid rounded"
                                loading="lazy">
                        </div>
                    </div>
                </div>

                {{-- Detail --}}
                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-body">

                            {{-- Cek apakah sudah di favorite --}}
                            @php
                                $isFavorite = \App\Models\Favorite::where('user_id', auth()->id())
                                                ->where('imdb_id', $movie['imdbID'])
                                                ->exists();
                            @endphp

                            {{-- Title & Favorite Button --}}
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h2 class="mb-1">{{ $movie['Title'] ?? '-' }}</h2>
                                    <p class="text-muted mb-3">
                                        {{ $movie['Year'] ?? '-' }} &bull;
                                        {{ $movie['Runtime'] ?? '-' }} &bull;
                                        {{ $movie['Genre'] ?? '-' }}
                                    </p>
                                </div>
                                <button type="button"
                                    class="btn {{ $isFavorite ? 'btn-danger' : 'btn-outline-danger' }} favorite-btn"
                                    id="favorite-btn"
                                    data-imdb="{{ $movie['imdbID'] ?? '' }}"
                                    data-title="{{ $movie['Title'] ?? '' }}"
                                    data-year="{{ $movie['Year'] ?? '' }}"
                                    data-poster="{{ $movie['Poster'] ?? '' }}"
                                    data-type="{{ $movie['Type'] ?? 'movie' }}">
                                    <i class="{{ $isFavorite ? 'fas' : 'far' }} fa-heart"></i>
                                    <span>{{ $isFavorite ? 'Remove from Favorites' : 'Add to Favorites' }}</span>
                                </button>
                            </div>

                            {{-- Ratings --}}
                            <div class="mb-4">
                                @if(isset($movie['imdbRating']) && $movie['imdbRating'] !== 'N/A')
                                    <span class="badge badge-info mr-1">
                                        IMDb: {{ $movie['imdbRating'] }}/10
                                    </span>
                                @endif
                                @if(isset($movie['Ratings'][1]))
                                    <span class="badge badge-info mr-1">
                                        Rotten Tomatoes: {{ $movie['Ratings'][1]['Value'] }}
                                    </span>
                                @endif
                                @if(isset($movie['Metascore']) && $movie['Metascore'] !== 'N/A')
                                    <span class="badge badge-info mr-1">
                                        Metacritic: {{ $movie['Metascore'] }}/100
                                    </span>
                                @endif
                            </div>

                            {{-- Plot --}}
                            <h5>Plot</h5>
                            <p class="mb-4">{{ $movie['Plot'] ?? '-' }}</p>

                            {{-- Director & Writer --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Director</h6>
                                    <p>{{ $movie['Director'] ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Writer</h6>
                                    <p>{{ $movie['Writer'] ?? '-' }}</p>
                                </div>
                            </div>

                            {{-- Actors & Language --}}
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h6>Actors</h6>
                                    <p>{{ $movie['Actors'] ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Language</h6>
                                    <p>{{ $movie['Language'] ?? '-' }}</p>
                                </div>
                            </div>

                            {{-- Country & Box Office --}}
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h6>Country</h6>
                                    <p>{{ $movie['Country'] ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Box Office</h6>
                                    <p>{{ isset($movie['BoxOffice']) && $movie['BoxOffice'] !== 'N/A' ? $movie['BoxOffice'] : '-' }}</p>
                                </div>
                            </div>

                            {{-- Back Button --}}
                            <div class="mt-4">
                                <a href="{{ route('movies.search') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Movies
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
{{-- SweetAlert Notifications --}}
@if(session()->has('success'))
  <script>
    Swal.fire({
        text: "{{ session()->get('success') }}",
        icon: 'success',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })
  </script>
@endif

@if(session()->has('error'))
  <script>
    Swal.fire({
        text: "{{ session()->get('error') }}",
        icon: 'error',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })
  </script>
@endif

{{-- Script Remove Favorite --}}
<script>
document.querySelectorAll('.remove-favorite').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const imdbId = this.dataset.imdb;
        const row    = document.getElementById(`row-${imdbId}`);
        const tbody  = document.getElementById('favorites-tbody');

        Swal.fire({
            title: 'Hapus dari Favorites?',
            text: 'Film ini akan dihapus dari daftar favorites kamu.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/controlpanel/favorites/${imdbId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        row.remove();

                        // Cek kalau sudah tidak ada row, tampilkan empty state
                        if (tbody.querySelectorAll('tr').length === 0) {
                            tbody.innerHTML = `
                                <tr id="empty-state">
                                    <td colspan="5">
                                        <div class="text-center py-5">
                                            <i class="fas fa-heart-broken fa-3x text-muted mb-3 d-block"></i>
                                            <h5 class="text-muted">No favorites yet</h5>
                                            <p class="text-muted">Start adding movies to your favorites list!</p>
                                            <a href="{{ route('movies.search') }}" class="btn btn-primary mt-2">
                                                <i class="fas fa-search"></i> Find your favorite movie
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        }

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
            }
        });
    });
});
</script>
@endsection