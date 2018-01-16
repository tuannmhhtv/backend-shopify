<?php

namespace Shopify\InstagramApp\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shop extends Model
{
    protected $fillable = ['name', 'id', 'domain', 'access_token', 'app_id', 'email','instagram_token','instagram_setting'];
    protected $primaryKey = 'id';

    public $shopDomain = '';
    public $shopFullURL = '';
    public $shopAdminURL = '';
    public $shopAppsPageURL = '';
    public $accessToken = '';

    public function __construct( $shopDomain = '' ){
        parent::__construct();
        //avoid attributes construct
        if (is_array($shopDomain)) {
            return;
        }

        $this->shopDomain = $shopDomain;
        $this->shopFullURL = $this->shopURL($shopDomain);
        $this->shopAdminURL = $this->shopAdminURL();
        $this->shopAppsPageURL = $this->shopAppsPageURL();
        //$this->accessToken = $this->getAccessToken();
    }

    private function shopURL( $shop ){

        if( strpos( $shop, 'https://' ) === false ){
            return "https://$shop";
        }

        return rtrim( $shop, '/' );
    }

    private function shopAdminURL(){

        return $this->shopFullURL . '/admin';
    }

    public function shopAppsPageURL(){

        return $this->shopAdminURL . '/apps';
    }

    public function getAccessToken(){

    }
}