<?php

namespace App\Repositories;

use App\Application;

class ApplicationRepository
{

	/**
	* @var $application;
	**/
	private $application;



	public function __construct(Application $application)
	{
		$this->application = $application;
	}


    public function allWithVersions()
    {
        return $this->application->with(['versions'])->get();
    }


	public function all()
	{
		return $this->application->all();
	}


    public function show($id)
    {
        $app = $this->application->with(['versions'])->find($id);

        return $app;
    }


    public function create($data)
    {
        $app = $this->application->create($data);

        return $app;
    }


    public function update($id, $data)
    {
        $app = $this->application->find($id);
        $app->title = $data['title'];
        $app->update();

        return $app;
    }


    public function delete($id)
    {
        $app = $this->application->find($id);
        $app->delete();
    }
}