<?php

namespace App\Http\Controllers\Backend\CactusAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Input;

class AppsAdminController extends Controller
{

    public function index()
    {

        $apps = DB::select('select * from apps');

        foreach( $apps as $app ){
            $app->edit = route('admin.cactus.apps.edit', [ 'id' => $app->id ] );
            $app->delete = route('admin.cactus.apps.delete', [ 'id' => $app->id ] );
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

            //slugify app name
            $request->name = strtolower( trim( $request->name ) );
            $request->name = preg_replace( '/\W\W+/', '-', $request->name );
            $request->name = preg_replace( '/\s+/', '-', $request->name );

            DB::table('apps')->insert([
                'name'       => $request->name,
                'url'        => trim( $request->url ),
                'api_key'    => trim( $request->api_key ),
                'api_secret' => trim( $request->api_secret )
            ]);

            //get inserted app
            $app = DB::table('apps')->where([
                'name'       => $request->name,
                'url'        => trim( $request->url ),
                'api_key'    => trim( $request->api_key ),
                'api_secret' => trim( $request->api_secret )
            ]);

            if( $request->hasFile('sql') ){

                $sql = file_get_contents( $request->sql->getRealPath() );

                //collect app tables
                preg_match_all( '/CREATE TABLE `\w+`/', $sql, $matches );

                if( !empty( $matches[0] ) ){

                    $tables = array();

                    foreach( $matches[0] as $match ){
                        $match = trim( $match, 'CREATE TABLE' );
                        $match = trim( $match, '`' );

                        //if table is existed then exit
                        $this_table = DB::select( DB::raw('show tables like "' . $match . '"') );

                        if( !empty( $this_table ) ){

                            $message = "Table '$match' is already existed";

                            //return data and message to add page
                            return view('backend.cactus-admin.apps.add', compact( 'request', 'message' ) );
                        }

                        //else add it to tables and keep going on loop
                        $tables[] = $match;
                    }
                }

                try {
                    //update tables column for app
                    $app->update( [ 'tables' => serialize( $tables ) ] );

                    $result = DB::unprepared( $sql );
                } catch (Exception $e) {

                    if( !empty( $tables ) ){
                        //remove inserted table
                        foreach( $tables as $table ){
                            try {
                                DB::statement('DROP TABLE `' . $table . '`;');
                            } catch (Exception $e) {
                                //thrown exception
                            }
                        }
                    }

                    //delete inserted row above
                    $app->delete();

                    $message = "Cannot import SQL file successfully";

                    return view('backend.cactus-admin.apps.add', compact( 'request', 'message' ) );

                }

            }



        }

        return redirect( route('admin.cactus.apps.index') );

    }

    public function delete( $id ){

        $response = DB::table('apps')->where( [ 'id' => $id ] )->delete();

        return redirect( route('admin.cactus.apps.index') );

    }

}
