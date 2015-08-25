<?php

namespace App\Services;


use App\Repositories\ApplicationRepository;

class ApplicationService {


    /**
     * @var $applicationRepository;
     **/
    private $applicationRepository;



    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }


    public function show($id)
    {
        /**
         * Show with business logic
         */
        return $this->applicationRepository->show($id);
    }


    public function create($data)
    {
        /**
         * Create with business logic
         */
        return $this->applicationRepository->create($data);
    }


    public function update($id, $data)
    {
        /**
         * Update with business logic
         */
        return $this->applicationRepository->update($id, $data);
    }


    public function delete($id)
    {
        /**
         * Delete with business logic
         */
        return $this->applicationRepository->delete($id);
    }

} 