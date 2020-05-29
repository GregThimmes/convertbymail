<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class CampaignLink extends Model
{

    protected $table = 'campaign_link';
    protected $fillable = [
        'id', 'campaign_id', 'link_id', 'link', 'clicks', 'total', 'active'];

}
