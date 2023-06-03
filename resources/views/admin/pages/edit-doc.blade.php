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
                        <h5>Edit Document</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.update-doc', ['id' => $doc->id]) }}" enctype="multipart/form-data" method="post">
                    @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Date</label>
                            <input type="text" value="{{ $doc->effective_date }}" name="effective_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Document Number</label>
                            <input type="text" value="{{ $doc->doc_number }}" name="doc_number" readonly class="form-control" id="doc_number">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Document Name</label>
                            <input value="{{ $doc->doc_name }}" type="text" name="doc_name" class="form-control"
                                   placeholder="Enter document type name">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Document Type</label>
                            <select name="doc_type" id="doc_type" class="form-control">
                                <option value="">Select Type</option>
                                @foreach($types as $type)
                                    <option @if($doc->doc_type === $type->id) selected @endif value="{{ $type->id }}">{{ $type->type }}</option>
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
                                    <option @if($customer->id === $doc->customer_id) selected @endif value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="doc_description" rows="5" class="form-control">{{ $doc->doc_description }}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">File</label>
                            <input type="file" name="file" id="" class="form-control"
                                   accept="application/pdf">
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                </form>
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
