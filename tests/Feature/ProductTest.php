<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_access_create_page()
    {
        $response = $this->get('/products/create');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function user_can_create_product()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/products', [
            'name' => 'Test Product',
            'price' => 100,
            'category_id' => null,
        ]);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function user_can_update_own_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->put("/products/{$product->id}", [
            'name' => 'Updated Name',
            'price' => 200,
            'category_id' => null,
        ]);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name',
        ]);
    }

    /** @test */
    public function user_cannot_update_others_product()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $this->actingAs($user);

        $response = $this->put("/products/{$product->id}", [
            'name' => 'Illegal Update',
            'price' => 999,
            'category_id' => null,
        ]);

        $response->assertStatus(403);
    }
}
