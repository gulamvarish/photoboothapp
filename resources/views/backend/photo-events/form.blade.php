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
                    {{ Form::text('event_title', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.photo-events.event_title'), 'required' => 'required']) }}
                </div>
                <!--col-->
            </div>
           

           
            <!--form-group-->

            <div class="form-group row">
                {{ Form::label('no_of_layout', trans('validation.attributes.backend.access.photo-events.no_of_layout'), ['class' => 'col-md-2 from-control-label required']) }}

                <div class="col-md-10">
                <div class="form-group">



                 

                   
                  
                        @if(isset($layoutPageDetail) && !empty($layoutPageDetail))
                        <ul style="column-count: 3;list-style: none;margin: 0;padding: 0;">
                         @foreach ($layoutPageDetail as  $key => $layoutPageDetailval)                         
                                     <li>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="mr-2 layoutchange form-check-input" id="trigger{{$layoutPageDetailval->id}}" layoutid="{{$layoutPageDetailval->id}}" title="{{$layoutPageDetailval->layout_title}} " name="nolayout[]" value="{{$layoutPageDetailval->id}}">{{$layoutPageDetailval->layout_title}} 
                                            </label>
                                        </div>
                                    </li>                            
                         @endforeach
                     </ul>
                        @endif

                        <ul id="apppend" style="column-count: 3;list-style: none;margin: 0;padding: 0;" class="mt-3"></ul>
                  
                </div> 
                </div>
                <!--col-->
            </div>
          

            <!--form-group-->

            <div class="form-group row">
                {{ Form::label('event_backendbg_image', trans('validation.attributes.backend.access.photo-events.event_backendbg_image'), ['class' => 'col-md-2 from-control-label required']) }}

                <div class="col-md-10">                   
                    {{ Form::file('event_backendbg_image', ['id' => 'event_backendbg_image']) }}
                </div>
                <!--col-->
            </div>
            <!--form-group-->

           
            <!--form-group-->

             <div class="form-group row">
                {{ Form::label('event_forntbg_image', trans('validation.attributes.backend.access.photo-events.event_forntbg_image'), ['class' => 'col-md-2 from-control-label required']) }}

                <div class="col-md-10">                   
                    {{ Form::file('event_forntbg_image', ['id' => 'event_forntbg_image']) }}
                </div>
                <!--col-->
            </div>
            <!--form-group-->

              <!--form-group-->

            <div class="form-group row">
                {{ Form::label('event_sound', trans('validation.attributes.backend.access.photo-events.event_sound'), ['class' => 'col-md-2 from-control-label required']) }}

                <div class="col-md-10">                   
                    {{ Form::file('event_sound', ['id' => 'event_sound']) }}
                </div>
                <!--col-->
            </div>

            <div class="form-group row">
                {{ Form::label('event_feature_image', trans('validation.attributes.backend.access.photo-events.event_feature_image'), ['class' => 'col-md-2 from-control-label required']) }}

                <div class="col-md-10">                   
                    {{ Form::file('event_feature_image', ['id' => 'event_feature_image']) }}
                </div>
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
                        <option value="{{$value->user_id}}">{{getUsername($value->user_id)}}</option>
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
                        <option value="{{$value->user_id}}">{{ getUsername($value->user_id) }}</option>
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
                        @php
                        $status = isset($photoEvent) ? '' : 'checked';
                        @endphp
                        <label class="switch switch-label switch-pill switch-primary mr-2" for="role-1"><input class="switch-input" type="checkbox" name="status" id="role-1" value="1" {{ (isset($photoEvent->status) && $photoEvent->status === 1) ? "checked" : $status }}><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                    </div>
                </div>				
                <!--col-->
            </div>
			<div class="form-group row">
				<label for="isActionOnDate" class="col-md-2 from-control-label ">isActionOnDate</label>
                
			<div class="col-md-10">
                    <div class="checkbox d-flex align-items-center">
                        @php
                        $status = isset($photoEvent) ? '' : 'checked';
                        @endphp
                        <label class="switch switch-label switch-pill switch-primary mr-2" for="role-2"><input class="switch-input" type="checkbox" name="isActionOnDate" id="role-2" value="1" {{ (isset($photoEvent->isActionOnDate) && $photoEvent->isActionOnDate === 1) ? "checked" : $status }}><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                    </div>
                </div>
		</div>
			
			<div class="form-group row">
                <label for="StartDatenTime" class="col-md-2 from-control-label ">Start Date & Time</label>

                <div class="col-md-10">
                    {{ Form::text('event_start_date', null, ['class' => 'form-control', 'placeholder' => 'YYYY-MM-DD H:i:s']) }}
                </div>
                <!--col-->
            </div>
			<div class="form-group row">
                <label for="EndDatenTime" class="col-md-2 from-control-label ">End Date & Time</label>

                <div class="col-md-10">
                    {{ Form::text('event_end_date', null, ['class' => 'form-control', 'placeholder' => 'YYYY-MM-DD H:i:s']) }}
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
        var checkbox = $("#"+id); 
        if (checkbox.is(':checked')) {
          $('#apppend').append('<li class="form-group"  id="file'+id+'"><label class="small mb-0 font-weight-bold">'+title+'</label><br><input type="file" name="layoutbgimage'+layoutid+'"></li>')
        } else {
          $('#file'+id).remove();
        }
      });
    });
           
</script>
@stop