<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Country;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Mail;

class CustomerController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $customers = Company::whereHas('users')->get();
        return view('admin.pages.customers.customers', compact('customers'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $countries = Country::all();
        return view('admin.pages.customers.add', compact('countries'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $input = $request->except('_token');
        $company = $input['company'];
        $countries = Country::all();
        $company_result = Company::create($company);
        if ($company_result) {
            $users = $input['user'];
            foreach ($users as $key => $user) {
                $exists = User::where('email', $user['email'])->first();
                if ($exists) {
                    $message = 'danger=User Email already registered';
                    return view('admin.pages.customers.add', compact('countries','message'));
                }
                $random_password = Str::random(16);
                $user_array['name'] = $user['name'];
                $user_array['email'] = $user['email'];
                $user_array['password'] = bcrypt($random_password);
                $user_array['local_key'] = $random_password;
                $user_array['is_verified'] = 0;
                $user_array['is_active'] = 1;
                $user_array['email_sent'] = 1;
                $user_array['role'] = 'management';
                $user_array['is_admin'] = 0;
                $user_array['customer_id'] = null;
                $user_array['company_id'] = $company_result->id;
                $user_array['code'] = $user['code'];
                $user_array['number'] = $user['number'];
                $user_array['is_owner'] = !empty($user['is_owner']) ? 1 : 0;
                $user_result = User::create($user_array);
                if ($user_result) {
                    $address = $user['address'];
                    $acronym = implode('', array_diff_assoc(str_split(ucwords($address['address'])), str_split(strtolower($address['address']))));
                    $address_obj['abbreviations'] = $address['country_id'] . '-' . $acronym;
                    $address_obj['user_id'] = $user_result->id;
                    $address_obj['country_code'] = $address['country_id'];
                    $address_obj['address'] = $address['address'];
                    \DB::table('user_addresses')->insert($address_obj);

                    $verification_code = base64_encode(Str::random(16)) . '_' . $user_result->id;
                    $user_result->verification_code = $verification_code;
                    $user_result->save();
                    $data['email'] = $user['email'];
                    $data['password'] = $random_password;
                    $data['name'] = $user['name'];
                    $data['url'] = route('verifyUser', ['code' => $verification_code]);

                    Mail::send('admin.pages.customer_add_email', $data, function ($message) use ($data) {
                        $message->to($data['email'], $data['name'])
                            ->subject('Profile Created');
                        $message->from('Support@mail.com', 'Customer care center');
                    });
                }
            }
        }

        return redirect()->route('admin.customers.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
        $countries = Country::all();
        $company = Company::where('id', $id)->with('users')->first();
        return view('admin.pages.customers.edit', compact('countries', 'company'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id) {
        $input = $request->except('_token');
        $company = Company::where('id', $id)->update($input['company']);
        if ($company) {
            $users = $input['user'];
            foreach ($users as $user) {
                $user['is_owner'] = !empty($user['is_owner']) ? 1 : 0;
                if (!isset($user['id'])) {
                    $random_password = Str::random(16);
                    $user_array['name'] = $user['name'];
                    $user_array['email'] = $user['email'];
                    $user_array['password'] = bcrypt($random_password);
                    $user_array['local_key'] = $random_password;
                    $user_array['is_verified'] = 0;
                    $user_array['email_sent'] = 1;
                    $user_array['role'] = 'management';
                    $user_array['is_admin'] = 0;
                    $user_array['customer_id'] = null;
                    $user_array['company_id'] = $id;
                    $user_array['code'] = $user['code'];
                    $user_array['number'] = $user['number'];
                    $user_result = User::create($user_array);
                    if ($user_result) {
                        $address = $user['address'];
                        $acronym = implode('', array_diff_assoc(str_split(ucwords($address['address'])), str_split(strtolower($address['address']))));
                        $address_obj['abbreviations'] = $address['country_id'] . '-' . $acronym;
                        $address_obj['user_id'] = $user_result->id;
                        $address_obj['country_code'] = $address['country_id'];
                        $address_obj['address'] = $address['address'];
                        \DB::table('user_addresses')->insert($address_obj);
                    }

                    $verification_code = base64_encode(Str::random(16)) . '_' . $user_result->id;
                    $user_result->verification_code = $verification_code;
                    $user_result->save();
                    $data['email'] = $user['email'];
                    $data['password'] = $random_password;
                    $data['name'] = $user['name'];
                    $data['url'] = route('verifyUser', ['code' => $verification_code]);

                    Mail::send('admin.pages.customer_add_email', $data, function ($message) use ($data) {
                        $message->to($data['email'], $data['name'])
                            ->subject('Profile Created');
                        $message->from('Support@mail.com', 'Customer care center');
                    });

                } else if (isset($user['id'])) {
                    $exist_user = User::findOrFail($user['id']);
                    $address = $user['address'];
                    unset($user['address']);
                    User::where('id', $user['id'])->update($user);
                    $exist_user->address()->delete();
                    $acronym = implode('', array_diff_assoc(str_split(ucwords($address['address'])), str_split(strtolower($address['address']))));
                    $address_obj['abbreviations'] = $address['country_id'] . '-' . $acronym;
                    $address_obj['user_id'] = $user['id'];
                    $address_obj['country_code'] = $address['country_id'];
                    $address_obj['address'] = $address['address'];
                    \DB::table('user_addresses')->insert($address_obj);
                }
            }
        }

        return back();
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getAddresses(Request $request)
    {
        $id = $request->get('customer_id');
        $user = User::findOrFail($id);
        $html = '';
        $html .= '<option value="">Select Address</option>';
        $html .= '<option value="' . $user->address->id . '">' . $user->address->abbreviations . '(' . $user->address->address . ')</option>';
//        foreach ($user->company->users as $company_user) {
//            $html .= '<option value="' . $company_user->address->id . '">' . $company_user->address->abbreviations . '(' . $company_user->address->address . ')</option>';
//        }

        return $html;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id) {
        $user = User::where('id', $id)->first();
        $users = $user->company->users;
        foreach ($users as $company_user) {
            $company_user->address()->delete();
        }
        $user->company->users()->delete();
        $user->company()->delete();
        $user->address()->delete();
        $user->delete();

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCompany($id) {
        $company = Company::where('id', $id)->first();
        $users = $company->users;
        foreach ($users as $company_user) {
            $company_user->address()->delete();
        }
        $company->users()->delete();
        $company->delete();

        return back();
    }

    /**
     *
     */
    public function sendEmail($id) {
        $random_password = Str::random(16);
        $customer = User::findOrFail($id);
        $customer->local_key = $random_password;
        $customer->password = bcrypt($random_password);
        $customer->save();
        $verification_code = base64_encode(Str::random(16)) . '_' . $customer->id;
        $customer->verification_code = $verification_code;
        $customer->save();
        $data['email'] = $customer->email;
        $data['password'] = $random_password;
        $data['name'] = $customer->company_name;
        $data['url'] = route('verifyUser', ['code' => $verification_code]);

        Mail::send('admin.pages.customer_add_email', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['name'])
                ->subject('Profile Created');
            $message->from('Support@mail.com', 'Customer care center');
        });

        return back();
    }
}
