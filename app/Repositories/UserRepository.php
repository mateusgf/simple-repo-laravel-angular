<?php

namespace App\Repositories;


use App\User;


class UserRepository
{

	/**
	* @var $user;
	**/
	private $user;



	public function __construct(User $user)
	{
		$this->user = $user;
	}


    public function create($data)
    {
        $user = $this->user->create($data);

        return $user;
    }

}