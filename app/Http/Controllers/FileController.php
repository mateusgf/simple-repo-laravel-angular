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
        $file = $fileService->create($applicationId, $applicationVersionId, $request->only('title', 'file'));
        return response()->json($file);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(FileService $fileService, $applicationId, $applicationVersionId, $id)
    {
        $file = $fileService->show($applicationId, $applicationVersionId, $id);
        return response()->json($file);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(FileService $fileService, $applicationId, $applicationVersionId, $id)
    {
        $fileService->delete($applicationId, $applicationVersionId, $id);
    }
}
