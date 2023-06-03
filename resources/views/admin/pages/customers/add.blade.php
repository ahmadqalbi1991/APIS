@extends('admin.main')
@section('content')
    <div class="content-wrapper">
        @if(!empty($message))
            @php
                $exploded_message = explode('=', $message);
            @endphp
            <div class="alert alert-{{ $exploded_message[0] }}">
                {{ $exploded_message[1] }}
            </div>
        @endif
        <form action="{{ route('admin.customers.save') }}" method="post">
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
                                <input type="text" name="company[company_name]" id="name" class="form-control">
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
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Owner name</label>
                                        <input type="text" class="form-control" name="user[0][name]">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Company Email</label>
                                        <input type="email" class="form-control" name="user[0][email]">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Contact Number</label>
                                        <div class="row">
                                            <div class="col-3">
                                                <select name="user[0][code]" id="" class="select2 form-control">
                                                    <option value="">Select Code</option>
                                                    @foreach($countries as $country)
                                                        <option
                                                            value="{{ $country->phonecode }}">
                                                            +{{ $country->phonecode }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" name="user[0][number]" id="name"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Company Country</label>
                                        <select name="user[0][address][country_id]" id="" class="select2 form-control">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->code }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Company Address</label>
                                        <input type="text" name="user[0][address][address]" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">
                                            <input type="checkbox" name="user[0][is_owner]" id=""
                                                   class="owners_checkbox form-control">
                                            Is Owner
                                        </label>
                                    </div>
                                </div>
                            </div>
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
            let i = 0;
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
            //
            // $(".owners_checkbox").on('change', function () {
            //     $(".owners_checkbox").map(function () {
            //         if ($(this).is(':checked')) {
            //             $(this).removeAttr('checked');
            //         }
            //     })
            // })
        </script>
    @endpush
@endsection
