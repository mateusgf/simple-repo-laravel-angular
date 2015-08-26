<?php

namespace App\Repositories;

use App\ApplicationVersion;
use App\Application;
use App\User;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ApplicationVersionRepository
{

	/**
	* @var $applicationVersion;
	**/
	private $applicationVersion;


    /**
     * @var $application;
     **/
    private $application;


    /**
     * @var $ownerUserId;
     **/
    private $ownerUserId;



	public function __construct(Application $application, ApplicationVersion $applicationVersion)
	{
        $this->application = $application;
		$this->applicationVersion = $applicationVersion;

        $this->ownerUserId = Authorizer::getResourceOwnerId();
	}


    public function getLatestRelease()
    {
        //@TO-DO
    }


	public function all($applicationId)
	{
        $user = User::find($this->ownerUserId);


        $app = $user->applications->find($applicationId);

        if ($app) {
            return $this->applicationVersion->where('application_id', '=', $app->id)->get();
        }

        return false;
	}


    public function show($applicationId, $id)
    {
        $user = User::with(['applications', 'applications.versions'])->find($this->ownerUserId);

        $app = $user->applications->find($applicationId);

        if ($app) {
            return $this->applicationVersion->where('application_id', '=', $app->id)->where('id', $id)->first();
        }
        return false;
    }


    public function create($applicationId, $data)
    {
        $user = User::with(['applications'])->find($this->ownerUserId);
        $app = $user->applications->find($applicationId);

        /**
         * Create new Version
         */
        $version = $this->applicationVersion->create($data);

        /**
         * Associate with current application
         */
        $version->application()->associate($app);
        $version->save();


        return $version;
    }


    public function update($applicationId, $id, $data)
    {
        $user = User::with(['applications'])->find($this->ownerUserId);
        $app = $user->applications->find($applicationId);

        if ($app) {
            $version = $this->applicationVersion->where('application_id', '=', $app->id)->where('id', $id)->first();
        }

        $version->title = $data['title'];
        $version->update();

        return $version;
    }


    public function delete($applicationId, $id)
    {
        $user = User::with(['applications'])->find($this->ownerUserId);
        $app = $user->applications->find($applicationId);

        if ($app) {
            $version = $this->applicationVersion->where('application_id', '=', $app->id)->where('id', $id)->first();

            if($version) {
                $version->delete();
            } else {
                throw new \Exception("Resource not found.");
            }

        } else {
            throw new \Exception("Resource not found.");
        }
    }
}