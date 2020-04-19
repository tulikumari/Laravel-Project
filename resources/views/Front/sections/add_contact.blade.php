@extends('layouts.app-cm-fancybox')

@section('title', 'Cases')

@section('content')

<div class="main-login">

    {{ Form::open(['route' => 'cases.save-contact', 'method' => 'POST','class' => 'form-main']) }}

    <div class="form-main">
    @if($contact_data && $contact_data['id'])
                        <h1>Edit Contact</h1>
                       @else
                       <h1>Add Contact</h1>
                       @endif
                    <div class="form_body normal_form_body">
                    <div class="row">
                    <div class="col-md-6 col-sm-6">
                    <div class="font_white">Full Name</div>
                        <div class="input-group">
                            <input type="hidden" name="contact_id" value="{{ $contact_data?$contact_data['id']:''}}">
                            <input type="hidden" name="caseManagementId" value="{{$caseManagementId}}">
                            <input type="text"  required name="full_name"  class="form-control" value="{{$contact_data?$contact_data['full_name']:''}}" /></div>
                            <div class="font_white">Title</div>
                        <div class="input-group">
                            <input type="text"  name="title"  value="{{$contact_data?$contact_data['title']:''}}" class="form-control" />
                        <span></span>
                    </div>                      
                        <div class="font_white">Address</div>
                        <div class="input-group">

                            <textarea   name="address" class="form-control" >{{$contact_data?$contact_data['address']:''}}</textarea>

                        </div>

                        <div class="font_white">Email</div>
                        <div class="input-group">
                            <input type="text" name="email"  class="form-control" value="{{$contact_data?$contact_data['email']:''}}" />
                        </div>
                        <div class="font_white">Phone no</div>
                        <div class="input-group">
                            <input type="number" name="phone"  class="form-control" value="{{$contact_data?$contact_data['phone']:''}}"/>
                        </div>
                    </div> 
                    <div class="col-md-6 col-sm-6">
                    <div class="font_white">Gender</div> 
                      <div class="input-group">
                        <select class="form-control" placeholder="gender" name="gender" value="{{$contact_data?$contact_data['gender']:''}}">
                        <option value="">Gender</option>
                        @foreach ($gender as $key => $value)
                        <option value="{{$value['id']}}" @if($contact_data && $contact_data['gender'] == $value['id']) selected @endif>{{ $value['category'] }}</option>
                        @endforeach
                    </select>
                      </div>       
                      <div class="font_white">Types</div>               
                      <div class="input-group">
                        <select class="form-control" placeholder="types" name="types">
                           <option value="">Types</option>
                             @foreach ($types as $key1 => $value1)
                              <option value="{{$value1['id']}}" @if($contact_data && $contact_data['types'] == $value1['id']) selected @endif>{{ $value1['category'] }}</option>
                             @endforeach
                    </select>
                </div>
                <div class="font_white">Country</div>
                 <div class="input-group">
                            <select class="form-control" placeholder="Choose your country" name="country">
                                <option>Country</option>
                                  @foreach ($country as $key2 => $value2)
                                <option value="{{ $value2?$value2['id']:''}}" @if($contact_data && $contact_data['country'] == $value2['id']) selected @endif>{{ $value2['name'] }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="font_white">Notes</div> 
                        <div class="input-group">

                    <textarea  placeholder="Notes" name="notes" class="form-control">{{$contact_data?$contact_data['notes']:''}}</textarea>

                    </div>  
                 </div>  
                    <div class="form_buttons setbtn">
                    <button type="submit" class="btn pull-right btn btn_primary "  onclick="parent.closeFancyBox('0');$('form').attr('action', '');">Close</button>
                   <button type="submit" class="btn pull-right btn btn_primary margin15"  onclick="validateFormc()">Submit</button>
                   
                </div>                  
              </div>
    {{ Form::close() }}
</div>

<script>	
function validateFormc() {
  //var x = document.getElementById("full_name").value;
  var xy = $('input[name="full_name"]').val();
  
  if (xy == "") {
   // alert("Name must be filled out");
    return false;
  }
    parent.closeFancyBox();
  
  
}
</script>

@endsection

