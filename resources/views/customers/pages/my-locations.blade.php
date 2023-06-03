@extends('customers.main')
@push('style_link')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>My Assets By Locations</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered myTable">
                                        <thead>
                                        <tr>
                                            <th>View</th>
                                            <th>Location Name</th>
                                            <th>Address</th>
                                            <th>Model</th>
                                            <th>Manufacture</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($assets as $asset)
                                            <tr>
                                                <td class="text-center">
                                                    <a href="{{ route('assets', ['asset_id' => $asset->id]) }}">
                                                        <i class="ft-eye"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $asset->loc_name }}</td>
                                                <td>{{ $asset->address }}</td>
                                                <td>{{ $asset->model }}</td>
                                                <td>{{ $asset->manufacture }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
