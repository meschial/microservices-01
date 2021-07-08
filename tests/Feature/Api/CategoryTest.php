<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected $endpoint = '/categories';
    /**
     * Get All Categories
     *
     * @return void
     */
    public function test_get_all_categories()
    {
        Category::factory()->count(6)->create();

        $response = $this->getJson($this->endpoint);
        //$response->dump();
        $response->assertJsonCount(6, 'data');
        $response->assertStatus(200);
    }

    /**
     *Error  Get All Categories
     *
     * @return void
     */
    public function test_error_get_single_category()
    {
        $category = 'fake-url';
        $response = $this->getJson("{$this->endpoint}/{$category}");
        $response->assertStatus(404);
    }

     /**
     *Get Single Category
     *
     * @return void
     */
    public function test_get_single_category()
    {
        $category = Category::factory()->create();
        $response = $this->getJson("{$this->endpoint}/{$category->url}");
        $response->assertStatus(200);
    }

     /**
     * Validation Store Category
     *
     * @return void
     */
    public function test_validation_store_category()
    {
        $response = $this->postJson($this->endpoint, [
            'title' => '',
            'description' => ''
        ]);

        // $response->dump();
        $response->assertStatus(422);
    }

     /**
     * Store Category
     *
     * @return void
     */
    public function test_store_category()
    {
        $response = $this->postJson($this->endpoint, [
            'title' => 'Category 01',
            'description' => 'Descripition of category'
        ]);

        $response->assertStatus(201);
    }

     /**
     * Delete Category
     *
     * @return void
     */
    public function test_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("$this->endpoint/fake-category");
        $response->assertStatus(404);

        $response = $this->deleteJson("$this->endpoint/{$category->url}");
        $response->assertStatus(204);
    }

     /**
     * Update Category
     *
     * @return void
     */
    public function test_update_category()
    {
        $category = Category::factory()->create();

        $data = [
            'title' => 'Title update',
            'description' => 'Description update',
        ];

        $response = $this->putJson("$this->endpoint/fake-category", $data);
        $response->assertStatus(404);

        $response = $this->putJson("$this->endpoint/fake-category", []);
        $response->assertStatus(422);

        $response = $this->putJson("$this->endpoint/{$category->url}", $data);
        $response->assertStatus(200);
    }
}
