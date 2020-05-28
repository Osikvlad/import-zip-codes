<?php

namespace App\Http\Controllers;

use App\Helpers\ImportHelper;
use App\Http\Requests\ImportCsvRequest;
use App\Jobs\ImportFromCsvJob;
use App\Models\ImportData;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    private $importHelper;

    public function __construct()
    {
        $this->importHelper = app(ImportHelper::class);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->importHelper->getData();
        return response($data);
    }

    /**
     * @param ImportCsvRequest $request
     * @return string
     */
    public function import(ImportCsvRequest $request)
    {
        $fileName = $this->importHelper->getFileName($request->all());
        $job = new ImportFromCsvJob($fileName);
        $this->dispatch($job);
        return 'Файл успешно загружен, задание в очереди. Выполните "php artisan queue:work" в консоли, для загрузки данных из файла.';

    }
}
