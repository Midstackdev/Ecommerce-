<?php

namespace Tests\Feature\Orders;

use App\Models\Address;
use App\Models\Country;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderStoreTest extends TestCase
{
    
    public function test_it_fails_if_not_authenticated()
    {
        $this->json('POST', 'api/orders')

        ->assertStatus(401);
    }

    public function test_it_requires_an_address()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/orders')

        ->assertJsonValidationErrors(['address_id']);
    }

    public function test_it_requires_an_address_that_exists()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/orders', [
            'address_id' => 1
        ])

        ->assertJsonValidationErrors(['address_id']);
    }

    public function test_it_requires_an_address_that_belongs_to_the_authenticated_user()
    {
        $user = factory(User::class)->create();

        $address = factory(Address::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->jsonAs($user, 'POST', 'api/orders', [
            'address_id' => $address->id
        ])

        ->assertJsonValidationErrors(['address_id']);
    }

    public function test_it_requires_a_shipping_method()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/orders')

        ->assertJsonValidationErrors(['shipping_method__id']);
    }

    public function test_it_requires_a_shipping_method_that_exists()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/orders', [
            'shipping_method__id' => 1
        ])

        ->assertJsonValidationErrors(['shipping_method__id']);
    }

    public function test_it_requires_a_shipping_method_valid_for_the_given_address()
    {
        $user = factory(User::class)->create();

        // $country = factory(Country::class)->create();

        $address = factory(Address::class)->create([
            'user_id' => $user->id,
            // 'country_id' => $country->id,
        ]);

        $shipping = factory(ShippingMethod::class)->create();

        $this->jsonAs($user, 'POST', 'api/orders', [
            'shipping_method__id' => $shipping->id,
            'address__id' => $address->id
        ])

        ->assertJsonValidationErrors(['shipping_method__id']);
    }
}
