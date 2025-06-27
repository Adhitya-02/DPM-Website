<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table = "tenant";
    protected $guarded = [];
    public $timestamps = false;

    /**
     * Get the main image for tenant
     */
    public function gambar_utama()
    {
        return $this->hasOne(GambarTenant::class, 'tenant_id', 'id')->where('is_gambar_utama', 'on')->first();
    }

    /**
     * Get all images for tenant
     */
    public function gambar_tenant()
    {
        return $this->hasMany(GambarTenant::class, 'tenant_id', 'id');
    }

    /**
     * Get all ratings for tenant
     */
    public function ratings()
    {
        return $this->hasMany(UserTenantRating::class, 'tenant_id', 'id');
    }

    /**
     * Get all reviews for tenant
     */
    public function ulasan()
    {
        return $this->hasMany(UlasanTenant::class, 'tenant_id', 'id');
    }

    /**
     * Get all bookings for tenant
     */
    public function bookings()
    {
        return $this->hasMany(UserTenantBooking::class, 'tenant_id', 'id');
    }

    /**
     * Get tenant type relationship
     */
    public function tipe_tenant()
    {
        return $this->belongsTo(TipeTenant::class, 'tipe_tenant_id', 'id');
    }

    /**
     * Get average rating for tenant
     */
    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    /**
     * Get total reviews count
     */
    public function getTotalReviewsAttribute()
    {
        return $this->ratings()->count();
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return $this->harga ? formatCurrency($this->harga) : null;
    }

    /**
     * Check if tenant has main image
     */
    public function hasMainImage()
    {
        return $this->gambar_utama() !== null;
    }

    /**
     * Get image URL or default
     */
    public function getImageUrlAttribute()
    {
        if ($this->hasMainImage()) {
            return asset('gambar_tenant/' . $this->gambar_utama()->gambar);
        }
        
        // Default images based on tenant type
        $defaultImages = [
            1 => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Destinasi Wisata
            2 => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Rumah Makan
            3 => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Hotel
        ];
        
        return $defaultImages[$this->tipe_tenant_id] ?? $defaultImages[1];
    }

    /**
     * Get tenant type name
     */
    public function getTipeNamaAttribute()
    {
        $types = [
            1 => 'Destinasi Wisata',
            2 => 'Rumah Makan', 
            3 => 'Hotel'
        ];
        
        return $types[$this->tipe_tenant_id] ?? 'Unknown';
    }

    /**
     * Get tenant type icon
     */
    public function getTipeIconAttribute()
    {
        $icons = [
            1 => 'fas fa-mountain',
            2 => 'fas fa-utensils',
            3 => 'fas fa-bed'
        ];
        
        return $icons[$this->tipe_tenant_id] ?? 'fas fa-map-marker-alt';
    }

    /**
     * Scope untuk filter berdasarkan tipe tenant
     */
    public function scopeByType($query, $type)
    {
        if ($type) {
            return $query->where('tipe_tenant_id', $type);
        }
        return $query;
    }

    /**
     * Scope untuk search
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%")
                  ->orWhere('alamat', 'LIKE', "%{$search}%");
            });
        }
        return $query;
    }
}