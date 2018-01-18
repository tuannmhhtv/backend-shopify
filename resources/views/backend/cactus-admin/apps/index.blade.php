@extends ('backend.layouts.app')

@section ('title', 'Shopify Apps Management')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    All Shopify Apps
                </h4>
            </div><!--col-->

            @if( $logged_in_user->isAdmin() )
                <div class="col-sm-7">
                    <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                        <a href="{{ route('admin.cactus.apps.add') }}" class="btn btn-success ml-1" data-toggle="tooltip" title="" data-original-title="Create New"><i class="fa fa-plus-circle"></i></a>
                    </div>
                </div><!--col-->
            @endif
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Shopify App name</th>
                            <th>URL</th>
                            <th>API Key</th>
                            <th>API Secret</th>
                            @if( $logged_in_user->isAdmin() )
                                <th>Action</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($apps as $app)
                            <tr>
                                <td>{{ $app->name }}</td>
                                <td>{{ $app->url }}</td>
                                <td>{{ $app->api_key }}</td>
                                <td>{{ $app->api_secret }}</td>
                                @if( $logged_in_user->isAdmin() )
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="User Actions">
                                            <a href="{{ $app->edit }}" class="btn btn-primary">
                                                <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                                </i>
                                            </a>
                                            <a href="{{ $app->delete }}" class="btn btn-danger">
                                                <i class="fa fa-trash">
                                                </i>
                                            </a>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
