@extends('admin.layouts.master')
@section('page_title') Account Settings @endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Account Settings</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{route('admin.settings.account')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Current Password</label>
                                <input type="password" class="form-control" name="current_password"  />
                                @if($errors->has('current_password')) <p class="text-danger">{{$errors->first('current_password')}}</p> @endif
                            </div>
                            <div class="form-group">
                                <label for="">New Password</label>
                                <input type="password" class="form-control" name="new_password" />
                                @if($errors->has('new_password')) <p class="text-danger">{{$errors->first('new_password')}}</p> @endif

                            </div>
                            <div class="form-group">
                                <label for="">Confirm New Password</label>
                                <input type="password" class="form-control" name="new_password_confirmation" />
                                @if($errors->has('new_password_confirmation')) <p class="text-danger">{{$errors->first('new_password_confirmation')}}</p> @endif

                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection
@section('footer_scripts')
    <script>

    </script>
@endsection
