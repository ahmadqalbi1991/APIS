@extends('customers.main')
@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
@endpush
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5>Documents</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Effective Date</th>
                            <th>Document Number</th>
                            <th>Document Name</th>
                            <th>Document Description</th>
                            <th>File</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($types_grouped as $type)
                            <tr>
                                <td colspan="5" class="bg-light">{{ $type[0]->type }}</td>
                            </tr>
                            @if($type[0]->docs()->count())
                                @foreach($type[0]->docs as $doc)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($doc->effective_date)->format('d M, Y') }}</td>
                                        <td>{{ $doc->doc_number }}</td>
                                        <td>{{ $doc->doc_name }}</td>
                                        <td>{{ $doc->doc_description }}</td>
                                        <td>
                                            <a href="{{ asset('files/' . $doc->file) }}">{{ $doc->file }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No File</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript"
                src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script>
            $('input[name="effective_date"]').daterangepicker({
                timePicker: false,
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2000,
                maxYear: parseInt(moment().format('YYYY'), 10),
                locale: {
                    format: 'Y-M-DD'
                }
            });
        </script>
    @endpush
@endsection
