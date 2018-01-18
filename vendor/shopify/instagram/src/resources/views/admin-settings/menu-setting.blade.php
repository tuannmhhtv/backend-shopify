<?php
    /**
 	 * Sample Menu Item HTML in Admin App Setting
 	 *
	 */

?>

<li class="nav-item">
    <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}" href="{{ route('admin.dashboard') }}"><i class="icon-speedometer"></i> Dashboard </a>
</li>
