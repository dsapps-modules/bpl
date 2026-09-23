<?php

use App\Http\Middleware\DemoReadOnly;
use App\Support\CrmAuthorizationResolver;

return [
    'demo' => [
        'enabled' => (bool) env('CRM_DEMO_MODE', false),
        'writes' => [
            'contacts' => (bool) env('CRM_DEMO_ALLOW_CONTACTS', true),
            'companies' => (bool) env('CRM_DEMO_ALLOW_COMPANIES', false),
            'pipelines' => (bool) env('CRM_DEMO_ALLOW_PIPELINES', false),
            'opportunities' => (bool) env('CRM_DEMO_ALLOW_OPPORTUNITIES', false),
            'tasks' => (bool) env('CRM_DEMO_ALLOW_TASKS', false),
            'calendar-events' => (bool) env('CRM_DEMO_ALLOW_CALENDAR_EVENTS', false),
            'teams' => (bool) env('CRM_DEMO_ALLOW_TEAMS', false),
            'tags' => (bool) env('CRM_DEMO_ALLOW_TAGS', false),
            'custom-fields' => (bool) env('CRM_DEMO_ALLOW_CUSTOM_FIELDS', false),
            'segments' => (bool) env('CRM_DEMO_ALLOW_SEGMENTS', false),
            'conversations' => (bool) env('CRM_DEMO_ALLOW_CONVERSATIONS', false),
            'automations' => (bool) env('CRM_DEMO_ALLOW_AUTOMATIONS', false),
            'email-campaigns' => (bool) env('CRM_DEMO_ALLOW_EMAIL_CAMPAIGNS', false),
        ],
    ],
    'api' => [
        'prefix' => env('CRM_API_PREFIX', 'api/crm/v1'),
        'middleware' => ['crm-api', 'auth', DemoReadOnly::class],
    ],
    'table_prefix' => env('CRM_TABLE_PREFIX', 'crm_'),
    'user_model' => env('CRM_USER_MODEL', 'App\\Models\\User'),
    'authorization_resolver' => CrmAuthorizationResolver::class,
    'whatsapp' => [
        'meta' => ['base_url' => env('CRM_WHATSAPP_META_BASE_URL', 'https://graph.facebook.com'), 'api_version' => env('CRM_WHATSAPP_META_API_VERSION')],
        'uazapi' => ['base_url' => env('CRM_WHATSAPP_UAZAPI_BASE_URL', 'https://api.uzapi.com.br')],
        'http_timeout' => (int) env('CRM_WHATSAPP_HTTP_TIMEOUT', 15),
    ],
    'email' => [
        'brevo' => [
            'base_url' => env('CRM_EMAIL_BREVO_BASE_URL', 'https://api.brevo.com'),
            'api_key' => env('CRM_EMAIL_BREVO_API_KEY'),
            'sender_email' => env('CRM_EMAIL_BREVO_SENDER_EMAIL'),
            'sender_name' => env('CRM_EMAIL_BREVO_SENDER_NAME'),
            'app_tag' => env('CRM_EMAIL_BREVO_APP_TAG', 'laravel_crm'),
            'reply_domain' => env('CRM_EMAIL_BREVO_REPLY_DOMAIN'),
            'webhook_token' => env('CRM_EMAIL_BREVO_WEBHOOK_TOKEN'),
        ],
        'http_timeout' => (int) env('CRM_EMAIL_HTTP_TIMEOUT', 15),
    ],
];
