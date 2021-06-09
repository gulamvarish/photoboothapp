@extends('backend.layouts.app')

@section('title', __('labels.backend.access.photo-events.management') . ' | ' . __('labels.backend.access.photo-events.edit'))

@section('breadcrumb-links')
    @include('backend.photo-events.includes.breadcrumb-links')
@endsection

@section('content')
   


     <form  method="POST" action ="{{url('admin/photo-events/update')}}/{{$photoEvent[0]->id}}" class="form-horizontal" role="form" id="create-permission"  enctype="multipart/form-data" ajax_url="{{url('admin/photo-events/deletenolayoutajax')}}" >

    @method('PUT')
    @csrf

    <div class="card">
        @include('backend.photo-events.editform')
        <div class="card-footer">
    <div class="row">
        <div class="col">
            <a href="{{url('admin/photo-events')}}" class="btn btn-danger btn-sm">Cancel</a>
        </div><!--col-->

        <div class="col text-right">
            <input class="btn btn-success btn-sm pull-right" type="submit" value="Update">
        </div><!--row-->
    </div><!--row-->
    </div>
        
    </div><!--card-->
   </form>
@endsection