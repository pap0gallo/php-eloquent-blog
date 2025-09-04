<?php

namespace App\Tests;

use App\Grocery;
use App\Models\Product;
use App\Models\Category;

class GroceryTest extends BaseTest
{
    public function testSearchWithoutParameters()
    {
        Product::factory()->count(5)->create();

        $products = Grocery::search();

        $this->assertCount(5, $products);
    }

    public function testSearchWithAllParameters()
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        Product::factory()->create([
            'name' => 'Apple',
            'description' => 'Fresh red apple',
            'price' => 10,
            'category_id' => $category1->id,
            'is_sponsored' => true,
        ]);
        Product::factory()->create([
            'name' => 'Banana',
            'description' => 'Ripe yellow banana',
            'price' => 20,
            'category_id' => $category1->id,
            'is_sponsored' => false,
        ]);
        Product::factory()->create([
            'name' => 'Orange',
            'description' => 'Juicy orange fruit',
            'price' => 30,
            'category_id' => $category2->id,
            'is_sponsored' => false,
        ]);
        Product::factory()->create([
            'name' => 'Grapes',
            'description' => 'Sweet green grapes',
            'price' => 25,
            'category_id' => $category2->id,
            'is_sponsored' => true,
        ]);

        $results = Grocery::search(
            category: $category1,
            subtitle: 'banana',
            minPrice:15,
            maxPrice: 25,
            limit: 2,
        );

        $this->assertCount(1, $results);

        $this->assertEquals('Banana', $results->first()->name);
        $this->assertEquals(20, $results->first()->price);
        $this->assertEquals($category1->id, $results->first()->category_id);
    }

    public function testSearchByPriceRange()
    {
        Product::factory()->create(['price' => 10]);
        Product::factory()->create(['price' => 20]);
        Product::factory()->create(['price' => 30]);

        $products = Grocery::search(minPrice:15, maxPrice: 25);

        $this->assertCount(1, $products);
        $this->assertEquals(20, $products->first()->price);
    }

    public function testSearchByCategory()
    {
        $category = Category::factory()->create();

        $product1 = Product::factory()->create(['category_id' => $category->id]);
        $product2 = Product::factory()->create(['category_id' => $category->id]);
        $product3 = Product::factory()->create();

        $products = Grocery::search(category: $category);

        $this->assertCount(2, $products);
        $this->assertTrue($products->contains($product1));
        $this->assertTrue($products->contains($product2));
        $this->assertFalse($products->contains($product3));
    }

    public function testSearchWithLimit()
    {
        Product::factory()->count(15)->create();

        $products = Grocery::search(limit: 5);

        $this->assertCount(5, $products);
    }

    public function testSearchSortsByIsSponsored()
    {
        Product::factory()->create(['is_sponsored' => false]);
        Product::factory()->create(['is_sponsored' => true]);
        Product::factory()->create(['is_sponsored' => false]);

        $products = Grocery::search();

        $this->assertEquals(1, $products->first()->is_sponsored);
    }

    public function testSearchWithEmpty()
    {
        Product::factory()->create([
            'name' => 'Apple',
            'description' => 'Fresh red apple',
            'price' => 10
        ]);

        $products = Grocery::search(subtitle: 'banana');

        $this->assertCount(0, $products);
    }

    public function testSearchWithMinPriceOnly()
    {
        Product::factory()->create(['price' => 10]);
        Product::factory()->create(['price' => 20]);
        Product::factory()->create(['price' => 30]);

        $products = Grocery::search(null, null, 25);

        $this->assertCount(1, $products);
    }

    public function testSearchWithMaxPriceOnly()
    {
        Product::factory()->create(['price' => 10]);
        Product::factory()->create(['price' => 20]);
        Product::factory()->create(['price' => 30]);

        $products = Grocery::search(maxPrice: 20);

        $this->assertCount(2, $products);
        $this->assertTrue($products->every(fn($product) => $product->price <= 20));
    }

    public function testSearchBySubtitle()
    {
        Product::factory()->create(['name' => 'Apple', 'description' => 'Fresh red apple']);
        Product::factory()->create(['name' => 'Banana', 'description' => 'Ripe yellow banana']);
        Product::factory()->create(['name' => 'Orange', 'description' => 'Juicy orange fruit']);

        // Ищем по описанию, не указывая название
        $result1 = Grocery::search(null, 'Juicy orange');

        $this->assertCount(1, $result1);
        $this->assertEquals('Orange', $result1->first()->name);

        $result2 = Grocery::search(null, 'Banana');

        $this->assertCount(1, $result2);
        $this->assertEquals('Banana', $result2->first()->name);
    }

    public function testSearchWithInvalidCategory()
    {
        $category = Category::factory()->create();
        Product::factory()->create(['category_id' => $category->id]);

        $invalidCategory = new Category(['id' => 999]); // Не существующая категория
        $products = Grocery::search($invalidCategory);

        $this->assertCount(0, $products);
    }
}
