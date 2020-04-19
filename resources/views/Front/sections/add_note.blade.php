@extends('layouts.app-cm-fancybox')

@section('title', 'Cases')

@section('content')

<style>
    .ck-editor__editable {
        min-height: 300px;
    }
</style>

<div class="main-login" style="min-height:580px;">

    {{ Form::open(['route'=> 'cases.save.notes', 'method' => 'POST','class' => 'form-main']) }}

    <div class="form-main">

        <div class="form_body normal_form_body">

            @if($note)

              <h1>Edit Note</h1>

            @else

              <h1>Add Note</h1>

            @endif

            <input type="hidden" name="noteId" value="{{ $note?$note['id']:''}}">

            <input type="hidden" name="caseManagementId" value="{{$caseManagementId}}">
            <input type="hidden" name="user_id" value="{{$user_id}}">

            <div class="input-group"><input type="text" placeholder="Title" name="title" required class="form-control" value="{{ $note ? $note['note_title'] :'' }}"/></div>
            
            <div ><textarea id="descEditor" placeholder="Description" class="form-control" name="description">{{ htmlspecialchars_decode($note?$note['title_desc']:'') }}</textarea></div>

        </div>

        <div class="form_buttons">
        <button type="button" class="btn pull-right btn btn_primary" onclick="parent.closeFancyBox('0');">close</button>

            <button type="submit" class="btn pull-right btn btn_primary margin15" onclick="validateFormt();">Submit</button>

        </div>

    </div>

    {{ Form::close() }}

</div>
<script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>

 

<script>
    ClassicEditor
        .create( document.querySelector( '#descEditor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

 <script>	
function validateFormt() {
  //var x = document.getElementById("full_name").value;
  var xy = $('input[name="title"]').val();  
  
  if (xy == "") {
   // alert("Name must be filled out");
    return false;
  }
 
   parent.closeFancyBox();
  
  
}
</script>

@endsection

