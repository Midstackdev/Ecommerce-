<?php

namespace Tests\Unit\Models\Orders;

use App\Cart\Money;
use App\Models\Address;
use App\Models\Order;
use App\Models\ProductVariation;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    
    public function test_it_has_a_default_status_of_pending()
    {
        $user = factory(User::class)->create();

        $address = factory(Address::class)->create([
            'user_id' => $user->id
        ]);

        $order = factory(Order::class)->create([
            'user_id' => $address->user_id,
            'address_id' => $address->user->id
        ]);

        $this->assertEquals($order->status, Order::PENDING);
    }

    public function test_it_belongs_to_a_user()
    {
    	$user = factory(User::class)->create();

    	$address = factory(Address::class)->create([
    		'user_id' => $user->id
    	]);

        $order = factory(Order::class)->create([
        	'user_id' => $address->user_id,
        	'address_id' => $address->user->id
        ]);

        $this->assertInstanceOf(User::class, $order->user);
    }

    public function test_it_belongs_to_an_address()
    {
    	$user = factory(User::class)->create();

    	$address = factory(Address::class)->create([
    		'user_id' => $user->id
    	]);

        $order = factory(Order::class)->create([
        	'user_id' => $address->user_id,
        	'address_id' => $address->user->id
        ]);

        $this->assertInstanceOf(Address::class, $order->address);
    }

    public function test_it_belongs_to_a_shipping_method()
    {
    	$user = factory(User::class)->create();

    	$address = factory(Address::class)->create([
    		'user_id' => $user->id
    	]);

        $order = factory(Order::class)->create([
        	'user_id' => $address->user_id,
        	'address_id' => $address->user->id
        ]);

        $this->assertInstanceOf(ShippingMethod::class, $order->shippingMethod); //returned mull
    }

    public function test_it_has_many_products()
    {
        $order = factory(Order::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $order->products()->attach(
            factory(ProductVariation::class)->create(), [
                'quantity' => 1
            ]
        );

        $this->assertInstanceOf(ProductVariation::class, $order->products->first());
    }

    public function test_it_has_a_quantity_attached_to_the_products()
    {
        $order = factory(Order::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $order->products()->attach(
            factory(ProductVariation::class)->create(), [
                'quantity' => $quantity = 2
            ]
        );

        $this->assertEquals($order->products->first()->pivot->quantity, $quantity);
    }

    public function test_it_returns_a_money_instance_for_the_subtotal()
    {
        $order = factory(Order::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->assertInstanceOf(Money::class, $order->subtotal);
    }

    public function test_it_returns_a_money_instance_for_the_total()
    {
        $order = factory(Order::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->assertInstanceOf(Money::class, $order->total());
    }

    public function test_it_adds_shipping_onto_the_total()
    {
        $order = factory(Order::class)->create([
            'user_id' => factory(User::class)->create()->id,
            'subtotal' => 1000,
            'shipping_method__id' => factory(ShippingMethod::class)->create([
                'price' => 1000
            ])
        ]);

        $this->assertEquals($order->total()->amount(), 2000);
    }
}
