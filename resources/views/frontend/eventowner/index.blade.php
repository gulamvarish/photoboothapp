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
            <div class="col">
                <div class="table-responsive">
                    <table id="photo-event-table1" class="table">
                      
                        <tbody>

                           
                                @if(isset($PhotoEvents) && !empty($PhotoEvents))
                                   @foreach ($PhotoEvents as $key => $PhotoEventdata)

                                    <tr>
                                            <td style="max-width: 100%;display: flex;flex-wrap: wrap;"><h4 class="titleevent"><a href="event-gallery/{{$PhotoEventdata->id}}"> {{$PhotoEventdata->event_title}}</a></h4><a href="event-gallery/{{$PhotoEventdata->id}}" class="btn viewbtn">View Gallery</a>
                                             
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
