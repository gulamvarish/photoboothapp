@extends('backend.layouts.app')

@section('title', __('labels.backend.access.layoutspages.management') . ' | ' . __('labels.backend.access.layoutspages.edit'))

@section('breadcrumb-links')
    @include('backend.layoutspages.includes.breadcrumb-links')
@endsection



@section('content')
    <form  method="POST" action ="{{url('admin/layoutspages/update')}}/{{$layoutsPage[0]->id}}" class="form-horizontal" role="form" id="create-permission"  enctype="multipart/form-data">

    @method('PUT')
    {{ csrf_field() }}

    <div class="card">
        @include('backend.layoutspages.editform')
        <div class="card-footer">
    <div class="row">
        <div class="col">
            <a href="{{url('admin/layoutspages')}}" class="btn btn-danger btn-sm">Cancel</a>
        </div><!--col-->

        <div class="col text-right">
            <input class="btn btn-success btn-sm pull-right" type="submit" value="Update">
        </div><!--row-->
    </div><!--row-->
</div>
        
    </div><!--card-->
   </form>
@endsection