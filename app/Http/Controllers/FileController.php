<?php

namespace App\Http\Controllers;

use App\Application;
use App\ApplicationVersion;
use App\File;
use App\Services\FileService;

use Illuminate\Http\Request;
use App\Repositories\ApplicationVersionRepository;
use App\Repositories\FileRepository;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FileController extends Controller
{

    /**
    * @var $applicationVersionRepository;
    **/
    private $applicationVersionRepository;

    /**
     * @var $applicationRepository;
     **/
    private $fileRepository;



    public function __construct(ApplicationVersionRepository $applicationVersionRepository, FileRepository $fileRepository)
    {
        $this->applicationVersionRepository = $applicationVersionRepository;
        $this->fileRepository = $fileRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($applicationId, $applicationVersionId)
    {
        $files = $this->fileRepository->all($applicationId, $applicationVersionId);
        return response()->json($files);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, FileService $fileService, $applicationId, $applicationVersionId)
    {
        $file = $fileService->create($applicationId, $applicationVersionId, $request->only('title'));
        return response()->json($file);
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
