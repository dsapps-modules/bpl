<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use DsApps\LaravelCrm\Models\Company;
use DsApps\LaravelCrm\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyDirectoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->string('search')->trim()->toString();
        $query = Company::query()->whereNull('archived_at');

        if ($search !== '') {
            $query->where(function ($companyQuery) use ($search): void {
                $companyQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('legal_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $companies = $query->latest('id')->paginate(min($request->integer('per_page', 25), 100));

        return response()->json($this->pagination($companies, fn (Company $company): array => $this->companyData($company)));
    }

    public function store(Request $request): JsonResponse
    {
        $company = Company::create($this->validatedData($request));

        return response()->json(['data' => $this->companyData($company)], 201);
    }

    public function show(Company $company): JsonResponse
    {
        $contacts = Contact::query()
            ->where('company_id', $company->id)
            ->whereNull('archived_at')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get(['id', 'first_name', 'last_name', 'email', 'phone']);

        return response()->json(['data' => array_merge($this->companyData($company), ['contacts' => $contacts])]);
    }

    public function update(Request $request, Company $company): JsonResponse
    {
        $company->update($this->validatedData($request));

        return response()->json(['data' => $this->companyData($company->refresh())]);
    }

    public function destroy(Company $company): JsonResponse
    {
        $company->update(['archived_at' => now()]);

        return response()->json(null, 204);
    }

    /** @return array<string, mixed> */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:180'], 'legal_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'], 'phone' => ['nullable', 'string', 'max:40'],
            'document_type' => ['nullable', 'in:cnpj'], 'document' => ['nullable', 'string', 'max:18'],
            'postal_code' => ['nullable', 'digits:8'], 'street' => ['nullable', 'string', 'max:180'],
            'number' => ['nullable', 'string', 'max:30'], 'complement' => ['nullable', 'string', 'max:120'],
            'district' => ['nullable', 'string', 'max:120'], 'city' => ['nullable', 'string', 'max:120'],
            'state' => ['nullable', 'string', 'size:2'], 'country' => ['sometimes', 'string', 'size:2'],
            'notes' => ['nullable', 'string', 'max:10000'],
        ]);
    }

    /** @return array<string, mixed> */
    private function companyData(Company $company): array
    {
        return [
            'id' => $company->id, 'name' => $company->name, 'legal_name' => $company->legal_name,
            'email' => $company->email, 'phone' => $company->phone, 'document_type' => $company->document_type,
            'document' => $company->document, 'postal_code' => $company->postal_code, 'street' => $company->street,
            'number' => $company->number, 'complement' => $company->complement, 'district' => $company->district,
            'city' => $company->city, 'state' => $company->state, 'country' => $company->country, 'notes' => $company->notes,
        ];
    }

    /** @return array<string, mixed> */
    private function pagination($paginator, callable $map): array
    {
        return ['data' => $paginator->getCollection()->map($map)->values(), 'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(), 'from' => $paginator->firstItem(), 'to' => $paginator->lastItem(),
            'total' => $paginator->total()];
    }
}
