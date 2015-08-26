<?php

namespace App\Services;

use Validator;

use App\Repositories\ApplicationRepository;
use App\Repositories\ApplicationVersionRepository;
use App\Repositories\FileRepository;

class FileService {


    /**
     * @var $applicationVersionRepository;
     **/
    private $applicationVersionRepository;


    /**
     * @var $applicationRepository;
     **/
    private $applicationRepository;


    /**
     * @var $fileRepository;
     **/
    private $fileRepository;



    public function __construct(ApplicationRepository $applicationRepository, ApplicationVersionRepository $applicationVersionRepository, FileRepository $fileRepository)
    {
        $this->applicationRepository = $applicationRepository;
        $this->applicationVersionRepository = $applicationVersionRepository;
        $this->fileRepository = $fileRepository;
    }


    public function show($applicationId, $applicationVersionId, $id)
    {
        /**
         * Show with business logic
         */
        return $this->fileRepository->show($applicationId, $applicationVersionId, $id);
    }


    public function create($applicationId, $applicationVersionId, $data)
    {
        /**
         * Create with business logic
         */

        $validator = Validator::make($data, [
            'title' => 'required|max:255',
            'file' => 'required',
        ]);


        if ($validator->fails()) {
            return ['success' => 0, 'errors' => $validator->errors()->all()];
        }

        $data['filename'] = 'mock';

        return ['success' => 1, 'return' => $this->fileRepository->create($applicationId, $applicationVersionId, $data)];
    }


    public function delete($applicationId, $applicationVersionId, $id)
    {
        /**
         * Delete with business logic
         */
        return $this->fileRepository->delete($applicationId, $applicationVersionId, $id);
    }

} 