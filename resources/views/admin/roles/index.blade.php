@extends('layouts.admin')
@section('title')
    Role List
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-md-6 col-sm-12">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Lista de Roles</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="active">Lista de roles</li>
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
                            <strong class="card-title">Custom Table</strong>
                        </div>
                        <div class="table-stats order-table ov-h">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>Nombre</th>
                                        <th>Permiso</th>
                                        <th>Descripción</th>
                                        <th style="width: 15rem">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="contenido-tabla">
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td class="serial"> {{ $role->id }} </td>
                                            <td>{{ $role->name }}</td>
                                            <td class="desc-rol">{{ $role->permissions->pluck('name')->join(', ') }}</td>
                                            <td>{{ $role->description }}</td>
                                            <td class="buttons-action">
                                                <button class="btn-primary btn-edit"><a href="{{ route('admin.roles.edit', $role->name) }}">Editar</a></button>
                                                <form action="{{ route('admin.roles.delete', ['role' => $role->name]) }}" method="POST"
                                                    style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este rol?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn-danger btn-borrar">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- /.table-stats -->
                    </div>
                </div>

            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection
