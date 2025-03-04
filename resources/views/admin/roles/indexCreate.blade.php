@extends('layouts.admin')
@section('title')
    Create adminds
@endsection

@section('content')
    <div class="container-fluid p-2">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 font-weight-bold">Crear Nuevo Administrador</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.StoreAdmin')}}" class="needs-validation" id="adminForm" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="first_name" class="form-label text-muted">Nombres</label>
                                    <input type="text"
                                        class="form-control bg-light border-1 @error('first_name') is-invalid @enderror"
                                        id="first_name" name="first_name" required>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="last_name" class="form-label text-muted">Apellidos</label>
                                    <input type="text"
                                        class="form-control bg-light border-1 @error('last_name') is-invalid @enderror"
                                        id="last_name" name="last_name" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="name" class="form-label text-muted">Télefono</label>
                                    <input type="phone"
                                        class="form-control bg-light border-1 @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" required>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="email" class="form-label text-muted">Correo electrónico</label>
                                    <input type="email"
                                        class="form-control bg-light border-1 @error('email') is-invalid @enderror"
                                        id="email" name="email" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-6">
                                    <label for="role" class="form-label text-muted">Rol</label>
                                    <select class="form-control bg-light border-1 @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="" selected disabled>Seleccionar rol</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6 mb-4">
                                    <label for="password" class="form-label text-muted">Contraseña</label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control bg-light border-1 @error('password') is-invalid @enderror"
                                            id="password" name="password" required>
                                        <svg class="password-toggle" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="password_confirmation" class="form-label text-muted">Confirmar
                                        contraseña</label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control bg-light border-1 @error('password') is-invalid @enderror"
                                            id="password_confirmation" name="password_confirmation" required>
                                        <svg class="password-toggle" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <div id="passwordConfirmationFeedback" class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="#" class="btn btn-light px-4 mr-4">Cancelar</a>
                                <button type="submit" class="btn btn-primary px-4" id="submitButton">Crear
                                    Administrador...</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
