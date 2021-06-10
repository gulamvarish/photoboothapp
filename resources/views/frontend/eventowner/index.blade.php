@extends('frontend.layouts.app')

@section('content')
    <div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                     Event Owner Image Listing
                </h4>
            </div>
            <!--col-->
        </div>
        <!--row-->
<?php 

    $status = array('0'=>'Inactive', '1'=>'Active');

?><?php //echo "<pre>";print_r($PhotoEvents); echo "<pre>"; die(); ?>

<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"/>
<link href="{{ asset('css/socialpic.min.css') }}" rel="stylesheet" type="text/css">
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<style type="text/css">
    
    .overlay i {
    font-size: 12px;
}
</style>

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table id="photo-event-table1" class="table">
                      
                        <tbody>

                           
                                @if(isset($PhotoEvents) && !empty($PhotoEvents))
                                   @foreach ($PhotoEvents as $key => $PhotoEventdata)

                                    <tr>
                                            <td style="max-width: 100%;display: flex;flex-wrap: wrap;"><h4 style="width: 100%;">{{$PhotoEventdata->event_title}}</h4><br>
                                             @if(isset($PhotoEventdata->event_owner) && $PhotoEventdata->event_owner !='')
                                               @foreach ($PhotoEventdata->event_owner as $key => $imagedata)
                                                <img src="{{ asset('/storage/img/event/eventimage/'.$imagedata->image)}}" style=" width: 100px; margin-right: 15px; margin-top: 15px">
                                                
                                               @endforeach
                                             @endif

                                            </td> 

                                           
                                    </tr><br>

                                         
                                   @endforeach

                               @else 
                                    <tr><td>No Results</td></tr>
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
