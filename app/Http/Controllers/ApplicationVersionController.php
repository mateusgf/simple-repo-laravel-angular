<?php

namespace App\Http\Controllers;

use App\Application;
use App\Services\ApplicationVersionService;
use Illuminate\Http\Request;
use App\Repositories\ApplicationRepository;
use App\Repositories\ApplicationVersionRepository;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApplicationVersionController extends Controller
{

    /**
    * @var $applicationVersionRepository;
    **/
    private $applicationVersionRepository;

    /**
     * @var $applicationRepository;
     **/
    private $applicationRepository;



    public function __construct(ApplicationRepository $applicationRepository, ApplicationVersionRepository $applicationVersionRepository)
    {
        $this->applicationRepository = $applicationRepository;
        $this->applicationVersionRepository = $applicationVersionRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($applicationId)
    {
        $versions = $this->applicationVersionRepository->all($applicationId);
        return response()->json($versions);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, ApplicationVersionService $applicationVersionService, $applicationId)
    {
        $version = $applicationVersionService->create($applicationId, $request->only('title'));
        return response()->json($version);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(ApplicationVersionService $applicationVersionService, $applicationId, $id)
    {
        $version = $applicationVersionService->show($applicationId, $id);
        return response()->json($version);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, ApplicationVersionService $applicationVersionService, $applicationId, $id)
    {
        $version = $applicationVersionService->update($applicationId, $id, $request->only('title'));
        return response()->json($version);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(ApplicationVersionService $applicationVersionService, $applicationId, $id)
    {
        $applicationVersionService->delete($applicationId, $id);
    }
}
