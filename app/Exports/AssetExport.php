<?php

namespace App\Exports;

use App\Asset;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class AssetExport implements FromCollection
{
    /**
    * @return array
     */
    public function collection()
    {
        $assets = Asset::where('user_id', Auth::id())->get();
        $assetsCSV = [];
        $assetsCSV[0][0] = 'Manufacture';
        $assetsCSV[0][1] = 'Model';
        $assetsCSV[0][2] = 'Asset Tag';
        $assetsCSV[0][3] = 'Serial Number';
        $assetsCSV[0][4] = 'Category';
        $assetsCSV[0][5] = 'Quantity';
        $assetsCSV[0][6] = 'Status';
        $i = 1;

        foreach ($assets as $key => $asset) {
            $assetsCSV[$i][0] = $asset->manufacture;
            $assetsCSV[$i][1] = $asset->model;
            $assetsCSV[$i][2] = $asset->asset_tag;
            $assetsCSV[$i][3] = $asset->serial;
            $assetsCSV[$i][4] = $asset->category;
            $assetsCSV[$i][5] = 1;
            $assetsCSV[$i][6] = $asset->status;
            $i++;
        }

        return collect($assetsCSV);
    }
}
