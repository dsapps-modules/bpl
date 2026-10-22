<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use DsApps\LaravelCrm\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactDirectoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->string('search')->trim()->toString();
        $companyTable = config('crm.table_prefix', 'crm_').'companies';
        $contactTable = config('crm.table_prefix', 'crm_').'contacts';
        $query = Contact::query()->leftJoin($companyTable.' as companies', $contactTable.'.company_id', '=', 'companies.id')
            ->whereNull($contactTable.'.archived_at')->select($contactTable.'.*', 'companies.name as company_name');

        if ($search !== '') {
            $query->where(function ($contactQuery) use ($search, $contactTable): void {
                $contactQuery->where($contactTable.'.first_name', 'like', "%{$search}%")
                    ->orWhere($contactTable.'.last_name', 'like', "%{$search}%")
                    ->orWhere($contactTable.'.email', 'like', "%{$search}%")
                    ->orWhere($contactTable.'.phone', 'like', "%{$search}%")
                    ->orWhere('companies.name', 'like', "%{$search}%");
            });
        }

        $contacts = $query->orderByDesc($contactTable.'.id')->paginate(min($request->integer('per_page', 25), 100));

        return response()->json(['data' => $contacts->getCollection()->map(fn (Contact $contact): array => [
            'id' => $contact->id, 'first_name' => $contact->first_name, 'last_name' => $contact->last_name,
            'email' => $contact->email, 'phone' => $contact->phone, 'company_id' => $contact->company_id,
            'company_name' => $contact->company_name,
        ])->values(), 'current_page' => $contacts->currentPage(), 'last_page' => $contacts->lastPage(),
            'from' => $contacts->firstItem(), 'to' => $contacts->lastItem(), 'total' => $contacts->total()]);
    }

    public function store(Request $request): JsonResponse
    {
        $contact = Contact::create($this->validatedData($request));

        return response()->json(['data' => $this->contactData($contact)], 201);
    }

    public function show(Contact $contact): JsonResponse
    {
        return response()->json(['data' => $this->contactData($contact)]);
    }

    public function update(Request $request, Contact $contact): JsonResponse
    {
        $contact->update($this->validatedData($request));

        return response()->json(['data' => $this->contactData($contact->refresh())]);
    }

    public function destroy(Contact $contact): JsonResponse
    {
        $contact->update(['archived_at' => now()]);

        return response()->json(null, 204);
    }

    /** @return array<string, mixed> */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['nullable', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'company_id' => ['nullable', 'integer', 'exists:'.config('crm.table_prefix', 'crm_').'companies,id'],
        ]);
    }

    /** @return array<string, mixed> */
    private function contactData(Contact $contact): array
    {
        return [
            'id' => $contact->id, 'first_name' => $contact->first_name, 'last_name' => $contact->last_name,
            'email' => $contact->email, 'phone' => $contact->phone, 'company_id' => $contact->company_id,
        ];
    }
}
