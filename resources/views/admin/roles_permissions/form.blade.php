@extends('layouts.adminlayout')
@section('title','Roles')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="main-card mb-3 card">

                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('roles.index') }}" class="btn-shadow btn btn-info btn-sm">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fas fa-arrow-circle-left fa-w-20"></i>
                        </span>
                                Back to list
                            </a>
                        </div>
                        <div>{{ isset($role) ? 'Edit' : 'Create New' }} Role</div>
                    </div>
                </div>
                <!-- form start -->
                <form id="roleFrom" role="form" method="POST"
                      action="{{ isset($role) ? route('roles.update',$role->id) : route('roles.store') }}">
                    @csrf
                    @if (isset($role))
                        @method('PUT')
                    @endif
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between"><div>Manage Role</div>
                            <div>
                                {!! isset($role) ? '<span class="badge badge-danger">'.$role->name.'</span>' : '' !!}
                            </div>
                        </h5>


                        <div class="form-group">
                            <label for="name">name</label>
                            <input type="text"
                                   id="name"
                                   class="form-control  @error('name') is-invalid @enderror"
                                   name="name"
                                   value="{{old('name',$role->name ?? '' )}}"
                                   placeholder="Type a role"
                                   autocomplete="name"
                            >
                            @error("name")
                            <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
                            @enderror
                        </div>


                        <div class="text-center">
                            <strong>Manage permissions for role</strong>
                            @error('permissions')
                            <p class="p-2">
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            </p>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-center ">
                            <div class="custom-control custom-checkbox bg-warning px-5">
                                <input type="checkbox" class="custom-control-input" id="select-all">
                                <label class="custom-control-label" for="select-all">Select All</label>
                            </div>
                        </div>

                        <div class="form-row">
                            <ul class="list-group mb-3 w-100">
                                @forelse($permissionGroups as $label =>  $permissions)
                                    <li class="bg-dark text-white list-group-item p-0 m-0"><h5 class="mt-2 ml-3">{{$label}}</h5></li>
                                    <li class="list-group-item">
                                        @foreach($permissions as $permission)
                                            <div class="custom-checkbox w-50 float-left">
                                                <div class="custom-control">
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="permission-{{ $permission->id }}"
                                                           value="{{ $permission->id }}"
                                                           name="permissions[]"
                                                    @if(isset($role))
                                                        @foreach($role->permissions as $rPermission)
                                                            {{ $permission->id == $rPermission->id ? 'checked' : '' }}
                                                            @endforeach
                                                        @endif
                                                    >
                                                    <label class="custom-control-label"
                                                           for="permission-{{ $permission->id }}"><h5></h5>{{ $permission->display_name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                        @empty
                                            <div class="row">
                                                <div class="col text-center">
                                                    <strong>No Permissions Found.</strong>
                                                </div>
                                            </div>
                                        @endforelse</li>
                            </ul>
                        </div>


                        <!--                        <button type="button" class="btn btn-danger" onClick="resetForm('roleFrom')">
                                                    <i class="fas fa-redo"></i>
                                                    <span>Reset</span>
                                                </button>-->

                        <button type="submit" class="btn btn-primary">
                            @isset($role)
                                <i class="fas fa-arrow-circle-up"></i>
                                <span>Update</span>
                            @else
                                <i class="fas fa-plus-circle"></i>
                                <span>Create</span>
                            @endisset
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        // Listen for click on toggle checkbox
        $('#select-all').click(function (event) {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function () {
                    this.checked = false;
                });
            }
        });
    </script>
@endpush
@push('css')
    <style>

        .custom-checkbox {
            padding: 10px;
            border-radius: 5px;
            -webkit-transition: .35s ease 0s;
            -moz-transition: .35s ease 0s;
            -ms-transition: .35s ease 0s;
            -o-transition: .35s ease 0s;
            transition: .35s ease 0s;
        }

        .custom-checkbox:hover {
            background: #eee;
            -webkit-transition: .35s ease 0s;
            -moz-transition: .35s ease 0s;
            -ms-transition: .35s ease 0s;
            -o-transition: .35s ease 0s;
            transition: .35s ease 0s;
        }
    </style>
@endpush
