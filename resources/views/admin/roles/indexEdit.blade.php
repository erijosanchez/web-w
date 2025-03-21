@extends('layouts.admin')
@section('title')
    Role Edit
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-md-6 col-sm-12">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Editar Roles</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="active">Editar Roles</li>
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
                            <h5 class="mb-0">Editar <b>{{ $roles->name }}</b></h5>
                            <p class="mt-2 passt">* Asegurate de que la información ingresada sea la correcta.</p>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <div class="mb-3 col-lg-6">
                                        <label class="form-label" for="current_password">Contraseña Actual</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="current_password" name="current_password" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-lg-6">
                                        <label class="form-label" for="current_password">Contraseña Actual</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="current_password" name="current_password" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-lg-6">
                                        <label class="form-label" for="current_password">Contraseña Actual</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="current_password" name="current_password" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-lg-6">
                                        <label class="form-label" for="current_password">Contraseña Actual</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="current_password" name="current_password" required>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection
