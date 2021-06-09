<div class="card-body">
    <div class="row">
        <div class="col-sm-5">
            <h4 class="card-title mb-0">
                {{ __('labels.backend.access.layoutspages.management') }}
                <small class="text-muted">{{ (isset($page)) ? __('labels.backend.access.layoutspages.edit') : __('labels.backend.access.layoutspages.create') }}</small>
            </h4>
        </div>
        <!--col-->
    </div>
    <!--row-->

    <hr>

    <div class="row mt-4 mb-4">
        <div class="col">
            <div class="form-group row">
                {{ Form::label('layout_title', trans('validation.attributes.backend.access.layoutspages.layout_title'), ['class' => 'col-md-2 from-control-label required']) }}

                <div class="col-md-10">
                    {{ Form::text('layout_title', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.layoutspages.layout_title'), 'required' => 'required']) }}
                </div>
                <!--col-->
            </div>
           
            <!--form-group-->

            <div class="form-group row">
                {{ Form::label('layout_image', trans('validation.attributes.backend.access.layoutspages.layout_image'), ['class' => 'col-md-2 from-control-label required']) }}

                @if(!empty($blog->layout_image))
                <div class="col-lg-1">
                    <img src="{{ asset('storage/img/blog/'.$blog->layout_image) }}" height="80" width="80">
                </div>
                <div class="col-lg-5">
                    {{ Form::file('layout_image', ['id' => 'layout_image']) }}
                </div>
                @else
                <div class="col-lg-5">
                    {{ Form::file('layout_image', ['id' => 'layout_image']) }}
                </div>
                @endif
            </div>
            

            <div class="form-group row">
                {{ Form::label('status', trans('validation.attributes.backend.access.layoutspages.status'), ['class' => 'col-md-2 from-control-label required']) }}

                <div class="col-md-10">
                    <div class="checkbox d-flex align-items-center">
                        @php
                        $status = isset($page) ? '' : 'checked';
                        @endphp
                        <label class="switch switch-label switch-pill switch-primary mr-2" for="role-1"><input class="switch-input" type="checkbox" name="status" id="role-1" value="1" {{ (isset($page->status) && $page->status === 1) ? "checked" : $status }}><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                    </div>
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
        FTX.Pages.edit.init("{{ config('locale.languages.' . app()->getLocale())[1] }}");
    });
</script>
@stop