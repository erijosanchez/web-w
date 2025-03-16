@extends('layouts.admin')
@section('title')
    Perfil Admin
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
                        <p class="text-muted mb-1">{{ $admin->roles->first()->name ?? 'Sin Asignar' }}</p>

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
                                        <button class="btn btn-danger mt-2 form-control">Eliminar foto</button>
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
                                <label class="form-label" for="current_password">Contraseña Actual</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    <svg class="password-toggle" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </div>
                            </div>
                    
                            <div class="mb-3">
                                <label class="form-label" for="password">Nueva Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password"
                                        autocomplete="new-password" required>
                                    <svg class="password-toggle" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </div>
                            </div>
                    
                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation">Confirmar Nueva Contraseña</label>
                                <div class="input-group">
                                    <input type="password" id="password_confirmation" class="form-control"
                                        name="password_confirmation" autocomplete="new-password" required>
                                    <svg class="password-toggle" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </div>
                                <div id="passwordConfirmationFeedback" class="invalid-feedback"></div>
                            </div>
                    
                            <button type="submit" id="submitButton" class="btn btn-primary">Cambiar Contraseña</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPasswordInput = document.getElementById('current_password');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const passwordConfirmationFeedback = document.getElementById('passwordConfirmationFeedback');
        const submitButton = document.getElementById('submitButton');

        // Validación de contraseña para el segundo y tercer input
        confirmPasswordInput.addEventListener('input', function() {
            const originalPassword = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            // Función para verificar si confirmPassword sigue el patrón de originalPassword
            function matchesPattern(original, confirm) {
                // Corta la confirmación al mismo largo que el original
                const truncatedConfirm = confirm.slice(0, original.length);

                // Verifica que cada carácter coincida
                for (let i = 0; i < truncatedConfirm.length; i++) {
                    if (truncatedConfirm[i] !== original[i]) {
                        return false;
                    }
                }
                return true;
            }

            // Si la confirmación es más larga que el original
            if (confirmPassword.length > originalPassword.length) {
                confirmPasswordInput.classList.add('is-invalid');
                passwordConfirmationFeedback.textContent = 'Las contraseñas no coinciden';
                submitButton.disabled = true;
            }
            // Si la confirmación no sigue el patrón
            else if (!matchesPattern(originalPassword, confirmPassword)) {
                confirmPasswordInput.classList.add('is-invalid');
                passwordConfirmationFeedback.textContent = 'Las contraseñas no coinciden';
                submitButton.disabled = true;
            }
            // Si coincide completamente
            else if (confirmPassword === originalPassword && confirmPassword !== '') {
                confirmPasswordInput.classList.remove('is-invalid');
                confirmPasswordInput.classList.add('is-valid');
                passwordConfirmationFeedback.textContent = '';
                submitButton.disabled = false;
            }
            // Si es más corto pero coincide hasta ahora
            else {
                confirmPasswordInput.classList.remove('is-invalid');
                confirmPasswordInput.classList.remove('is-valid');
                passwordConfirmationFeedback.textContent = '';
            }
        });

        // Toggle password visibility para todos los campos
        document.querySelectorAll('.password-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                // Obtener el campo de contraseña asociado
                // Esto encuentra el input dentro del mismo contenedor padre (input-group)
                const passwordField = this.parentElement.querySelector('input');
                const isPasswordVisible = passwordField.type === 'password';

                // Cambiar el tipo de input
                passwordField.type = isPasswordVisible ? 'text' : 'password';

                // Cambiar el ícono del SVG
                if (isPasswordVisible) {
                    this.innerHTML = `
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    `;
                } else {
                    this.innerHTML = `
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    `;
                }
            });
        });
    });
</script>

@endpush
