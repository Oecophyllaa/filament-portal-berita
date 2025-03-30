<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        // Fetch all categories
        $categories = \App\Models\Category::all();

        // Fetch featured articles
        $featured_articles = \App\Models\ArticleNews::with(['category'])
            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Fetch latest articles
        $articles = \App\Models\ArticleNews::with(['category'])
            ->where('is_featured', 'not_featured')
            ->latest()
            ->take(3)
            ->get();

        // Fetch all authors
        $authors = \App\Models\Author::all();

        // Fetch a random banner advertisement
        // Ensure the 'is_active' and 'type' columns exist in the 'banner_advertisements' table
        // and that the 'banner' type is defined in your database.
        // You may need to adjust the query based on your actual database structure.
        $bannerads = \App\Models\BannerAdvertisement::where('is_active', 'active')
            ->where('type', 'banner')
            ->inRandomOrder()
            ->first();

        // Fetch featured entertainment articles
        $featured_entertainment_articles = \App\Models\ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Entertainment');
        })
            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->first();

        // Fetch latest entertainment articles
        $entertainment_articles = \App\Models\ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Entertainment');
        })
            ->where('is_featured', 'not_featured')
            ->latest()
            ->take(6)
            ->get();

        // Fetch featured business articles
        $featured_business_articles = \App\Models\ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Business');
        })
            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->first();

        // Fetch latest business articles
        $business_articles = \App\Models\ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Business');
        })
            ->where('is_featured', 'not_featured')
            ->latest()
            ->take(6)
            ->get();

        // Fetch featured automotive articles
        $featured_automotive_articles = \App\Models\ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Automotive');
        })
            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->first();

        // Fetch latest automotive articles
        $automotive_articles = \App\Models\ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Automotive');
        })
            ->where('is_featured', 'not_featured')
            ->latest()
            ->take(6)
            ->get();

        return view('front.index', compact([
            'categories',
            'featured_articles',
            'articles',
            'authors',
            'bannerads',
            'featured_entertainment_articles',
            'entertainment_articles',
            'featured_business_articles',
            'business_articles',
            'featured_automotive_articles',
            'automotive_articles',
        ]));
    }

    public function category(Category $category)
    {
        // Fetch all categories
        $categories = \App\Models\Category::all();

        // Fetch a random banner advertisement
        $bannerads = \App\Models\BannerAdvertisement::where('is_active', 'active')
            ->where('type', 'banner')
            ->inRandomOrder()
            ->first();

        return view('front.category', compact('category', 'categories', 'bannerads'));
    }

    public function details($slug)
    {
        return view('front.details', compact('slug'));
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
