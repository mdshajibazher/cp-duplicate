@extends('layouts.adminlayout')
@section('title','Admins')
@section('content')

  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-4">
                        <h5 class="card-title">Edit Admin</h5>
                    </div>
                    <div class="col-8">

                    </div>
                </div>

            </div>
            <div class="card-body">
              <div class="row justify-content-center">
                <div class="col-lg-4 col-12">
                <form action="{{route('admininfo.update',$admin->id)}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    <div class="form-group">
                      <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter Your Name" value="{{old('name',$admin->name)}}" required>
                    </div>

                    <div class="form-group">
                      <label for="name">Email (Optional)</label>
                    <input type="text" class="form-control" name="email" value="{{old('email',$admin->email)}}" placeholder="Enter Your Email">
                    </div>

                    <div class="form-group">
                      <label for="name">Phone</label>
                    <input type="text" class="form-control" name="phone" value="{{old('phone',$admin->phone)}}" placeholder="Enter Your Phone" required>
                    </div>


                <div class="form-group">
                  <label for="role">Role</label>
                  <select name="role" id="role" class="form-control">
                    @foreach ($roles as $item)
                  <option value="{{$item->name}}"
                    @foreach ($admin->roles as $role)
                         @if($role->id == $item->id) selected @endif
                    @endforeach>{{$item->name}}</option>
                    @endforeach

                  </select>
                  <table class="table table-striped table-sm mt-3" id="permissioninfo"></table>
                </div>



              <div class="form-group">
                <label for="permissions">Direct Permissions</label>
                <select  data-placeholder="Select Some Permission" class="js-example-responsive" multiple="multiple" name="permissions[]" id="permissions" class="form-control @error('permissions') is-invalid @enderror" >
                  <option></option>
                  @foreach ($permissions as $permission)
                <option value="{{$permission->name}}" @foreach($admin->permissions as $single_permission)
                  @if($single_permission->name === $permission->name) selected @endif
                  @endforeach >{{$permission->name}}</option>
                  @endforeach
                </select>
                @error('permissions')
                <small class="form-error">{{ $message }}</small>
                @enderror
              </div>







                <div class="form-group">
                  <label for="signature">Signature</label>
                  <input type="file" class="form-control" name="signature">
                  <small>signature must be keep  size of 339x115 px otherwise it will cropped autometically </small>
                  @if($admin->signature)
                  <img  src="{{asset('uploads/admin/signature/'.$admin->signature)}}" alt="">
                  @endif
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
                  </form>
                </div>

                <div class="col-lg-4 col-12">
                  @if($admin->hasAnyRole($roles))
                  <p>Current Permission Inherited Via Roles</p>
                  @if(count($admin->getPermissionsViaRoles()) > 0)
                  <table class="table">
                    @foreach ($admin->getPermissionsViaRoles() as $key =>  $item)
                    <tr>
                      <td>{{$key+1}}</td>
                      <th>{{$item->name}}</th>
                    </tr>
                    @endforeach
                    @else
                    <p class="alert alert-danger">No Roles Permission Found</p>
                    @endif
                </table>
                @endif


            <p>Direct Permission</p>
            <table class="table">
              @if(count($admin->getDirectPermissions()) > 0)
              @foreach ($admin->getDirectPermissions() as $key =>  $item)
              <tr>
                <td>{{$key+1}}</td>
                <th>{{$item->name}}</th>
              </tr>
              @endforeach
              @else
              <p class="alert alert-danger">No Direct Permission Found</p>
              @endif


                </div>
              </div>

            </div>
        </div>





    </div>
  </div>

@endsection

@push('css')
<style>
  .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice__remove{
    color: #fff !important;
  }
  .select2-container--bootstrap .select2-results__option[aria-selected="true"]{
    background: #FFC312 !important;
  }


</style>
@endpush

@push('js')
<script src="{{asset('assets/js/axios.min.js')}}"></script>
<script>
  var url = '{{url('/')}}';
  sessionStorage.clear();
  $('#user').select2({
width: '100%',
  theme: "bootstrap"
});



$('#permissions').select2({
      width: '100%',
      closeOnSelect: false,
      theme: "bootstrap",templateSelection: function (data, container) {
    $(container).css("background-color", "#4cd137");
    $(container).css("color", "#ffffff");
    return data.text;
}
});

$("#role").change(function(){
  let rolename = $("#role").val();
  let permissionsinfo = "";
  axios.get(url+'/api/getrolepermissions/'+rolename)

  .then(function (response) {
    let permitobjet = response.data.permissions;
    if(permitobjet.length < 1){
      permissionsinfo = `<tr><td><p class="alert alert-danger">No Permission Found in <b>${rolename}</b> Role</p></td></tr>`;
    }else{
      permissionsinfo += `
        <tr>
            <td></td>
            <td><p class="alert alert-success">Permission Associated via <b>${rolename}</b> Role </p></td>
        </tr>`;
    permitobjet.forEach((permit,key) => {
      permissionsinfo += `
        <tr>
            <td>${key+1}</td>
            <td>${permit.name}</td>
        </tr>`;
    });
    }

    $("#permissioninfo").html(permissionsinfo);

  })
  .catch(function (error) {
    // handle error
    console.log(error);
  })


})



</script>
<script src="{{asset('assets/js/flatpicker.min.js')}}"></script>


@endpush


