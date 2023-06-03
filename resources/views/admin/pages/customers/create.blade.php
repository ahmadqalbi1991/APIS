@extends('admin.main')
@section('content')
    <div class="content-wrapper">
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
                                <label for="">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Phone Number</label>
                                <div class="row">
                                    <div class="col-3">
                                        <select name="contact_number_code" style="height: 88px"
                                                class="form-control select2">
                                            <option value="">Select Code</option>
                                            @foreach($countries as $country)
                                                <option value="+{{ $country->phonecode }}">
                                                    +{{ $country->phonecode }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" name="contact_number">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>Addresses <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" id="add-more-address">Add More</a></span></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12" id="address-div">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="">Country</label>
                                        <select name="addresses[0][country]" id="" class="select2 form-control">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->code }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input type="text" name="addresses[0][address]" id="" class="form-control">
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
                    '<div class="col-3">' +
                    '<div class="form-group">' +
                    '<label for="">Country</label>' +
                    '<select name="addresses[' + i + '][country]" id="" class="select2 form-control">' +
                    '<option value="">Select Country</option>\n' +
                    '@foreach($countries as $country)' +
                    '<option value="{{ $country->code }}">{{ $country->name }}</option>\n' +
                    '@endforeach' +
                    '</select>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-9">' +
                    '<div class="form-group">' +
                    '<label for="">Address</label>' +
                    '<input type="text" name="addresses[' + i + '][address]" id="" class="form-control">' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                $("#address-div").append(html);
                $(".select2").select2();
            })
        </script>
    @endpush
@endsection
