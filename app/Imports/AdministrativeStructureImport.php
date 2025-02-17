<?php

namespace App\Imports;

use App\Models\AdministrativeStructure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdministrativeStructureImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AdministrativeStructure([
         
            'text'     => $row['text'],
            'parent_id'    => $row['parent_id'],
            'rank'    => $row['rank'],
            'type_branch'    => $row['type_branch'],
            'status'    => $row['status'],


        ]);
    }
}
