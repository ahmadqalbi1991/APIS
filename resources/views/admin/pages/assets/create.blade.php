@extends('admin.main')
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3>Add Asset</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.assets.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Customer</label>
                                <select name="user_id" id="customer" class="form-control select2">
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->company->company_name }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group d-none" id="address-div">
                                <label for="">Address</label>
                                <select name="address_id" id="address_dropdown" class="form-control">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row d-none" id="asset-form">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Server Rack</label>
                                <select name="server_rack" id="server_rack" class="form-control">
                                    <option value="">Select option</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12" id="server_rack_num">
                            <div class="form-group">
                                <label for="">Server Rack Number</label>
                                <input type="text" name="server_rack_number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Device Manufacture</label>
                                <input type="text" name="manufacture" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Model</label>
                                <input type="text" name="model" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Serial</label>
                                <input type="text" name="serial" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">CPU Manufacture</label>
                                <input type="text" name="cpu_manufacture" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">CPU Part Number</label>
                                <input type="text" name="cpu_part_number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">CPU Quantity</label>
                                <input type="text" name="cpu_qty" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Memory Quantity</label>
                                <input type="text" name="memory_qty" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Memory Capacity</label>
                                <input type="text" name="memory_capacity" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Asset Tag</label>
                                <input type="text" name="asset_tag" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Hardware Manufacture</label>
                                <input type="text" name="hardware_manufacture" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Hard Drive Quantity</label>
                                <input type="text" name="hard_drive_qty" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Hard Drive Capacity</label>
                                <input type="text" name="hard_drive_capacity" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Weight</label>
                                <input type="text" name="weight" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Status</label>
                                <input type="text" name="status" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Asset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script !src="">
            $("#customer").on("change", function () {
                $.ajax({
                    url: "{{ route('admin.customers.get-addresses') }}" + "?customer_id=" + $(this).val(),
                    type: "GET",
                    success: function (response) {
                        $("#address_dropdown").html(response);
                        $("#address-div").removeClass("d-none");
                    }
                })
            });

            $("#address_dropdown").on("change", function () {
                if ($(this).val()) {
                    $("#asset-form").removeClass("d-none")
                } else {
                    $("#asset-form").addClass("d-none")
                }
            })

            $("#server_rack").on("change", function () {
                if ($(this).val() === 'no') {
                    $("#server_rack_num").addClass("d-none");
                } else {
                    $("#server_rack_num").removeClass("d-none");
                }
            })
        </script>
    @endpush
@endsection
