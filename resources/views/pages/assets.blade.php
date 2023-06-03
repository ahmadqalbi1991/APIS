@extends('main')
@section('content')
    <div class="notika-status-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>My Assets</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="data-table-basic" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Location</th>
                                        <th>Address</th>
                                        <th>Total Assets</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($final_record as $record)
                                        <tr>
                                            <td>
                                                <a href="{{ route('asset_detail', ['id' => $record['location']]) }}">
                                                    <i class="notika-icon notika-eye"></i>
                                                </a>
                                            </td>
                                            <td>{{ $record['location'] }}</td>
                                            <td>{{ $record['address'] }}</td>
                                            <td>{{ $record['total_assets'] }}</td>
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
@endsection
