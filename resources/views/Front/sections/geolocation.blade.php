@extends('layouts.app')
@section('title', 'Post Geo Location')
@section('page-header', 'Post Geo Location')
@section('content')
    <div class="inner-info-content">
        <div style="width: 100%; height: 500px;">
            {!! Mapper::render() !!}
        </div>
    </div>
    <div class="fixed_buttons">@include('layouts.app-partials.flag-buttons')</div>
@endsection
