<?php

namespace App\Http\Controllers;

use App\Campaign;
use Auth;

class PageController extends Controller
{
    /**
     * Display all the static pages when authenticated
     *
     * @param string $page
     * @return \Illuminate\View\View
     */
    public function index(string $page, $id)
    {
        if (view()->exists("pages.{$page}")) 
        {

            $campaign = Campaign::where('id', $id)->first();
            if( !is_object($campaign) || $campaign->client_id != Auth::User()->id)
            {
                return abort(404);
            }
            
            return view("pages.{$page}")->with('id',$id)->with('name', $campaign->Name);
        }

        return abort(404);
    }
}
