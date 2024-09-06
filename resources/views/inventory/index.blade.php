@extends('main')

@section('title', 'Master Inventory')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- /.content-header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Master Inventory </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
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
                        <h3 class="card-title">Data Inventory</h3>
                        <a href="{{ route('inventory.create') }}" class="card-title float-right btn btn-primary btn-xs"> <i
                                class="fa fa-plus"> </i> Tambah Data</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Group</th>
                                    <th>Nama Barang</th>
                                    <th>Satuan</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Kadaluarsa</th>
                                    <th>Jumlah Stock</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>


                                    <th style="width: 15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($inventory as $inv)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $inv->group_name }}</td>
                                        <td>{{ $inv->item_name }}</td>
                                        <td>{{ $inv->uom_name }}</td>
                                        <td>{{ $inv->description }}</td>
                                        <td>{{ $inv->entry_date }}</td>
                                        <td>{{ $inv->expiry_date }}</td>
                                        <td>{{ $inv->stock_quantity }}</td>
                                        <td>Rp {{ number_format($inv->purchase_price, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($inv->sale_price, 0, ',', '.') }}</td>



                                        <td>
                                            <a href="{{ route('inventory.show', $inv->id) }}"
                                                class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('inventory.edit', $inv->id) }}" id='btnEdit'
                                                data-id="{{ $inv->id }}" class="btn btn-success btn-sm"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                            <button id="btnDelete" class="btn btn-danger btn-sm"
                                                data-id="{{ $inv->id }}"><i class="fa fa-trash"></i></button>
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
    <script>
        $(document).ready(function() {


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
                            url: "{{ url('inventory') }}/" + id,
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
