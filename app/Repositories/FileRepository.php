<?php

namespace App\Repositories;

use App\ApplicationVersion;
use App\Application;
use App\File;
use App\User;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class FileRepository
{

	/**
	* @var $file;
	**/
	private $file;


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



	public function __construct(Application $application, ApplicationVersion $applicationVersion, File $file)
	{
        $this->application = $application;
		$this->applicationVersion = $applicationVersion;
        $this->file = $file;

        $this->ownerUserId = Authorizer::getResourceOwnerId();
	}


	public function all($applicationId, $applicationVersionId)
	{
        $user = User::with(['applications'])->find($this->ownerUserId);


        $app = $user->applications->find($applicationId);

        if ($app) {
            return $this->file->where('application_id', '=', $app->id)->where('application_version_id', '=', $applicationVersionId)->get();
        }

        return false;
	}


    public function show($applicationId, $applicationVersionId, $id)
    {
        $user = User::with(['applications'])->find($this->ownerUserId);
        $app = $user->applications->find($applicationId);

        if (!$app) return false;

        $version = $this->applicationVersion->where('application_id', '=', $app->id)->where('id', '=', $applicationVersionId)->first();


        if ($app && $version) {
            return $this->file->where('application_id', '=', $app->id)->where('application_version_id', '=', $version->id)->where('id', $id)->first();
        }
        return false;
    }


    public function create($applicationId, $applicationVersionId, $data)
    {
        $user = User::with(['applications'])->find($this->ownerUserId);
        $app = $user->applications->find($applicationId);

        if (!$app) return false;

        $version = $this->applicationVersion->where('application_id', '=', $app->id)->where('id', '=', $applicationVersionId)->first();

        /**
         * Create new File
         */
        $file = $this->file->create($data);

        /**
         * Associate with current application
         */
        $file->application()->associate($app);

        /**
         * Associate with current version
         */
        $file->version()->associate($version);
        $file->save();


        return $file;
    }



    public function delete($applicationId, $applicationVersionId, $id)
    {
        $user = User::with(['applications'])->find($this->ownerUserId);
        $app = $user->applications->find($applicationId);

        if (!$app) return false;


        $version = $this->applicationVersion->where('application_id', '=', $app->id)->where('id', '=', $applicationVersionId)->first();


        if ($version) {
            $file = $this->file->where('application_id', '=', $app->id)->where('application_version_id', '=', $version->id)->where('id', $id)->first();

            if ($file) {
                $file->delete();
            } else {
                throw new \Exception("Resource not found.");
            }
        } else {
            throw new \Exception("Resource not found.");
        }
    }
}