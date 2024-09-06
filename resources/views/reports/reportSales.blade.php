@extends('main')

@section('title', 'Master Inventory')

@section('content')

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create Inventory</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventory</a></li>
                            <li class="breadcrumb-item active">Create Inventory</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create Data Inventory</h3>
                    </div>

                    <form id="inventoryForm">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="transaction_no">No Transaksi</label>
                                        <select class="form-control select2" style="width: 100%;" name="group_id"
                                            id="transaction_no" required>
                                            <option value="">- Choose -</option>
                                            <!-- Add options here -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="start_date">Tanggal Mulai:</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                            required />
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date">Tanggal Akhir:</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control"
                                            required />
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <!-- Tombol Go -->
                                <button type="button" id="goButton" class="btn btn-primary mx-2">
                                    <i class="fas fa-play"></i> Go
                                </button>

                                <!-- Tombol Export -->
                                <button type="button" id="exportButton" class="btn btn-success mx-2">
                                    <i class="fas fa-file-export"></i> Export
                                </button>

                                <!-- Tombol Print -->
                                <button type="button" id="printButton" class="btn btn-info mx-2">
                                    <i class="fas fa-print"></i> Print
                                </button>

                                <!-- Tombol Buat PDF -->
                                <button type="button" id="pdfButton" class="btn btn-danger mx-2">
                                    <i class="fas fa-file-pdf"></i> Buat Pdf
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Optional: include Bootstrap JS for additional features -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
    </script>

@endsection
