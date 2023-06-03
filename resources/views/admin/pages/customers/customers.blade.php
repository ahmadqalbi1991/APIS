@extends('admin.main')
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h5>Companies</h5>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">Add Customer</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Company</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customers as $key => $customer)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $customer->company_name }}</td>
                            <td>
                                <a href="{{ route('admin.customers.edit', ['id' => $customer->id]) }}">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{ route('admin.customers.delete', ['id' => $customer->id]) }}" class="text-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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

            $('.send_email_btn').on('click', function () {
                const val = $('#email_' + $(this).data('id')).val();
                if (!val) {
                    alert('Please enter email for ' + $(this).data('name'));
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.update-customer-email') }}",
                    type: 'post',
                    data: {email: val, customer_id: $(this).data('customer-id')},
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: (response) => {
                        window.location.reload();
                    }
                })
            })
        </script>
    @endpush
@endsection
