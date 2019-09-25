<?php

namespace Tests\Unit\Models\Orders;

use App\Models\Address;
use App\Models\Order;
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
}
