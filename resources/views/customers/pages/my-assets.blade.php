@extends('customers.main')
@push('style_link')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="row my-2">
                <div class="col-12 text-right">
                    <button data-toggle="modal" data-target="#add-assets-modal" class="btn btn-primary">Import Assets</button>
                    <a href="{{ route('export-assets') }}" class="btn btn-primary">Export Assets</a>
                </div>
            </div>
            @if(request()->has('asset_id'))
                <div class="card">
                    <div class="card-header">
                        <h5>Asset Detail</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
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
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>My Assets</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered myTable">
                                        <thead>
                                        <tr>
                                            <th>View</th>
                                            <th>Manufacture</th>
                                            <th>Model</th>
                                            <th>Serial</th>
                                            <th>Status</th>
                                            <th>Weight</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($assets as $asset)
                                            <tr>
                                                <td class="text-center">
                                                    <a href="?asset_id={{ $asset->id }}">
                                                        <i class="ft-eye"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $asset->manufacture }}</td>
                                                <td>{{ $asset->model }}</td>
                                                <td>{{ $asset->serial }}</td>
                                                <td>{{ $asset->status }}</td>
                                                <td>{{ $asset->weight }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
{{--                @if(request()->has('country_id') && request()->has('address'))--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-12">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-header">--}}
{{--                                    <h5>My Assets</h5>--}}
{{--                                </div>--}}
{{--                                <div class="card-body">--}}
{{--                                    <div class="table table-responsive">--}}
{{--                                        <table class="table table-bordered myTable">--}}
{{--                                            <thead>--}}
{{--                                            <tr>--}}
{{--                                                <th>VIew</th>--}}
{{--                                                <th>Device Model</th>--}}
{{--                                                <th>Device Manufacture</th>--}}
{{--                                                <th>Serial</th>--}}
{{--                                            </tr>--}}
{{--                                            </thead>--}}
{{--                                            <tbody>--}}
{{--                                            @foreach($my_assets as $asset)--}}
{{--                                                <tr>--}}
{{--                                                    <td class="text-center">--}}
{{--                                                        <a href="{{ route('assets', ['asset_id'=>$asset->id]) }}" class="text-primary">--}}
{{--                                                            <i class="fas ft-eye"></i>--}}
{{--                                                        </a>--}}
{{--                                                    </td>--}}
{{--                                                    <td>{{ $asset->model }}</td>--}}
{{--                                                    <td>{{ $asset->manufacture }}</td>--}}
{{--                                                    <td>{{ $asset->serial }}</td>--}}
{{--                                                </tr>--}}
{{--                                            @endforeach--}}
{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
            @endif
        </div>
        <div class="modal fade" id="add-assets-modal" style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Assets</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('import-assets') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Select CSV file for importing assets</label>
                                <input type="file" name="file" class="form-control">
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
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.myTable').DataTable();
            });
        </script>
    @endpush
@endsection
