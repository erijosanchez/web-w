@extends('layouts.admin')
@section('title')
    Create adminds
@endsection

@section('content')
    <div class="container-fluid p-2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 font-weight-bold">Crear Nuevo Rol</h5>
                        <p class="mt-2 passt">* Asegurate de que la información ingresada sea la correcta.</p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.roles.store') }}" class="needs-validation" id="adminForm"
                            novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="name" class="form-label text-muted">Nombre</label>
                                    <input type="text"
                                        class="form-control bg-light border-1 @error('name') is-invalid @enderror"
                                        id="name" name="name" required>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="description" class="form-label text-muted">Descripción</label>
                                    <input type="text"
                                        class="form-control bg-light border-1 @error('description') is-invalid @enderror"
                                        id="description" name="description" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-6">
                                    <label for="permission" class="form-label text-muted">Permisos</label>
                                    @foreach ($permissions as $permission)
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input" id="flexSwitchCheckDefault" name="permissions[]" value="{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </div>
                                    @endforeach
                                    @error('permission')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('admin.roles') }}" class="btn btn-light px-4 mr-4">Cancelar</a>
                                <button type="submit" class="btn btn-primary px-4" id="submitButton">Crear Rol...</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
