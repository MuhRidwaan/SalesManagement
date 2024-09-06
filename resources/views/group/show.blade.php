@extends('main')

@section('title', 'Detail Group | Page')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Group </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>


        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-6">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="Code">Code</label>
                                        <input type="text" class="form-control" id="Code"
                                            value="<?= $group->code ?> "readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="Item">Group Name</label>
                                        <input type="text" class="form-control" id="Item"
                                            value="<?= $group->name ?> "readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="Item">Create Who</label>
                                        <input type="text" class="form-control" id="Item"
                                            value="<?= $group->created_who ?> "readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="Code">Create Date</label>
                                        <input type="text" class="form-control" id="Code"
                                            value="<?= $group->created_at ?> "readonly>
                                    </div>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="Code">Change Who</label>
                                        <input type="text" class="form-control" id="Code"
                                            value="<?= $group->change_who ?> "readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="Code">Change Date</label>
                                        <input type="text" class="form-control" id="Code"
                                            value="<?= $group->updated_at ?> "readonly>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('groups.index') }}" class="btn btn-warning">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
