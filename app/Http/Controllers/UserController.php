<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /**
    * @var $userRepository;
    **/
    private $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, UserService $userService)
    {
        $user = $userService->create($request->only('name', 'email', 'password', 'password_confirmation'));

        return response()->json($user);
    }

}
