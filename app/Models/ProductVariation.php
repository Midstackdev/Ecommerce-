<?php

namespace App\Models;

use App\Cart\Money;
use App\Models\Product;
use App\Models\ProductVariationType;
use App\Models\Stock;
use App\Models\Traits\HasPrice;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
	use HasPrice;

	public function getPriceAttribute($value)
    {
    	if($value === null){
    		return $this->product->price;
    	}
        return new Money($value);
    }

    public function priceVaries()
    {
    	return $this->price->amount() !== $this->product->price->amount();
    }

    public function inStock()
    {
    	return $this->stockCount() > 0;
    }

    public function stockCount()
    {
    	return $this->stock->sum('pivot.stock');
    }

	public function type()
	{
		return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function stocks()
	{
		return $this->hasMany(Stock::class);
	}

	public function stock()
	{
		return $this->belongsToMany(
			ProductVariation::class, 'product_variation_stock_view'
		)
			->withPivot([
				'stock',
				'in_stock'
			]);
	}

	// Stock view pivot table issue
	public function test_it_can_check_if_its_in_stock()
	{
		$product = factory(Product::class)->create();

		$product->variations()->save(
			$variation = factory(ProductVarition::class)->create()
		);

		$variation->stocks->save(
			factory(Stock::class)->make()
		);

		$this->assertTrue($product->inStock());
	}

	public function test_it_can_get_the_stock_count()
	{
		$product = factory(Product::class)->create();

		$product->variations()->save(
			$variation = factory(ProductVarition::class)->create()
		);

		$variation->stocks->save(
			factory(Stock::class)->make([
				'quantity' => $quantity = 5
			])
		);

		$this->assertEuals($product->stockCount(), $quantity);
	}
}
