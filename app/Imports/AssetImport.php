<?php

namespace App\Imports;

use App\Asset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class AssetImport implements ToModel
{
    protected $user_id;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (($row[0] && $row[1] && $row[2] && $row[3] && $row[4] && $row[5] && $row[6] && $row[7] && $row[8] && $row[9]
            && $row[10] && $row[11] && $row[12] && $row[13] && $row[14] && $row[15])) {
                return new Asset([
                    'manufacture' => $row[2],
                    'model' => $row[1],
                    'cpu_manufacture' => $row[3],
                    'asset_tag' => $row[9],
                    'serial' => $row[6],
                    'category' => $row[12],
                    'qty' => $row[13],
                    'status' => $row[14],
                    'user_id' => 38,
                    'memory_capacity' => $row[4],
                    'hard_drive_capacity' => $row[5]
                ]);
        }
    }
}
