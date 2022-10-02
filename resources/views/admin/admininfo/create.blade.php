@extends('layouts.adminlayout')
@section('title','Admins')
@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h5 class="card-title">Create Admin</h5>
                    </div>
                    <div class="col-lg-8">
                        <a href="{{route('admininfo.create')}}" class="btn btn-info btn-sm float-right"><i class="fa fa-plus"></i>Add New Admin</a>
                    </div>
                </div>

            </div>
            <div class="card-body">
              <div class="row justify-content-center">
                <div class="col-lg-4">
                <form action="{{route('admininfo.store')}}" method="POST" enctype="multipart/form-data" onsubmit="triggerBtnLoader()">
                  @csrf
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
                    <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="Enter Your Name" required>
                    </div>

                    <div class="form-group">
                      <label for="name">Email (Optional)</label>
                    <input type="text" class="form-control" name="email" value="{{old('email')}}" placeholder="Enter Your Email">
                    </div>

                    <div class="form-group">
                      <label for="name">Phone</label>
                    <input type="text" class="form-control" name="phone" value="{{old('phone')}}" placeholder="Enter Your Phone" required>
                    </div>

<!--                    <div class="form-group">
                        <label for="password">password<span>*</span></label>
                        <input type="password" id="password" placeholder="Enter Password" class="form-control"
                               name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Confirm Password<span>*</span></label>
                        <input type="password" id="password-confirm" placeholder="Confirm your Password"
                               class="form-control" name="password_confirmation" required>

                    </div>-->
                <div class="form-group">
                  <label for="role">Role</label>
                  <select name="role" id="role" class="form-control">
                    <option value="">-select admin role-</option>
                    @foreach ($roles as $item)
                  <option value="{{$item->name}}">{{$item->name}}</option>
                    @endforeach

                  </select>
                  <table class="table table-striped table-sm mt-3" id="permissioninfo"></table>
                </div>

                <div class="form-group">
                  <label for="signature">Signature (optional)</label>
                  <input type="file" class="form-control" name="signature">
                  <small>signature must be keep  size of 339x115 px otherwise it will cropped autometically </small>

                </div>
                <div class="form-group">
                  <button id="create-btn" type="submit" class="btn btn-success">Create</button>
                </div>
                  </form>
                </div>
              </div>

            </div>
        </div>





    </div>
  </div>

@endsection

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
@endpush

@push('js')
<script src="{{asset('assets/js/axios.min.js')}}"></script>
<script>
 var url = '{{url('/')}}';
$("#role").change(function(){
  let rolename = $("#role").val();
  if(rolename){
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
  }else{
    alert('please select a role');
  }

})
  sessionStorage.clear();
  $('#user').select2({
width: '100%',
  theme: "bootstrap"
});


function triggerBtnLoader(){
    $('#create-btn').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled', true);
}


</script>

@endpush


