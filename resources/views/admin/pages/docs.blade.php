@extends('admin.main')
@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h5>Documents</h5>
                    </div>
                    <div class="col-6 text-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#add-type-modal">Add Document
                        </button>
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
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($types_grouped as $type)
                        <tr>
                            <td colspan="6" class="bg-light">{{ $type[0]->type }}</td>
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
                                    <td>
                                        <a href="{{ route('admin.editDocuments', ['id' => $doc->id]) }}"><i class="fa fa-pen"></i></a>
                                        <a href="{{ route('admin.deleteDocuments',  ['id' => $doc->id]) }}" class="text-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">No File</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="add-type-modal" style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Document</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.save-doc') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Date</label>
                                        <input type="text" name="effective_date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Document Number</label>
                                        <input type="text" name="doc_number" readonly class="form-control" id="doc_number">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Document Name</label>
                                        <input type="text" name="doc_name" class="form-control"
                                               placeholder="Enter document type name">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Document Type</label>
                                        <select name="doc_type" id="doc_type" class="form-control">
                                            <option value="">Select Type</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->id }}">{{ $type->type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Customer</label>
                                        <select name="customer_id" id="" class="form-control">
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->company->company_name }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <textarea name="doc_description" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">File</label>
                                        <input type="file" name="file" id="" class="form-control"
                                               accept="application/pdf">
                                    </div>
                                </div>
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

            $(function () {
                $("#example1").DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": ["csv", "excel", "pdf", "print"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });

            $("#doc_type").on("change", function () {
                $.ajax({
                    url: "{{ url('/') }}/admin/generate-random-doc-number/" + $(this).val(),
                    type: 'get',
                    success: function (response) {
                        $('#doc_number').val(response)
                    }
                })
            })
        </script>
    @endpush
@endsection
