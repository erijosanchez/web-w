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
                            <form action="{{ route('admin.roles.update', $roles->name) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <div class="col-lg-6 mb-6">
                                        <label for="permission" class="form-label text-muted">Permisos</label>
                                        @foreach ($permissions as $permission)
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="flexSwitchCheckDefault"
                                                    name="permissions[]" value="{{ $permission->id }}"
                                                    {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                                {{ $permission->name }}
                                            </div>
                                        @endforeach
                                        @error('permission')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-lg-6">
                                        <label for="description" class="form-label">Descripción</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="description"
                                                name="description" required value="{{ $roles->description }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('admin.roles') }}" class="btn btn-light px-4 mr-4">Cancelar</a>
                                    <button type="submit" class="btn btn-primary px-4" id="submitButton">Actualizar Rol...</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection
