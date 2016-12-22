<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Declare all the contants in the base class
    protected $status = 'status';
    protected $message = 'message';
    protected $data = 'data';
    protected $token = 'token';
    protected $hashKey = 'hash_key';
    protected $statusCode = 'statusCode';
    protected $response = 'response';
    protected $error = 'error';
    protected $id = 'id';
    protected $tokenId = 'tokenId';
    protected $hashId = 'hashId';
    protected $userId = 'user_id';
}
