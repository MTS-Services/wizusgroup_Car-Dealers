<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        $categorySlug = $request->input('category');

        $products = Product::query();

        if ($query) {
            $products->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%');
            });
        }

        if ($categorySlug && $categorySlug !== 'all') {
            $category = \App\Models\Category::where('slug', $categorySlug)->first();
            if ($category) {
                $products->whereHas('relation', function ($q) use ($category) {
                    $q->where('category_id', $category->id)
                        ->orWhere('sub_category_id', $category->id)
                        ->orWhere('sub_child_category_id', $category->id);
                });
            }
        }

        $products = $products->select('id', 'name', 'slug', 'price')
            ->orderBy('name', 'asc')
            ->with('primaryImage')
            ->get();

        $formattedProducts = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'image' => $product->primaryImage->isNotEmpty()
                    ? $product->primaryImage->first()->modified_image
                    : 'https://placehold.co/600x400?text=No+Image',
                'price' => $product->price,
                'category' => $product->category ? $product->category->name : 'Uncategorized',
                'url' => route('frontend.products.show', $product->slug),
            ];
        });

        return response()->json($formattedProducts);
    }
}
