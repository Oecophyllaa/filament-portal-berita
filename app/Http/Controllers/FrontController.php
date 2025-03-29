<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::all();

        $articles = \App\Models\ArticleNews::with(['category'])
            ->where('is_featured', 'not_featured')
            ->latest()
            ->take(3)
            ->get();

        $featured_articles = \App\Models\ArticleNews::with(['category'])
            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->take(3)
            ->get();

        $authors = \App\Models\Author::all();

        $bannerads = \App\Models\BannerAdvertisement::where('is_active', 'active')
            ->where('type', 'banner')
            ->inRandomOrder()
            ->first();

        return view('front.index', compact('categories', 'articles', 'featured_articles', 'authors', 'bannerads'));
    }

    public function details($slug)
    {
        return view('front.details', compact('slug'));
    }

    public function category($slug)
    {
        return view('front.category', compact('slug'));
    }

    public function author($slug)
    {
        return view('front.author', compact('slug'));
    }

    public function search(Request $request)
    {
        return view('front.search', ['query' => $request->input('query')]);
    }
}
