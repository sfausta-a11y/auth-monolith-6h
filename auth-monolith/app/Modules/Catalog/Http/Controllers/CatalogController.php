<?php

namespace App\Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\Models\Book;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        // Optimization: Eager loading 'categories' memangkas N+1 query
        $books = Book::with('categories')
                    ->available()
                    ->when($request->search, fn($q) => $q->search($request->search))
                    ->when($request->category_id, fn($q) => $q->byCategory($request->category_id))
                    ->get();

        return response()->json($books);
    }
}