@extends('admin.main')
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <h5>Document Types</h5>
                    </div>
                    <div class="col-6 text-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#add-type-modal">Add Document
                            Type
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($types as $key => $type)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $type->type }}</td>
                            <td>
                                <a href="{{ route('admin.docTypesEdit', ['id' => $type->id]) }}"><i
                                        class="fa fa-pen"></i></a>
                                <a href="{{ route('admin.docTypesDelete', ['id' => $type->id]) }}"
                                   class="text-danger"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="add-type-modal" style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add document type</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.save-doc-type') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Type Name</label>
                                <input type="text" name="type" class="form-control"
                                       placeholder="Enter document type name">
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
