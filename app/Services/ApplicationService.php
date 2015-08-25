<?php

namespace App\Services;

use Validator;

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

        $validator = Validator::make($data, [
            'title' => 'required|max:255',
        ]);


        if ($validator->fails()) {
            //return $validator->errors(); // errors with fields in the keys
            return ['success' => 0, 'errors' => $validator->errors()->all()];
        }

        return ['success' => 1, 'return' => $this->applicationRepository->create($data)];
    }


    public function update($id, $data)
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

        return ['success' => 1, 'return' => $this->applicationRepository->update($id, $data)];
    }


    public function delete($id)
    {
        /**
         * Delete with business logic
         */
        return $this->applicationRepository->delete($id);
    }

} 