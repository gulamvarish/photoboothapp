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



        <div class="row mt-4">
                                

                           
                                @if(isset($PhotoEvents) && !empty($PhotoEvents))
                                   @foreach ($PhotoEvents as $key => $PhotoEventdata)

                                        <div class="col-md-12">
                                            <h4 style="width: 100%;">{{$PhotoEventdata->event_title}}</h4>
                                        </div>
                                             @if(isset($PhotoEventdata->event_owner) && $PhotoEventdata->event_owner !='')
                                               @foreach ($PhotoEventdata->event_owner as $key => $imagedata)

                                                   @php 

                                                    $imagedata1 = explode(".",$imagedata->image);
                                                    
                                                     $imagename = $imagedata1[0];
                                                     $imageext  = $imagedata1[1];
                                                     $imagethumbinailname = $imagename.'-thumbnail.'.$imageext

                                                   @endphp
                                            <div class="col-md-2">
                                                      <div class="thumbnail">
                                                <img src="{{ asset('/storage/img/event/eventimage/'.$imagethumbinailname)}}" downloadurl="{{ asset('/storage/img/event/eventimage/'.$imagedata->image)}}" name="{{$imagedata->image}}" style=" width: 100%; margin-right: 15px; margin-top: 15px">
                                            </div></div>
                                                
                                               @endforeach
                                             @endif

                                            

                                         
                                   @endforeach

                               @else 
                                    <tr><td>No Results</td></tr>
                              @endif


                        
               
            <!--col-->
        </div>
        <!--row-->

    </div>
    <!--card-body-->
</div>
<!--card-->

@endsection
