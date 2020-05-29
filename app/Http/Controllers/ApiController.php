<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class ApiController extends Controller
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


    public function getUserCampaigns() {

    	$users = DB::select('SELECT count(*) AS total, b.id as campaignID,b.name AS campaign FROM campaign_page_click_log a INNER JOIN campaign b ON a.campaign_id = b.id INNER JOIN company c ON b.client_id = c.id WHERE c.id = ? GROUP BY a.campaign_id', [Auth::User()->company_id ]);
        
        return json_encode($users);

    }

    public function getCampaignReport(Request $request) {

    	$id = $request->get('id');

    	$query = DB::select('SELECT * FROM `campaign` WHERE id = ?', [$id]);

	    if($query[0]->client_id != Auth::User()->company_id )
	    {
	        $a = array();
	        return json_encode($a);
	    }
	    else
	    {
	        $query = DB::select('SELECT DATE_FORMAT(DATE,"%b-%d-%Y") as Daily, COUNT(campaign_id) AS Clicks FROM campaign_page_click_log WHERE campaign_id = ? GROUP BY Daily ORDER BY Daily ASC LIMIT 10', [$id]);

	        return json_encode($query);
	    }
	}

    public function getCompanyInsertionOrders(Request $request)
    {
        $company_id = $request->get('id');
        $insertion_order = \App\InsertionOrder::where('client_id', $company_id)->get();
        return json_encode($insertion_order);
    }


}
