<?php

if (!function_exists('formatCurrency')) {
    /**
     * Format currency untuk Indonesia
     */
    function formatCurrency($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('formatDateIndonesia')) {
    /**
     * Format tanggal ke bahasa Indonesia
     */
    function formatDateIndonesia($date, $format = 'd M Y')
    {
        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Ags',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        
        $carbonDate = \Carbon\Carbon::parse($date);
        $formattedDate = $carbonDate->format($format);
        
        // Replace English month names with Indonesian
        foreach ($months as $num => $month) {
            $englishMonth = $carbonDate->format('M');
            $formattedDate = str_replace($englishMonth, $month, $formattedDate);
        }
        
        return $formattedDate;
    }
}

if (!function_exists('highlightSearchTerm')) {
    /**
     * Highlight search term dalam text
     */
    function highlightSearchTerm($text, $search)
    {
        if (!$search || !$text) {
            return $text;
        }
        
        // Escape special characters untuk regex
        $search = preg_quote($search, '/');
        
        // Highlight dengan case insensitive
        return preg_replace('/(' . $search . ')/i', '<span class="highlight">$1</span>', $text);
    }
}

if (!function_exists('fuzzySearch')) {
    /**
     * Fuzzy search function untuk collection
     */
    function fuzzySearch($collection, $searchTerm, $fields = ['nama', 'deskripsi'])
    {
        if (!$searchTerm) {
            return $collection;
        }
        
        return $collection->filter(function ($item) use ($searchTerm, $fields) {
            $searchLower = strtolower($searchTerm);
            
            foreach ($fields as $field) {
                $fieldValue = strtolower($item->{$field} ?? '');
                
                // Check exact match
                if (strpos($fieldValue, $searchLower) !== false) {
                    return true;
                }
                
                // Check word-by-word match
                $words = explode(' ', $searchLower);
                foreach ($words as $word) {
                    if (strlen($word) >= 3 && strpos($fieldValue, $word) !== false) {
                        return true;
                    }
                }
                
                // Check similarity using similar_text
                similar_text($fieldValue, $searchLower, $percent);
                if ($percent > 60) { // 60% similarity threshold
                    return true;
                }
            }
            
            return false;
        });
    }
}

if (!function_exists('calculateSearchScore')) {
    /**
     * Calculate search relevance score
     */
    function calculateSearchScore($item, $searchTerm, $fields = ['nama', 'deskripsi'])
    {
        $score = 0;
        $searchLower = strtolower($searchTerm);
        
        foreach ($fields as $field) {
            $fieldValue = strtolower($item->{$field} ?? '');
            $weight = ($field === 'nama') ? 100 : 30; // Nama lebih penting
            
            // Exact match
            if (strpos($fieldValue, $searchLower) !== false) {
                $score += $weight;
                
                // Bonus if at the beginning
                if (strpos($fieldValue, $searchLower) === 0) {
                    $score += $weight * 0.5;
                }
            }
            
            // Word-by-word match
            $words = explode(' ', $searchLower);
            foreach ($words as $word) {
                if (strlen($word) >= 3 && strpos($fieldValue, $word) !== false) {
                    $score += $weight * 0.3;
                }
            }
            
            // Similarity bonus
            similar_text($fieldValue, $searchLower, $percent);
            $score += ($percent / 100) * $weight * 0.2;
        }
        
        return $score;
    }
}

if (!function_exists('getStatusBadgeClass')) {
    /**
     * Get CSS class untuk status badge
     */
    function getStatusBadgeClass($status, $type = 'kehadiran')
    {
        if ($type === 'kehadiran') {
            return $status == 2 ? 'status-kehadiran hadir' : 'status-kehadiran';
        } elseif ($type === 'pembayaran') {
            return $status == 1 ? 'status-pembayaran lunas' : 'status-pembayaran';
        }
        
        return '';
    }
}

if (!function_exists('getStatusText')) {
    /**
     * Get text untuk status
     */
    function getStatusText($status, $type = 'kehadiran')
    {
        if ($type === 'kehadiran') {
            return $status == 1 ? 'Belum Hadir' : 'Sudah Hadir';
        } elseif ($type === 'pembayaran') {
            return $status == 0 ? 'Belum Bayar' : 'Sudah Bayar';
        }
        
        return '';
    }
}

if (!function_exists('getStatusIcon')) {
    /**
     * Get icon untuk status
     */
    function getStatusIcon($status, $type = 'kehadiran')
    {
        if ($type === 'kehadiran') {
            return $status == 2 ? 'fas fa-check' : 'fas fa-clock';
        } elseif ($type === 'pembayaran') {
            return $status == 1 ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
        }
        
        return 'fas fa-question';
    }
}