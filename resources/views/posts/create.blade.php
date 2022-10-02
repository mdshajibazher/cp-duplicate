@extends('layouts.adminlayout')
@section('title','Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                Create Post
            </div>
            <div class="card-body">
                <form action="{{route('posts.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Enter Title<span>*</span></label>
                <input type="text" id="title" placeholder="Enter Title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{old('title')}}" required>

                    @error('title')
                    <small class="form-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input id="description" type="hidden" name="description"  value="{{old('description')}}">
                    <trix-editor input="description" id="desc"></trix-editor>
                </div>


                <div class="form-group">
                    <label for="category">Category</label>
                    <select data-placeholder="Select a Category" name="category" id="category" class="form-control" >
                      <option></option>
                      @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                      @endforeach
                    </select>
                    <small class="text-danger category_err"></small>
                </div>

                <div class="form-group">
                    <label for="image">Image<span>*</span></label>
                <input type="file" id="image" placeholder="Upload Post Image" class="form-control @error('image') is-invalid @enderror" name="image" required>

                    @error('image')
                    <small class="form-error">{{ $message }}</small>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="tags">Tag</label>
                    <select data-placeholder="Select Tag" class="js-example-responsive" multiple="multiple" name="tags[]" id="tags" class="form-control"  >
                    <option></option>
                    @foreach ($tags as $tag)
                    <option value="{{$tag->id}}">{{$tag->tag_name}}</option>
                    @endforeach
                    </select>
                    <small class="text-danger tags_err"></small>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-danger">Submit</button>
                </div>

            </form>

            </div>
        </div>
    </div>
</div>
@endsection


@push('css')
<link rel="stylesheet" href="{{asset('assets/css/trix.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/dropify.min.css')}}">
<style>
    .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice__remove{
      color: #000 !important;
    }
  </style>
@endpush

@push('js')
<script src="{{asset('assets/js/trix.js')}}"></script>
<script src="{{asset('assets/js/dropify.min.js')}}"></script>
<script>
    $('#image').dropify();
    $('#tags').select2({
        width: '100%',
        theme: "bootstrap",templateSelection: function (data, container) {
        $(container).css("background-color","#A3CB38");
        $(container).css("color", "#000");
        return data.text;
        }
    });

      //For Editmodal
  $('#category').select2({
      width: '100%',
      theme: "bootstrap"
    });
</script>
@endpush

