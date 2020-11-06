<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CampaignController extends Controller
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


    public function index(Campaign $model)
    {
        return view('admin/campaign', ['campaigns' => $model->paginate(50)]);
    }

    public function view($id)
    {
        $campaign = \App\Campaign::find($id);
        return view('admin/campaignView')->with('campaign',$campaign);
    }

    public function create()
    {
        $companies = \App\Company::all();
        $sales_reps = \App\User::where('level','>=', 1)->get(); 
        return view('admin/campaignCreate')->with('companies',$companies)->with('sales_reps',$sales_reps);
    }

    public function edit($id)
    {
        $campaign = \App\Campaign::find($id);
        $companies = \App\Company::all();
        $sales_reps = \App\User::where('level','>=', 1)->get();
        $orders = \App\InsertionOrder::where('client_id',$campaign->client_id)->get();

        return view('admin/campaignEdit')->with('campaign',$campaign)->with('companies',$companies)->with('sales_reps',$sales_reps)->with('orders',$orders);

    }

    public function update(Request $request)
    {
        $campaign = \App\Campaign::find($request->get('id'));
        $campaign->client_id = $request->get('client_id');
        $campaign->io_id = $request->get('io_id');
        $campaign->broadcast_date = $request->get('broadcast_date');
        $campaign->name = $request->get('name');
        $campaign->quantity = $request->get('quantity');
        $campaign->subject_line = $request->get('subject_line');
        $campaign->friendly_from = $request->get('friendly_from');
        $campaign->creative_o = $request->get('creative_o');
        $campaign->notes = $request->get('notes');
        $campaign->save();

        //Delete all the links, we need to reprocess

        $campaignLink = \App\CampaignLink::where('campaign_id', $campaign->id)->delete();

        $creativeProcess = $this->processCreative($request->get('creative_o'), $campaign->id);


        return redirect('campaign/links/'.$campaign->id);
    

    }

    public function store(Request $request)
    {
       /*
        $request->validate([
                'io_id' => 'required',
                'client_id' => 'required',
                'broadcast_date' => 'required',
                'name' => 'required',
                'quantity' => 'required',
                'subject_line' => 'required',
                'friendly_from' => 'required',
                'creative_o' => 'required'
            ], [
                'io_id.required' => 'Insertion Order is required',
                'client_id.required' => 'Company is required',
                'broadcast_date' => 'Broadcast Date is required',
                'name' => 'Name is required',
                'quanity' => 'Quantity is required',
                'subject_line' => 'Subject Line is required',
                'friendly_from' => 'Friendly From is required',
                'creative_o' => 'Creative is required'
            ]);
    */
        $input = $request->all();
        $input['creative'] = $request->get('creative_o');

        $min = 0.0799;
        $max = 0.1498;
        $randomPercent = $this->float_bienthuy($min,$max,4);

        $input['o_rate'] = $randomPercent ;

        //die(print_r($input));

        $campaign = Campaign::create($input);

        $creativeProcess = $this->processCreative($input['creative_o'], $campaign->id);
    
        return redirect('campaign/links/'.$campaign->id);
    }


    function editCreative($id)
    {
        $campaign = \App\Campaign::find($id);
        return view('admin/campaignCreative')->with('campaign',$campaign);
    }

    function updateCreative(Request $request)
    {
        $campaign = \App\Campaign::find($request->get('id'));
        $campaign->creative_o = $request->get('creative_o');
        $campaign->save();

        //Delete all the links, we need to reprocess
        $campaignLink = \App\CampaignLink::where('campaign_id', $campaign->id)->delete();
        $creativeProcess = $this->processCreative($request->get('creative_o'), $campaign->id);

        return redirect('campaign/links/'.$campaign->id);
    }

    function processCreative($creative, $id)
    {
    
        //Delete existing because its a new save

        $deletedRows = \App\CampaignLink::where('campaign_id', $id)->delete();


        $openpixel = '<img src="http://staycationmedia.com/tracker.php?c='.$id.'" width="0" height="0" />';
        $openpixel = str_replace('%20',' ',$openpixel);
        
        $o_anchors = array();
        
        $dom = new \DomDocument();
//      $creative = html_entities($creative);  //preg_replace('/\x03/', '', $creative); // remove ETX control-character 8/14/2014
        @$dom->loadHTML($creative);
        
        $anchors = $dom->getElementsByTagName("a");
        $i = 1;
        
        $href_tag = '';
        foreach($anchors as $anchor) {
            $href_tag = $anchor->getAttribute('href');
            if ( trim($href_tag) != '' && $href_tag[0] != '#' && strpos(strtolower($href_tag),'mailto:') === false && strpos(strtolower($href_tag),'tel:') === false && strpos(strtolower($href_tag),'unsub') === false && strpos(strtolower($href_tag),'optout') === false && strpos(strtolower($href_tag),'opt-out') === false ) {
                
                if($href_tag != 'http://ww2.networkmediaworks.com/r/')
                {
                    $o_anchors[] = $href_tag; //$anchor->getAttribute('href');
                    $anchor->setAttribute('href', "http://ads.staycationmedia.com/campaign_page.php?c=".$id."~".$i);
                    $i++;
                }
            }
        }

        $areas = $dom->getElementsByTagName("area");
        $o_areas = array();
        foreach($areas as $area) {
            $href_tag = $area->getAttribute('href');
            if ( trim($href_tag) != '' && $href_tag[0] != '#' && strpos(strtolower($href_tag),'mailto:') === false && strpos(strtolower($href_tag),'tel:') === false && strpos(strtolower($href_tag),'unsub') === false && strpos(strtolower($href_tag),'optout') === false && strpos(strtolower($href_tag),'opt-out') === false) {
                $o_anchors[] = $href_tag; //$area->getAttribute('href');
                $area->setAttribute('href', "campaign_page.php?c=".$id."~".$i);
                $i++;
            }
         }
        
        $newcreative = $dom->saveHTML();
        $newcreative .= $openpixel;
        

        $campaign = \App\Campaign::find($id);
        $campaign->creative =  $newcreative;
        $campaign->save();
        
        $i = 1;
        foreach($o_anchors as $link) 
        {
            $campaignLink = new \App\CampaignLink;
            $campaignLink->campaign_id = $id;
            $campaignLink->link_id = $i;
            $campaignLink->link = $link;
            $campaignLink->save();
            $i++;
        }

        /*
        $fileA = "OriginalCreative_".$Id.".html";
        $fileB = "NewCreative_".$Id.".html";
        $file_path = '../packages';

        $fp = fopen("../packages/".$fileA, 'w');
        fwrite($fp, $creative);
        fclose($fp);

        $fp = fopen("../packages/".$fileB, 'w');
        fwrite($fp, $newcreative);
        fclose($fp);
        */

}

function float_bienthuy($Min, $Max, $round=0){
  //validate input
  if ($Min>$Max) { $min=$Max; $max=$Min; }
        else { $min=$Min; $max=$Max; }
  $randomfloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);
  if($round>0)
  $randomfloat = round($randomfloat,$round);
  return $randomfloat;
}

}
