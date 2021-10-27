@extends('admin.layouts.master')
@section('page_title') Feedbacks @endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Feedbacks</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                    <div class="row">
                        <div class="col-12">
                            @foreach($feedbacks as $feedback)
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="{{asset('public/uploads/'.$feedback->user->profile_picture)}}" alt="user image">
                                        <span class="username">
                                        <a href="#">{{$feedback->user->name}}</a>
                                    </span>
                                        <span class="description">Date - {{$feedback->created_at->format('d-F-Y @ h:i A')}}</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <h4>{{$feedback->subject}}</h4>
                                    <p>
                                        {{$feedback->body}}
                                    </p>
{{--                                    @if(isset($feedback->images) && $feedback->images->count())--}}
{{--                                        <p>--}}
{{--                                            <a href="javascript:;" class="link-black text-sm view_feedback_attachments" data-feedback="{{$feedback->id}}"><i class="fas fa-link mr-1"></i> View Attachments </a>--}}
{{--                                        </p>--}}
{{--                                    @endif--}}
                                </div>
                            @endforeach


                        </div>
                        <div class="col-12 text-center">
                            <nav aria-label="Contacts Page Navigation">
                                {{$feedbacks->links()}}
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2 feedback_img_container">

                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
@section('footer_scripts')
{{--    <script>--}}
{{--        $(function(){--}}
{{--            $(document).on('click','.view_feedback_attachments',function(){--}}
{{--                var id=$(this).data('feedback');--}}
{{--                $(".feedback_img_container").empty();--}}
{{--                var img_path="{{asset('public/uploads')}}"--}}
{{--                $.ajax({--}}
{{--                    url:"{{route('admin.feedbacks.images')}}",--}}
{{--                    method:"POST",--}}
{{--                    data:{_token:"{{csrf_token()}}",id:id},--}}
{{--                    success:function(response){--}}
{{--                        if(response.status==1){--}}
{{--                            $.each(response.data,function(index,rec){--}}
{{--                                $(".feedback_img_container").append('<img src=" '+img_path+'/'+rec.feedback_image_src+'" alt="" class="img img-thumbnail mr-1" style="width: 150px; height: 150px">');--}}
{{--                            })--}}
{{--                        }--}}
{{--                    },--}}
{{--                    error:function(xhr){--}}
{{--                        alert('something went wrong')--}}
{{--                    }--}}
{{--                })--}}
{{--            })--}}
{{--        })--}}
{{--    </script>--}}
@endsection
