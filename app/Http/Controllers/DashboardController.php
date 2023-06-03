<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Custody;
use App\Customer;
use App\DocType;
use App\Exports\AssetExport;
use App\Imports\AssetImport;
use App\Order;
use App\User;
use App\UserAddress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use Maatwebsite\Excel\Excel;
use PDF, Excel;

class DashboardController extends Controller
{
    public function home(Request $request)
    {
        $locations = \DB::table('users as u1')
            ->select('ua.address as address', 'ua.id as address_id', 'a.model')
            ->where('u1.id', \Auth::id());

        if (!Auth::user()->is_owner) {
            $locations->join('companies as c', 'c.id', 'u1.company_id')
                ->join('users as u2', 'u2.company_id', 'c.id')
                ->join('user_addresses as ua', 'ua.user_id', 'u2.id')
                ->join('assets as a', 'a.user_id', 'u2.id');
        } else {
            $locations->join('users as u2', 'u2.company_id', 'u1.company_id')
                ->join('user_addresses as ua', 'ua.user_id', 'u2.id')
                ->join('assets as a', 'a.user_id', 'u2.id');
        }

        $locations = $locations->get();

        $result['locations'] = array_values(array_unique($locations->pluck('address')->toArray()));
        $ids = array_values(array_unique($locations->pluck('address_id')->toArray()));
        $result['ids'] = $ids;
        $values = $locations->groupBy('address');
        $i = 0;
        $pie_values = $pie_colors = [];
        if (!Auth::user()->is_owner) {
            $total_orders = \DB::table('orders')->where(['order_for' => 'purchased', 'user_id' => Auth::id()])->count();
        } else {
            $total_orders = \DB::table('orders as o')->where(['o.order_for' => 'purchased', 'u.company_id' => Auth::user()->company_id])
                ->join('users as u', 'o.user_id', 'u.id')
                ->count();
        }


        if ($total_orders) {
            foreach ($ids as $id) {
                $orders = DB::table('assets as a')
                    ->where(['a.address_id' => $id])
                    ->join('orders as o', 'o.asset_id', 'a.id')
                    ->where('o.order_for', 'purchased')
                    ->join('users as u', 'u.id', 'o.user_id');
                if (Auth::user()->is_owner) {
                    $orders->where('u.company_id', Auth::user()->company_id);
                } else {
                    $orders->where('u.id', Auth::id());
                }
                $orders = $orders->count();

                $pie_values[$i] = round(($orders / $total_orders) * 100);
                $pie_colors[$i] = chart_colors();
                $i++;
            }
        }


        $result['pie_values'] = $pie_values;
        $result['pie_colors'] = $pie_colors;

        $assets = \DB::table('assets as ase')
            ->select('o.asset_id', 'ase.model')
            ->join('users as u1', 'u1.id', 'ase.user_id')
            ->join('companies as c', 'c.id', 'u1.company_id')
            ->join('users as u2', 'u2.company_id', 'c.id')
            ->join('orders as o', 'o.asset_id', 'ase.id')
            ->where(['u2.role' => 'management', 'u2.id' => \Auth::id(), 'o.order_for' => 'purchased'])
            ->get()->groupBy('model');

        if ($assets->count()) {
            $i = 0;
            foreach ($assets as $key => $asset) {
                $result['items'][$i] = $key;
                $result['colors'][$i] = chart_colors();
                $result['values'][$i] = count($asset);
                $result['ids'][$i] = $asset[0]->asset_id;
                $i++;
            }
        } else {
            $result['items'] = [];
            $result['colors'] = [];
            $result['values'] = [];
        }

        $assets = [];
        if ($request->has('location')) {
            $assets = Asset::where('address_id', $request->get('location'))->get();
        }

        $result['assets'] = $assets;

        return view('customers.pages.home')->with($result);
    }

    public function myAssets()
    {
        $asset_detail = [];
        $assets = [];
        if (\request()->has('asset_id')) {
            $asset_detail = Asset::where('id', \request()->get('asset_id'))->first();
        } else {
            $assets = DB::table('assets as a');
            if (Auth::user()->is_owner) {
                $assets->where('a.company_id', Auth::user()->company_id);
            } else {
                $assets->where('a.user_id', Auth::id());
            }
            $assets = $assets->get();
        }

        return view('customers.pages.my-assets', compact('assets', 'asset_detail'));
    }

    public function importMyAssets(Request $request) {
        Excel::import(new AssetImport, $request->file('file')->store('temp'));
        return back();
    }

    public function exportMyAssets() {
        return Excel::download(new AssetExport, 'my-assets.xlsx');
    }

    public function assetDetail($id)
    {
        $data['asset'] = Asset::where('id', $id)->with(['user', 'address'])->first();
        return view('pages.assets')->with($data);
    }

    public function reports()
    {
        $orders = DB::table('assets as a')
            ->select(
                'uad.abbreviations as loc_name',
                'o.order_date', 'o.order_for as status',
                \DB::raw('(o.price + o.tax + o.service_charges) AS total'))
            ->join('orders as o', 'o.asset_id', 'a.id')
            ->join('user_addresses as uad', 'uad.id', 'a.address_id')
            ->when(\request()->has('status') && \request()->get('status'), function ($q) {
                return $q->where('o.order_for', \request()->get('status'));
            })
            ->join('users as u', 'u.id', 'a.user_id');
        if (Auth::user()->is_owner) {
            $orders->where('u.company_id', Auth::user()->company_id);
        } else {
            $orders->where('u.id', Auth::id());
        }

        $orders = $orders->get()->groupBy('loc_name');

        $reports = [];
        $i = 0;
        foreach ($orders as $key => $order) {
            $ordersByStatues = $order->groupBy('status');
            foreach ($ordersByStatues as $status => $byStatue) {
                $reports[$i]['location'] = $key;
                $reports[$i]['total_items'] = count($byStatue);
                $reports[$i]['status'] = ucfirst($status);
                $reports[$i]['total'] = array_sum($byStatue->pluck('total')->toArray());
                $reports[$i]['dates'] = implode(', ', $byStatue->pluck('order_date')->toArray());
                $i++;
            }
        }

        $data['records'] = $reports;

        return view('customers.pages.reports')->with($data);
    }

    public function downloadReport($id) {
        $data = UserAddress::where(['abbreviations' => $id, 'user_id' => Auth::id()])
            ->with(['assets' => function ($q) {
                return $q->with('orders');
            }])
            ->with('user')
            ->first();

        $pdf = PDF::loadView('customers.report-pdf', ['data' => $data]);
        return $pdf->download($data->user->name . '_' . $data->user->company->company_nam . '.pdf');
    }

    public function verifyUser(Request $request)
    {
        $input = $request->all();
        $user = User::where('verification_code', $input['code'])->update(['is_verified' => 1, 'verification_code' => null]);
        // if ($user) {
        return redirect()->route('customer-login', ['type' => 'customer']);
        // }
    }

    public function showLogin(Request $request)
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $input = $request->except('_token');

        if (\Auth::attempt($input)) {
            if (!\Auth::user()->is_verified && \Auth::user()->role === 'management') {
                \Auth::logout();
                return redirect()->route('customer-login', ['type' => 'customer'])->with('message', 'danger=Your account is not verified, Please check your email');
            }
        } else {
            return back()->with('message', 'danger=Invalid Email or Password');
        }

        return redirect()->route('home');
    }

    public function docs()
    {
        $types = DocType::with(['docs' => function ($q) {
            $q->join('users as u', 'documents.customer_id', 'u.id');
            if (Auth::user()->is_owner) {
                $q->where('u.company_id', Auth::user()->company_id);
            } else {
                $q->where('u.id', Auth::id());
            }
        }])->latest()->get();
        $types_grouped = $types->groupBy('type');

        return view('customers.pages.docs', compact('types', 'types_grouped'));
    }

    public function myLocations()
    {
        $assets = \DB::table('assets as ast')
            ->select('uad.address', 'uad.abbreviations as loc_name', 'ast.id', 'ast.model', 'ast.manufacture')
            ->join('user_addresses as uad', 'uad.id', 'ast.address_id')
            ->join('users as u', 'u.id', 'ast.user_id');
        if (!Auth::user()->is_owner) {
            $assets->where('u.company_id', Auth::user()->company_id);
        } else {
            $assets->where('u.id', Auth::id());
        }
        $assets = $assets->get();

        return view('customers.pages.my-locations', compact('assets'));
    }

    public function orders()
    {
        $orders = DB::table('orders as o')
            ->select('o.id', 'o.price', 'o.tax', 'o.service_charges', 'c.status', 'a.model', 'a.manufacture', 'o.order_date')
            ->join('custody as c', 'c.order_id', 'o.id')
            ->join('assets as a', 'a.id', 'o.asset_id')
            ->join('users as u', 'u.id', 'o.user_id');
        if (Auth::user()->is_owner) {
            $orders->where('u.company_id', Auth::user()->company_id);
        } else {
            $orders->where('u.id', Auth::id());
        }
        $orders = $orders->get();

        $order_detail = null;
        if (\request()->has('order_id')) {
            $order_detail = DB::table('orders as o')
                ->select('o.id as order_id', 'o.price', 'o.service_charges', 'o.tax', 'o.order_date', 'a.*', 'c.*', 'c1.name as country_1',
                    'c2.name as country_2', 's1.name as state_1', 's2.name as state_2', 'ct1.name as city_1', 'ct2.name as city_2'
                )
                ->join('custody as c', 'c.order_id', 'o.id')
                ->join('assets as a', 'a.id', 'o.asset_id')
                ->join('countries as c1', 'c1.id', 'c.address_country')
                ->join('countries as c2', 'c2.id', 'c.location_country')
                ->join('states as s1', 's1.id', 'c.address_state')
                ->join('states as s2', 's2.id', 'c.location_state')
                ->join('cities as ct1', 'ct1.id', 'c.address_city')
                ->join('cities as ct2', 'ct2.id', 'c.location_city')
                ->first();
        }

        return view('customers.pages.orders', compact('orders', 'order_detail'));
    }
}
