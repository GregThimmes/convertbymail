<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Cookie;
use Illuminate\Support\Facades\Http;


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
        if(!$this->getCookie())
        {
            $response = Http::get('https://login.myadcampaigns.com/admin/auth', ['login' => 'myadcampaigns','password' => '2300R!ddle',]);
        
            if($response->ok())
            {
                $token = $response->body();
                Cookie::queue('3CEB6A9B84DDAE0F4A98BDF212857467', $token, 10);
                return $response->body();
            }
        }
        else
        {
            return $this->getCookie();
        }
    }

   public function getCookie(){
        return Cookie::get('3CEB6A9B84DDAE0F4A98BDF212857467');
   }

    public function Campaigns()
    {
        $token = $this->create_token();

        $response = Http::get('https://login.myadcampaigns.com/admin/api/Campaign', ['token' => $token,'range' => '0-25','filters' => 'is_active:true', 'ord' => '-id',]);
        $body = $response->json(); 
        $array_data = (array) $body['response'];
        $json_data = json_encode(array_values($array_data));
        return $json_data; 
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

                    $stateCodes = array();
                    $cityCodes = array();

                    if($column[16] != '')
                    { 
                        //$cities = explode(PHP_EOL, $column[16]);
                        $cities = explode('|', $column[16]);
                        foreach($cities AS $key => $value)
                        {   
                            $string = explode(',', $value);
                            $iso = trim(strtolower($string[1]));
                            
                            if(isset($json_states[0][$country][$iso]))
                            {
                                $cityName = ucwords(strtolower(trim($string[0])));
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

                    if($column[4] == 'FALSE')
                    {
                        $is_offer_active = false;
                    }

                    $advertiser_id = '101673';
                    $remotefeed_id = '229533';

                    $response = Http::post('https://login.myadcampaigns.com/admin/api/Campaign?token='.$token.'', array(
                        'advertiser_id' => intval($advertiser_id),
                        'remotefeed_id' => intval($remotefeed_id),
                        'name'  => $column[0],
                        'budget_total'  => floatval($column[1]), //double
                        'budget_daily'  => floatval($column[2]), //double
                        'budget_limiter_type' => $column[3], //ENUM [Evenly,ASAP]
                        'is_active' => $is_campaign_active,
                        'start_date' => $column[5], //Date
                        //'start_date' => date("Y-m-d", strtotime($column[5])), //Date
                        'end_date' => date("Y-m-d", strtotime($column[6])) //Date
                    ));

                    $result = $response->json(); 

                    
                    if($result['status'] === 'Error')
                    {
                        $uploadErrors[$row]['campaigns'] = $result['message'];
                    }
                    else
                    {
                        $ad_campaign_id = $result->response->created;

                        ////make offer call with ad_campaign_ID
                        $response = Http::post('https://login.myadcampaigns.com/admin/api/OfferNew', [
                            'token' => $token,
                            'ad_campaign_id'  => $ad_campaign_id,
                            'name'  => $column[7],
                            'is_active'  => $is_offer_active,
                            'bid' => floatval($column[9]), //ENUM [Evenly,ASAP]
                            'Ad' => array(
                                'mode' => 'REPLACE',
                                'create' => array(
                                        'title' => $column[10], //string
                                        'desc' => $columns[11], //string
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

                        $OfferResult = $curl->response;

                        if($OfferResult->status == 'Error')
                        {
                            $uploadErrors[$row]['offers'] = $OfferResult->message;

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
