<?php

namespace App\Imports;

use App\Models\Dispatchs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Facades\Excel;

class DispatchController implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        return $rows;
    }

    public function import() 
    {
        $data = [];

        Excel::import($data, 'users.xlsx');

        return $data;
        
    }
}
