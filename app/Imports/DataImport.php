<?php

namespace App\Imports;

use App\ImportData;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DataImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            return new ImportData([
                'zip' => $row[0],
                'lat' => $row[1],
                'lng' => $row[2],
                'city' => $row[3],
                'state_id' => $row[4],
                'state_name' => $row[5],
                'zcta' => $row[6],
                'parent_zcta' => $row[7],
                'population' => $row[8],
                'density' => $row[9],
                'county_name' => $row[10],
                'county_weights' => $row[11],
                'county_names_all' => $row[12],
                'county_fips_all' => $row[13],
                'imprecise' => $row[14],
                'military' => $row[15],
                'timezone' => $row[16],
            ]);
        }

    }
}
