<div class="card-body">
    <div class="row">
        <div class="col-sm-5">
            <h4 class="card-title mb-0">
                {{ __('labels.backend.access.photo-events.management') }}
                <small class="text-muted">{{ (isset($photoEvent)) ? __('labels.backend.access.photo-events.edit') : __('labels.backend.access.photo-events.create') }}</small>
            </h4>
        </div>
        <!--col-->
    </div>
    <!--row-->

    <hr>

    <div class="row mt-4 mb-4">
        <div class="col">
            <div class="form-group row">
                {{ Form::label('event_title', trans('validation.attributes.backend.access.photo-events.event_title'), ['class' => 'col-md-2 from-control-label required']) }}

                <div class="col-md-10">
                   <input class="form-control" placeholder="{{trans('validation.attributes.backend.access.photo-events.event_title')}}" value="{{$photoEvent[0]->event_title}}" required="required" name="event_title" type="text" id="event_title">
                </div>
                <!--col-->
            </div>
           
<?php 

?>
           
            <!--form-group-->

            <div class="form-group row">
                {{ Form::label('no_of_layout', trans('validation.attributes.backend.access.photo-events.no_of_layout'), ['class' => 'col-md-2 from-control-label required']) }}

                <div class="col-md-10">
                 <div class="form-group">


                        @if(isset($layoutPageDetail) && $layoutPageDetail !='')
                        <ul style="column-count: 3;list-style: none;margin: 0;padding: 0;">
                         @foreach ($layoutPageDetail as  $key => $layoutPageDetailval)                         
                                     <li>

                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="mr-2 layoutchange form-check-input" id="trigger{{$layoutPageDetailval->id}}" layoutid="{{$layoutPageDetailval->id}}" title="{{$layoutPageDetailval->layout_title}} " @if(in_array($layoutPageDetailval->id, $selectenolayoutIdarr)) checked @endif name="nolayout[]" value="{{$layoutPageDetailval->id}}" >{{$layoutPageDetailval->layout_title}} 
                                            </label>
                                        </div>
                                    </li>                            
                         @endforeach
                     </ul>
                        @endif


                        @if(isset($layoutPageDetail) && $layoutPageDetail !='')
                        <ul id="apppend" style="column-count: 3;list-style: none;margin: 0;padding: 0;" class="mt-3">
                         @foreach ($layoutPageDetail as  $key => $layoutPageDetailval)
                            @if(in_array($layoutPageDetailval->id, $selectenolayoutIdarr)) 

                            <li class="form-group"  id="file{{$layoutPageDetailval->id}}"><label class="small mb-0 font-weight-bold">{{$layoutPageDetailval->layout_title}}</label><br>
                                @if($selectenolayoutarr[$layoutPageDetailval->id])
                                <img src="{{ asset('storage/img/event/layoutbg/'.$selectenolayoutarr[$layoutPageDetailval->id]) }}" height="50" width="50">
                                @endif
                                <input type="file" name="layoutbgimage{{$layoutPageDetailval->id}}">
                                <input type="hidden" id="slected{{$layoutPageDetailval->id}}" name="layoutbgimage{{$layoutPageDetailval->id}}_old" value="{{$selectenolayoutarr[$layoutPageDetailval->id]}}">

                            </li>

                            @endif

                        @endforeach
                     </ul>
                        @endif
                  
                </div>  
                </div>
                <!--col-->
            </div>
          

            <!--form-group-->

            <div class="form-group row">
                {{ Form::label('event_backendbg_image', trans('validation.attributes.backend.access.photo-events.event_backendbg_image'), ['class' => 'col-md-2 from-control-label required']) }}               

                  
                @if(!empty($photoEvent[0]->event_backendbg_image))
                <div class="col-lg-1">
                    <img src="{{ asset('storage/img/event/'.$photoEvent[0]->event_backendbg_image) }}" height="80" width="80">
                    <input class="form-control" placeholder="Layout Title" value="{{$photoEvent[0]->event_backendbg_image}}" required="required" name="event_backendbg_image_old" type="hidden" id="event_backendbg_image_old">
                </div>
                <div class="col-lg-5">
                    {{ Form::file('event_backendbg_image', ['id' => 'event_backendbg_image']) }}
                </div>
                @else
                <div class="col-lg-5">
                    {{ Form::file('event_backendbg_image', ['id' => 'event_backendbg_image']) }}
                </div>
                @endif
               
                <!--col-->
            </div>



            <!--form-group-->

           
            <!--form-group-->

             <div class="form-group row">
                {{ Form::label('event_forntbg_image', trans('validation.attributes.backend.access.photo-events.event_forntbg_image'), ['class' => 'col-md-2 from-control-label required']) }}

                @if(!empty($photoEvent[0]->event_forntbg_image))
                <div class="col-lg-1">
                    <img src="{{ asset('storage/img/event/'.$photoEvent[0]->event_forntbg_image) }}" height="80" width="80">
                    <input class="form-control" placeholder="Layout Title" value="{{$photoEvent[0]->event_forntbg_image}}" required="required" name="event_forntbg_image_old" type="hidden" id="event_forntbg_image_old">
                </div>
                <div class="col-lg-5">
                    {{ Form::file('event_forntbg_image', ['id' => 'event_forntbg_image']) }}
                </div>
                @else
                <div class="col-lg-5">
                    {{ Form::file('event_forntbg_image', ['id' => 'event_forntbg_image']) }}
                </div>
                @endif
                <!--col-->
            </div>
            <!--form-group-->

            <div class="form-group row">
                {{ Form::label('event_feature_image', trans('validation.attributes.backend.access.photo-events.event_feature_image'), ['class' => 'col-md-2 from-control-label required']) }}

                @if(!empty($photoEvent[0]->event_feature_image))
                <div class="col-lg-1">
                    <img src="{{ asset('storage/img/event/feature/'.$photoEvent[0]->event_feature_image) }}" height="80" width="80">
                    <input class="form-control" placeholder="Event Feature Image" value="{{$photoEvent[0]->event_feature_image}}" required="required" name="event_feature_image_old" type="hidden" id="event_feature_image_old">
                </div>
                <div class="col-lg-5">
                    {{ Form::file('event_feature_image', ['id' => 'event_feature_image']) }}
                </div>
                @else
                <div class="col-lg-5">
                    {{ Form::file('event_feature_image', ['id' => 'event_feature_image']) }}
                </div>
                @endif
                <!--col-->
            </div>


              <!--form-group-->

            <div class="form-group row">
                {{ Form::label('event_sound', trans('validation.attributes.backend.access.photo-events.event_sound'), ['class' => 'col-md-2 from-control-label required']) }}

                @if(!empty($photoEvent[0]->event_sound))
                <div class="col-lg-1">
                   {{$photoEvent[0]->event_sound}}
                    <input class="form-control" placeholder="Layout Title" value="{{$photoEvent[0]->event_sound}}" required="required" name="event_sound_old" type="hidden" id="event_sound_old">
                </div>
                <div class="col-lg-5">
                    {{ Form::file('event_sound', ['id' => 'event_sound']) }}
                </div>
                @else
                <div class="col-lg-5">
                    {{ Form::file('event_sound', ['id' => 'event_sound']) }}
                </div>
                @endif
                <!--col-->
            </div>
            <!--form-group-->

          <!--   <div class="form-group row">
                {{ Form::label('event_qrcode', trans('validation.attributes.backend.access.photo-events.event_qrcode'), ['class' => 'col-md-2 from-control-label required']) }}

                <div class="col-md-10">
                    {!! QrCode::size(250)->generate('ItSolutionStuff.com'); !!}
                </div>
              
            </div> -->

             <div class="form-group row">
                {{ Form::label('event_host', trans('validation.attributes.backend.access.photo-events.event_host'), ['class' => 'col-md-2 from-control-label required']) }}

               

                <div class="col-md-10">
                  
                    <select class="form-control" name="event_host" placeholder="{{trans('validation.attributes.backend.access.photo-events.event_host')}}" id="event_host">
                        <option value="">Select Event Host</option>
                    @php $userroleid = getUserByrole(2);  @endphp

                    @if(isset($userroleid) && !empty($userroleid))
                    @foreach ($userroleid as $key => $value)
                        <option value="{{$value->user_id}}" @if($photoEvent[0]->event_host == $value->user_id) selected @endif>{{getUsername($value->user_id)}}</option>
                   @endforeach
                   @endif
                    </select>
                </div>
                <!--col-->
            </div>
            <!--form-group-->

             <div class="form-group row">
                {{ Form::label('event_collage', trans('validation.attributes.backend.access.photo-events.event_collage'), ['class' => 'col-md-2 from-control-label required']) }}

              

                 <div class="col-md-10">                   
                    <select class="form-control" name="event_collage" placeholder="{{trans('validation.attributes.backend.access.photo-events.event_collage')}}" id="event_collage">
                        <option value="">Select Event Collage</option>
                    @php $userroleid = getUserByrole(3);  @endphp
                    @if(isset($userroleid) && !empty($userroleid))
                    @foreach ($userroleid as $key => $value)
                        <option value="{{$value->user_id}}" @if($photoEvent[0]->event_collage == $value->user_id) selected @endif>{{ getUsername($value->user_id) }}</option>
                   @endforeach
                   @endif
                    </select>
                </div>
                <!--col-->
            </div>
            <!--form-group-->

            <div class="form-group row">
                {{ Form::label('status', trans('validation.attributes.backend.access.photo-events.status'), ['class' => 'col-md-2 from-control-label required']) }}

                <div class="col-md-10">
                    <div class="checkbox d-flex align-items-center">
                        <select name="status">
                            <option value="1" @if($photoEvent[0]->status==1) selected @endif>Active</option>
                            <option value="0" @if($photoEvent[0]->status==0) selected @endif>Deactive</option>
                        </select>
                        
                    </div>
                </div>
                <!--col-->
            </div>
			<div class="form-group row">
                <label for="isActionOnDate" class="col-md-2 from-control-label">isActionOnDate</label>

                <div class="col-md-10">
                    <div class="checkbox d-flex align-items-center">
                        <select name="isActionOnDate">
                            <option value="1" @if($photoEvent[0]->isActionOnDate==1) selected @endif>On</option>
                            <option value="0" @if($photoEvent[0]->isActionOnDate==0) selected @endif>Off</option>
                        </select>
                        
                    </div>
                </div>
                <!--col-->
            </div>
			<div class="form-group row">
                <label for="StartDatenTime" class="col-md-2 from-control-label ">Start Date & Time</label>

                <div class="col-md-10">
					<input class="form-control" placeholder="YYYY-MM-DD H:i:s" value="{{$photoEvent[0]->event_start_date}}" required="required" name="event_start_date" type="text" id="event_start_date">
                </div>
                <!--col-->
            </div>
			<div class="form-group row">
                <label for="EndDatenTime" class="col-md-2 from-control-label ">End Date & Time</label>

                <div class="col-md-10">
					<input class="form-control" placeholder="YYYY-MM-DD H:i:s" value="{{$photoEvent[0]->event_end_date}}" required="required" name="event_end_date" type="text" id="event_start_date">
                </div>
                <!--col-->
            </div>
            <!--form-group-->
        </div>
        <!--col-->
    </div>
    <!--row-->
</div>
<!--card-body-->

@section('pagescript')
<script type="text/javascript">
    FTX.Utils.documentReady(function() {
        FTX.PhotoEvent.edit.init("{{ config('locale.languages.' . app()->getLocale())[1] }}");
    });

   /*For No Of Layout Bg*/

    $(function() {       
      $(".layoutchange").change(function() {
        var id       = $(this).attr('id');
        var title    = $(this).attr('title'); 
        var layoutid = $(this).attr('layoutid'); 
        var token    = $("#create-permission input[name='_token']").val();
        var ajax_url = $("#create-permission").attr('ajax_url');
        var event_id = <?php echo $photoEvent[0]->id; ?>;
        var filename = $("#slected"+layoutid).val();

        var checkbox = $("#"+id); 
        if (checkbox.is(':checked')) {
          $('#apppend').append('<li class="form-group"  id="file'+id+'"><label class="small mb-0 font-weight-bold">'+title+'</label><br><input type="file" name="layoutbgimage'+layoutid+'"></li>')
        }else {

           
            $('#file'+id).remove();



            $.ajax({
                        url: ajax_url,
                        method: 'POST',
                        data:{'_token':token, layoutid:layoutid, event_id: event_id, filename: filename },                       

                        success: function (data){
                            
                            if(data.success==true){                                

                                $('#file'+layoutid).remove();
                            
                            }

                }// End of success
              }); // End of Ajax
        }// End of else
    });

     }); 
</script>
@stop