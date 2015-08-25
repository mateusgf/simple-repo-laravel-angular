<?php

namespace App\Http\Controllers;

use App\Services\ApplicationService;
use Illuminate\Http\Request;
use App\Repositories\ApplicationRepository;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{

    /**
    * @var $applicationRepository;
    **/
    private $applicationRepository;


    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $apps = $this->applicationRepository->allWithVersions();
        return response()->json($apps);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, ApplicationService $applicationService)
    {
        $app = $applicationService->create($request->only('title'));
        return response()->json($app);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(ApplicationService $applicationService, $id)
    {
        $app = $applicationService->show($id);
        return response()->json($app);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, ApplicationService $applicationService, $id)
    {
        $app = $applicationService->update($id, $request->only('title'));
        return response()->json($app);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(ApplicationService $applicationService, $id)
    {
        $applicationService->delete($id);
    }
}
