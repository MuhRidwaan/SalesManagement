@extends('main')

@section('title', 'Penjualan')

@section('content')

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Halaman transaksi </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Penjualan</a></li>
                            <li class="breadcrumb-item active">Transaksi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Buat Transaksi Baru</h3>
                    </div>

                    <form id="inventoryForm">
                        @csrf
                        <div class="card-body">
                            <div class="container">


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="transaction_number">No Transaksi:</label>
                                            <input type="text" id="transaction_number" name="transaction_number"
                                                class="form-control" placeholder="No Transaksi" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="transation_date">Tanggal Transaksi:</label>
                                            <input type="date" id="transation_date" name="transation_date"
                                                class="form-control" required />
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea class="form-control" rows="3" placeholder="Silahkan Isi..." name="notes"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <select id="item_select" class="form-control select2">
                                        <option value="Item 1">Item 1</option>
                                        <option value="Item 2">Item 2</option>
                                        <option value="Item 3">Item 3</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" id="total_item" class="form-control" placeholder="Total Item"
                                        required>
                                </div>
                                <div class="col-md-1">
                                    <button id="add_button" class="btn btn-primary "><i class="fa fa-plus"
                                            aria-hidden="true"></i></button>
                                </div>
                            </div>


                            <div class="card mt-4">
                                <div class="card-header">
                                    <h3 class="card-title">Detail Penjualan</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <input type="text" id="search_input" class="form-control"
                                        placeholder="Cari barang...">
                                    <table class="table table-striped mt-2">
                                        <thead>
                                            <tr>
                                                <th>Aksi</th>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Harga Satuan</th>
                                                <th>Total Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body">
                                            <!-- Baris baru akan ditambahkan di sini -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- /.row (main row) -->
                        </div>

                        <div class="card-footer">
                            <button type="button" id="saveData" class="btn btn-primary">Simpan</button>
                        </div>
                </div>
                </form>
            </div>
    </div>
    </section>

    </div>
    <script>
        $(document).ready(function() {
            let rowNumber = 1;

            // Tambah Baris
            $('#add_button').click(function() {
                let itemName = $('#item_select').val();
                let totalItem = $('#total_item').val();

                // Validasi input
                if (!itemName || !totalItem || totalItem <= 0) {
                    alert('Harap pilih item dan masukkan jumlah yang valid.');
                    return;
                }

                // Tambahkan baris baru ke tabel
                let newRow = `<tr>
                    <td><button class="btn btn-danger btn-sm delete_button"><i class="fa fa-minus" aria-hidden="true"></i></button></td>
                    <td>${rowNumber}</td>
                    <td>${itemName}</td>
                    <td>${totalItem}</td>
                    <td><input type="text" class="form-control" placeholder="Harga Satuan"></td>
                    <td><input type="text" class="form-control" placeholder="Total Harga"></td>
                </tr>`;

                $('#table_body').append(newRow);
                rowNumber++;

                // Reset input fields
                $('#total_item').val('');
                $('#item_select').val('');
            });

            // Hapus Baris
            $('#table_body').on('click', '.delete_button', function() {
                $(this).closest('tr').remove();

                // Update nomor baris setelah baris dihapus
                $('#table_body tr').each(function(index) {
                    $(this).find('td').eq(1).text(index + 1); // Update nomor baris
                });

                rowNumber = $('#table_body tr').length + 1;
            });

            // Fungsi Pencarian
            $('#search_input').on('keyup', function() {
                let searchTerm = $(this).val().toLowerCase();

                $('#table_body tr').each(function() {
                    let rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(searchTerm) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#saveData').on('click', function() {
                var formData = $('#inventoryForm').serialize();
                var url = "{{ route('inventory.store') }}";
                var method = 'POST';

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: "Good job!",
                                text: response.message,
                                icon: "success"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        "{{ route('inventory.index') }}";
                                }
                            });
                        } else if (response.status === 'error') {
                            Swal.fire({
                                title: "Oops",
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
        });
    </script> --}}

@endsection
