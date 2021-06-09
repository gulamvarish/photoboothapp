@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.layouts.management'))

@section('breadcrumb-links')
@include('backend.layoutspages.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.access.layoutspages.management') }} <small class="text-muted">{{ __('labels.backend.access.layoutspages.active') }}</small>
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
                    <table id="layouts-table" class="table" data-ajax_url="{{ route("admin.layoutspages.get") }}">
                        <thead>
                            <tr>
                                <th>{{ trans('labels.backend.access.layoutspages.table.name') }}</th>
                                <th data-orderable="false">Layout Image</th>
                                <th>{{ trans('labels.backend.access.layoutspages.table.status') }}</th>
                                <th>{{ trans('labels.backend.access.layoutspages.table.createdat') }}</th>
                                <th>{{ trans('labels.general.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                                @if(isset($layoutsdatas) && $layoutsdatas !='')
                                   @foreach ($layoutsdatas as $key => $layoutvalue)                                   
                                   <tr>
                                   <td>{{ $layoutvalue->layout_title }}</td>
                                   <td> <img src="{{ asset('/storage/img/layout/'.$layoutvalue->layout_image) }}" height="50" width="50"></td>
                                   

                                   <td>{{ $status[$layoutvalue->status] }}</td>
                                   <td>{{ date('m-d-Y',strtotime($layoutvalue->created_at)) }}</td>
                                   <td>
                                        <div class="btn-group" role="group" aria-label="User Actions">
                                            <a href="{{url()->current()}}/edit/{{ $layoutvalue->id }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                       </div>
                                       <a href="#" class="btn btn-primary btn-danger btn-sm" data-method="delete" data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();">
                                         <i data-toggle="tooltip" data-placement="top" title="Delete" class="fa fa-trash"></i>
                                         <form action="{{url()->current()}}/delete/{{ $layoutvalue->id }}" method="POST" name="delete_item" style="display:none">
                                            {{ csrf_field() }}
                                        <input type="hidden" name="deleteid" value="{{ $layoutvalue->id }}">
                                       
                                        </form>
                                     </a>
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

@section('layoutscript')
<script>
    FTX.Utils.documentReady(function() {
        FTX.layouts.list.init();
    });
</script>
@endsection