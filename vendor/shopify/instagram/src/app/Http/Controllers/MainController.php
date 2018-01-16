<?php

namespace Shopify\InstagramApp\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Shopify\InstagramApp\app\Models\App as ShopifyApp;
use Shopify\InstagramApp\app\Models\Shop;
use Shopify\InstagramApp\app\Models\Instagram;
use Shopify\InstagramApp\app\Models\Authentication;
use App;

class MainController extends Controller
{
    public $API_KEY = '';
    public $API_SECRET = '';

    public function __construct(Request $request) {

        $app_name = config('shopify.instagram.APP_NAME');
        $app = ShopifyApp::where(['name' => $app_name])->first();
        $this->API_KEY = $app->api_key;
        $this->API_SECRET = $app->api_secret;
    }

    public function index(Request $request) {
        //$request->session()->flush();
        // if app was accessed already, redirect to dashboard
        if ($request->session()->has('access_token')) {

            $shop_domain = $request->session()->get('shop_domain');
            $access_token = $request->session()->get('access_token');

            $sh = App::make('ShopifyAPI', ['API_KEY' => $this->API_KEY, 'API_SECRET' => $this->API_SECRET, 'SHOP_DOMAIN' => $shop_domain, 'ACCESS_TOKEN' => $access_token]);

            // check if access token still be valid
            $shop = $sh->call(['METHOD' => 'GET', 'URL' => 'shop.json']);
            if (isset($shop->shop) && $shop->shop) {
                return $this->appDashboard($shop_domain);
            } else {
                // delete authentication in DB with invalid access token
                Authentication::where(['shop_domain' => $shop_domain, 'access_token' => $access_token])->delete();
                Instagram::where(['shop_domain' => $shop_domain])->delete();
                $request->session()->flush();
                echo $shop->errors;
            }
        } else {
            // check for the first time access the App
            if (isset($_GET['shop']) && $_GET['shop'] != null && isset($_GET['hmac'])) {

                $sh = App::make('ShopifyAPI', ['API_KEY' => $this->API_KEY, 'API_SECRET' => $this->API_SECRET, 'SHOP_DOMAIN' => $_GET['shop']]);

                // perform HMAC validation to determine if the request is coming from Shopify
                $verify = $sh->verifyRequest(Input::all());

                $auth = Authentication::join('apps', 'authentications.app_id', '=', 'apps.id')->where([
                    ['authentications.shop_domain', '=', $_GET['shop']],
                    ['apps.api_key', '=', $this->API_KEY],
                    ['apps.api_secret', '=', $this->API_SECRET]
                ])->first();
                // if one backend for one App only, it should be
                //$shop = Shop::where(['domain' => $_GET['shop']])->first();

                $is_access_token_valid = false;
                if ($auth && $auth->access_token != '') {
                    // check if access token still be valid
                    $sh->setup(['ACCESS_TOKEN' => $auth->access_token]);

                    $shopInfo = $sh->call(['METHOD' => 'GET', 'URL' => 'shop.json']);
                    if (isset($shopInfo->shop) && $shopInfo->shop) {
                        $is_access_token_valid = true;
                    } else {
                        // delete authentication in DB with invalid access token
                        Authentication::where(['shop_domain' => $_GET['shop'], 'access_token' => $auth->access_token])->delete();
                        Instagram::where(['shop_domain' => $_GET['shop']])->delete();
                    }
                }

                // check if shop was installed or not
                if ($verify && $is_access_token_valid) {

                    // if check successfully then create session
                    session(['shop_domain' => $_GET['shop'], 'access_token' => $auth->access_token]);
                    return $this->appDashboard($_GET['shop']);

                } else {
                    // if checking fail, redirect to App Install URL (when user click get App);

                    $permissions = array(
                        'read_content', 'write_content',
                        'read_products', 'write_products',
                        'read_product_listings', 'read_collection_listings',
                        'read_script_tags', 'write_script_tags',
                        'read_customers', 'write_customers',
                        'read_orders', 'write_orders',
                        'read_fulfillments', 'write_fulfillments',
                        'read_shipping', 'write_shipping',
                        'read_analytics',
                        'read_checkouts', 'write_checkouts',
                        'read_reports', 'write_reports',
                        'read_price_rules', 'write_price_rules',
                        'read_marketing_events', 'write_marketing_events',
                        'read_resource_feedbacks', 'write_resource_feedbacks',
                    );

                    $appInstallURL = $sh->installURL(['permissions' => $permissions, 'redirect' => route('appAuthorize')]);
                    return redirect($appInstallURL);
                }
            } else {
                // do nothing
            }
        }
    }

    public function appAuthorize() {
        // when click install App, it will redirect here and do authorizing process

        if (isset($_GET['shop']) && isset($_GET['code']) && isset($_GET['hmac'])) {

            $sh = App::make('ShopifyAPI', ['API_KEY' => $this->API_KEY, 'API_SECRET' => $this->API_SECRET, 'SHOP_DOMAIN' => $_GET['shop']]);

            try {
                // perform HMAC validation to determine if the request is coming from Shopify
                $verify = $sh->verifyRequest(Input::all());

                if ($verify) {
                    $code = Input::get('code');
                    //make API call to get access token, each Shop have only one valid access token for each App
                    $access_token = $sh->getAccessToken($code);

                    $this->saveAuthInfo($_GET['shop'], $access_token);
                    $this->postScriptTag($_GET['shop'], $access_token);

                    session(['shop_domain' => $_GET['shop'], 'access_token' => $access_token]);
                    return redirect('https://'.$_GET['shop'].'/admin/apps');

                } else {
                    // Issue with data
                }

            } catch (Exception $e) {
                echo '<pre>Error: ' . $e->getMessage() . '</pre>';
            }
        } else {
            echo 'Authorizing Failed. Missing Shop URL or Missing Code';
            return;
        }
    }

    public function saveAuthInfo($shop_domain, $access_token) {

        $sh = App::make('ShopifyAPI', ['API_KEY' => $this->API_KEY, 'API_SECRET' => $this->API_SECRET, 'SHOP_DOMAIN' => $shop_domain, 'ACCESS_TOKEN' => $access_token]);
        try {
            $shopInfo = $sh->call(['METHOD' => 'GET', 'URL' => 'shop.json']);
        } catch (Exception $e) {
            $shopInfo = $e->getMessage();
        }

        // // if one backend for one App only, dont need to get this, dont need to save app_id
        $app = ShopifyApp::where(['api_key' => $this->API_KEY, 'api_secret' => $this->API_SECRET])->first();

        // Save accessToken and shop Info
        Authentication::create([
            'access_token' => $access_token,
            'shop_domain' => $shop_domain,
            'shop_id' => $shopInfo->shop->id,
            'app_id' => $app->id,
        ]);

        Shop::updateOrCreate(
            ['domain' => $shop_domain],
            [
                'id' => $shopInfo->shop->id,
                'domain' => $shop_domain,
                'name' => $shopInfo->shop->name,
                'email' => $shopInfo->shop->email
            ]
        );
    }

    public function postScriptTag($shop_domain, $access_token) {

        $sh = App::make('ShopifyAPI', ['API_KEY' => $this->API_KEY, 'API_SECRET' => $this->API_SECRET, 'SHOP_DOMAIN' => $shop_domain, 'ACCESS_TOKEN' => $access_token]);

        $data = array(
            'script_tag' => array(
                'event' => 'onload',
                'src'   => secure_asset( '/vendor/shopify/instagram/js/postScriptTag.js' )
            )
        );

        $result = $sh->call(['METHOD' => 'POST', 'URL' => 'script_tags.json', 'DATA' => $data]);
    }

    public function appDashboard($shop_domain) {

        $instagram = Instagram::where('shop_domain', $shop_domain)->first();
        if ($instagram) {
            $access_token = $instagram->access_token;
            $setting = $instagram->setting;
        } else {
            $access_token = $setting = '';
        }

        $template = '<a href="{{link}}" target="_blank"><img style="object-fit:cover;margin:5px;width:320px;height:320px;" title="{{caption}}" src="{{image}}" /></a>';
        return view('instagram::app', compact('access_token', 'setting', 'template'));

    }

    public function getTokenFromInstagram() {
        return view('instagram::pages.get-instagram-token');
    }

    public function getInstagramTokenforShop() {

        if (empty($_GET['shop']) || empty($_GET['shop'])) {
            die();
        }

        $instagram = Instagram::where('shop_domain', $_GET['shop'])->first()->toArray();
        $access_token = $instagram['access_token'];
        $setting = $instagram['setting'];
        $setting = json_encode(unserialize($setting));

        return response(json_encode(array($access_token, $setting)))
            ->header('Access-Control-Allow-Origin', '*');
    }

    public function saveInstagramToken() {

        $shop_domain = session('shop_domain');
        $access_token = $_POST['access_token'];
        $setting = array();
        $setting[] = $_POST['resolution'];
        $setting[] = $_POST['feed_limit'];
        $setting[] = $_POST['space'];
        $setting[] = $_POST['sortby'];
        $setting[] = $_POST['open_ig'];
        $setting[] = $_POST['user_instagram_id'];

        $result = Instagram::updateOrCreate(
            ['shop_domain' => $shop_domain],
            [
                'shop_domain' => $shop_domain,
                'access_token' => $access_token,
                'setting' => serialize($setting),
            ]
        );

        if ($result) {
            return response(1)
                ->header('Access-Control-Allow-Origin', '*');
        } else {
            return response(0)
                ->header('Access-Control-Allow-Origin', '*');
        }
    }
}