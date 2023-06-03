<?php

namespace App\Imports;

use App\Asset;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class AssetImport implements ToModel
{
    protected $user_id;

    /**
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($row[0] && $row[1] && $row[2] && $row[3] && $row[4] && $row[5] && $row[6]) {
            return new Asset([
                'manufacture' => $row[1],
                'model' => $row[2],
                'asset_tag' => $row[3],
                'serial' => $row[4],
                'category' => $row[5],
                'qty' => $row[6],
                'status' => $row[7],
                'user_id' => $this->user_id
            ]);
        }
    }
}
