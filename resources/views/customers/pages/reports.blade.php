@extends('customers.main')
@push('style_link')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">

            <div class="row mt-5">
                <div class="col-9"></div>
                <div class="col-3 text-right">
                    <form action="">
                        <select name="status" id="status" class="form-control">
                            <option value="">Select Status</option>
                            <option @if(request()->has('status') && request()->get('status') === 'sale') selected @endif value="sale">Sales</option>
                            <option @if(request()->has('status') && request()->get('status') === 'purchased') selected @endif value="purchased">Purchased</option>
                        </select>
                    </form>
                </div>
                <div class="col-12 mt-2">
                    <div class="card">
                        <div class="card-header">
                            <h4>Financial Report</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="myTable">
                                    <thead>
                                    <tr>
                                        {{--                                        <th>View</th>--}}
                                        <th>Location Name</th>
                                        <th>Number of Assets</th>
                                        <th>Amount</th>
                                        <th>Dates</th>
                                        <th>Order For</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($records as $record)
                                        {{--                                        @dd($record)--}}
                                        <tr>
                                            {{--                                        <td class="text-center">--}}
                                            {{--                                            <a href="">--}}
                                            {{--                                                <i class="ft-eye"></i>--}}
                                            {{--                                            </a>--}}
                                            {{--                                        </td>--}}
                                            <td>{{ $record['location'] }}</td>
                                            <td>{{ $record['total_items'] }}</td>
                                            <td>$ {{ $record['total'] }}</td>
                                            <td>{{ $record['dates'] }}</td>
                                            <td>{{ $record['status'] }}</td>
                                            <td>
                                                <a href="{{ route('download-report', ['id' => $record['location']]) }}">Download File</a>
                                            </td>
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
                $('#myTable').DataTable();
            });

            $("#status").on("change", function () {
                var url = new URL(window.location.href);
                url.searchParams.set('status', $(this).val());
                window.location.href = url.href;
            })
        </script>
    @endpush
@endsection
