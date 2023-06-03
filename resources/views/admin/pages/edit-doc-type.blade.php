@extends('admin.main')
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h5>Edit Document Type</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.updateDocType', ['id' => $type->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Type Name</label>
                        <input type="text" value="{{ $type->type }}" name="type" class="form-control"
                               placeholder="Enter document type name">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
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
