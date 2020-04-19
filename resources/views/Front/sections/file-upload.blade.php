@extends('layouts.app-cm')
@section('title', 'Cases')
@section('content')
<style>
  #navigation {
    margin: 10px 0;
  }
  @media (max-width: 767px) {
    #title,
    #description {
      display: none;
    }
  }
</style>

<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css"/>
<link rel="stylesheet" href="{{ asset('public/file-uploader/css/jquery.fileupload.css') }}" />
<link rel="stylesheet" href="{{ asset('public/file-uploader/css/jquery.fileupload-ui.css') }}" />
<noscript><link rel="stylesheet" href="{{ asset('public/file-uploader/css/jquery.fileupload-noscript.css') }}"/></noscript>
<noscript><link rel="stylesheet" href="{{ asset('public/file-uploader/css/jquery.fileupload-ui-noscript.css') }}"/></noscript>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<div class="inner-info">
    <div class="container">
        <h3 class="info-head addspc">Files</h3>
        <div class="inner-info-content cases">
            <div class="blocked_spaced">
                <form id="fileupload"  method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="caseManagementId" value="{{$caseManagementId}}">
                    <div class="row fileupload-buttonbar">
                        <div class="col-7">
                            <span class="btn btn_primary fileinput-button">
                              <i class="fa fa-plus"></i>
                              <span>Add files...</span>
                              <input type="file" id="fileupload" name="files[]" multiple />
                            </span>
                            <button type="submit" class="btn start">
                              <i class="fa fa-upload"></i>
                              <span>Start upload</span>
                            </button>
                            <button type="reset" class="btn btn-warning cancel">
                              <i class="fa fa-ban"></i>
                              <span>Cancel upload</span>
                            </button>
                            <button type="button" class="btn btn-danger delete">
                              <i class="fa fa-trash-o"></i>
                              <span>Delete selected</span>
                            </button>
                            <input type="checkbox" class="toggle" />
                            <span class="fileupload-process"></span>
                        </div>
                        <div class="col-5 fileupload-progress fade">
                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                            </div>
                            <div class="progress-extended">&nbsp;</div>
                        </div>
                    </div>
                    <table role="presentation" class="table table-striped">
                      <tbody class="files"></tbody>
                    </table>
                </form>
             </div>
         </div>
    </div>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
  {% for (var i=0, file; file=o.files[i]; i++) { %}
      <tr class="template-upload fade">
          <td>
                {% if(file.type=="application/pdf") { %}
                    <a href="javascript:void(0);"><img src="{{ asset('/public/icons/pdf.png') }}" class="thumbnail-icon"/></a>
                {% }else if(file.type=="application/doc" || file.type=="application/docx"){ %}
                    <a href="javascript:void(0);"><img src="{{ asset('/public/icons/doc.png') }}" class="thumbnail-icon"/></a>
                {% }else { %}
                    <span class="preview"></span>
                {% } %}
          </td>
          <td>
              <input name="title" data-filetype="{%= file.type %}" placeholder="Title"  cols="25" class="title-input"></textarea>
          </td>
          <td>
              <input type="hidden" name="caseManagementId" value="{{$caseManagementId}}">
              <textarea name="description" data-filetype="{%= file.type %}" placeholder="Description"  cols="25" class="description-textarea"></textarea>
          </td>
          <td>
              {% if (window.innerWidth > 480 || !o.options.loadImageFileTypes.test(file.type)) { %}
                  <p class="name">{%=file.name%}</p>
              {% } %}
              <strong class="error text-danger"></strong>
          </td>
          <td>
              <p class="size">Processing...</p>
              <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
          </td>
          <td>
              {% if (!o.options.autoUpload && o.options.edit && o.options.loadImageFileTypes.test(file.type)) { %}
                <button class="btn btn-warning edit" data-index="{%=i%}" disabled>
                    <i class="fa fa-edit"></i>
                    <span>Edit</span>
                </button>
              {% } %}
              {% if (!i && !o.options.autoUpload) { %}
                  <button class="btn start" disabled>
                      <i class="fa fa-upload"></i>
                      <span>Start</span>
                  </button>
              {% } %}
              {% if (!i) { %}
                  <button class="btn btn-warning cancel">
                      <i class="fa fa-ban"></i>
                      <span>Cancel</span>
                  </button>
              {% } %}
          </td>
      </tr>
  {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
  {% for (var i=0, file; file=o.files[i]; i++) { %}
      <tr class="template-download fade">
          <td>
              <span class="preview">
                  {%
                    var filename  = file.name;
                    var ext = filename.split('.').pop();
                  %}
                  {% if(ext=="pdf") %}
                    <a href="{%= file.url %}" download><img src="{{ asset('/public/icons/pdf.png') }}" class="thumbnail-icon"/></a>
                  {% else if (file.thumbnailUrl) { %}
                      <a rel="gallery" class="fancybox" data-fancybox  href="{%=file.url%}"><img  src="{%=file.thumbnailUrl%}"></a>
                  {% } %}
              </span>
          </td>
          <td>
              	{% if(file.dbData.title) { %}
              		<p class="update-title-text title-text">{%=file.dbData.title%}</p>
              	{% }else{ %}
              		<p class="update-title-text title-text">Edit Title</p>
              	{% } %}
          </td>
          <td>
          		{% if(file.dbData.description) { %}
              		<p class="update-description-text description-text">{%=file.dbData.description%}</p>
              	{% }else{ %}
              		<p class="update-description-text description-text">Edit Description</p>
              	{% } %}
          </td>
          <td>
              {% if (window.innerWidth > 480 || !file.thumbnailUrl) { %}
                  <p class="name">
                      {% if (file.url) { %}
                          <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                      {% } else { %}
                          <span>{%=file.name%}</span>
                      {% } %}
                  </p>
              {% } %}
              {% if (file.error) { %}
                  <div><span class="label label-danger">Error</span> {%=file.error%}</div>
              {% } %}
          </td>
          <td>
              <span class="size">{%=o.formatFileSize(file.size)%}</span>
          </td>
          <td>
              {% if (file.deleteUrl) { %}
                  <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-id ="{%= file.dbData.id %}" data-url="{%=file.deleteUrl+'&id='+file.dbData.id %}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                      <i class="fa fa-trash"></i>
                      <span>Delete</span>
                  </button>
                  <input type="checkbox" name="delete" value="1" class="toggle">
              {% } else { %}
                  <button class="btn btn-warning cancel">
                      <i class="fa fa-ban"></i>
                      <span>Cancel</span>
                  </button>
              {% } %}
          </td>
      </tr>
  {% } %}
</script>
<script src="{{ asset('public/file-uploader/js/vendor/jquery.ui.widget.js')}}"></script>
<script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="{{ asset('public/file-uploader/js/jquery.iframe-transport.js')}}"></script>
<script src="{{ asset('public/file-uploader/js/jquery.fileupload.js')}}"></script>
<script src="{{ asset('public/file-uploader/js/jquery.fileupload-pdf.js')}}"></script>
<script src="{{ asset('public/file-uploader/js/jquery.fileupload-process.js')}}"></script>
<script src="{{ asset('public/file-uploader/js/jquery.fileupload-image.js')}}"></script>
<script src="{{ asset('public/file-uploader/js/jquery.fileupload-audio.js')}}"></script>
<script src="{{ asset('public/file-uploader/js/jquery.fileupload-video.js')}}"></script>
<script src="{{ asset('public/file-uploader/js/jquery.fileupload-validate.js')}}"></script>
<script src="{{ asset('public/file-uploader/js/jquery.fileupload-ui.js')}}"></script>
<script src="{{ asset('public/file-uploader/js/demo.js')}}"></script>


@endsection
