@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.photo-events.management'))

@section('breadcrumb-links')
@include('backend.photo-events.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.access.photo-events.qrcode') }} <small class="text-muted">{{ __('labels.backend.access.photo-events.qrcodecreate') }}</small>
                </h4>
            </div>
            <!--col-->
        </div>
        <!--row-->

        <div class="row mt-4">
            <div class="col">
                
            <div class="form-group row">
              

                <div class="col-md-10">
                 
                    {!! QrCode::size(250)->generate($id); !!}
                </div>
              
            </div>
        </div>
        <!--row-->

    </div>
    <!--card-body-->
</div>
<!--card-->
@endsection

