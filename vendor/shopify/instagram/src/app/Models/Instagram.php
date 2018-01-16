<?php

namespace Shopify\InstagramApp\app\Models;

use Illuminate\Database\Eloquent\Model;

class Instagram extends Model
{
    protected $table = 'instagrams';

    protected $primaryKey = 'id';

    protected $fillable = ['shop_domain','access_token','setting'];

    public $timestamps = true;

}
