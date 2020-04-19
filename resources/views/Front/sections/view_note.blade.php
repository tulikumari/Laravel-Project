@extends('layouts.app-cm-fancybox')

@section('title', 'Cases')

@section('content')



<div class="view_model" >
 
 
 

              
            <div class="font_white" ><h3>{{ $note ? $note['note_title'] :'' }}</h3> 
            {!!html_entity_decode($note?$note['title_desc']:'')!!}  

 
 
 

</div>

@endsection

