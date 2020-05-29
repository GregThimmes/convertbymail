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

    public function store(Request $request)
    {
       
        $input = $request->all();
        $campaign = Campaign::create($input);
        return view('admin/campaignLink/'.$campaign->id);
    }

}
