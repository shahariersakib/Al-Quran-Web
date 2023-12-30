<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class QuranController extends Controller
{
    // public function index()
    // {
    //     // $response = Http::get('https://cdn.jsdelivr.net/npm/quran-json@3.1.2/dist/quran_bn.json');
    //     $response = Http::withoutVerifying()->get('https://cdn.jsdelivr.net/npm/quran-json@3.1.2/dist/quran_bn.json');
    //     $quranData = $response->json();

    //     // Check if the 'verses' key exists in the response
    //     if (isset($quranData['verses'])) {
    //         $verses = $quranData['verses'];
    //     } else {
    //         // Handle the case where 'verses' key is not present
    //         $verses = [];
    //     }

    //     return view('quran.index', compact('verses'));
    // }

    public function index()
    {
        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch,
            CURLOPT_URL,
            'https://cdn.jsdelivr.net/npm/quran-json@3.1.2/dist/quran_bn.json'
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification (use with caution)

        // Execute cURL session and get the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            // Handle cURL error here
            return response()->json(['error' => 'cURL error: ' . curl_error($ch)], 500);
        }

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $quranData = json_decode($response, true);

        // Check if the 'verses' key exists in the response
        if (!isset($quranData[0]['verses'])) {
            // Handle the case where 'verses' key is not present
            return response()->json(['error' => 'Invalid API response format'], 500);
        }

        // Get all Surahs and their verses
        $allVerses = collect($quranData);

        // Paginate the data
        $perPage = 1; // Adjust the number of items per page as needed
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $allVerses->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $verses = new LengthAwarePaginator($currentItems, $allVerses->count(), $perPage, $currentPage, ['path' => url()->current()]);

        return view('quran.index', compact('verses'));
    }
}