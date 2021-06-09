@extends('backend.layouts.app')

@section('title', __('labels.backend.access.layoutspages.management') . ' | ' . __('labels.backend.access.layoutspages.create'))

@section('breadcrumb-links')
    @include('backend.layoutspages.includes.breadcrumb-links')
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.layoutspages.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-permission', 'files' => true]) }}

    <div class="card">
        @include('backend.layoutspages.form')
        @include('backend.components.footer-buttons', ['cancelRoute' => 'admin.layoutspages.index'])
    </div><!--card-->
    {{ Form::close() }}
@endsection