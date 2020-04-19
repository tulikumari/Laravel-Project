@extends('layouts.app')
@section('title', 'Same Area Posts')
@section('page-header', 'Same Area Posts')
@section('refresh-button')
    <a href="{{ route('cache', $sectionId.$case->id) }}" class="btn btn-success">Refresh</a>
@endsection
@section('content')
    <div class="inner-info-content">
        <div class="twitter_main_entities">
        @if(!empty($sameAreaPosts))
            @foreach($sameAreaPosts as $tweetPreview)
                <div class="twitter_entity">{!!html_entity_decode($tweetPreview)!!}</div>
            @endforeach
        @else
            <p> No item Found </p>
        @endif
        </div>
    </div>
    <div class="fixed_buttons">@include('layouts.app-partials.flag-buttons')</div>
@endsection
