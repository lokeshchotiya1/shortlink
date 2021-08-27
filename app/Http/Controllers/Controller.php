<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\User;


class Controller extends BaseController
{

	protected $authorizeStatus = 401;
    protected $httpStatus = 200;
    protected $successStatus = true;
    protected $errorStatus = false;
    protected $successCode = 200;
    protected $errorCode = 400;
    protected $userRole        = 'user';
    protected $adminRole       = 'admin';
    protected $emailNotVerified = 204;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


}