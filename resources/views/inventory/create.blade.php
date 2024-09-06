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
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Group</label>
                                        <select class="form-control select2" style="width: 100%;" name="group_id" required>
                                            <option value="">- Choose -</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}">
                                                    {{ $group->code }} / {{ $group->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Nama Barang</label>
                                        <select class="form-control select2" style="width: 100%;" name="item_id" required>
                                            <option value="">- Choose -</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->code }} / {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Satuan / UOM</label>
                                        <select class="form-control select2" style="width: 100%;" name="uom_id" required>
                                            <option value="">- Choose -</option>
                                            @foreach ($uoms as $uom)
                                                <option value="{{ $uom->id }}">
                                                    {{ $uom->code }} / {{ $uom->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Barang</label>
                                <textarea class="form-control" rows="3" placeholder="Silahkan Masukkan deskripsi barang jika ada"
                                    name="description"></textarea>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="entry_date">Tanggal Masuk:</label>
                                        <input type="date" id="entry_date" name="entry_date" class="form-control"
                                            required />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="expiry_date">Tanggal Kadaluarsa:</label>
                                        <input type="date" id="expiry_date" name="expiry_date" class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Jumlah Stock</label>
                                        <input type="text" name="stock_quantity" class="form-control"
                                            placeholder="Jumlah Stock" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Harga Beli</label>
                                        <input type="text" name="purchase_price" class="form-control"
                                            placeholder="Harga Beli" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Harga Jual</label>
                                        <input type="text" name="sale_price" class="form-control"
                                            placeholder="Harga Jual" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Jumlah Pesan</label>
                                        <input type="text" name="order_quantity" class="form-control"
                                            placeholder="Jumlah Pesan">
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label>Supplier</label>
                                        <input type="text" name="supplier" class="form-control" placeholder="Supplier">
                                    </div>
                                    <div class="form-group">
                                        <label>Stok Minimal</label>
                                        <input type="text" name="minimum_stock" class="form-control"
                                            placeholder="Stok Minimal">
                                    </div>
                                    <div class="form-group">
                                        <label>Stok Maksimal</label>
                                        <input type="text" name="maximum_stock" class="form-control"
                                            placeholder="Stok Maksimal">
                                    </div>

                                    <div class="form-group">
                                        <label>Jumlah Terjual</label>
                                        <input type="text" name="sold_quantity" class="form-control"
                                            placeholder="Jumlah Terjual">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Catatan</label>
                                <textarea class="form-control" rows="3" placeholder="Silahkan Isi..." name="notes"></textarea>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
