<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';
    protected $fillable = [
        'id','name','address','address2','city','state','zip','phone','active'];

}
