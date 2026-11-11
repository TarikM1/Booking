<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_pages(): void
    {
        $this->get(route('admin.slots.index'))
            ->assertRedirect(route('login'));

        $this->get(route('admin.bookings.index'))
            ->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_access_admin_pages(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $this->actingAs($user);

        $this->get(route('admin.slots.index'))
            ->assertForbidden();

        $this->get(route('admin.bookings.index'))
            ->assertForbidden();

        $this->get(route('services.create'))
            ->assertForbidden();
    }

    public function test_admin_can_access_admin_pages(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $this->actingAs($admin);

        $this->get(route('admin.slots.index'))
            ->assertOk();

        $this->get(route('admin.bookings.index'))
            ->assertOk();

        $this->get(route('services.create'))
            ->assertOk();
    }
}
