<?php

namespace Tests\Feature;

use App\Livewire\NoticeBar;
use App\Models\NoticeBar as NoticeBarModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NoticeBarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock(\App\Services\SettingsService::class, function ($mock) {
            $mock->shouldReceive('all')->andReturn([]);
            $mock->shouldReceive('get')->andReturn(null);
        });
    }

    public function test_active_notice_is_displayed()
    {
        NoticeBarModel::create([
            'title' => 'Test Notice',
            'message' => 'This is a test notice',
            'audience' => 'all',
            'is_active' => true,
            'expires_at' => now()->addDay(),
        ]);

        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(NoticeBar::class)
            ->assertSet('notice.title', 'Test Notice') // Basic test
            ->assertSee('Test Notice')
            ->assertSee('This is a test notice');
    }

    public function test_inactive_notice_is_not_displayed()
    {
        NoticeBarModel::create([
            'title' => 'Inactive Notice',
            'message' => 'This is inactive',
            'audience' => 'all',
            'is_active' => false,
        ]);

        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(NoticeBar::class)
            ->assertSet('notice', null)
            ->assertDontSee('Inactive Notice');
    }

    public function test_expired_notice_is_not_displayed()
    {
        NoticeBarModel::create([
            'title' => 'Expired Notice',
            'message' => 'This is expired',
            'audience' => 'all',
            'is_active' => true,
            'expires_at' => now()->subDay(),
        ]);

        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(NoticeBar::class)
            ->assertSet('notice', null)
            ->assertDontSee('Expired Notice');
    }

    public function test_audience_filtering()
    {
        // Notice for ALL
        NoticeBarModel::create([
            'title' => 'All Audience',
            'message' => 'Hello everyone',
            'audience' => 'all',
            'is_active' => true,
            'created_at' => now()->subMinute(),
        ]);

        // Notice for PRO only
        NoticeBarModel::create([
            'title' => 'Pro Audience',
            'message' => 'Hello pros',
            'audience' => 'pro',
            'is_active' => true,
            'created_at' => now(),
        ]);

        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(NoticeBar::class)
            ->assertSet('notice.title', 'All Audience') // Should pick All Audience
            ->assertSee('All Audience')
            ->assertDontSee('Pro Audience');
    }
}
