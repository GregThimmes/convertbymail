<?php

namespace App\Http\Controllers;

use App\CampaignLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CampaignLinkController extends Controller
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

    public function index($id)
    {
        $links = \App\CampaignLink::where('campaign_id', $id)->get();


        return view('admin/campaignLink')->with('links',$links)->with('id',$id);
    }

    public function update(Request $request)
    {
       
        foreach($request->get('links') AS $link)
        {
            $total = $link['total'];
            $link = \App\CampaignLink::find($link['primary_id']);
            $link->total = $total;
            $link->save();
        }
        
        return redirect('campaign');
    }

}
