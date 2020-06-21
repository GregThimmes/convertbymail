<?php

namespace App\Http\Controllers;
use App\InsertionOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InsertionOrderController extends Controller
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

    public function index(InsertionOrder $model)
    {
        return view('admin/orders', ['orders' => $model->paginate(50)]);
    }

    public function create()
    {
        $companies = \App\Company::all();
        $sales_reps = \App\User::where('level','>=', 1)->get();
        return view('admin/ordersCreate')->with('companies',$companies)->with('sales_reps',$sales_reps);
    }

    public function edit($id)
    {
        $order = \App\InsertionOrder::find($id);
        $companies = \App\Company::all();
        $sales_reps = \App\User::where('level','>=', 1)->get();


        return view('admin/ordersEdit')->with('order',$order)->with('companies',$companies)->with('sales_reps',$sales_reps);
    }


    public function store(Request $request, $id)
    {
        $input = $request->all();
        $order = InsertionOrder::create($input);
        return redirect('admin/orders');
    }

    public function update(Request $request)
    {
 
        $order = \App\InsertionOrder::find($request->get('id'));
        $order->name = $request->get('name');
        $order->internal_id = $request->get('internal_id');
        $order->sales_rep_id = $request->get('sales_rep_id');
        $order->type = $request->get('type');
        $order->status = $request->get('status'); 
        $order->quantity = $request->get('quantity');
        $order->notes = $request->get('notes');
        $order->save();

        return redirect('admin/orders');
    }


}
