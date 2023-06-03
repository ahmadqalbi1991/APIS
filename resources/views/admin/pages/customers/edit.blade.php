@extends('admin.main')
@section('content')
    <div class="content-wrapper">
        <form action="{{ route('admin.customers.update', ['id' => $company->id]) }}" method="post">
            <div class="card">
                <div class="card-header">
                    <h5>Add Customer(s)</h5>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Company Name</label>
                                <input type="text" name="company[company_name]" value="{{ $company->company_name }}"
                                       id="name" class="form-control">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>Customers <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary"
                                                               id="add-more-address">Add More</a></span></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12" id="address-div">
                            @php $key = 0 @endphp
                            @foreach($company->users as $key => $user)
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <a href="{{ route('admin.customers.delete', ['id' => $user->id]) }}"
                                           class="text-danger"><i class="fa fa-trash"></i></a>
                                        <input type="hidden" name="user[{{ $key }}][id]" value="{{ $user->id }}">
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input type="text" class="form-control" value="{{ $user->name }}"
                                                   name="user[{{ $key }}][name]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="email" class="form-control" value="{{ $user->email }}"
                                                   name="user[{{ $key }}][email]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Contact Number</label>
                                            <div class="row">
                                                <div class="col-3">
                                                    <select name="user[{{ $key }}][code]" id=""
                                                            class="select2 form-control">
                                                        <option value="">Select Code</option>
                                                        @foreach($countries as $country)
                                                            <option
                                                                @if ($user->code == $country->phonecode) selected @endif
                                                            value="{{ $country->phonecode }}">
                                                                +{{ $country->phonecode }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" name="user[{{ $key }}][number]"
                                                           value="{{ $user->number }}" id="name"
                                                           class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Country</label>
                                            <select name="user[{{ $key }}][address][country_id]" id=""
                                                    class="select2 form-control">
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                    <option
                                                        @if($country->code === $user->address->country_code) selected
                                                        @endif value="{{ $country->code }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Address</label>
                                            <input type="text" value="{{ $user->address->address }}"
                                                   name="user[{{ $key }}][address][address]" id=""
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">
                                                        <input type="checkbox" @if ($user->is_owner) checked
                                                               @endif name="user[{{ $key }}][is_owner]" id=""
                                                               class="owners_checkbox form-control">
                                                        Is Owner
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6 text-right">
                                                <a class="btn btn-primary" href="{{ route('admin.send-email', ['id' => $user->id]) }}">Resend Email</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            let i = "{{$key}}";
            $("#add-more-address").on("click", function () {
                i++;
                let html = '<div class="row">' +
                    '<div class="col-6">' +
                    '<div class="form-group">' +
                    '<label for="">Name</label>' +
                    '<input type="text" class="form-control" name="user[' + i + '][name]">' +
                    '</div>' +
                    '</div>' +
                    ' <div class="col-6">' +
                    '<div class="form-group">' +
                    '<label for="">Email</label>' +
                    '<input type="email" class="form-control" name="user[' + i + '][email]">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    ' <div class="form-group">' +
                    '<label for="">Company Contact Number</label>' +
                    '<div class="row">' +
                    '<div class="col-3">' +
                    '<select name="user[' + i + '][code]" id="" class="select2 form-control">' +
                    '<option value="">Select Code</option>' +
                    @foreach($countries as $country)
                        '<option value="{{ $country->phonecode }}">+{{ $country->phonecode }}</option>' +
                    @endforeach
                        '</select>' +
                    '</div>' +
                    '<div class="col-9">' +
                    '<input type="text" name="user[' + i + '][number]" id="name" class="form-control">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-6">' +
                    '<div class="form-group">' +
                    '<label for="">Country</label>' +
                    '<select name="user[' + i + '][address][country_id]" id="" class="select2 form-control">' +
                    '<option value="">Select Country</option>' +
                    @foreach($countries as $country)
                        '<option value="{{ $country->code }}">{{ $country->name }}</option>' +
                    @endforeach
                        '</select>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-6">' +
                    '<div class="form-group">' +
                    '<label for="">Address</label>' +
                    '<input type="text" name="user[' + i + '][address][address]" id="" class="form-control">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-6">' +
                    '<div class="form-group">' +
                    '<label for="">' +
                    '<input type="checkbox" name="user[' + i + '][is_owner]" id="" class="owners_checkbox form-control"> Is Owner' +
                    ' </label>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                $("#address-div").append(html);
                $(".select2").select2();
            })
        </script>
    @endpush
@endsection
