@extends('layout')
@section('content')
<style>
    .image-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .image-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .image-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }
    
    .image-container {
        position: relative;
        width: 100%;
        height: 200px;
        overflow: hidden;
    }
    
    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .image-card:hover .image-container img {
        transform: scale(1.05);
    }
    
    .main-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: 0 2px 10px rgba(40, 167, 69, 0.3);
    }
    
    .image-actions {
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .upload-area {
        border: 3px dashed #ddd;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }
    
    .upload-area:hover {
        border-color: var(--primary-green);
        background: #f0f9f0;
    }
    
    .upload-area.dragover {
        border-color: var(--primary-green);
        background: #e8f5e8;
        transform: scale(1.02);
    }
    
    .upload-icon {
        font-size: 3rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }
    
    .upload-area:hover .upload-icon {
        color: var(--primary-green);
    }
    
    .btn-set-main {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        border: none;
        color: white;
        border-radius: 6px;
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }
    
    .btn-set-main:hover {
        background: linear-gradient(135deg, #e0a800, #e8690b);
        transform: translateY(-1px);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
        color: white;
        border-radius: 6px;
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }
    
    .btn-delete:hover {
        background: linear-gradient(135deg, #c82333, #bd2130);
        transform: translateY(-1px);
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .tenant-info {
        background: linear-gradient(135deg, #e8f5e8, #f0f9f0);
        border: 1px solid #c3e6cb;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .file-info {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.5rem;
    }
</style>

<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fas fa-images mr-3"></i>
            <div>
                <h3 class="card-title mb-0">Kelola Gambar Destinasi</h3>
                @isset($tenant)
                <small class="text-white-50">{{ $tenant->nama }}</small>
                @endisset
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Tenant Info -->
        @isset($tenant)
        <div class="tenant-info">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="mb-1"><i class="fas fa-map-marker-alt text-success mr-2"></i>Destinasi:</h6>
                    <strong>{{ $tenant->nama }}</strong>
                    <p class="mb-0 text-muted">{{ $tenant->alamat }}</p>
                </div>
                <div class="col-md-4 text-right">
                    <span class="badge badge-info">{{ $data->count() }} Gambar</span>
                </div>
            </div>
        </div>
        @endisset

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h6><i class="fas fa-check-circle mr-2"></i>Berhasil!</h6>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h6><i class="fas fa-exclamation-triangle mr-2"></i>Error!</h6>
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h6><i class="fas fa-exclamation-triangle mr-2"></i>Terjadi Kesalahan:</h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Upload Area -->
        @isset($id)
        <div class="upload-area" id="uploadArea">
            <i class="fas fa-cloud-upload-alt upload-icon"></i>
            <h5>Upload Gambar Baru</h5>
            <p class="text-muted mb-3">Klik untuk memilih file atau drag & drop gambar ke sini</p>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-upload">
                <i class="fas fa-plus mr-2"></i>Pilih Gambar
            </button>
            <div class="file-info">
                <small>Format yang didukung: JPEG, PNG, JPG, GIF | Maksimal: 5MB</small>
            </div>
        </div>
        @endisset

        <!-- Image Gallery -->
        @if ($data && $data->count() > 0)
        <div class="image-gallery">
            @foreach ($data as $d)
            <div class="image-card">
                <div class="image-container">
                    <img src="{{ asset('gambar_tenant/' . $d->gambar) }}" 
                         alt="Gambar {{ $tenant->nama ?? 'Destinasi' }}"
                         onerror="this.src='https://via.placeholder.com/300x200/e9ecef/6c757d?text=Gambar+Tidak+Ditemukan'">
                    @if ($d->is_gambar_utama)
                    <span class="main-badge">
                        <i class="fas fa-star mr-1"></i>Gambar Utama
                    </span>
                    @endif
                </div>
                <div class="image-actions">
                    <div>
                        @if (!$d->is_gambar_utama)
                        <button type="button" class="btn btn-set-main btn-sm" onclick="setAsMain({{ $d->id }})">
                            <i class="fas fa-star mr-1"></i>Jadikan Utama
                        </button>
                        @else
                        <span class="badge badge-success">
                            <i class="fas fa-check mr-1"></i>Gambar Utama
                        </span>
                        @endif
                    </div>
                    <form action="{{ route('gambar_tenant.destroy', $d->id) }}" method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus gambar ini?')" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete btn-sm">
                            <i class="fas fa-trash mr-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-images"></i>
            <h5>Belum Ada Gambar</h5>
            <p>Upload gambar pertama untuk destinasi ini</p>
        </div>
        @endif

        <!-- Back Button -->
        <div class="text-center mt-4">
            <a href="{{ route('tenant.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Destinasi
            </a>
        </div>
    </div>
</div>

<!-- Upload Modal -->
@isset($id)
<div class="modal fade" id="modal-upload">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="fas fa-upload mr-2"></i>Upload Gambar Destinasi
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('gambar_tenant.tambah_gambar') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="tenant_id" value="{{ $id }}">
                    
                    <div class="form-group">
                        <label for="gambar">
                            <i class="fas fa-image mr-2"></i>Pilih Gambar
                        </label>
                        <input name="gambar" type="file" class="form-control-file" id="gambar"
                               accept="image/*" required>
                        <small class="form-text text-muted">
                            Format: JPEG, PNG, JPG, GIF | Maksimal: 5MB
                        </small>
                    </div>
                    
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="gambar_utama" name="gambar_utama">
                            <label class="custom-control-label" for="gambar_utama">
                                <i class="fas fa-star mr-2"></i>Jadikan sebagai Gambar Utama
                            </label>
                        </div>
                        <small class="form-text text-muted">
                            Gambar utama akan ditampilkan sebagai thumbnail destinasi
                        </small>
                    </div>
                    
                    <!-- Image Preview -->
                    <div id="imagePreview" class="text-center" style="display: none;">
                        <img id="previewImg" src="" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 8px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-upload mr-2"></i>Upload Gambar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endisset

<script>
    // Image preview
    document.getElementById('gambar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Set as main function
    function setAsMain(imageId) {
        if (confirm('Jadikan gambar ini sebagai gambar utama?')) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/gambar_tenant/${imageId}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PUT';
            
            const setMainField = document.createElement('input');
            setMainField.type = 'hidden';
            setMainField.name = 'set_as_main';
            setMainField.value = '1';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            form.appendChild(setMainField);
            
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Form submission loading state
    document.getElementById('uploadForm').addEventListener('submit', function() {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...';
    });

    // Drag and drop functionality
    const uploadArea = document.getElementById('uploadArea');
    if (uploadArea) {
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            $('#modal-upload').modal('show');
        });
    }
</script>
@endsection