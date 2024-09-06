 @extends('main')

@section('title', 'Master Group | Page')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- /.content-header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Group </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Master Group</h3>
                        <button class="card-title float-right btn btn-primary btn-xs" data-toggle="modal"
                            data-target="#modal-default"> <i class="fa fa-plus"> </i> Tambah Data</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th style="width: 15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($groups as $group)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $group->code }}</td>
                                        <td>{{ $group->name }}</td>
                                        <td>
                                            <a href="{{ route('groups.show', $group->id) }}"
                                                class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                            <button id='btnEdit' data-id="{{ $group->id }}"
                                                class="btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></button>
                                            <button id="btnDelete" class="btn btn-danger btn-sm"
                                                data-id="{{ $group->id }}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title">Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="groupForm">
                        @csrf
                        <input type="hidden" id="groupId" name="id">
                        <div class="form-group">
                            <label for="code">Code:</label>
                            <input class="form-control" type="text" id="code" name="code"
                                placeholder="Enter code">
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Group :</label>
                            <input class="form-control" type="text" id="name" name="name"
                                placeholder="Enter name">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="button" id="saveData" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>
        $(document).ready(function() {

            $('#modal-default').on('hidden.bs.modal', function() {
                $(this).find('form').trigger('reset'); // Reset form fields
                $('#groupId').val(''); // Reset the hidden input field
                $('#modal-title').text('Tambah Data'); // Reset modal title to default
            });

            $('#saveData').on('click', function() {
                var groupId = $('#groupId').val();
                var url = groupId ? "{{ url('groups') }}/" + groupId : "{{ route('groups.store') }}";
                var method = groupId ? "PUT" : "POST";

                $.ajax({
                    url: url,
                    method: method,
                    data: $('#groupForm').serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: "Good job!",
                                text: response.message,
                                icon: "success"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else if (response.status === 'error') {
                            Swal.fire({
                                title: "Opsss",
                                text: response.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON || {};
                        Swal.fire({
                            title: "Error!",
                            text: response.message ||
                                'Failed to save data. Please try again.',
                            icon: "error"
                        });
                    }
                });
            });

            // edit data 
            $(document).on('click', '#btnEdit', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ url('groups') }}/" + id + "/edit",
                    method: "GET",
                    success: function(response) {
                        if (response.status === 'success') {
                            var item = response.data;
                            $('#groupId').val(item.id);
                            $('#code').val(item.code);
                            $('#name').val(item.name);
                            $('#modal-title').text('Edit Data');
                            $('#modal-default').modal('show');
                        } else {
                            Swal.fire({
                                title: "Opps",
                                text: response.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error !",
                            text: "Failed to fetch Item Detail. Please Try Again.",
                            icon: "error"
                        });
                    }
                });
            });

            $(document).on('click', '#btnDelete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('groups') }}/" + id,
                            method: "DELETE",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: response.message,
                                        icon: "success"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Oops!",
                                        text: response.message,
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to delete item. Please try again.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });

        });
    </script>

@endsection
