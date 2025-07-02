<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinas Pariwisata Kabupaten Madiun</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('style2.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
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
            color: #2c3e50;
        }

        /* Hero Section with Title */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 20px;
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
            text-align: center;
        }

        .header {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            margin: 0;
        }

        /* Carousel Section */
        .carousel-section {
            max-width: 1200px;
            margin: 0 auto 40px;
            padding: 0 20px;
        }

        .carousel-container {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            position: relative;
        }

        .carousel-item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(102, 126, 234, 0.8);
            border: none;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }

        .carousel-control-prev {
            left: 20px;
        }

        .carousel-control-next {
            right: 20px;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background: rgba(102, 126, 234, 1);
            transform: translateY(-50%) scale(1.1);
        }

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        /* Destination Info */
        .destination-info {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
            position: relative;
            overflow: hidden;
        }

        .destination-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .destination-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .destination-title {
            flex: 1;
        }

        .destination-name {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .rating-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #6c757d;
            font-size: 1rem;
            flex-wrap: wrap;
        }

        .rating-stars {
            color: #ffc107;
            font-size: 1.1rem;
        }

        .rating-text {
            font-weight: 500;
        }

        .btn-booking {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-booking:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-booking:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .description {
            text-align: justify;
            margin: 25px 0;
            line-height: 1.8;
            font-size: 1rem;
            color: #495057;
        }

        .info-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 25px 0;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .info-item i {
            color: #667eea;
            font-size: 1.2rem;
            width: 20px;
            text-align: center;
        }

        .info-text {
            font-weight: 500;
            color: #2c3e50;
        }

        /* Reviews Section */
        .reviews-section {
            margin-top: 40px;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .review-item {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .review-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .review-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .user-avatar {
            color: #667eea;
            font-size: 1.8rem;
        }

        .user-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1rem;
        }

        .review-text {
            color: #495057;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .review-actions {
            display: flex;
            gap: 10px;
        }

        .delete-btn {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .delete-btn:hover {
            background: #dc3545;
            color: white;
        }

        /* Recommendations Section */
        .recommendations {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
            margin-top: 40px;
        }

        .recommendation-section {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
        }

        .recommendation-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .recommendation-title i {
            color: #667eea;
        }

        /* One-by-One Auto Display Carousel */
        .recommendation-carousel {
            position: relative;
            overflow: hidden;
            height: 300px; /* Fixed height untuk konsistensi */
        }

        .recommendation-wrapper {
            position: relative;
            height: 100%;
        }

        .recommendation-card {
            background: #f8f9fa;
            border-radius: 12px;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            transition: all 0.5s ease;
            border: 1px solid #e9ecef;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transform: translateX(100%);
            animation: slideShow 20s infinite;
        }

        /* Animation untuk 4 item - setiap item muncul 3 detik */
        .recommendation-card:nth-child(1) {
            animation-delay: 0s;
        }

        .recommendation-card:nth-child(2) {
            animation-delay: 5s;
        }

        .recommendation-card:nth-child(3) {
            animation-delay: 10s;
        }

        .recommendation-card:nth-child(4) {
            animation-delay: 15s;
        }

        @keyframes slideShow {
            0% {
                opacity: 0;
                transform: translateX(100%);
            }
            8.33% { /* 1/12 = masuk */
                opacity: 1;
                transform: translateX(0);
            }
            25% { /* 3/12 = tampil penuh */
                opacity: 1;
                transform: translateX(0);
            }
            33.33% { /* 4/12 = mulai keluar */
                opacity: 0;
                transform: translateX(-100%);
            }
            100% {
                opacity: 0;
                transform: translateX(-100%);
            }
        }

        .recommendation-card:hover {
            transform: translateX(0) scale(1.02) !important;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            z-index: 10;
            animation-play-state: paused;
        }

        .recommendation-wrapper:hover .recommendation-card {
            animation-play-state: paused;
        }

        .recommendation-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .recommendation-content {
            padding: 15px;
            height: calc(100% - 200px);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .recommendation-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .recommendation-description {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex-grow: 1;
        }

        /* Progress Indicator */
        .carousel-progress {
            margin-top: 15px;
            text-align: center;
        }

        .progress-bar {
            width: 100%;
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
            animation: progressFill 12s infinite linear;
        }

        @keyframes progressFill {
            0% { width: 0%; }
            25% { width: 25%; }
            50% { width: 50%; }
            75% { width: 75%; }
            100% { width: 100%; }
        }

        .carousel-info {
            text-align: center;
            font-size: 0.85rem;
            color: #6c757d;
            font-style: italic;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .current-indicator {
            display: flex;
            gap: 6px;
            justify-content: center;
            margin-bottom: 8px;
        }

        .indicator-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #cbd5e0;
            animation: dotActive 12s infinite;
        }

        .indicator-dot:nth-child(1) {
            animation-delay: 0s;
        }

        .indicator-dot:nth-child(2) {
            animation-delay: 3s;
        }

        .indicator-dot:nth-child(3) {
            animation-delay: 6s;
        }

        .indicator-dot:nth-child(4) {
            animation-delay: 9s;
        }

        @keyframes dotActive {
            0%, 20% {
                background: #667eea;
                transform: scale(1.3);
            }
            25%, 100% {
                background: #cbd5e0;
                transform: scale(1);
            }
        }

        /* Desktop Layout */
        @media (min-width: 1024px) {
            .main-content {
                grid-template-columns: 2fr 1fr;
                align-items: start;
            }

            .recommendations {
                grid-template-columns: 1fr;
            }
        }

        /* Tablet Responsive */
        @media (max-width: 1023px) {
            .header {
                font-size: 2rem;
            }

            .carousel-item img {
                height: 300px;
            }

            .destination-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .destination-name {
                font-size: 1.8rem;
            }

            .info-details {
                grid-template-columns: 1fr;
            }

            .recommendations {
                grid-template-columns: 1fr;
            }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .hero-section {
                padding: 20px 15px;
            }

            .header {
                font-size: 1.8rem;
            }

            .carousel-section,
            .main-content {
                padding: 0 15px;
            }

            .carousel-item img {
                height: 250px;
            }

            .carousel-control-prev,
            .carousel-control-next {
                width: 40px;
                height: 40px;
            }

            .carousel-control-prev {
                left: 10px;
            }

            .carousel-control-next {
                right: 10px;
            }

            .destination-info,
            .recommendation-section {
                padding: 20px;
            }

            .destination-name {
                font-size: 1.5rem;
            }

            .rating-info {
                font-size: 0.9rem;
            }

            .description {
                font-size: 0.95rem;
            }

            .info-item {
                padding: 12px;
            }

            .recommendation-image {
                height: 180px;
            }

            .btn-booking {
                width: 100%;
                justify-content: center;
                padding: 15px;
            }
        }

        /* Small Mobile */
        @media (max-width: 480px) {
            .hero-section {
                padding: 15px 10px;
            }

            .header {
                font-size: 1.5rem;
            }

            .carousel-section,
            .main-content {
                padding: 0 10px;
            }

            .carousel-item img {
                height: 200px;
            }

            .destination-info,
            .recommendation-section {
                padding: 15px;
            }

            .destination-name {
                font-size: 1.3rem;
            }

            .info-item {
                padding: 10px;
                flex-direction: column;
                text-align: center;
                gap: 8px;
            }

            .review-item {
                padding: 15px;
            }

            .recommendation-content {
                padding: 12px;
            }
        }

        /* Loading States */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: #6c757d;
        }

        /* Empty States */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        .empty-state h4 {
            font-size: 1.2rem;
            margin-bottom: 8px;
            color: #495057;
        }

        .empty-state p {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    @include('home.menu')
    
    <!-- Carousel Section -->
    <div class="carousel-section" style="margin-top: 20px;">
        <div id="carouselExample" class="carousel slide carousel-container">
            <div class="carousel-inner">
                @foreach ($gambar as $img)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ asset('gambar_tenant/' . $img->gambar) }}" alt="{{ $data->nama }}" loading="lazy">
                    </div>
                @endforeach
            </div>
            @if(count($gambar) > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Left Panel - Destination Info -->
        <div class="content-left">
            <div class="destination-info">
                <div class="destination-header">
                    <div class="destination-title">
                        <h2 class="destination-name">{{ $data->nama }}</h2>
                        <div class="rating-info">
                            <span class="rating-text">{{ round($average_rating, 1) }}</span>
                            <span class="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $average_rating)
                                        <i class="fa-solid fa-star"></i>
                                    @elseif ($i - $average_rating < 1)
                                        <i class="fa-solid fa-star-half-stroke"></i>
                                    @else
                                        <i class="fa-regular fa-star"></i>
                                    @endif
                                @endfor
                            </span>
                            <span>({{ count($ulasan) }} ulasan)</span>
                            <span>•</span>
                            <span>{{ $tipe_tenant->nama }}</span>
                        </div>
                    </div>

                    @if ($data->tipe_tenant_id == 1)
                        @auth
                            <a href="{{ route('booking', ['tenant_id' => $data->id]) }}" class="btn-booking">
                                <i class="fas fa-ticket-alt"></i>
                                Booking Sekarang
                            </a>
                        @else
                            <button class="btn-booking" onclick="alert('Anda harus login terlebih dahulu!')">
                                <i class="fas fa-sign-in-alt"></i>
                                Login untuk Booking
                            </button>
                        @endauth
                    @endif
                </div>

                <div class="description">
                    {{ $data->deskripsi }}
                </div>

                <div class="info-details">
                    <div class="info-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <span class="info-text">{{ $data->alamat }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fa-solid fa-money-bill"></i>
                        <span class="info-text">Rp {{ number_format($data->harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Reviews Section -->
                @if(count($ulasan) > 0)
                <div class="reviews-section">
                    <h3 class="section-title">
                        <i class="fas fa-comments"></i>
                        Ulasan Pengunjung
                    </h3>
                    
                    @foreach ($ulasan as $u)
                        <div class="review-item">
                            <div class="review-header">
                                <i class="fa-solid fa-user-circle user-avatar"></i>
                                <span class="user-name">{{ $u->user->nama ?? 'Anonymous' }}</span>
                            </div>
                            <div class="review-text">{{ $u->komentar }}</div>
                            <div class="review-actions">
                                <form action="{{ route('ulasan.delete', $u->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                                        <i class="fa-solid fa-trash"></i>
                                        Hapus Ulasan
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                <div class="reviews-section">
                    <h3 class="section-title">
                        <i class="fas fa-comments"></i>
                        Ulasan Pengunjung
                    </h3>
                    <div class="empty-state">
                        <i class="fas fa-comment-slash"></i>
                        <h4>Belum Ada Ulasan</h4>
                        <p>Jadilah yang pertama memberikan ulasan untuk {{ $data->nama }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Panel - Recommendations -->
        @if ($data->tipe_tenant_id == 1)
        <div class="content-right">
            <div class="recommendations">
                @if(count($rekomendasi_restorant) > 0)
                <div class="recommendation-section">
                    <h3 class="recommendation-title">
                        <i class="fa-solid fa-utensils"></i>
                        Rumah Makan Terdekat
                    </h3>
                    <div class="recommendation-carousel" id="restoCarousel">
                        <div class="recommendation-wrapper">
                            @foreach ($rekomendasi_restorant as $resto)
                                <a href="{{ route('detail_pariwisata', $resto->id) }}" class="recommendation-card">
                                    <img src="{{ asset('gambar_tenant/' . $resto->gambar_utama()?->gambar) }}" 
                                         alt="{{ $resto->nama }}" 
                                         class="recommendation-image"
                                         loading="lazy"
                                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGVlMmU2Ii8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNHB4IiBmaWxsPSIjNmM3NTdkIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSI+R2FtYmFyIFRpZGFrIERpdGVtdWthbjwvdGV4dD48L3N2Zz4='">
                                    <div class="recommendation-content">
                                        <h4 class="recommendation-name">{{ $resto->nama }}</h4>
                                        <p class="recommendation-description">{{ Str::limit($resto->deskripsi, 100) }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="carousel-info">
                            <i class="fas fa-info-circle"></i> Hover untuk berhenti • Auto-scroll setiap 3 detik
                        </div>
                    </div>
                </div>
                @endif

                @if(count($rekomendasi_hotel) > 0)
                <div class="recommendation-section">
                    <h3 class="recommendation-title">
                        <i class="fa-solid fa-hotel"></i>
                        Hotel Terdekat
                    </h3>
                    <div class="recommendation-carousel" id="hotelCarousel">
                        <div class="recommendation-wrapper">
                            @foreach ($rekomendasi_hotel as $hotel)
                                <a href="{{ route('detail_pariwisata', $hotel->id) }}" class="recommendation-card">
                                    <img src="{{ asset('gambar_tenant/' . $hotel->gambar_utama()?->gambar) }}" 
                                         alt="{{ $hotel->nama }}" 
                                         class="recommendation-image"
                                         loading="lazy"
                                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGVlMmU2Ii8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNHB4IiBmaWxsPSIjNmM3NTdkIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSI+R2FtYmFyIFRpZGFrIERpdGVtdWthbjwvdGV4dD48L3N2Zz4='">
                                    <div class="recommendation-content">
                                        <h4 class="recommendation-name">{{ $hotel->nama }}</h4>
                                        <p class="recommendation-description">{{ Str::limit($hotel->deskripsi, 100) }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="carousel-info">
                            <i class="fas fa-info-circle"></i> Hover untuk berhenti • Auto-scroll setiap 3 detik
                        </div>
                    </div>
                </div>
                @endif

                @if(count($rekomendasi_restorant) == 0 && count($rekomendasi_hotel) == 0)
                <div class="recommendation-section">
                    <div class="empty-state">
                        <i class="fas fa-map-marked-alt"></i>
                        <h4>Tidak Ada Rekomendasi</h4>
                        <p>Belum ada rekomendasi rumah makan atau hotel terdekat untuk lokasi ini</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <script>
        // Simple Auto-Scroll Carousel - No complex JavaScript needed!
        
        // Add smooth scrolling for better UX
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add loading states for images
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });
            
            img.addEventListener('error', function() {
                this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGVlMmU2Ii8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNHB4IiBmaWxsPSIjNmM3NTdkIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSI+R2FtYmFyIFRpZGFrIERpdGVtdWthbjwvdGV4dD48L3N2Zz4=';
                this.alt = 'Gambar tidak ditemukan';
            });
        });

        // Optimize carousel for mobile
        if (window.innerWidth <= 768) {
            const carousel = document.querySelector('#carouselExample');
            if (carousel) {
                // Add touch events for better mobile experience
                let startX = 0;
                let currentX = 0;
                
                carousel.addEventListener('touchstart', function(e) {
                    startX = e.touches[0].clientX;
                });
                
                carousel.addEventListener('touchmove', function(e) {
                    currentX = e.touches[0].clientX;
                });
                
                carousel.addEventListener('touchend', function(e) {
                    const diffX = startX - currentX;
                    if (Math.abs(diffX) > 50) {
                        if (diffX > 0) {
                            // Swipe left - next slide
                            const nextBtn = carousel.querySelector('.carousel-control-next');
                            if (nextBtn) nextBtn.click();
                        } else {
                            // Swipe right - previous slide
                            const prevBtn = carousel.querySelector('.carousel-control-prev');
                            if (prevBtn) prevBtn.click();
                        }
                    }
                });
            }
        }