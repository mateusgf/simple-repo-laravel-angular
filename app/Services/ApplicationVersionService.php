<?php

namespace App\Services;

use Validator;

use App\Repositories\ApplicationRepository;
use App\Repositories\ApplicationVersionRepository;

class ApplicationVersionService {


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


    public function show($applicationId, $id)
    {
        /**
         * Show with business logic
         */
        return $this->applicationVersionRepository->show($applicationId, $id);
    }


    public function create($applicationId, $data)
    {
        /**
         * Create with business logic
         */

        $validator = Validator::make($data, [
            'title' => 'required|max:255',
        ]);


        if ($validator->fails()) {
            return ['success' => 0, 'errors' => $validator->errors()->all()];
        }

        return ['success' => 1, 'return' => $this->applicationVersionRepository->create($applicationId, $data)];
    }


    public function update($applicationId, $id, $data)
    {
        /**
         * Update with business logic
         */

        $validator = Validator::make($data, [
            'title' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return ['success' => 0, 'errors' => $validator->errors()->all()];
        }

        return ['success' => 1, 'return' => $this->applicationVersionRepository->update($applicationId, $id, $data)];
    }


    public function delete($applicationId, $id)
    {
        /**
         * Delete with business logic
         */
        return $this->applicationVersionRepository->delete($applicationId, $id);
    }

} 