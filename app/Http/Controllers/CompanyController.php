<?php

namespace App\Http\Controllers;

use App\Actions\Company\CreateCompanyAction;
use App\Actions\Company\UpdateCompanyAction;
use App\Http\Requests\Companies\CreateCompanyRequest;
use App\Http\Requests\Companies\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CompanyController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        /*
         * get the companies
         * their account manager, and quotes
         *
         * if the search bar has been used, filter with the value
         * */
        $companies = Company::with(['accountManager:id,name', 'quotes:company_id'])
            ->select('id', 'name', 'account_manager_id')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name', 'asc')
            ->paginate(10);

        // Pass the paginated users to the 'users.index' view.
        return view('companies.companies-index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Company::class);

        $users = User::orderBy('name', 'asc')
            ->select('id', 'name')
            ->get();

        return view('companies.companies-create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCompanyRequest $request, CreateCompanyAction $createCompanyAction)
    {
        // validate the request
        $validated = $request->validated();

        // trigger the company action
        $action = $createCompanyAction->execute($validated);

        // handle error
        if(!$action['success']) return Redirect::back()->withErrors(['error' => 'Failed to create company.']);

        // redirect to the users show / edit page
        return Redirect::to("/companies/{$action['company']->id}")
            ->with('status', [
                'type' => 'create',
                'message' => 'Company created',
                'colour' => 'green',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Company $company)
    {
        $company->load(['quotes.user']);

        // get the quotes assigned to this company and paginate them
        $quotes = $company->quotes()->with(['user:id,name'])->paginate(10);

        // check if the request is an AJAX call (for infinite scrolling)
        if ($request->ajax()) {
            // return quotes in JSON format
            return response()->json([
                'quotes' => $quotes,
            ]);
        }

        return view('companies.companies-edit', [
            'company' => $company,
            'users' => User::orderBy('name', 'asc')->select('id', 'name')->get(),
            'quotes' => $quotes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company, UpdateCompanyAction $updateCompanyAction)
    {
        // validate the request
        $validated = $request->validated();

        // trigger the user action
        $action = $updateCompanyAction->execute(array_merge($validated, ['id' => $company->id]));

        // handle error
        if(!$action['success']) return Redirect::back()->withErrors(['error' => 'Failed to update company.']);

        // redirect to the users show / edit page
        return Redirect::to("/companies/{$company->id}")
            ->with('status', [
                'type' => 'update',
                'message' => 'Company updated',
                'colour' => 'green',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        // check the user is allowed to delete the resource
        if(!Auth::user()->isAdmin()) return Redirect::back()->withErrors(['error' => 'You do not have permission to delete this company.']);

        // delete the resource
        $company->delete();

        // return to companies index
        return Redirect::to('/companies')
            ->with('status', [
                'type' => 'delete',
                'message' => 'Company deleted',
                'colour' => 'red',
            ]);
    }
}
