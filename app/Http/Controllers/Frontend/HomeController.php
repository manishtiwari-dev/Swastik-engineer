<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;


class HomeController extends Controller
{
    # set theme
    public function theme($name = "")
    {
        session(['theme' => $name]);
        return redirect()->route('home');
    }

    # homepage
    public function index()
    {   
    
        $sliders =$contents = [];

        if (getSetting('hero_sliders') != null) {
            $sliders = json_decode(getSetting('hero_sliders'));
        }

        if (getSetting('home_page_contents') != null) {
            $contents = json_decode(getSetting('home_page_contents'));
        }

        $contentObj='';
        if(!empty($contents) && sizeof($contents)>0)
            $contentObj=$contents[0];

        $certificates = [];
        if (getSetting('certificates') != null) {
            $certificates = json_decode(getSetting('certificates'));
        }
        

        $top_category_ids = getSetting('top_category_ids') != null ? json_decode(getSetting('top_category_ids')) : [];
        $categories = Category::whereIn('id', $top_category_ids)->get();

        $featured_products = getSetting('featured_products') != null ? json_decode(getSetting('featured_products')) : [];
        $featureProducts = Product::whereIn('id', $featured_products)->get();

        $trending_products = getSetting('top_trending_products') != null ? json_decode(getSetting('top_trending_products')) : [];
        $trendingProducts = Product::whereIn('id', $trending_products)->get();

        $recent_added_products = getSetting('recent_added_products') != null ? json_decode(getSetting('recent_added_products')) : [];
        $recentProducts = Product::whereIn('id', $recent_added_products)->get();

        $blogs = Blog::isActive()->latest()->take(3)->get();

        $top_distributer_ids = getSetting('top_distributer_ids') != null ? json_decode(getSetting('top_distributer_ids')) : [];
        $distributers = Brand::whereIn('id', $top_distributer_ids)->get();

        

        return getView('pages.home', ['blogs' => $blogs,'recentProducts'=>$recentProducts,
                                      'featureProducts'=>$featureProducts,'trendingProducts'=>$trendingProducts,
                                      'categories'=>$categories, 'sliders' => $sliders,
                                      'distributers'=>$distributers,'certificates'=>$certificates,
                                      'contentObj'=>$contentObj
                                    ]);
    }

   

    # all categories
    public function allCategories()
    {
        return getView('pages.categories');
    }


    # contact us page
    public function contactUs()
    {   
        
        return getView('pages.contactUs');
    }


    # all blogs
    public function allBlogs(Request $request)
    {
        $searchKey  = null;
        $blogs = Blog::isActive()->latest();

        if ($request->search != null) {
            $blogs = $blogs->where('title', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        if ($request->category_id != null) {
            $blogs = $blogs->where('blog_category_id', $request->category_id);
        }

        $blogs = $blogs->paginate(paginationNumber(5));
        return getView('pages.blogs.index', ['blogs' => $blogs, 'searchKey' => $searchKey]);
    }

    # blog details
    public function showBlog($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        return getView('pages.blogs.blogDetails', ['blog' => $blog]);
    }

  
}   
