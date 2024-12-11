<?php

namespace App\Http\Controllers;

use App\Services\HelperService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $helperService;

    public function __construct(
        HelperService $helperService,
    ) {
        $this->helperService = $helperService;
    }

    // * For telling the vscode intelephense that the hasPermission method and etc is exist in User Model
    public function getUser()
    {
        /** @var \App\Models\User */
        $user = auth()->user();
        return $user;
    }
}
