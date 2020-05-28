<?php


namespace App\Helpers;

use App\Models\ImportData;

class SearchHelper
{
    private $importData;

    /**
     * SearchHelper constructor.
     * @param ImportData $importData
     */
    public function __construct(ImportData $importData)
    {
        $this->importData = $importData;
    }

    /**
     * @param $zip
     * @return mixed
     */
    public function findZip($zip)
    {
        $data = $this->importData->where('zip', $zip)->get();

        return $data;

    }

    /**
     * @param $city
     * @return mixed
     */
    public function findByCity($city)
    {
        $data = $this->importData->where('city', 'like', '%' . $city . '%')->get();

        return $data;
    }
}
