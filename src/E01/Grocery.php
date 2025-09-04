<?php

namespace App;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Collection;

class Grocery
{
    public static function search(
        ?Category $category = null,
                  $subtitle = null,
                  $minPrice = null,
                  $maxPrice = null,
                  $limit = 10,
    ): Collection {
        // BEGIN (write your solution here)
        $query = Product::query();
        if ($subtitle) {
            $query->where(function ($q) use ($subtitle) {
                $q->where('name', 'like', "%{$subtitle}%")
                    ->orWhere('description', 'like', "%{$subtitle}%");
            });
        }
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        if ($category) {
            $query->where('category_id', $category->id);
        }
        $query->orderByDesc('is_sponsored');
        $query->take($limit);
        // END

        return $query->get();
    }
}
