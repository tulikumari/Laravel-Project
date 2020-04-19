@extends('layouts.app')
@section('title', 'Author Latest Posts')
@section('page-header', 'Author Latest Posts')
@section('refresh-button')
    <a href="{{ route('cache', $sectionId.$case->id.$duration) }}" class="btn btn-success">Refresh</a>
@endsection
@section('content')
    <div class="inner-info-content">
        {{ Form::open(['url'=> route('author-posts', $case->id), 'method' => 'GET', 'id' => 'post_duration_form']) }}
            {{ Form::label('duration', 'Filter By: ') }}
            {{ Form::select('duration',
                array('24' => 'Last 24 Hours', 'week' => 'Last Week', 'month' => "Last Month"),
                isset($duration)? $duration: null,
                ['class' => 'form-control author_post_duration'])
            }}
        {{ Form::close() }}
        <div class="twitter_main_entities">
        @if(!empty($authorPosts))
            @foreach($authorPosts as $tweetPreview)
                <div class="twitter_entity">{!!html_entity_decode($tweetPreview)!!}</div>
            @endforeach
        @else
            <p> No item Found </p>
        @endif
        </div>
    </div>
    <div class="fixed_buttons">@include('layouts.app-partials.flag-buttons')</div>
@endsection
