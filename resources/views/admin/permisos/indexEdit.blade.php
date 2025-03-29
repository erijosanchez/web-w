@extends('layouts.admin')
@section('title')
    Permission Edit
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-md-6 col-sm-12">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Editar Permisos</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="active">Editar Permisos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Editar <b>{{ $permission->name }}</b></h5>
                            <p class="mt-2 passt">* Asegurate de que la información ingresada sea la correcta.</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.permission.update', $permission->name) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <div class="col-lg-6 mb-6">
                                        <label for="permission" class="form-label text-muted">Permiso</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="name"
                                                name="name" required value="{{ $permission->name }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-lg-6">
                                        <label for="description" class="form-label">Descripción</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="description"
                                                name="description" required value="{{ $permission->description }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('admin.permission') }}" class="btn btn-light px-4 mr-4">Cancelar</a>
                                    <button type="submit" class="btn btn-primary px-4" id="submitButton">Actualizar Permiso...</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection
