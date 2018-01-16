<?php

namespace App\Http\Controllers\Backend\CactusAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AppsAdminController extends Controller
{

    public function index()
    {

        $apps = DB::select('select * from apps');

        foreach( $apps as $app ){
            $app->edit = route('admin.cactus.apps.edit', [ 'id' => $app->id ] );
        }

        return view('backend.cactus-admin.apps.index', [ 'apps' => $apps ] );

    }

    public function edit( $id ){

        $apps = DB::select("select * from apps where id = $id");
        $app = $apps[0];

        return view('backend.cactus-admin.apps.edit', [ 'this_app' => $app ] );

    }

    public function update( $id ){

        $data = Input::all();

        if( $data['_token'] == csrf_token() ){
            DB::table('apps')->update([
                'name'       => isset( $data['name'] ) ? $data['name'] : '',
                'url'        => isset( $data['url'] ) ? $data['url'] : '',
            ]);
        }

        $apps = DB::select("select * from apps where id = $id");
        $app = $apps[0];

        return view('backend.cactus-admin.apps.edit', [ 'this_app' => $app ] );

    }

    public function add(){

        return view('backend.cactus-admin.apps.add');

    }

    public function create(Request $request){

        if( $request->_token == csrf_token() ){

            DB::table('apps')->insert([
                'name'       => $request->name,
                'url'        => $request->url,
                'api_key'    => $request->api_key,
                'api_secret' => $request->api_secret
            ]);

            if( $request->hasFile('sql') ){
                $sql = $request->sql;
                $result = DB::unprepared( file_get_contents( $sql->getRealPath() ) );
            }

        }

        return redirect( route('admin.cactus.apps.index' ) );

    }

}
