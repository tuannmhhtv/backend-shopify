@extends ('backend.layouts.app')

@section ('title', 'Edit Shopify App' . ' | ' )

@section('content')
<form class="form-horizontal" novalidate action="{{ route('admin.cactus.apps.update', $this_app->id) }}" method="post">
    {{ csrf_field() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Edit Shopify App
                        <small class="text-muted">{{ $this_app->name }}</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr />

            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="name">App Name</label>

                        <div class="col-md-10">
                            <input class="form-control" type="text" name="name" id="name" value="{{ $this_app->name }}" placeholder="App Name" maxlength="191" required="">
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="url">App URL</label>

                        <div class="col-md-10">
                            <input class="form-control" type="text" name="url" id="url" value="{{ $this_app->url }}" placeholder="App URL" maxlength="191">
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="api_key">API Key</label>

                        <div class="col-md-10">
                            <input class="form-control" type="text" name="api_key" id="api_key" value="{{ $this_app->api_key }}" placeholder="App API Key" maxlength="191" disabled>
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="api_secret">API Key</label>

                        <div class="col-md-10">
                            <input class="form-control" type="text" name="api_secret" id="api_secret" value="{{ $this_app->api_secret }}" placeholder="App API Secret" maxlength="191" disabled>
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
                    {{ form_submit('Update') }}
                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
</form>
@endsection
