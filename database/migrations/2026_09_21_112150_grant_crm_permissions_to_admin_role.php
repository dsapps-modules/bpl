<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * @var list<string>
     */
    private array $crmPermissions = [
        'crm.contacts.manage',
        'crm.companies.manage',
        'crm.pipelines.manage',
        'crm.opportunities.manage',
        'crm.tasks.manage',
        'crm.calendar.manage',
        'crm.teams.manage',
        'crm.tags.manage',
        'crm.fields.manage',
        'crm.segments.manage',
        'crm.inbox.manage',
        'crm.automations.manage',
        'crm.reports.view',
        'crm.email_marketing.manage',
    ];

    public function up(): void
    {
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');

        if ($adminRoleId === null) {
            return;
        }

        $permissionIds = DB::table('permissions')
            ->whereIn('name', $this->crmPermissions)
            ->pluck('id')
            ->map(fn (mixed $id): array => ['permission_id' => $id, 'role_id' => $adminRoleId])
            ->all();

        if ($permissionIds !== []) {
            DB::table('permission_role')->insertOrIgnore($permissionIds);
        }
    }

    public function down(): void
    {
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');

        if ($adminRoleId !== null) {
            DB::table('permission_role')
                ->where('role_id', $adminRoleId)
                ->whereIn('permission_id', DB::table('permissions')->whereIn('name', $this->crmPermissions)->pluck('id'))
                ->delete();
        }
    }
};
