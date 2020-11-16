<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Cookie;
use Illuminate\Support\Facades\Http;
use Auth;

class AdKernalController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('bulk/bulk');
    }

    public function create_token()
    {
        
            $response = Http::get('https://login.myadcampaigns.com/admin/auth', ['login' => Auth::user()->adkernal_l,'password' => Auth::user()->adkernal_p,]);
        
            if($response->ok())
            {
                $token = $response->body();
                return $response->body();
            }
        
            else
            {
                return '';
            }
    }

    public function Campaigns()
    {
        $token = $this->create_token();                    
        $filters = array();
        if(Auth::user()->level != 9)
        {
            $response = Http::get('https://login.myadcampaigns.com/admin/api/Campaign', ['token' => $token, 'range' => '0-10', 'filters' => 'advertiser:'.Auth::user()->advertiser_id.'', 'is_active:true', 'ord' => '-id',]);
        }
        else
        {
            $response = Http::get('https://login.myadcampaigns.com/admin/api/Campaign', ['token' => $token, 'range' => '0-10', 'filters' => 'is_active:true', 'ord' => '-id',]);
        }
        
        $body = $response->json(); 

        if($body['status'] === 'Error')
        {
            return json_encode(array());
        }

        $array_data = (array) $body['response'];
        $json_data = json_encode(array_values($array_data));
        return $json_data; 
    }

    public function getCampaignByName($name, $token)
    {
        $name = strtolower(trim($name));

         $response = Http::get('https://login.myadcampaigns.com/admin/api/Campaign', ['token' => $token, 'filters' => 'search:'.$name.'']);
         $result = $response->json(); 

         foreach($result['response'] AS $key => $value)
         {
            $searchName = strtolower(trim($value['name']));

            if( $searchName === $name)
            {
                return false;
            }
         }

         return true;
    }

    public function Download()
    {
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',   
            'Content-Disposition' => 'attachment; filename=campaigns.csv',   
            'Expires' => '0',
            'Pragma' => 'public'
        ];

        $columns = array('campaign_id', 'campaign_name', 'campaign_budget_total', 'campaign_budget_daily', 'campaign_budget_limiter_type', 'campaign_is_active',  'campaign_start_date', 'campaign_end_date', 'offer_name','offer_active','offer_bid','ad_title','ad_desc ad_display', 'ad_destination_url', 'countries', 'states','cities', 'dma');

        $token = $this->create_token();
 
        if(Auth::user()->level != 9)
        {
            $response = Http::get('https://login.myadcampaigns.com/admin/api/Campaign', ['token' => $token, 'range' => '0-10', 'filters' => 'advertiser:'.Auth::user()->advertiser_id.'', 'is_active:true', 'ord' => '-id',]);
        }
        else
        {
            $response = Http::get('https://login.myadcampaigns.com/admin/api/Campaign', ['token' => $token, 'range' => '0-10', 'filters' => 'is_active:true', 'ord' => '-id',]);
        }

        $body = $response->json(); 

        if($body['status'] === 'Error')
        {   
            $row = array();
        }
        else 
        {
            $row = array();
            $data = (array) $body['response'];
            $count = 0;
            foreach ($data as $key => $value) 
            {
                $row[$count]['campaign_id'] = $value['id'];
                $row[$count]['campaign_name']  = $value['name'];
                $row[$count]['campaign_budget_total'] = $value['budget_total'];
                $row[$count]['campaign_budget_daily']  = $value['budget_daily'];
                $row[$count]['campaign_budget_limiter_type']  = $value['budget_daily'];
                $row[$count]['campaign_is_active'] = $value['is_active'];
                $row[$count]['campaign_start_date'] = $value['start_date'];
                $row[$count]['campaign_end_date'] = $value['end_date'];

                $offerResponse = Http::get('https://login.myadcampaigns.com/admin/api/OfferNew', ['token' => $token, 'filters' => 'campaign:'.$value['id'].'']);

                $body2 = $offerResponse->json(); 
                $data2 = (array) $body2['response'];

                
                foreach($data2 as $key2 => $value2)
                {
  
                    $row[$count]['offer_name'] = $value2['name'];
                    $row[$count]['offer_active'] = $value2['is_active'];
                    $row[$count]['offer_bid'] = $value2['bid'];

                    foreach($value2['Ad']['value'] AS $value3)
                    {
                        $row[$count]['ad_title'] = $value3['title'];
                        $row[$count]['ad_desc ad_display'] = $value3['desc'];
                        $row[$count]['ad_destination_url'] = $value3['dest_url'];
                    }

                    $countries = '';
                    $states = '';
                    $cities = '';

                    $geoStatesUS = file_get_contents(storage_path('json/GeoStatesUS.json'));
                    $json_states = json_decode($geoStatesUS, true);


                    foreach($value2['Location']['value'] AS $value4)
                    {

                        if($value4['type'] === 'COUNTRY')
                        {
                            if($value4['enabled'] === true )
                            {
                                $countries .= ''.$value4['id'].'|';
                            }
                            
                        }

                        if($value4['type'] === 'STATE')
                        {
                            $states .= ''.$value4['name'].'|';
                            
                        }

                        if($value4['type'] === 'CITY')
                        {
                            if($value4['enabled'] === true )
                            {
                                $stateName = $json_states[$value4['id']['Region']];
                                $cities .= ''.$value4['name'].','.$stateName.'|';
                            }
                        }
                        
                    }

                    $row[$count]['countries'] = $countries;
                    $row[$count]['states'] = $states;
                    $row[$count]['cities'] = $cities;
                }

                $count++;
            }
        }

        $callback = function() use($row, $columns) 
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach( $row AS $key => $value)
            {
                fputcsv($file, $value);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);        
    }

    public function Upload()
    {
        return view('bulk/bulk-upload');
    }

    public function Store()
    {
        $fileName = $_FILES["csv_file"]["tmp_name"];
        

        if ($_FILES["csv_file"]["size"] > 0) 
        {
            $token = $this->create_token();
            $cities = file_get_contents(storage_path('json/GeoCities.json'));
            $json_cities = json_decode($cities, true);
            $states = file_get_contents(storage_path('json/GeoRegions.json'));
            $json_states = json_decode($states, true);
            $file = fopen($fileName, "r");
            $row = 0;
            $uploadErrors = array();
            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) 
            {
                if($row > 0)
                {
                    $is_campaign_active = true;
                    $is_offer_active = true;
                    $country = $column[14];
                    $countryCodes = array('us');
                    $stateCodes = array();
                    $cityCodes = array();

                    if($column[17] != '')
                    {
                        $dma_file = file_get_contents(storage_path('json/dma.json'));
                        $json_dma = json_decode($dma_file, true);
                        $dmaX = explode('|', $column['17']);

                        $dma = array();
                        foreach($dmaX AS $key => $value)
                        {   
                            array_push($dma, $value);
                        }

                        foreach($json_dma AS $key => $value)
                        {
                            foreach($value AS $key2 => $value2)
                            {
                                if( in_array($key2, $dma) )
                                {
                                    $string = explode(',', $value2);

                                    if(isset($string[0]) && isset($string[1])) 
                                    {
                                        $iso = trim(strtolower($string[1]));

                                        if(isset($json_states[0][$country][$iso]))
                                        {
                                            $cityName = strtolower(trim($string[0]));
                                            $stateID = $json_states[0][$country][$iso];

                                            if(isset($json_cities[$stateID][$cityName]))
                                            {
                                                $cityCodes[] = $json_cities[$stateID][$cityName];
                                            }
                                            else
                                            {
                                                $uploadErrors[$row]['cities'][] = $value2;
                                            }
                                        }
                                        else
                                        {
                                            $uploadErrors[$row]['states'][] = $value2;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if($column[16] != '')
                    { 
                        $cities = explode('|', $column[16]);
                        foreach($cities AS $key => $value)
                        {   
                            $string = explode(',', $value);
                            $iso = trim(strtolower($string[1]));
                            
                            if(isset($json_states[0][$country][$iso]))
                            {
                                $cityName = strtolower(trim($string[0]));
                                $stateID = $json_states[0][$country][$iso];

                                if(isset($json_cities[$stateID][$cityName]))
                                {
                                    $cityCodes[] = $json_cities[$stateID][$cityName];
                                }
                                else
                                {
                                    $uploadErrors[$row]['cities'][] = $value;
                                }
                            }
                            else
                            {
                                $uploadErrors[$row]['cities'][] = $value;
                            }
                        }
                    }

                    if($column[15] != '')
                    {
                        $states = explode('|', $column[15]);
                        foreach($states AS $key => $value)
                        {
                            $iso = trim(strtolower($value));
                            if(isset($json_states[0][$country][$iso]))
                            {
                                $stateCodes[] = $json_states[0][$country][$iso];
                            }
                            else
                            {
                                $uploadErrors[$row]['states'][] = $iso;
                            }
                        }
                    }

                    if($column[4] == 'FALSE')
                    {
                        $is_campaign_active = false;
                    }

                    if($column[8] == 'FALSE')
                    {
                        $is_offer_active = false;
                    }

                    $duplicate = $this->getCampaignByName($column[0], $token);
                    $result['status'] = 'Error';

                    if($duplicate)
                    { 
                        $advertiser_id = Auth::user()->advertiser_id;
                        $remotefeed_id = Auth::user()->remotefeed_id;

                        $response = Http::post('https://login.myadcampaigns.com/admin/api/Campaign?token='.$token.'', array(
                            'advertiser_id' => intval($advertiser_id),
                            'remotefeed_id' => intval($remotefeed_id),
                            'name'  => $column[0],
                            'budget_total'  => floatval($column[1]), //double
                            'budget_daily'  => floatval($column[2]), //double
                            'budget_limiter_type' => $column[3], //ENUM [Evenly,ASAP]
                            'is_active' => $is_campaign_active,
                            //'start_date' => $column[5], //Date
                            'start_date' => date("Y-m-d", strtotime($column[5])), //Date
                            'end_date' => date("Y-m-d", strtotime($column[6])) //Date
                        ));

                        $result = $response->json();
                    }

                    if(!$duplicate)
                    {
                        $uploadErrors[$row]['campaigns'] = 'Campaign name already exists';
                    }
                    else if($result['status'] === 'Error')
                    {
                        $uploadErrors[$row]['campaigns'] = $result['message'];
                    }
                    else
                    {
                        $ad_campaign_id = $result['response']['created'];
                        ////make offer call with ad_campaign_ID
                        $response = Http::post('https://login.myadcampaigns.com/admin/api/OfferNew?token='.$token.'', [
                            'ad_campaign_id'  => $ad_campaign_id,
                            'name'  => $column[7],
                            'is_active'  => $is_offer_active,
                            'bid' => floatval($column[9]), //ENUM [Evenly,ASAP]
                            'Ad' => array(
                                'mode' => 'REPLACE',
                                'create' => array(
                                        'title' => $column[10], //string
                                        'desc' => $column[11], //string
                                        'display' => $column[12], //string
                                        'dest_url'=> $column[13]
                                    )
                            ),
                            'Location' => array(
                                'mode' => 'REPLACE',
                                'edit' => array(
                                    'countries' => $countryCodes,
                                    'states' => $stateCodes,
                                    'cities' => $cityCodes,
                                    'enabled' => true
                                )
                            ),
                            'TimePeriod' => array(
                                'mode' => 'REPLACE',
                                'edit' => array(
                                    array( "hour" => 4, "enabled" => true),
                                    array( "hour" => 5, "enabled" => true),
                                    array( "hour" => 6, "enabled" => true),
                                    array( "hour" => 7, "enabled" => true),
                                    array( "hour" => 8, "enabled" => true),
                                    array( "hour" => 9, "enabled" => true),
                                    array( "hour" => 10, "enabled" => true),
                                    array( "hour" => 11, "enabled" => true),
                                    array( "hour" => 12, "enabled" => true),
                                    array( "hour" => 13, "enabled" => true),
                                    array( "hour" => 14, "enabled" => true),
                                    array( "hour" => 15, "enabled" => true),
                                    array( "hour" => 16, "enabled" => true),
                                    array( "hour" => 17, "enabled" => true),
                                    array( "hour" => 18, "enabled" => true),
                                    array( "hour" => 19, "enabled" => true),
                                    array( "hour" => 20, "enabled" => true),
                                    array( "hour" => 21, "enabled" => true)
                                )
                            )

                        ]);

                        $OfferResult = $response->json(); 

                        if($OfferResult['status'] === 'Error')
                        {
                            $uploadErrors[$row]['offers'] = $OfferResult['message'];

                            //$offerError[$row] = array('campaign' => $column[0], 'error' => $OfferResult->message);
                        }
                    }
                }

                $row++;
            }  

            $html = '<h1>Error Report</h1>';
            if(!empty($uploadErrors))
            {
                $html .= '<table class="table align-items-center"><thead class="thead-light"><tr><th scope="col">Row Number</th><th scope="col">Campaign Error</th><th scope="col">Offer Error<th scope="col">Invalid States</th><th scope="col">Invalid Cities</th></thead><tbody class="list">';
                    foreach($uploadErrors AS $key => $value)
                    {
                        $html .= '<tr><td>'.$key.'</td>';

                        if(isset($value['campaigns']))
                        {
                            $html .= '<td>'.$value['campaigns'].'</td>';
                        } else { $html .= '<td></td>'; }


                        if(isset($value['offers'])) {
                            $html .= '<td>'.$value['offers'].'</td>';
                        } else { $html .= '<td></td>'; }

                        if(isset($value['states']))
                        {
                            $html .= '<td><ol>';
                            foreach($value['states'] AS $key2 => $value2)
                            {
                                $html .= '<li>'.$value2.'</li>';
                            }
                            $html .= '</ol></td>';
                        } else { $html .= '<td></td>'; }

                        if(isset($value['cities']))
                        {
                            $html .= '<td><ol>';
                            foreach($value['cities'] AS $key2 => $value2)
                            {
                                $html .= '<li>'.$value2.'</li>';
                            }
                            $html .= '</ol></td>';
                        } else { $html .= '<td></td>'; }

                        $html .= '</tr>';

                    }
                    $html .= '</tbody></table>';
            }

            if($html != '')
            {
                $result = array('status' => 'Error', 'message' => $html);
                return json_encode($result);
            }

            $result = array('status' => 'Success');
            return json_encode($result);
        }
    }
}
