<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoModeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['crm.demo.enabled' => true]);
    }

    public function test_demo_user_can_open_pages_without_permissions(): void
    {
        $user = User::factory()->create();

        $routes = [
            'dashboard',
            'crm.contacts',
            'crm.companies',
            'crm.pipeline',
            'crm.tasks',
            'crm.calendar',
            'crm.inbox',
            'crm.campaigns',
            'crm.automations',
            'crm.reports',
            'crm.settings.pipelines',
            'crm.settings.teams',
            'crm.settings.tags',
            'crm.settings.segments',
            'crm.settings.custom-fields',
        ];

        foreach ($routes as $routeName) {
            $this->actingAs($user)->get(route($routeName))->assertOk();
        }
    }

    public function test_demo_user_can_create_a_contact(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson('/api/crm/v1/contacts', [
                'first_name' => 'Ana',
                'email' => 'ana-demo@example.test',
            ])
            ->assertCreated();

        $this->assertDatabaseHas('crm_contacts', ['email' => 'ana-demo@example.test']);
    }

    public function test_demo_user_cannot_write_to_other_crm_resources(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson('/api/crm/v1/tasks', ['title' => 'Não deve ser salvo'])
            ->assertForbidden()
            ->assertJsonPath('message', 'Esta ação está disponível somente após a contratação do sistema.');

        $this->assertDatabaseCount('crm_tasks', 0);
    }
}
