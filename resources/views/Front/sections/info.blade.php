@extends('layouts.app')
@section('title', 'Case Info')
@section('page-header', 'Case Info')
@section('refresh-button')
    <a href="{{ route('cache', [$case, $sectionId]) }}" class="btn btn-success">Refresh</a>
@endsection
@section('content')
    <div class="inner-info-content">
         <h3>{{ $case->title }}</h3>
        <ul>
            <li>URL: <a href="{{ $case->url }}">{{ $case->url }}</a></li>
            <li>Keywords: {{ $case->keywords }}</li>
            <li>Reported By: {{ isset($case->user)? $case->user->name: '' }}</li>
            <li>Reported on: {{ $case->created_at->format('d/m/Y h:i') }}</li>
        </ul>
        <a href="{{ route('editcase', $case->id) }}" class="btn edit_btn btn_primary" role="button"><i class="fa fa-pencil"></i> Edit</a>
    </div>
    <h3 class="info-head">Preview</h3>
    <div class="inner-info-content">
        {!!html_entity_decode($tweetPreview)!!}
    </div>
    <div class="fixed_buttons">@include('layouts.app-partials.flag-buttons')</div>
@endsection
