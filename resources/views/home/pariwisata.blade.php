<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinas Pariwisata Kabupaten Madiun</title>
    <link rel="stylesheet" href="style2.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: #f8f9fa;
        }

        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,0 0,100 1000,100"/></svg>');
            background-size: cover;
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .header {
            text-align: center;
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 20px;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .search-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            max-width: 800px;
            margin: 0 auto;
        }

        .search-form {
            display: flex;
            width: 100%;
            max-width: 600px;
            background: white;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            border: 2px solid rgba(255,255,255,0.2);
        }

        .filter-tabs {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .filter-tab {
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .filter-tab:hover, .filter-tab.active {
            background: rgba(255,255,255,0.9);
            color: #667eea;
            border-color: rgba(255,255,255,0.9);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .search-form input {
            flex: 1;
            padding: 18px 25px;
            border: none;
            background: transparent;
            font-size: 16px;
            outline: none;
            color: #2c3e50;
        }

        .search-form input::placeholder {
            color: #adb5bd;
        }

        .search-form button {
            padding: 18px 30px;
            border: none;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 50px;
            margin: 4px;
        }

        .search-form button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .search-results-info {
            margin-bottom: 20px;
            padding: 15px 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .search-results-info h3 {
            color: #2c3e50;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .search-results-info p {
            color: #6c757d;
            font-size: 14px;
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .no-results h3 {
            color: #6c757d;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .no-results p {
            color: #adb5bd;
            font-size: 16px;
        }

        /* Flexbox Rows Layout */
        .destinations-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .destination-row {
            display: flex;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            min-height: 120px;
            position: relative;
        }

        .destination-row:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .destination-image-container {
            flex: 0 0 200px;
            position: relative;
            overflow: hidden;
        }

        .destination-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .destination-row:hover .destination-image {
            transform: scale(1.05);
        }

        .destination-content {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .destination-name {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
            line-height: 1.3;
        }

        .destination-description {
            font-size: 15px;
            color: #6c757d;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .destination-type {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .destination-meta {
            flex: 0 0 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-left: 1px solid #e9ecef;
        }

        .destination-arrow {
            color: #667eea;
            font-size: 24px;
            font-weight: bold;
            transition: transform 0.3s ease;
        }

        .destination-row:hover .destination-arrow {
            transform: translateX(5px);
        }

        .highlight {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: 600;
        }

        /* Rating Stars */
        .destination-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 8px;
            font-size: 12px;
            color: #6c757d;
        }

        .rating-stars {
            color: #ffc107;
        }

        .price-tag {
            background: #e8f5e8;
            color: #2e7d32;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
            display: inline-block;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .header {
                font-size: 28px;
                margin: 20px 0;
            }
            
            .filter-tabs {
                gap: 5px;
            }
            
            .filter-tab {
                padding: 6px 12px;
                font-size: 12px;
            }
            
            .destination-row {
                flex-direction: column;
                min-height: auto;
            }
            
            .destination-image-container {
                flex: none;
                height: 180px;
            }
            
            .destination-content {
                padding: 15px;
            }
            
            .destination-meta {
                display: none;
            }
            
            .destination-name {
                font-size: 18px;
            }
            
            .destination-description {
                -webkit-line-clamp: 2;
            }
        }

        @media (max-width: 480px) {
            .search-form {
                flex-direction: column;
                border-radius: 15px;
            }
            
            .search-form button {
                border-radius: 0 0 15px 15px;
                margin: 0;
            }
            
            .destinations-container {
                gap: 10px;
            }
            
            .destination-image-container {
                height: 150px;
            }
            
            .filter-tabs {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    @include('home.menu')
    <div class="hero-section">
        <div class="hero-content">
            <div class="header">Destinasi Pariwisata</div>
            <div class="search-container">
                <form action="" method="GET" class="search-form">
                    <input type="hidden" name="tipe_tenant_id" value="{{ request('tipe_tenant_id') }}">
                    <input type="text" placeholder="Cari destinasi wisata, rumah makan, atau hotel..." name="search" value="{{ request('search') }}">
                    <button type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </form>
                <div class="filter-tabs">
                    <a href="{{ route('pariwisata') }}" class="filter-tab {{ !request('tipe_tenant_id') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i> Semua
                    </a>
                    <a href="{{ route('pariwisata') }}?tipe_tenant_id=1{{ request('search') ? '&search=' . request('search') : '' }}" class="filter-tab {{ request('tipe_tenant_id') == '1' ? 'active' : '' }}">
                        <i class="fas fa-mountain"></i> Destinasi Wisata
                    </a>
                    <a href="{{ route('pariwisata') }}?tipe_tenant_id=2{{ request('search') ? '&search=' . request('search') : '' }}" class="filter-tab {{ request('tipe_tenant_id') == '2' ? 'active' : '' }}">
                        <i class="fas fa-utensils"></i> Rumah Makan
                    </a>
                    <a href="{{ route('pariwisata') }}?tipe_tenant_id=3{{ request('search') ? '&search=' . request('search') : '' }}" class="filter-tab {{ request('tipe_tenant_id') == '3' ? 'active' : '' }}">
                        <i class="fas fa-bed"></i> Hotel
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        @if(request('search'))
            <div class="search-results-info">
                <h3><i class="fas fa-search"></i> Hasil Pencarian untuk "{{ request('search') }}"</h3>
                <p>Ditemukan {{ count($data) }} hasil 
                @if(request('tipe_tenant_id'))
                    dalam kategori 
                    @if(request('tipe_tenant_id') == '1') Destinasi Wisata
                    @elseif(request('tipe_tenant_id') == '2') Rumah Makan
                    @elseif(request('tipe_tenant_id') == '3') Hotel
                    @endif
                @endif
                </p>
            </div>
        @endif

        @if(count($data) > 0)
            <div class="destinations-container">
                @foreach ($data as $d)
                    <a href="{{ route('detail_pariwisata', $d->id) }}" class="destination-row">
                        <div class="destination-image-container">
                            <img src="{{ $d->image_url }}" 
                                 alt="{{ $d->nama }}" 
                                 class="destination-image"
                                 loading="lazy">
                        </div>
                        <div class="destination-content">
                            <div class="destination-type">
                                <i class="{{ $d->tipe_icon }}"></i> {{ $d->tipe_nama }}
                            </div>
                            <h3 class="destination-name">
                                @if(request('search'))
                                    {!! highlightSearchTerm($d->nama, request('search')) !!}
                                @else
                                    {{ $d->nama }}
                                @endif
                            </h3>
                            <p class="destination-description">
                                @if(request('search'))
                                    {!! highlightSearchTerm(Str::limit($d->deskripsi, 150), request('search')) !!}
                                @else
                                    {{ Str::limit($d->deskripsi, 150) }}
                                @endif
                            </p>
                            
                            @if($d->tipe_tenant_id == 1 && $d->harga)
                                <div class="price-tag">
                                    <i class="fas fa-ticket-alt"></i> {{ $d->formatted_price }}
                                </div>
                            @endif

                            {{-- Rating Display --}}
                            @if($d->total_reviews > 0)
                                <div class="destination-rating">
                                    <span class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $d->average_rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </span>
                                    <span>{{ number_format($d->average_rating, 1) }} ({{ $d->total_reviews }} ulasan)</span>
                                </div>
                            @endif
                        </div>
                        <div class="destination-meta">
                            <span class="destination-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="no-results">
                <i class="fas fa-search" style="font-size: 48px; color: #dee2e6; margin-bottom: 20px;"></i>
                <h3>Tidak ada hasil ditemukan</h3>
                <p>
                    @if(request('search'))
                        Tidak ada hasil untuk pencarian "{{ request('search') }}"
                        @if(request('tipe_tenant_id'))
                            dalam kategori ini
                        @endif
                        <br>
                    @endif
                    Coba ubah kata kunci pencarian atau pilih kategori yang berbeda
                </p>
            </div>
        @endif
    </div>

    <!-- Font Awesome untuk icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        // Auto-submit form saat mengetik (debounced)
        let searchTimeout;
        const searchInput = document.querySelector('input[name="search"]');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    if (this.value.length >= 3 || this.value.length === 0) {
                        this.form.submit();
                    }
                }, 800); // Increased delay untuk mengurangi request
            });
        }

        // Loading state untuk search
        const searchForm = document.querySelector('.search-form');
        const searchButton = searchForm.querySelector('button');
        
        searchForm.addEventListener('submit', function() {
            searchButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mencari...';
            searchButton.disabled = true;
        });

        // Smooth scroll untuk better UX
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>