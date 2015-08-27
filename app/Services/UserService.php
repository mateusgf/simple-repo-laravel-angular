<?php

namespace App\Services;

use Validator;

use App\Repositories\UserRepository;

class UserService {


    /**
     * @var $userRepository;
     **/
    private $userRepository;



    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function create($data)
    {
        /**
         * Create with business logic
         */

        $validator = Validator::make($data, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);


        if ($validator->fails()) {
            //return $validator->errors(); // errors with fields in the keys
            return ['success' => 0, 'errors' => $validator->errors()->all()];
        }

        $data['password_original'] = $data['password'];
        $data['password'] = bcrypt($data['password']);


        $user = $this->userRepository->create($data);

        $request = [
            'url' => \URL::to('/') . '/oauth/access_token',
            'params' => [
                'client_id' => 1,
                'client_secret' => 'secret',
                'grant_type' => 'password',
                'username' => $data['email'],
                'password' => $data['password_original'],
            ]
        ];


        $response = \HttpClient::post($request);


        return ['success' => 1, 'return' => $user, 'token' => json_decode($response->content())];
    }

} 