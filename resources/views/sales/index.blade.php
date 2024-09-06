@extends('main')

@section('title', 'Master UOMS | Page')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- /.content-header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Penjualan </h1>
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
                        <h3 class="card-title">Penjualan</h3>
                        <a href="{{ route('sales.create') }}" class="card-title float-right btn btn-primary btn-xs"> <i
                                class="fa fa-plus"> </i> Tambah Data</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    {{-- <th>judul</th> --}}
                                    <th>Tanggal Penjualan</th>
                                    <th>Nomor Transaksi</th>

                                    <th style="width: 15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <?php $no = 1; ?>
                                @foreach ($uoms as $uom)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $uom->code }}</td>
                                        <td>{{ $uom->name }}</td>
                                        <td>
                                            <a href="{{ route('uoms.show', $uom->id) }}" class="btn btn-primary btn-sm"><i
                                                    class="fa fa-eye"></i></a>
                                            <button id='btnEdit' data-id="{{ $uom->id }}"
                                                class="btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></button>
                                            <button id="btnDelete" class="btn btn-danger btn-sm"
                                                data-id="{{ $uom->id }}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach --}}
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
                    <form id="dataForm">
                        @csrf
                        <input type="hidden" id="uomId" name="id">
                        <div class="form-group">
                            <label for="code">Code:</label>
                            <input class="form-control" type="text" id="code" name="code"
                                placeholder="Enter code" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Satuan :</label>
                            <input class="form-control" type="text" id="name" name="name"
                                placeholder="Enter name" required>
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

    {{-- <script>
        $(document).ready(function() {
            $('#modal-default').on('hidden.bs.modal', function() {
                $(this).find('form').trigger('reset'); // Reset form fields
                $('#uomId').val(''); // Reset the hidden input field
                $('#modal-title').text('Tambah Data'); // Reset modal title to default
            });
            $('#saveData').on('click', function() {
                var uomId = $('#uomId').val();
                var url = uomId ? "{{ url('uoms') }}/" + uomId : "{{ route('uoms.store') }}";
                var method = uomId ? "PUT" : "POST";

                $.ajax({
                    url: url,
                    method: method,
                    data: $('#dataForm').serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: "Kerja Bagus!",
                                text: response.message,
                                icon: "success"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else if (response.status === 'error') {
                            Swal.fire({
                                title: "Terjadi Kesalahan",
                                text: response.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON || {};
                        Swal.fire({
                            title: "Error Bro!",
                            text: response.message ||
                                "gagal Menyimpan Data , silahkan Coba Lagi.",
                            icon: "error"
                        });
                    }
                });
            });

            $(document).on('click', '#btnEdit', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ url('uoms') }}/" + id + "/edit",
                    method: "GET",
                    success: function(response) {
                        if (response.status === 'success') {
                            var uom = response.data;
                            $('#uomId').val(uom.id);
                            $('#code').val(uom.code);
                            $('#name').val(uom.name);
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
                            text: "Gagal mengambil detail UOM. Silahkan coba lagi.",
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
                            url: "{{ url('uoms') }}/" + id,
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
    </script> --}}

@endsection
