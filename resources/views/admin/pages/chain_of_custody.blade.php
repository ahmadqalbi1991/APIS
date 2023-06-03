@extends('admin.main')
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h4>Chain of custody</h4>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('admin.chainOfCustodyCreate') }}" class="btn btn-primary">Add Chain of custody</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @if(session()->has('message'))
                    @php
                    $message = session()->get('message');
                    $messaages = explode('=', $message);
                    @endphp
                <div class="alert alert-{{ $messaages[0] }}">
                    {{ $messaages[1] }}
                </div>
                @endif
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>View</th>
                        <th>Chain of Custody ID</th>
                        <th>Date of start action</th>
                        <th>Date of last action</th>
                        <th>Status</th>
                        <th>Current custody</th>
                        <th>Hours since last action</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($custodies as $custody)
                    <tr>
                        <td>
                            <a href="?custody_id={{ $custody->id }}" class="text-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                        <td>{{ $custody->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($custody->start_date)->format('d/M/Y, h:i a') }}</td>
                        <td>{{ $custody->change_date ? \Carbon\Carbon::parse($custody->change_date)->format('d/M/Y, h:i a') : \Carbon\Carbon::parse($custody->updated_at)->format('d/M/Y, h:m a') }}</td>
                        <td>{{ $custody->status }}</td>
                        <td>{{ $custody->current_custody }}</td>
                        @php
                        $start_date = \Carbon\Carbon::parse($custody->start_date);
                        $end_date = \Carbon\Carbon::parse($custody->change_date);
                        @endphp
                        <td>{{ $start_date->diff($end_date)->format('%D days %H hours %I minutes') }}</td>
                        <td>
                            <a href="{{ route('admin.chainOfCustodyEdit', ['id' => $custody->id]) }}"><i class="fa fa-pen"></i></a>
                            <a href="{{ route('admin.chainOfCustodyDelete', ['id' => $custody->id]) }}" class="text-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if(request()->has('custody_id'))
            <div class="card">
                <div class="card-header">
                    <h4>View chain of custody details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <strong>Date Started</strong>
                        </div>
                        <div class="col-10">
                            <p>{{ \Carbon\Carbon::parse($custody_detail->start_date)->format('d M, Y h:i a') }}</p>
                        </div>
                        <div class="col-2">
                            <strong>Date of last action</strong>
                        </div>
                        <div class="col-10">
                            <p>{{ \Carbon\Carbon::parse($custody_detail->changed_date)->format('d M, Y h:i a') }}</p>
                        </div>
                        <div class="col-2">
                            <strong>Receiving Party</strong>
                        </div>
                        <div class="col-10">
                            <p>{{ $custody_detail->receiving_party }}</p>
                        </div>
                        <div class="col-2">
                            <strong>Initialized by</strong>
                        </div>
                        <div class="col-10">
                            <p>{{ $custody_detail->initialized_by }}</p>
                        </div>
                        <div class="col-2">
                            <strong>Status</strong>
                        </div>
                        <div class="col-10">
                            <p>{{ $custody_detail->status }}</p>
                        </div>
                        <div class="col-2">
                            <strong>Partner to send to</strong>
                        </div>
                        <div class="col-10">
                            <p>{{ $custody_detail->partner_to_send_to }}</p>
                        </div>
                        <div class="col-2">
                            <strong>Current custody</strong>
                        </div>
                        <div class="col-10">
                            <p>{{ $custody_detail->current_custody }}</p>
                        </div>
                        <div class="col-2">
                            <strong>Final Address</strong>
                        </div>
                        <div class="col-10">
                            <p>{{ $custody_detail->final_address }}, {{ $custody->city1->name }}, {{ $custody->state1->name }}, {{ $custody->country1->name }}</p>
                        </div>
                        <div class="col-2">
                            <strong>Final Location</strong>
                        </div>
                        <div class="col-10">
                            <p>{{ $custody_detail->final_location }}, {{ $custody->city2->name }}, {{ $custody->state2->name }}, {{ $custody->country2->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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
