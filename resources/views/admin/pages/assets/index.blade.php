@extends('admin.main')
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h5>Assets</h5>
                    </div>
                    <div class="col-6 text-right">
                        <button data-toggle="modal" data-target="#add-assets-modal" class="btn btn-primary">Import Assets</button>
                        <a href="{{ route('admin.assets.create') }}"
                           class="btn btn-primary">Add Asset</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>View</th>
                        <th>Device Manufacture</th>
                        <th>Device Model</th>
                        <th>Customer</th>
                        <th>Serial</th>
                        <th>Asset Tag</th>
                        <th>CPU Manufacture</th>
                        <th>Memory Capacity</th>
                        <th>Hard Drive Capacity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($assets as $asset)
                        <tr>
                            <td>
                                <a href="?id={{ $asset->id }}">
                                    <i class="fas fa-eye text-primary"></i>
                                </a>
                            </td>
                            <td>{{ $asset->manufacture }}</td>
                            <td>{{ $asset->model }}</td>
                            <td>{{ $asset->user->name }} ({{ $asset->user->company->company_name }})</td>
                            <td>{{ $asset->serial }}</td>
                            <td>{{ $asset->asset_tag }}</td>
                            <td>{{ $asset->cpu_manufacture }}</td>
                            <td>{{ $asset->memory_capacity }}</td>
                            <td>{{ $asset->hard_drive_capacity }}</td>
                            <td>{{ $asset->status }}</td>
                            <td>
                                <a href="{{ route('admin.assets.edit', ['id' => $asset->id]) }}" class="text-primary">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{ route('admin.assets.delete', ['id' => $asset->id]) }}" class="text-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if(request()->has('id'))
            <div class="card">
                <div class="card-header">
                    <h5>Asset Detail</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <label for="">Customer</label>
                        </div>
                        <div class="col-9">
                            {{ strtoupper($asset_detail->user->name) }}
                        </div>
                        @if(!empty($asset_detail->address))
                            <div class="col-3">
                                <label for="">Address</label>
                            </div>
                            <div class="col-9">
                                {{ strtoupper($asset_detail->address->abbreviations) }}
                                ({{ strtoupper($asset_detail->address->address) }})
                            </div>
                        @endif
                        <div class="col-3">
                            <label for="">Server Rack</label>
                        </div>
                        <div class="col-9">
                            {{ strtoupper($asset_detail->server_rack) }}
                        </div>
                        <div class="col-3">
                            <label for="">Server Rack Number</label>
                        </div>
                        <div class="col-9">
                            {{ strtoupper($asset_detail->server_rack_number) }}
                        </div>
                        <div class="col-3">
                            <label for="">Device Manufacture</label>
                        </div>
                        <div class="col-9">
                            {{ strtoupper($asset_detail->manufacture) }}
                        </div>
                        <div class="col-3">
                            <label for="">Device Model</label>
                        </div>
                        <div class="col-9">
                            {{ strtoupper($asset_detail->model) }}
                        </div>
                        <div class="col-3">
                            <label for="">Server</label>
                        </div>
                        <div class="col-9">
                            {{ strtoupper($asset_detail->serial) }}
                        </div>
                        <div class="col-3">
                            <label for="">CPU Manufacture</label>
                        </div>
                        <div class="col-9">
                            {{ strtoupper($asset_detail->cpu_manufacture) }}
                        </div>
                        <div class="col-3">
                            <label for="">CPU Quantity</label>
                        </div>
                        <div class="col-9">
                            {{ strtoupper($asset_detail->cpu_qty) }}
                        </div>
                        <div class="col-3">
                            <label for="">Memory Quantity</label>
                        </div>
                        <div class="col-9">
                            {{ strtoupper($asset_detail->memory_qty) }}
                        </div>
                        <div class="col-3">
                            <label for="">Memory Capacity</label>
                        </div>
                        <div class="col-9">
                            {{ strtoupper($asset_detail->memory_capacity) }}
                        </div>
                        <div class="col-3">
                            <label for="">Asset Tag</label>
                        </div>
                        <div class="col-9">
                            {{ strtoupper($asset_detail->asset_tag) }}
                        </div>
                        <div class="col-3">
                            <label for="">Hard Drive Manufacture</label>
                        </div>
                        <div class="col-9">
                            {{ strtoupper($asset_detail->hardware_manufacture) }}
                        </div>
                        <div class="col-3">
                            <label for="">Hard Drive Quantity</label>
                        </div>
                        <div class="col-9">
                            {{ strtoupper($asset_detail->hard_drive_qty) }}
                        </div>
                        <div class="col-3">
                            <label for="">Hard Drive Capacity</label>
                        </div>
                        <div class="col-9">
                            {{ strtoupper($asset_detail->hard_drive_capacity) }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="modal fade" id="add-assets-modal" style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Assets</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.assets.import-assets') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Select CSV file for importing assets</label>
                                <input type="file" name="file" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Customer</label>
                                <select name="user_id" id="" class="form-control">
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->company->company_name }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    @push('scripts')
        <script>
            $(function () {
                $("#example1").DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": ["csv", "excel", "pdf", "print"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endpush
@endsection
