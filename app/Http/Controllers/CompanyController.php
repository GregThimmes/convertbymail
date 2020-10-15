<?php

namespace App\Http\Controllers;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Company $model)
    {
        return view('admin/companies', ['companies' => $model->paginate(50)]);
    }

    public function create()
    {
        $companies = \App\Company::all();
        $sales_reps = \App\User::where('level','=', 2)->get();
        return view('admin/companyCreate')->with('companies',$companies)->with('sales_reps',$sales_reps);
    }

    public function edit($id)
    {
        $company = \App\Company::find($id);
 
        return view('admin/companyEdit')->with('company',$company);
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $company = Company::create($input);
        return redirect('admin/companies');
    }

    public function update(Request $request)
    {
        $company = \App\Company::find($request->get('id'));
        $company->name = $request->get('name');
        $company->address = $request->get('address');
        $company->address2 = $request->get('address2');
        $company->city = $request->get('city');
        $company->state = $request->get('state'); 
        $company->zip = $request->get('zip');
        $company->phone = $request->get('phone');
        $company->fax = $request->get('fax');
        $company->website = $request->get('website');
        $company->save();

        return redirect('companies');
    }


}
