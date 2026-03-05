<?php

namespace Tests\Feature;

use App\Models\User; // ضيفي هاد السطر فوق
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        // بنخلي التست يدخل كأنه مستخدم مسجل دخول
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
    }

    public function test_volunteers_page_is_accessible()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/volunteers'); 
        $response->assertStatus(200);
    } 

    public function test_it_can_create_a_volunteer()
    {
        $user = User::factory()->create();

        $volunteerData = [
            'name' => 'Malak Test',
            'email' => 'malak' . rand(1,100) . '@test.com',
            'phone' => '123456789'
        ];

        // بننفذ العملية كأنه مستخدم مسجل دخول
        $this->actingAs($user)->post('/volunteers', $volunteerData);

        $this->assertDatabaseHas('volunteers', [
            'name' => 'Malak Test'
        ]);
    }
}