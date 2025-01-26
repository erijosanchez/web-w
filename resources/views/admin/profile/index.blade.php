@extends('layouts.admin')
@section('title')
    Perfil
@endsection

@section('content')
    <div class="container py-2">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="{{ auth()->user()->profile_img ? asset('storage/' . auth()->user()->profile_img) : 'https://via.placeholder.com/150' }}"
                            alt="avatar" class="rounded-circle img-fluid profile-photo" style="width: 150px;">
                        <h5 class="my-3">{{ auth()->user()->username }}</h5>
                        <p class="text-muted mb-1">{{ auth()->user()->role->name ?? 'Usuario' }}</p>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Profile Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Información del Perfil</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.update.profile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Foto de Perfil</label>
                                <input type="file" class="form-control aft" name="profile_img">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nombres</label>
                                <input type="text" class="form-control" name="first_name"
                                    value="{{ old('name', auth()->user()->first_name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Apellidos</label>
                                <input type="text" class="form-control" name="last_name"
                                    value="{{ old('name', auth()->user()->last_name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="{{ old('email', auth()->user()->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="text" class="form-control" name="phone"
                                    value="{{ old('phone', auth()->user()->phone) }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Cambiar Contraseña</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Contraseña Actual</label>
                                <input type="password" class="form-control" name="current_password" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
