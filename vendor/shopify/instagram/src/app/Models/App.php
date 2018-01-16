<?php

namespace Shopify\InstagramApp\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class App extends Model
{
    protected $table = 'apps';

    protected $primaryKey = 'id';

    public $timestamps = false;

}
