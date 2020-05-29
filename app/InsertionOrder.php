<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class InsertionOrder extends Model
{
    protected $table = 'insertion_order';
    protected $fillable = [
        'id','internal_id','client_id','contact_id','sales_rep_id','name','type','status','quantity','active'];

}
