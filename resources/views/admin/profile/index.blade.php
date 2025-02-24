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
                        <div class="card-header">
                            <h5 class="-mt-2">Información del Perfil</h5>
                        </div>
                        <img src="{{ $admin->profile_photo_url }}" alt="{{ $admin->name }}"
                            class="rounded-circle img-fluid profile-photo mt-4" style="width: 150px;">
                        <h5 class="my-3">{{ auth()->user()->name }}</h5>
                        <p class="text-muted mb-1">{{ auth()->user()->name ?? 'Usuario' }}</p>

                        <!-- Formulario para actualizar la foto de perfil de administrador -->
                        <form method="POST" action="{{ route('admin.update.photo') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="mt-4">
                                <input type="file" class="form-control aft" name="photo" id="photo"
                                    accept="image/*">
                                <button type="submit" class="btn btn-primary mt-3 form-control">Actualizar foto</button>
                                @if ($admin->profile_photo_path)
                                    <form method="post" action="{{ route('admin.delete.photo') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger mt-2 form-control">Eliminar foto</button>
                                    </form>
                                @endif
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Profile Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Información del Perfil</h5>
                        <p class="mt-2 passt">* Asegurate de que la información ingresada sea la correcta .</p>
                    </div>

                    <div class="card-body">
                        <!-- formulario para actualizar y mostrar la información de perfil -->
                        <form action="{{ route('admin.update.profile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label class="form-label">Nombres</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name', auth()->user()->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ old('email', auth()->user()->email) }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Cambiar Contraseña</h5>
                        <p class="mt-2 passt">* Asegurate que la contraseña sea larga y segura.</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.update.password') }}" method="POST">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label class="form-label" for="password">Contraseña Actual</label>
                                <input type="password" class="form-control" name="current_password" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="password">Nueva Contraseña</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    autocomplete="new-password" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation">Confirmar Nueva Contraseña</label>
                                <input type="password" id="password_confirmation" class="form-control"
                                    name="password_confirmation" autocomplete="new-password" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
