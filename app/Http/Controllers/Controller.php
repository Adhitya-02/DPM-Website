<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant; // Sesuaikan dengan model Anda
use Illuminate\Support\Str;

class PariwisataController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::query();
        
        // Filter berdasarkan tipe tenant jika ada
        if ($request->filled('tipe_tenant_id')) {
            $query->where('tipe_tenant_id', $request->tipe_tenant_id);
        }
        
        // Search functionality dengan algoritma fuzzy search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            
            // Implementasi fuzzy search menggunakan multiple conditions
            $query->where(function($q) use ($searchTerm) {
                // Exact match (prioritas tertinggi)
                $q->where('nama', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('alamat', 'LIKE', "%{$searchTerm}%");
                
                // Fuzzy search untuk kata-kata terpisah
                $words = explode(' ', $searchTerm);
                foreach ($words as $word) {
                    if (strlen($word) >= 3) { // Hanya kata dengan minimal 3 huruf
                        $q->orWhere('nama', 'LIKE', "%{$word}%")
                          ->orWhere('deskripsi', 'LIKE', "%{$word}%")
                          ->orWhere('alamat', 'LIKE', "%{$word}%");
                    }
                }
                
                // Search berdasarkan similarity (optional - untuk hasil yang lebih baik)
                // Uncomment jika ingin menggunakan SOUNDEX untuk pencarian fonetik
                // $q->orWhereRaw("SOUNDEX(nama) = SOUNDEX(?)", [$searchTerm])
                //   ->orWhereRaw("SOUNDEX(deskripsi) LIKE CONCAT('%', SOUNDEX(?), '%')", [$searchTerm]);
            });
            
            // Order by relevance (yang paling cocok di atas)
            $data = $query->get()->sortByDesc(function($item) use ($searchTerm) {
                return $this->calculateRelevanceScore($item, $searchTerm);
            });
        } else {
            // Jika tidak ada search, tampilkan semua dengan order default
            $data = $query->orderBy('created_at', 'desc')->get();
        }
        
        return view('pariwisata', compact('data'));
    }
    
    /**
     * Menghitung skor relevansi untuk setiap item
     */
    private function calculateRelevanceScore($item, $searchTerm)
    {
        $score = 0;
        $searchLower = strtolower($searchTerm);
        $namaLower = strtolower($item->nama);
        $deskripsiLower = strtolower($item->deskripsi);
        $alamatLower = strtolower($item->alamat ?? '');
        
        // Exact match di nama (skor tertinggi)
        if (strpos($namaLower, $searchLower) !== false) {
            $score += 100;
            // Bonus jika di awal nama
            if (strpos($namaLower, $searchLower) === 0) {
                $score += 50;
            }
        }
        
        // Match di deskripsi
        if (strpos($deskripsiLower, $searchLower) !== false) {
            $score += 30;
        }
        
        // Match di alamat
        if (strpos($alamatLower, $searchLower) !== false) {
            $score += 20;
        }
        
        // Bonus untuk kata-kata individual
        $words = explode(' ', $searchLower);
        foreach ($words as $word) {
            if (strlen($word) >= 3) {
                if (strpos($namaLower, $word) !== false) {
                    $score += 15;
                }
                if (strpos($deskripsiLower, $word) !== false) {
                    $score += 5;
                }
            }
        }
        
        // Bonus untuk similarity ratio (menggunakan similar_text)
        similar_text($namaLower, $searchLower, $percent);
        $score += $percent * 0.5;
        
        return $score;
    }
    
    /**
     * Alternative fuzzy search menggunakan Levenshtein distance
     */
    private function calculateLevenshteinScore($text, $search)
    {
        $maxDistance = max(strlen($text), strlen($search));
        $distance = levenshtein(strtolower($text), strtolower($search));
        
        // Convert distance to similarity score (0-100)
        return (($maxDistance - $distance) / $maxDistance) * 100;
    }
    
    /**
     * Search dengan auto-complete suggestions (optional)
     */
    public function suggestions(Request $request)
    {
        if (!$request->filled('term') || strlen($request->term) < 2) {
            return response()->json([]);
        }
        
        $suggestions = Tenant::where('nama', 'LIKE', "%{$request->term}%")
            ->limit(10)
            ->pluck('nama')
            ->unique()
            ->values();
            
        return response()->json($suggestions);
    }
}