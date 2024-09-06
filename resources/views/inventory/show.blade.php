@extends('main')

@section('title', 'Detail Inventory')

@section('content')

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Inventory</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventory</a></li>
                            <li class="breadcrumb-item active">Detail Inventory</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Detail Data Inventory</h3>
                    </div>
                    <div class="card-body">
                        <form>
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Group</label>
                                        <input type="text" class="form-control" value="{{ $inventory->group_name }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nama Barang</label>
                                        <input type="text" class="form-control" value="{{ $inventory->item_name }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Satuan / UOM</label>
                                        <input type="text" class="form-control" value="{{ $inventory->uom_name }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Barang</label>
                                <textarea class="form-control" rows="3" readonly>{{ $inventory->description }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Masuk</label>
                                        <input type="date" class="form-control" value="{{ $inventory->entry_date }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Kadaluarsa</label>
                                        <input type="date" class="form-control" value="{{ $inventory->expiry_date }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Jumlah Stock</label>
                                        <input type="number" class="form-control" value="{{ $inventory->stock_quantity }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Harga Beli</label>
                                        <input type="text" class="form-control" value="{{ $inventory->purchase_price }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Harga Jual</label>
                                        <input type="text" class="form-control" value="{{ $inventory->sale_price }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jumlah Pesan</label>
                                        <input type="number" class="form-control" value="{{ $inventory->order_quantity }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Supplier</label>
                                        <input type="text" class="form-control" value="{{ $inventory->supplier }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Stok Minimal</label>
                                        <input type="number" class="form-control" value="{{ $inventory->minimum_stock }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Stok Maksimal</label>
                                        <input type="number" class="form-control" value="{{ $inventory->maximum_stock }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Jumlah Terjual</label>
                                <input type="number" class="form-control" value="{{ $inventory->sold_quantity }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label>Catatan</label>
                                <textarea class="form-control" rows="3" readonly>{{ $inventory->notes }}</textarea>
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('inventory.edit', $inventory->id) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Back to List</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
