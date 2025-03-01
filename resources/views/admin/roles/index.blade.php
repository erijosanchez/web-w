@extends('layouts.admin')
@section('title')
    Roles
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
                                <li><a href="#">Dashboard</a></li>
                                <li><a href="#">Admins</a></li>
                                <li class="active">Super Admins</li>
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
                                        <th class="avatar">Avatar</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Ingreso</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td class="serial"></td>
                                            <td class="avatar">
                                                <div class="round-img">
                                                    <a href="#"><img class="rounded-circle" src=""
                                                        alt=""></a>
                                                </div>
                                            </td>
                                            <td>  </td>
                                            <td> <span class="name"></span> </td>
                                            <td> <span class="product"></span> </td>
                                            <td>
                                                    <span class="badge badge-success">Activo</span>
                                            </td>
                                            <td>
                                                <span</span>
                                            </td>
                                            <td>
                                                <button class="btn-primary btn-edit">Editar</button>
                                                <button class="btn-danger btn-borrar">Eliminar</button>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div> <!-- /.table-stats -->
                    </div>
                </div>

            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection
