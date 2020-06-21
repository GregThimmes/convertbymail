<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        //return view('users.index', ['users' => $model->paginate(15)]);
    }

    public function reps(User $model)
    {
        $sales_reps = \App\User::where('level','=', 2)->get();
        return view('admin/reps', ['reps' => $sales_reps]);
    }

    public function repsCreate()
    {
        return view('admin/repCreate');
    }

    public function repsStore(Request $request)
    {
        $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 10 );
        $request->request->set('password',Hash::make($password ));
        $request->request->set('level',2);
        $input = $request->all();
        $rep = User::create($input);
        return redirect('admin/reps');
    }

    public function repsEdit($id)
    {   
        $rep = \App\User::find($id);
        return view('admin/repEdit')->with('rep',$rep);
    }

    public function repsUpdate(Request $request)
    {
        $rep = \App\User::find($request->get('id'));
        $rep->name = $request->get('name');
        $rep->email = $request->get('email');
        $rep->level = 2;
        $rep->active = $request->get('active');
        $rep->save();

        return redirect('admin/reps');
    }
}
