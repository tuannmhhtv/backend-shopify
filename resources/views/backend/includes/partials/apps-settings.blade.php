<?php

    $s_apps = config( 'shopify' );

    if( empty( $s_apps ) ){
        return;
    }

?>

<li class="nav-title">
    Shopify Apps Settings
</li>

@foreach( $s_apps as $app )
    @if( isset( $app['prefix'] ) )
        @include( $app['prefix'] . '::admin-settings.menu-setting')
    @endif
@endforeach
