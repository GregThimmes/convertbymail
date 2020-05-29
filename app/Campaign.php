<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{

    protected $table = 'campaign';
    protected $fillable = [
        'id', 'io_id', 'client_id', 'broadcast_date', 'name', 'quantity', 'subject_line', 'friendly_from', 'notes', 'creative', 'creative_o', 'fulfilled', 'approved', 'assigned', 'sales_rep_id', 'active', 'added', 'ref', 'o_rate', 'referral'];

}
