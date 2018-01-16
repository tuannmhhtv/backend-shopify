<?php

namespace Shopify\InstagramApp\app\Models;

use Illuminate\Database\Eloquent\Model;

class Authentication extends Model
{
    protected $table = 'authentications';

    protected $primaryKey = 'id';

    protected $fillable = ['access_token', 'shop_id', 'shop_domain', 'app_id'];

    public $timestamps = true;

}
