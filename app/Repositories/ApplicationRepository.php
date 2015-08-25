<?php

namespace App\Repositories;

use App\Application;
use App\User;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ApplicationRepository
{

	/**
	* @var $application;
	**/
	private $application;


    /**
     * @var $ownerUserId;
     **/
    private $ownerUserId;


	public function __construct(Application $application)
	{
		$this->application = $application;
        $this->ownerUserId = Authorizer::getResourceOwnerId();
	}


    public function allWithVersions()
    {
        $user = User::with(['applications', 'applications.versions'])->find($this->ownerUserId);

        return $user->applications;

        //return $this->application->with(['versions'])->get();
    }


	public function all()
	{
        $user = User::find($this->ownerUserId);

        return $user->applications;
	}


    public function show($id)
    {
        $user = User::with(['applications', 'applications.versions'])->find($this->ownerUserId);

        $app = $user->applications->find($id);

        return $app;
    }


    public function create($data)
    {
        $app = $this->application->create($data);

        $user = User::find($this->ownerUserId);

        $user->applications()->attach($app->id);

        return $app;
    }


    public function update($id, $data)
    {
        $user = User::find($this->ownerUserId);

        $app = $user->applications->find($id);
        $app->title = $data['title'];
        $app->update();

        return $app;
    }


    public function delete($id)
    {
        $user = User::find($this->ownerUserId);

        $app = $user->applications->find($id);

        if($app) {
            $app->delete();
        } else {
            throw new \Exception("Resource not found.");
        }
    }
}