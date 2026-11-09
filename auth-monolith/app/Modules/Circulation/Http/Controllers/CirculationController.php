<?php

namespace App\Modules\Circulation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Circulation\Services\CirculationService;
use Illuminate\Http\Request;
use Exception;

class CirculationController extends Controller
{
    protected CirculationService $circulationService;

    public function __construct(CirculationService $circulationService)
    {
        $this->circulationService = $circulationService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_ids'  => 'required|array',
            'book_ids.*'=> 'exists:books,id',
        ]);

        try {
            $borrowing = $this->circulationService->borrowBooks(
                $request->member_id,
                $request->book_ids
            );

            return response()->json([
                'message'   => 'Peminjaman buku berhasil diproses!',
                'borrowing' => $borrowing->load('details')
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
}