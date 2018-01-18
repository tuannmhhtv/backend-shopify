@extends ('backend.layouts.app')

@section ('title', 'Add New Shopify App' )

@section('content')

    @if( isset( $message ) )
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ $message }}
        </div>
    @endif

<form class="form-horizontal" enctype="multipart/form-data" action="{{ route('admin.cactus.apps.create') }}" method="post">
    {{ csrf_field() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Add New Shopify App
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr />

            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="name">App Name</label>

                        <div class="col-md-10">
                            <input class="form-control" type="text" name="name" id="name" value="{{ isset( $request->name ) ? $request->name : '' }}" placeholder="App Name" maxlength="191" required="">
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="url">App URL</label>

                        <div class="col-md-10">
                            <input class="form-control" type="text" name="url" id="url" value="{{ isset( $request->url ) ? $request->url : '' }}" placeholder="App URL" maxlength="191">
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="api_key">API Key</label>

                        <div class="col-md-10">
                            <input class="form-control" type="text" name="api_key" id="api_key" value="{{ isset( $request->api_key ) ? $request->api_key : '' }}" placeholder="App API Key" maxlength="191" required>
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="api_secret">API Secret</label>

                        <div class="col-md-10">
                            <input class="form-control" type="text" name="api_secret" id="api_secret" value="{{ isset( $request->api_secret ) ? $request->api_secret : '' }}" placeholder="App API Secret" maxlength="191" required>
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="sql">SQL File</label>

                        <div class="col-md-10">
                            <input class="form-control" type="file" name="sql" id="sql" value="">
                        </div><!--col-->
                    </div><!--form-group-->

                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.cactus.apps.index'), 'Cancel') }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit('Create') }}
                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
</form>
@endsection
