<?php

namespace App\Http\Controllers;

use App\Helpers\SearchHelper;
use App\Http\Requests\SearchByZip;
use App\Models\ImportData;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    private $searchHelper;

    public function __construct()
    {
        $this->searchHelper = app(SearchHelper::class);
    }

    public function findZip(SearchByZip $request, ImportData $data){
        $data = $this->searchHelper->findZip($request->zip);

        return response($data);
    }

    public function findCity(Request $request, ImportData $data){
        $data = $this->searchHelper->findByCity($request->city);

        return response($data);
    }
}
