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
                    {{ __('labels.backend.access.photo-events.management') }} <small class="text-muted">{{ __('labels.backend.access.photo-events.active') }}</small>
                </h4>
            </div>
            <!--col-->
        </div>
        <!--row-->
<?php 

    $status = array('0'=>'Inactive', '1'=>'Active');

?>
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table id="photo-event-table1" class="table" data-ajax_url="{{ route("admin.photoEvents.get") }}">
                        <thead>
                            <tr>
                                <th>{{ trans('labels.backend.access.photo-events.table.name') }}</th>
                                <th>{{ trans('labels.backend.access.photo-events.table.status') }}</th>
                                <th data-orderable="false">{{ trans('labels.backend.access.photo-events.table.createdby') }}</th>
                                <th>{{ trans('labels.backend.access.photo-events.table.createdat') }}</th>
                                <th>{{ trans('labels.general.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                                @if(isset($photoeventdata) && $photoeventdata !='')
                                   @foreach ($photoeventdata as $key => $photoeventvalue)                                   
                                   <tr>
                                   <td>{{ $photoeventvalue->event_title }}</td>
                                   

                                   <td>{{ $status[$photoeventvalue->status] }}</td>
                                   <td>{{getUsername($photoeventvalue->created_by)}} </td>
                                   <td>{{ date('m-d-Y',strtotime($photoeventvalue->created_at)) }}</td>
                                   <td>
                                    <div class="btn-group" role="group" aria-label="Event Actions">
                                            <a href="{{url()->current()}}/qrcodegenrate/{{ $photoeventvalue->id }}" data-toggle="tooltip" data-placement="top" title="Print QR Code" class="btn btn-primary btn-sm">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </div>
                                        <div class="btn-group" role="group" aria-label="Event Actions">
                                       
                                            <a href="{{url()->current()}}/edit/{{ $photoeventvalue->id }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-success btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                       </div>
                                       <!-- <a href="#" class="btn btn-primary btn-danger btn-sm" data-method="delete" data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();">
                                         <i data-toggle="tooltip" data-placement="top" title="Delete" class="fa fa-trash"></i>
                                         <form action="{{url()->current()}}/delete/{{ $photoeventvalue->id }}" method="POST" name="delete_item" style="display:none">
                                            {{ csrf_field() }}
                                        <input type="hidden" name="deleteid" value="{{ $photoeventvalue->id }}">
                                       
                                        </form>
                                     </a> -->

                                       
                                    </td>
                                   <tr>

                                         
                                   @endforeach

                                @endif


                        </tbody>
                    </table>
                </div>
            </div>
            <!--col-->
        </div>
        <!--row-->

    </div>
    <!--card-body-->
</div>
<!--card-->
@endsection

@section('pagescript')
<script>
    FTX.Utils.documentReady(function() {
        FTX.PhotoEvent.list.init();
    });
</script>
@endsection