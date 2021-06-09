@extends('backend.layouts.app')

@section('title', __('labels.backend.access.photo-events.management') . ' | ' . __('labels.backend.access.photo-events.create'))

@section('breadcrumb-links')
    @include('backend.photo-events.includes.breadcrumb-links')
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.photo-events.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-permission', 'files' => true]) }}

    <div class="card">
    	  
        @include('backend.photo-events.form')
        @include('backend.components.footer-buttons', ['cancelRoute' => 'admin.photo-events.index'])
    </div><!--card-->
    {{ Form::close() }}
@endsection