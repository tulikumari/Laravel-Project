@extends('layouts.app')
@section('title', 'Case Results')
@section('page-header', 'Case Results')
@section('content')
@php
    $totalResults = $case->sectionFakeResults()->count() + $case->sectionTrustedResults()->count();
    $fakePrecentage = 0;
    if($totalResults > 0){
        $fakePrecentage = ($case->sectionFakeResults()->count()/$totalResults)*100;
    }

@endphp
    <div class="inner-info-content">
        <table class="table table-striped case_results">
            <thead>
                <tr>
                    <th></th>
                    <th>Fake News</th>
                    <th>Trusted News</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sections as $sectionId => $section)
                    <tr>
                        <td>{{ $section }}</td>
                        <td>{{ $case->sectionFakeResults()->where('section_id', $sectionId)->count() }}</td>
                        <td>{{ $case->sectionTrustedResults()->where('section_id', $sectionId)->count() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h3>This news is {{ round($fakePrecentage) }}% fake.</h3>
    </div>
    <div class="fixed_buttons">
        <div class="inner-info-content flag_button">
            {{ Form::open(['url'=> route('flag-case', $case->id), 'class' => 'flag_trusted']) }}
                {{ Form::hidden('flag', 'trusted')}}
                {{ Form::button('<i class="fa fa-check"></i> Flag Trusted', ['type' => 'submit', 'class' => 'btn pull-left btn_primary']) }}
            {{ Form::close() }}
            {{ Form::open(['url'=> route('flag-case', $case->id), 'class' => 'flag_fake']) }}
                {{ Form::hidden('flag', 'fake')}}
                {{ Form::button('<i class="fa fa-times"></i> Flag Fake', ['type' => 'submit', 'class' => 'btn pull-right btn_secondary']) }}
            {{ Form::close() }}
        </div>
    </div>
@endsection
