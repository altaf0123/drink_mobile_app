@extends('admin.layouts.master')
@section('page_title') General Content @endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('public/assets/admin/plugins/summernote/summernote-bs4.css')}}">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h3 class="card-title">
                       <h3>{{$content->type}}</h3>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body pad">
                    <form action="{{route('admin.content.save',['type'=>$content->type])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                        <textarea name="body" class="textarea" placeholder="Place some text here"
                                  style="width: 100%; height: 500px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$content->body}}</textarea>
                        </div>
                        <button class="btn btn-primary float-right">Save</button>
                    </form>

                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('public/assets/admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script>
        $(function(){
            $('.textarea').summernote()
            $(".note-insert").hide()
        })
    </script>
@endsection
