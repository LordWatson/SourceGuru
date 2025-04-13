<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*
         * get the users
         * their roles
         * and their clients (we'll add a count on the index table)
         * */
        $companies = Company::with(['accountManager', 'quotes'])
            ->paginate(10);

        // Pass the paginated users to the 'users.index' view.
        return view('companies.companies-index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Company $company)
    {
        // eager load account manager, quotes, and products through quotes
        $company->load(['accountManager', 'quotes' => function($query) {
            $query->with('user');
            $query->with('company');
        }]);

        // get the quotes assigned to this company and paginate them
        $quotes = $company->quotes()->with(['user'])->paginate(10);

        // check if the request is an AJAX call (for infinite scrolling)
        if ($request->ajax()) {
            // return quotes in JSON format
            return response()->json([
                'quotes' => $quotes,
            ]);
        }

        return view('companies.companies-edit', [
            'company' => $company,
            'users' => User::all(),
            'quotes' => $quotes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
