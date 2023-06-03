<?php

namespace App\Http\Controllers\Admin;

use App\Asset;
use App\Customer;
use App\Imports\AssetImport;
use App\User;
use App\UserAddress;
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
        Excel::import(new AssetImport($request->get('user_id')), $request->file('file')->store('temp'));
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
