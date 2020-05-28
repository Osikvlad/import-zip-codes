<?php


namespace App\Helpers;

use App\Models\ImportData;
use Illuminate\Support\Facades\Storage;

class ImportHelper
{
    protected $importData;

    /**
     * ImportHelper constructor.
     * @param ImportData $importData
     */
    public function __construct(ImportData $importData)
    {
        $this->importData = $importData;
    }

    /**
     * @return ImportData[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getData()
    {
        $data = $this->importData->all();

        return $data;
    }

    public function getFileName($request)
    {
        $file = $request['file'];
        $fileOriginalName = $file->getClientOriginalName();
        $path = $file->storeAs('import_files', $fileOriginalName);
        $fileName = Storage::path($path);

        return $fileName;
    }

    public function CsvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    public function import($fileName)
    {
        $customerArr = $this->csvToArray($fileName);
        for ($i = 0; $i < count($customerArr); $i++) {
            ImportData::updateOrCreate([
                'zip' => $customerArr[$i]['zip']
            ],
                [
                    'lat' => $customerArr[$i]['lat'],
                    'lng' => $customerArr[$i]['lng'],
                    'city' => $customerArr[$i]['city'],
                    'state_id' => $customerArr[$i]['state_id'],
                    'state_name' => $customerArr[$i]['state_name'],
                    'zcta' => $customerArr[$i]['zcta'],
                    'parent_zcta' => $customerArr[$i]['parent_zcta'],
                    'population' => $customerArr[$i]['population'],
                    'density' => $customerArr[$i]['density'],
                    'county_fips' => $customerArr[$i]['county_fips'],
                    'county_name' => $customerArr[$i]['county_name'],
                    'county_weights' => $customerArr[$i]['county_weights'],
                    'county_names_all' => $customerArr[$i]['county_names_all'],
                    'county_fips_all' => $customerArr[$i]['county_fips_all'],
                    'imprecise' => $customerArr[$i]['imprecise'],
                    'military' => $customerArr[$i]['military'],
                    'timezone' => $customerArr[$i]['timezone'],
                ]);

        }
    }
}
