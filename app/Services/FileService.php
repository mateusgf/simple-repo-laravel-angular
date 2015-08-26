<?php

namespace App\Services;

use Validator;

use App\Repositories\ApplicationRepository;
use App\Repositories\ApplicationVersionRepository;
use App\Repositories\FileRepository;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
        // @TO-DO get file by hash for security

        /**
         * Show with business logic
         */
        //$fileRow = $this->fileRepository->show($applicationId, $applicationVersionId, $id);
        $fileRow = File::find($id);
        $file = Storage::disk('local')->get($fileRow->filename);

        return ['file' => $file, 'mime' => $fileRow->mime];
    }


    public function create($applicationId, $applicationVersionId, $data)
    {
        /**
         * Create with business logic
         */

        $validator = Validator::make($data, [
            'file' => 'required',
        ]);


        if ($validator->fails()) {
            return ['success' => 0, 'errors' => $validator->errors()->all()];
        }

        $extension = $data['file']->getClientOriginalExtension();
        $fileName = $data['file']->getFilename();

        Storage::disk('local')->put($fileName . '.' . $extension,  File::get($data['file']));

        $data['filename'] = $fileName . '.' . $extension;
        $data['title'] = $fileName;
        $data['mime'] = $data['file']->getClientMimeType();

        // @TO-DO: Save file with original name.

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