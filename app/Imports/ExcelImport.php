<?php

namespace App\Imports;

use App\Models\Beneficiary;
use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class ExcelImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new Beneficiary([
           'id_num'     => $row[0],
        ]);
    }
}
