@extends('layouts.adminlayout')
@section('title','Database Backup')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-cloud icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <h3 class="mb-3">All Backups</h3>
            </div>
            <div class="page-title-actions">
                <div class="d-flex justify-content-between mb-3">

                    <div>
                    <button onclick="event.preventDefault();
                          document.getElementById('new-backup-form').submit();"
                            class="btn-shadow btn btn-info btn-sm">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fas fa-plus-circle fa-w-20"></i>
                        </span>
                        Create New Backup
                    </button>
                    <form id="new-backup-form" action="{{ route('backups.store') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    </div>
                    <div class="d-none">
{{--                        <button onclick="event.preventDefault();--}}
{{--                          document.getElementById('clean-old-backups').submit();"--}}
{{--                                class="btn-shadow btn btn-danger btn-sm">--}}
{{--                        <span class="btn-icon-wrapper pr-2 opacity-7">--}}
{{--                            <i class="fas fa-trash fa-w-20"></i>--}}
{{--                        </span>--}}
{{--                            'Clean Old Backups--}}
{{--                        </button>--}}
{{--                        <form id="clean-old-backups" action="{{ route('backups.clean') }}" method="POST" style="display: none;">--}}
{{--                            @csrf--}}
{{--                            @method('DELETE')--}}
{{--                        </form>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="table-responsive">
                    <table id="datatable" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">File Name</th>
                            <th class="text-center">Size</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($backups as $key=>$backup)
                            <tr>
                                <td class="text-center text-muted">#{{ $key + 1 }}</td>
                                <td class="text-center">
                                    <code>{{ $backup['file_name'] }}</code>
                                </td>
                                <td class="text-center">{{ $backup['file_size'] }}</td>
                                <td class="text-center">{{ $backup['created_at'] }}</td>
                                <td class="text-center">
                                    <a class="btn btn-info btn-sm" href="{{ route('backups.download',$backup['file_name']) }}"><i
                                            class="fas fa-download"></i>
                                        <span>Download</span>
                                    </a>
{{--                                    <button type="button" class="btn btn-danger btn-sm"--}}
{{--                                            onclick="deleteData({{ $key }})">--}}
{{--                                        <i class="fas fa-trash-alt"></i>--}}
{{--                                        <span>Delete</span>--}}
{{--                                    </button>--}}
{{--                                    <form id="delete-form-{{ $key }}"--}}
{{--                                          action="{{ route('backups.destroy',$backup['file_name']) }}" method="POST"--}}
{{--                                          style="display: none;">--}}
{{--                                        @csrf()--}}
{{--                                        @method('DELETE')--}}
{{--                                    </form>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
