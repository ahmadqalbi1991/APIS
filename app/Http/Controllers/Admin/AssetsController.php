<?php

namespace App\Http\Controllers\Admin;

use App\Asset;
use App\Customer;
use App\Imports\AssetImport;
use App\User;
use App\UserAddress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;

class AssetsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $assets = Asset::with('user')->whereHas('user')->get();
        $asset_detail = Asset::where('id', $request->get('id'))->with(['user', 'address'])->first();
        $customers = User::where(['is_verified' => 1, 'is_admin' => 0, 'role' => 'management'])->get();

        return view('admin.pages.assets.index', compact('assets', 'asset_detail', 'customers'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importAssets(Request $request) {
        $collection = Excel::toArray(new AssetImport(), $request->file('file')->store('temp'));
        $items = $collection[0];
        $assets = [];
        foreach ($items as $item) {
            if ($item[0] !== 'Date Time' && $item[0] !== 'Audit Report' && $item[0]) {
                $assets[] = [
                    'manufacture' => $item[2],
                    'model' => $item[1],
                    'cpu_manufacture' => $item[3],
                    'asset_tag' => $item[9],
                    'serial' => $item[6],
                    'category' => $item[12],
                    'qty' => $item[13],
                    'status' => $item[14],
                    'user_id' => $request->get('user_id'),
                    'memory_capacity' => $item[4],
                    'hard_drive_capacity' => $item[5],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
        }
        Asset::insert($assets);
        return back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        $customers = User::where(['is_verified' => 1, 'is_admin' => 0, 'role' => 'management'])->get();
        return view('admin.pages.assets.create', compact('customers'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        $input = $request->except('_token');
        $input['server_rack'] = isset($input['server_rack']) && $input['server_rack'] ? $input['server_rack'] : 'no';
        $company_id = User::where('id', $input['user_id'])->first();
        if ($company_id) {
            $input['company_id'] = $company_id;
        }
        Asset::create($input);

        return redirect()->route('admin.assets.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
        $asset = Asset::findOrFail($id);
        $customers = User::with('company')->where(['is_verified' => 1, 'is_admin' => 0, 'role' => 'management'])->get();
        $addresses = UserAddress::all();

        return view('admin.pages.assets.edit', compact('customers', 'addresses', 'asset'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id) {
        $input = $request->except('_token');
        $asset = Asset::find($id);
        $company_id = User::where('id', $asset->user_id)->first();
        if ($company_id) {
            $input['company_id'] = $company_id->company_id;
        }
        Asset::where('id', $id)->update($input);

        return back();
    }

    public function delete($id) {
        Asset::where('id', $id)->delete();

        return redirect()->route('admin.assets.index');
    }
}
