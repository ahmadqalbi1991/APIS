<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Country;
use App\Custody;
use App\Customer;
use App\DocType;
use App\Document;
use App\Order;
use App\State;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use PhpParser\Comment\Doc;
use Mail, Helpers;

class AdminController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.pages.dashboard');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function customers()
    {
        $responses = getRZRResponse('https://api.tst.razorerp.com/api/v1/Customer/all', 'GET');
        $responses = json_decode($responses);
        $items = [];
        foreach ($responses as $key => $response) {
            if ($key === 'items') {
                $items = $response;
            }
        }

        $items = collect($items)->count();
        $customers = Customer::with('user')->latest()->get();

        return view('admin.pages.customers', compact('customers', 'items'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importContacts()
    {
        $responses = getRZRResponse('https://api.tst.razorerp.com/api/v1/Customer/all', 'GET');
        $responses = json_decode($responses);
        $items = [];
        foreach ($responses as $key => $response) {
            if ($key === 'items') {
                $items = $response;
            }
        }

        $items = collect($items);
        $customers = $items;
        foreach ($customers as $customer) {
            $exist_customer = Customer::where('rzr_id', $customer->id)->first();
            if (!$exist_customer) {
                $customer_array['rzr_id'] = $customer->id;
                $customer_array['name'] = $customer->name;
                $customer_array['email'] = null;

                $customer_success = Customer::create($customer_array);
                if ($customer_success) {
                    $random_password = Str::random(16);
                    $user_array['name'] = $customer->name;
                    $user_array['email'] = 'dummy@mail.com' . $customer->id;
                    $user_array['password'] = bcrypt($random_password);
                    $user_array['local_key'] = $random_password;
                    $user_array['is_verified'] = 0;
                    $user_array['email_sent'] = 0;
                    $user_array['role'] = 'customer';
                    $user_array['is_admin'] = 0;
                    $user_array['customer_id'] = $customer_success->id;

                    User::create($user_array);
                }
            }
        }

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function chainOfCustody(Request $request)
    {
        $input = $request->all();
        $custodies = Custody::all();
        $custody_detail = null;
        if (isset($input['custody_id'])) {
            $custody_detail = Custody::with('country1', 'state1', 'city1', 'country2', 'state2', 'city2')->where('id', $input['custody_id'])->first();
        }

        return view('admin.pages.chain_of_custody', compact('custodies', 'custody_detail'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editChainOfCustody($id)
    {
        $countries = Country::all();
        $orders = Order::latest()->get();
        $customers = User::where(['role' => 'customer', 'is_verified' => 1, 'is_admin' => 0])->get();
        $custody = Custody::findOrFail($id);
        $address_states = State::where('country_id', $custody->address_country)->get();
        $states_ids = $address_states->pluck('id')->toArray();
        $address_cities = City::whereIn('state_id', $states_ids)->get();
        $location_states = State::where('country_id', $custody->location_country)->get();
        $states_ids = $location_states->pluck('id')->toArray();
        $location_cities = City::whereIn('state_id', $states_ids)->get();

        return view('admin.pages.edit_custody', compact('countries', 'orders', 'customers', 'custody', 'address_states', 'address_cities', 'location_states', 'location_cities'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addChainOfCustody()
    {
        $countries = Country::all();
        $orders = Order::latest()->get();
        $customers = User::with('company')->where(['role' => 'management', 'is_verified' => 1, 'is_admin' => 0])->get();

        return view('admin.pages.add_custody', compact('countries', 'orders', 'customers'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCustody(Request $request)
    {
        $input = $request->except('_token');
        $input['start_date'] = Carbon::parse($input['start_date'])->format('Y-m-d h:i');
        $input['change_date'] = Carbon::parse($input['change_date'])->format('Y-m-d h:i');

        Custody::create($input);

        return redirect()->route('admin.chainOfCustody')->with('message', 'success=custody added');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCustody($id, Request $request)
    {
        $input = $request->except('_token');
        $input['start_date'] = Carbon::parse($input['start_date'])->format('Y-m-d h:i');
        $input['change_date'] = Carbon::parse($input['change_date'])->format('Y-m-d h:i');

        Custody::where('id', $id)->update($input);

        return redirect()->route('admin.chainOfCustody')->with('message', 'success=custody updated');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function deleteChainOfCustody($id)
    {
        Custody::where('id', $id)->delete();

        return back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function docTypes()
    {
        $types = DocType::latest()->get();

        return view('admin.pages.doc-types', compact('types'));
    }

    public function editDocTypes($id)
    {
        $type = DocType::findOrFail($id);

        return view('admin.pages.edit-doc-type', compact('type'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveDocType(Request $request)
    {
        $input = $request->except('_token');
        DocType::create($input);

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDocType(Request $request, $id)
    {
        $input = $request->except('_token');
        DocType::where('id', $id)->update($input);

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDocTypes($id)
    {
        $type = DocType::where('id', $id)->first();
        $type->docs()->delete();
        $type->delete();

        return back();
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function docs()
    {
        $types = DocType::with('docs')->latest()->get();
        $types_grouped = $types->groupBy('type');
        $customers = User::where(['role' => 'management', 'is_verified' => 1])->get();

        return view('admin.pages.docs', compact('types', 'types_grouped', 'customers'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveDoc(Request $request)
    {
        $input = $request->except('_token');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $destnation = public_path() . '/files';
            $file->move($destnation, $file->getClientOriginalName());
            $input['file'] = $file->getClientOriginalName();
        }

        Document::create($input);

        return back();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDoc(Request $request, $id)
    {
        $input = $request->except('_token');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $destnation = public_path() . '/files';
            $file->move($destnation, $file->getClientOriginalName());
            $input['file'] = $file->getClientOriginalName();
        }

        Document::where('id', $id)->update($input);

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDoc($id)
    {
        Document::where('id', $id)->delete();

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editDocs($id)
    {
        $doc = Document::findOrFail($id);
        $types = DocType::with('docs')->latest()->get();
        $types_grouped = $types->groupBy('type');
        $customers = User::where(['role' => 'management'])->get();

        return view('admin.pages.edit-doc', compact('types', 'types_grouped', 'customers', 'doc'));
    }

    public function updateCustomerEmail(Request $request)
    {
        $input = $request->except('_token');
        $customer_success = Customer::where('id', $input['customer_id'])->update(['email' => $input['email']]);
        $customer = Customer::find($input['customer_id']);
        if ($customer_success) {
            $verification_code = base64_encode(Str::random(16)) . '_' . $input['customer_id'];
            $random_password = Str::random(8);
            $user['email'] = $input['email'];
            $user['password'] = bcrypt($random_password);
            $user['local_key'] = $random_password;
            $user['email_sent'] = 1;
            $user['is_verified'] = 0;
            $user['verification_code'] = $verification_code;

            User::where('customer_id', $input['customer_id'])->update($user);

            $data['email'] = $input['email'];
            $data['password'] = $random_password;
            $data['name'] = $customer->name;
            $data['url'] = route('verifyUser', ['code' => $verification_code]);

            Mail::send('admin.pages.customer_add_email', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['name'])
                    ->subject('Profile Created');
                $message->from('Support@mail.com', 'Customer care center');
            });
        }

        return back()->with('message', 'success=Email is set and password is sent to customer');
    }

    public function generateRandomDocNumber($id)
    {
        $type = DocType::findOrFail($id);
        return implode('', array_diff_assoc(str_split(ucwords($type->type)), str_split(strtolower($type->type)))) . '_' . time();
    }
}
