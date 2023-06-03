@extends('admin.main')
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3>Edit Asset</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.assets.update', ['id' => $asset->id]) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Customer</label>
                                <select name="user_id" id="customer" class="form-control select2" disabled>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                                @if ($asset->user_id === $customer->id) selected @endif>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group" id="address-div">
                                <label for="">Address</label>
                                <select name="address_id" id="address_dropdown" class="form-control" disabled>
                                    @foreach($addresses as $address)
                                        <option value="{{ $address->id }}"
                                                @if ($asset->address_id === $address->id) selected @endif>{{ $address->abbreviations }}
                                            ({{ $address->address }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="asset-form">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Server Rack</label>
                                <select name="server_rack" class="form-control">
                                    <option value="">Select option</option>
                                    <option @if ($asset->server_rack === 'yes') selected @endif value="yes">Yes</option>
                                    <option @if ($asset->server_rack === 'no') selected @endif value="no">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Server Rack Number</label>
                                <input type="text" name="server_rack_number" value="{{ $asset->server_rack_number }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Device Manufacture</label>
                                <input type="text"  name="manufacture" value="{{ $asset->manufacture }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Model</label>
                                <input type="text"  name="model" value="{{ $asset->model }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Serial</label>
                                <input type="text"  name="serial" value="{{ $asset->serial }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">CPU Manufacture</label>
                                <input type="text"  name="cpu_manufacture" value="{{ $asset->cpu_manufacture }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">CPU Part Number</label>
                                <input type="text"  name="cpu_part_number" value="{{ $asset->cpu_part_number }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">CPU Quantity</label>
                                <input type="text"  name="cpu_qty" value="{{ $asset->cpu_qty }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Memory Quantity</label>
                                <input type="text"  name="memory_qty" value="{{ $asset->memory_qty }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Memory Capacity</label>
                                <input type="text"  name="memory_capacity" value="{{ $asset->memory_capacity }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Asset Tag</label>
                                <input type="text"  name="asset_tag" value="{{ $asset->asset_tag }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Hardware Manufacture</label>
                                <input type="text"  name="hardware_manufacture" value="{{ $asset->hardware_manufacture }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Hard Drive Quantity</label>
                                <input type="text"  name="hard_drive_qty" value="{{ $asset->hard_drive_qty }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Hard Drive Capacity</label>
                                <input type="text"  name="hard_drive_capacity" value="{{ $asset->hard_drive_capacity }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Weight</label>
                                <input type="text" name="weight" value="{{ $asset->weight }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="">Status</label>
                                <input type="text"  name="status" value="{{ $asset->status }}" class="form-control">
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
@endsection
