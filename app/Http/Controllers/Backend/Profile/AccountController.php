<?php

namespace App\Http\Controllers\Backend\Profile;

use App\Http\Controllers\Controller;

/**
 * Class AccountController.
 */
class AccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {   
        return view('backend.profile.account');
    }
}
