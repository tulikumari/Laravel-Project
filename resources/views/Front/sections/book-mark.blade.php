@extends('layouts.app-cm')
@section('title', 'Fake News Bookmarks')
@section('page-header', 'Bookmarks')
@section('content')
<?php
$user = auth()->user();
$case_id = Request::segment(2); ?>
 <style>
        body{ /*margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; color:#3C4043; font-size: 14px;*/ }
        
        .tabbable .tab-content > .tab-pane { padding-top: 15px; }
        #google-pagination, #twitter-pagination, #youtube-pagination{ margin-top:10px; }
        #google-pagination ul.pagination, #twitter-pagination ul.pagination, #youtube-pagination ul.pagination{ margin-bottom:0; }
        .twitter-search{ max-width: 900px; height:350px; overflow-y:auto; overflow-x:hidden; }
        .twitter-sec{ display: table; width: 100%; margin-top: 35px; }
        .twitter-cell{ /*display: table-cell;*/ width: 35px; vertical-align: top; padding-top: 5px; }
        .twitter-cell img{ border-radius:100%; -moz-border-radius:100%; -webkit-border-radius:100%; -khtml-border-radius:100%; }
        .twitter-cell2{ display: table-cell; width: 100%; vertical-align: top; padding-top: 15px; }
        .twitter-cell2 .inner{ padding-left: 25px; }
       .twitter-sec h2{ margin: 0; padding: 0; font-weight: 400; font-size: 16px; text-align: left; }
       .twitter-sec p{ margin: 0; padding: 0; font-weight: 400; font-size: 14px; }
       .twitter-sec p{ padding-top: 7px; line-height: 22px; font-size: 16px; }
       .twitter-sec h2 a{ color:rgba(0,0,0,0.7) ; text-decoration: none; line-height: 1.3; display: inline-block; }
       .twitter-sec h2 a:hover{ text-decoration: none; }
       .mt-30{ margin-top: 30px !important; }
       .mt-60{ margin-top: 60px !important; }
       .grey-txt{ color:rgba(0,0,0,0.6) !important;}
       .blue_link{ color: rgb(27, 149, 224) !important; text-decoration: none; }
       .blue_link:hover{ color: rgb(27, 149, 224) !important; text-decoration: underline; }
       .twitter-icon{ display: inline-block; width: 20px; vertical-align: middle; margin-top: 4px; }
       .twitter-icon svg{ color: rgba(29,161,242,1.00); fill: currentcolor; }
       .twitter-img{ margin-top: 25px; border: 1px solid rgba(0,0,0,0.2); overflow: hidden; max-height: 400px; border-radius:16px; -moz-border-radius:16px; -webkit-border-radius:16px; -khtml-border-radius:16px; }
       .twitter-img img{ width: 100%; }
        .youtube-search{ max-width: 900px; margin-top: 25px; max-width: 900px; height:350px; overflow-y:auto; overflow-x:hidden; }
        .youtube-sec{ display: table; width: 100%; }
        .youtube-cell{ display: table-cell; width: 150px; vertical-align: top; width: 80px; }
        .youtube-cell img{ width: 80px }
        .youtube-cell2{ display: table-cell; width: 100%; vertical-align: top; }
        .youtube-cell2 .inner{ padding-left: 15px; }
       .youtube-sec h2{ margin: 0; padding: 0; font-weight: 400; font-size: 16px; color:rgba(0,0,0,0.8) ; text-align:left; }
       .youtube-sec p{ margin: 0; padding: 0; padding-top: 1px; font-weight: 400; font-size: 14px; color:rgba(0,0,0,0.7) ; }      
       .youtube-sec h2 a{ font-weight: 700; color:rgba(0,0,0,0.7) ; text-decoration: none; line-height: 1.3; display: inline-block; }
       .youtube-sec h2 a:hover{ text-decoration: none; }
       .youtube-divider{ margin-top: 16px; margin-bottom: 16px; height: 1px; background-color: rgba(0,0,0,0.2);}
       .google-search-results{ max-width: 900px; }
       #google-search-results{ height:400px; overflow-y:auto; overflow-x:hidden; }
       #bookmark-sec{ height:510px; overflow-y:auto; overflow-x:hidden; }
       .google-search { margin-top: 25px; }
       .google-search h2, .google-search p{ margin: 0; padding: 0; font-weight: 400; text-align:left !important;  }
       .google-search p{ padding-top: 7px; line-height: 22px; font-size:14px; color: #3C4043; }
       .google-search h2 a{ color: #1a0dab; text-decoration: none; font-size: 18px; line-height: 1.3; display: inline-block; }
       .google-search h2 a:hover{ text-decoration: underline; }
       .mt-30{ margin-top: 30px !important; }
       .inner-info-content img{ margin-bottom:0; }
       .twitter-outer{ margin-top: 0px; margin-bottom: 15px; }
       .twitter-outer .twitter-sec { margin-top: 0px; }
       .youtube_outer{ margin-top: 0px; margin-bottom: 15px; }
       #bookmark-sec .google-search { margin-top: 0px; margin-bottom: 15px; }
       div#bookmark-sec { margin-top: 0px; }
       .youtube_outer .youtube-sec{ padding-top:4px; }
       .left-top-icon{ text-align:right; padding-right: 15px; padding-top: 8px; }
       .left-top-icon span{ display:inline-block; margin-left:10px; }
       .twitter-outer .twitter-cell{ padding-top:10px; }
       .inner-info-content { padding: 25px 10px 25px 25px; }
    </style>
<div class="row">
    <div class="col-md-8 col-sm-8">
        <div class="inner-info-content">
            <input type="hidden" name="case_id" id="case_id" value="<?php echo $case_id?>">
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user->id;?>">
                <div id="bookmark-sec"></div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4">
        <div class="inner-info-content">
            <div class="tabbable">
                <!-- Only required for left/right tabs -->
                <ul class="nav nav-tabs">
                    <li class="smbtn active"><a href="#tab1" data-toggle="tab"><i class="fa fa-google-plus-square"></i> Google</a></li>
                    <li class="smbtn"><a href="#tab2" data-toggle="tab"><i class="fa fa-twitter-square"></i> Twitter</a></li>
                    <li class="smbtn"><a href="#tab3" data-toggle="tab"><i class="fa fa-youtube-square"></i> Youtube</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <input type="search" placeholder="Search on Google" id="google-search">
                        <input id="bm-search-btn1" value="Go" type="button" onclick="search_sm('google');">
                         <div class="loading-image"><img src="http://43.224.136.33/~dezireit/fake_news/public/img/loader.gif"></div>
                        <div id="google-search-results"></div><div id="google-pagination"></div>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <input type="search" placeholder="Search on Twitter" id="twitter-search">
                        <input id="bm-search-btn2" value="Go" type="button" onclick="search_sm('twitter');">
                         <div class="loading-image"><img src="http://43.224.136.33/~dezireit/fake_news/public/img/loader.gif"></div>
                        <div class="twitter_scroll"><div class="twitter-search"></div><div id="twitter-pagination"></div></div>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <input type="search" placeholder="Search on Youtube" id="youtube-search">
                        <input id="bm-search-btn3" value="Go" type="button" onclick="search_sm('youtube');">
                         <div class="loading-image"><img src="http://43.224.136.33/~dezireit/fake_news/public/img/loader.gif"></div>
                        <div class="youtube_scroll"><div class="youtube-search" id="youtube-search-results"></div><div id="youtube-pagination"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
<style>
    .smbtn {
        padding-right: 15px !important;
    }
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
  var user_id;
  var case_management_id;
  var startIndex;
  var paginationIndexTwitter;
  var twitterLoopingIndex;
  var youtubeIndex= 0 ;
  var  youtubeLoopingIndex = 0 ;




  $(document).ready(function () { 
   user_id = document.getElementById('user_id').value;
   case_management_id = document.getElementById('case_id').value;
   startIndex = 0;
   twitterIndex = 0;  
   twitterLoopingIndex =0 ;
    youtubeIndex = 0;
    youtubeLoopingIndex = 0 ;
    getBookmark();    
    });

    function saveBookmark(bookmark_from , bookmark_details){
      var _token = $('input[name="_token"]').val()

        $('.loading-image').show(); 
        console.log("bookmark_details" , bookmark_details);
        console.log("bookmark_from" , bookmark_from);
        $.ajax({
          type : "POST",
          url  :  URL +'/save-bookmark',
            dataType: 'json',
          data : {
            'user_id' : user_id,
            'caseManagementId' : case_management_id,
            'bookmark_details' : bookmark_details,
            'bookmark_from'    : bookmark_from,
          },
          success: function(result){
              getBookmark();
          },
          complete: function(){
            $('.loading-image').hide();
          }
      });
    }
    function getBookmark(){ 
 $('.loading-image').show(); 
        $.ajax({url: URL +'/Getbookmarkdata/'+ case_management_id, success: function(result){
            $("#bookmark-sec").empty();
             result.forEach(function(item) {
            console.log(item);
             if (item.bookmark_from == "google") {

             var dec = window.atob(item.bookmark_details);      
                  console.log("dec",dec);    
             var temp = decodeURIComponent(dec);    
                  console.log("temp",temp);      
             var formattedItem = JSON.parse(temp);
             // console.log(formattedItem);

                 var element = '<div class="google-search"><div class="left-top-icon"><span><i class="fa fa-google-plus-square"></i></span><span style="cursor: pointer;" onclick="deleteBookmark('+ item.id +');"><i class="fa fa-trash" aria-hidden="true"></i></span></div><h2><a href="'+formattedItem.link+'" target="_blank" >'+formattedItem.htmlTitle+'</a></h2><p>'+formattedItem.htmlSnippet+'</p></div>';
                  $("#bookmark-sec").append(element); 

        }

         if (item.bookmark_from == "twitter") {
          var dec = window.atob(item.bookmark_details);          
             var temp = decodeURIComponent(dec);          
             var formattedItem = JSON.parse(temp);
             // console.log(formattedItem);
            var element = '<div class="twitter-outer"><div class="left-top-icon"><span><i class="fa fa-twitter-square"></i></span><span style="cursor: pointer;" onclick="deleteBookmark('+ item.id +');"><i class="fa fa-trash" aria-hidden="true"></i></span></div><div class="twitter-sec"><div class="twitter-cell"><a href="#"><img src="'+ formattedItem.user.profile_image_url_https +'" alt="" title=""></a></div><div class="twitter-cell2"> <div class="inner"> <h2><a href="#"><b>'+formattedItem.user.name +'</b> <span class="twitter-icon"> <svg viewBox="0 0 24 24" aria-label="Verified account" class="blue_link r-13gxpu9 r-4qtqp9 r-yyyyoo r-1xvli5t r-9cviqr r-dnmrzs r-bnwqim r-1plcrui r-lrvibr"><g><path d="M22.5 12.5c0-1.58-.875-2.95-2.148-3.6.154-.435.238-.905.238-1.4 0-2.21-1.71-3.998-3.818-3.998-.47 0-.92.084-1.336.25C14.818 2.415 13.51 1.5 12 1.5s-2.816.917-3.437 2.25c-.415-.165-.866-.25-1.336-.25-2.11 0-3.818 1.79-3.818 4 0 .494.083.964.237 1.4-1.272.65-2.147 2.018-2.147 3.6 0 1.495.782 2.798 1.942 3.486-.02.17-.032.34-.032.514 0 2.21 1.708 4 3.818 4 .47 0 .92-.086 1.335-.25.62 1.334 1.926 2.25 3.437 2.25 1.512 0 2.818-.916 3.437-2.25.415.163.865.248 1.336.248 2.11 0 3.818-1.79 3.818-4 0-.174-.012-.344-.033-.513 1.158-.687 1.943-1.99 1.943-3.484zm-6.616-3.334l-4.334 6.5c-.145.217-.382.334-.625.334-.143 0-.288-.04-.416-.126l-.115-.094-2.415-2.415c-.293-.293-.293-.768 0-1.06s.768-.294 1.06 0l1.77 1.767 3.825-5.74c.23-.345.696-.436 1.04-.207.346.23.44.696.21 1.04z"></path></g></svg> </span> <span class="grey-txt">@'+ formattedItem.user.screen_name + ' ' +formattedItem.created_at+'</span></a></h2> <p> PM <a href="#" class="blue_link">@'+ formattedItem.user.screen_name+' </a> '+ formattedItem.created_at + ' ' + formattedItem.text + '</p></div></div></div>'
        $("#bookmark-sec").append(element); 
        }  

        if (item.bookmark_from == "youtube") {

          var dec = window.atob(item.bookmark_details);
          var temp = decodeURIComponent(dec);
          var formattedItem = JSON.parse(temp);
          //console.log(formattedItem);
          var element = '<div class="youtube_outer"><div class="left-top-icon"><span><i class="fa fa-youtube-square"></i></span><span style="cursor: pointer;" onclick="deleteBookmark('+ item.id +');"><i class="fa fa-trash" aria-hidden="true"></i></span></div><div class="youtube-sec"><div class="youtube-cell"><a href="https://www.youtube.com/watch?v=' + formattedItem.id.videoId+ '" target="_blank"><img src="' +formattedItem.snippet.thumbnails.default.url+ '"/></a></div><div class="youtube-cell2"> <div class="inner"> <h2><a href="https://www.youtube.com/watch?v=' + formattedItem.id.videoId+ '" target="_blank">' + formattedItem.snippet.title + '</a></h2> <p>' + formattedItem.snippet.channelTitle + '</p></div></div></div></div>'
        $("#bookmark-sec").append(element); 

        }   }
        );
             

           
          },
          complete: function(){
            $('.loading-image').hide();
          }}
          );
    }

     function deleteBookmark(bookmark_id){ 
      alert("Are you sure you want to delete Bookmark ?");  
        $.ajax({url: URL +'/delete-bookmark?bookmark_id='+ bookmark_id, success: function(result){ 
        getBookmark();
          }});
      }

      function setIndexGoogle(index){
        if (index >= 0) {
          startIndex = index;
         
        }else{
           startIndex = 0 ;
        }       
       search_sm('google');
      }

      function setLoopingIndex(index){
        twitterLoopingIndex = index ;
      // console.log(twitterLoopingIndex);
      search_sm('twitter');
      }

      function paginationForTwitter(next_results){
        console.log("next_results" , next_results);
        twitterIndex++ ;
        twitterLoopingIndex = 0 ;
         $('.loading-image').show(); 
        $.ajax({               
                url: 'http://43.224.136.33/~dezireit/twitter-api-php/index.php?' + next_results , success: function(result) {
                        var data =JSON.parse(result);
                        //console.log(data);
                        $(".twitter-search").empty();
                        $("#twitter-pagination").empty();
                         // console.log(twitterLoopingIndex);
                         //  console.log(twitterLoopingIndex+20);
                        for (var i = twitterLoopingIndex; i < twitterLoopingIndex+20; i++) {       
                        var temp =  encodeURIComponent(JSON.stringify(data.statuses[i]));
                        var enc = window.btoa(temp);
                        var element = '<div class="twitter-sec"><span style="cursor: pointer;" onclick="saveBookmark(\'twitter\',\''+ enc +'\');"><i class="fa fa-plus" aria-hidden="true"></i></span><div class="twitter-cell"><img src="'+ data.statuses[i].user.profile_image_url_https +'" alt="" title=""></div><div class="twitter-cell2"> <div class="inner"> <h2><a href="#"><b>'+data.statuses[i].user.name +'</b> <span class="twitter-icon"> <svg viewBox="0 0 24 24" aria-label="Verified account" class="blue_link r-13gxpu9 r-4qtqp9 r-yyyyoo r-1xvli5t r-9cviqr r-dnmrzs r-bnwqim r-1plcrui r-lrvibr"><g><path d="M22.5 12.5c0-1.58-.875-2.95-2.148-3.6.154-.435.238-.905.238-1.4 0-2.21-1.71-3.998-3.818-3.998-.47 0-.92.084-1.336.25C14.818 2.415 13.51 1.5 12 1.5s-2.816.917-3.437 2.25c-.415-.165-.866-.25-1.336-.25-2.11 0-3.818 1.79-3.818 4 0 .494.083.964.237 1.4-1.272.65-2.147 2.018-2.147 3.6 0 1.495.782 2.798 1.942 3.486-.02.17-.032.34-.032.514 0 2.21 1.708 4 3.818 4 .47 0 .92-.086 1.335-.25.62 1.334 1.926 2.25 3.437 2.25 1.512 0 2.818-.916 3.437-2.25.415.163.865.248 1.336.248 2.11 0 3.818-1.79 3.818-4 0-.174-.012-.344-.033-.513 1.158-.687 1.943-1.99 1.943-3.484zm-6.616-3.334l-4.334 6.5c-.145.217-.382.334-.625.334-.143 0-.288-.04-.416-.126l-.115-.094-2.415-2.415c-.293-.293-.293-.768 0-1.06s.768-.294 1.06 0l1.77 1.767 3.825-5.74c.23-.345.696-.436 1.04-.207.346.23.44.696.21 1.04z"></path></g></svg> </span> <span class="grey-txt">@'+ data.statuses[i].user.screen_name + ' ' +data.statuses[i].created_at+'</span></a></h2> <p> PM <a href="#" class="blue_link">@'+ data.statuses[i].user.screen_name+' </a> '+ data.statuses[i].created_at + ' ' + data.statuses[i].text + '</p></div></div>'
                          $(".twitter-search").append(element);
                           
                    }

                    $("#twitter-pagination").append('<nav aria-label="Page navigation example"> <ul class="pagination"> <li class="page-item disabled" id="page_index" onclick="setLoopingIndex(0)"><a class="page-link" href="#">Previous</a></li><li class="page-item" id="page_index" onclick="setLoopingIndex(19)"><a class="page-link" href="#">'+(twitterIndex+1)+'</a></li><li class="page-item" id="page_index" onclick="setLoopingIndex(39)"><a class="page-link" href="#">'+(twitterIndex+2)+'</a></li><li class="page-item" id="page_index" onclick="setLoopingIndex(59)"><a class="page-link" href="#">'+(twitterIndex+3)+'</a></li><li class="page-item" id="page_index" onclick="paginationForTwitter(\''+ data.search_metadata.next_results+'\')"><a class="page-link" href="#">Next</a></li></ul></nav>');                        
                }
                ,
          complete: function(){
            $('.loading-image').hide();
          }
            });
     
       }

      function setIndexYoutube(index){
        youtubeLoopingIndex = index ;
      // console.log(twitterLoopingIndex);
      search_sm('youtube');
       
      }

      function paginationForYouTube(pageToken, searchval){

        youtubeIndex++ ;
        youtubeLoopingIndex = 0 ;
 $('.loading-image').show(); 
         $.ajax({
                // http://43.224.136.33/~dezireit/GoogleCustomSearchAPI/search.php?query=lockdown%in%india   
                url: 'http://43.224.136.33/~dezireit/youtube-api/search.php?query='+ searchval +'&pageToken' + pageToken, success: function(result) {var data =JSON.parse(result); 
                console.log(data);   
               $("#youtube-pagination").empty();
              $("#youtube-search-results").empty();                                    
                          for (var i = youtubeLoopingIndex; i < youtubeLoopingIndex+8 ; i++) {      
                            var temp =  encodeURIComponent(JSON.stringify(data.items[i]));
                            var enc = window.btoa(temp);                                
                            var element = '<span style="cursor: pointer;" onclick="saveBookmark(\'youtube\',\''+ enc +'\');"><i class="fa fa-plus" aria-hidden="true"></i></span><div class="youtube-sec"><div class="youtube-cell"><img src="' +data.items[i].snippet.thumbnails.default.url+ '"/></div><div class="youtube-cell2"> <div class="inner"> <h2><a href="https://www.youtube.com/watch?v=' + data.items[i].id.videoId+ '" target="_blank">' + data.items[i].snippet.title + '</a></h2> <p>' + data.items[i].snippet.channelTitle + '</p><p> ' + data.items[i].snippet.description.substring(0,51) + '.... </p></div></div></div><div class="youtube-divider"></div>';                       
                              
                              $("#youtube-search-results").append(element);
                               
                    }
                     $("#youtube-pagination").append('<nav aria-label="Page navigation example"> <ul class="pagination"> <li class="page-item disabled" id="page_index" onclick="setIndexYoutube(0)"><a class="page-link" href="#">Previous</a></li><li class="page-item" id="page_index" onclick="setIndexYoutube(8)"><a class="page-link" href="#">'+(youtubeIndex+1)+'</a></li><li class="page-item" id="page_index" onclick="setIndexYoutube(17)"><a class="page-link" href="#">'+(youtubeIndex+2)+'</a></li><li class="page-item" id="page_index" onclick="setIndexYoutube(15)"><a class="page-link" href="#">'+(youtubeIndex+3)+'</a></li><li class="page-item" id="page_index" onclick="paginationForYouTube(\''+ data.nextPageToken+'\',\''+ searchval +'\')"><a class="page-link" href="#">Next</a></li></ul></nav>'); 
                }
                ,
          complete: function(){
            $('.loading-image').hide();
          }
                 
               
            });

      }
   

 function search_sm(sm) {
        var searchval = $('#' + sm + '-search').val();        
          $("#youtube-search-results").empty();
          $(".twitter-search").empty();
          $("#google-search-results").empty();          
          $("#google-pagination").empty();
          $("#twitter-pagination").empty();
          $("#youtube-pagination").empty();
        if (sm == "google") { 
         $('.loading-image').show();          
            $.ajax({               
                url: 'http://43.224.136.33/~dezireit/GoogleCustomSearchAPI/search.php?query='+ searchval+ '&start='+startIndex, success: function(result) {
                        var data =JSON.parse(result);
                        console.log(data);
                        $("#google-search-results").empty();                       
                        for (var i = 0 ; i<data.items.length; i++) {
                            var temp = encodeURIComponent(JSON.stringify(data.items[i]));                           
                            var enc = window.btoa(temp);
                            var element = '<div class="google-search"><span style="cursor: pointer;" onclick="saveBookmark(\'google\' ,\''+ enc +'\');"><i class="fa fa-plus" aria-hidden="true"></i></span><h2><a href="'+data.items[i].link+'" target="_blank" >'+data.items[i].title+'</a></h2><p>'+data.items[i].htmlSnippet+'</p></div>'
                              $("#google-search-results").append(element);
                        }                       
                        $("#google-pagination").append('<nav aria-label="Page navigation example"> <ul class="pagination"><li class="page-item" onclick="setIndexGoogle('+(startIndex-1)+')"> <a class="page-link" href="#" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> <span class="sr-only">Previous</span> </a> </li><li class="page-item" id="page_index" onclick="setIndexGoogle('+(startIndex+1)+')"><a class="page-link" href="#" >'+(startIndex+1)+'</a></li><li class="page-item" id="page_index" onclick="setIndexGoogle('+(startIndex+2)+')"><a class="page-link" href="#">'+(startIndex+2)+'</a></li><li class="page-item" id="page_index" onclick="setIndexGoogle('+(startIndex+3)+')"><a class="page-link" href="#">'+(startIndex+3)+'</a></li> <li class="page-item" onclick="setIndexGoogle('+(startIndex+4)+')"> <a class="page-link" href="#" aria-label="Next"> <span aria-hidden="true">&raquo;</span> <span class="sr-only">Next</span> </a> </li></ul></nav>');
                       
                },
                  complete: function(){
            $('.loading-image').hide();
          }
            });

        }
        if (sm == "twitter") {
         $('.loading-image').show();             
             $.ajax({
                // http://43.224.136.33/~dezireit/GoogleCustomSearchAPI/search.php?query=lockdown%in%india   
                url: 'http://43.224.136.33/~dezireit/twitter-api-php/index.php?&q='+ searchval + '&count=100&result_type=mixed', success: function(result) {
                        var data =JSON.parse(result);
                       // console.log(data);
                        // console.log(twitterLoopingIndex);
                        for (var i = twitterLoopingIndex; i < twitterLoopingIndex+20; i++) {    
                        var temp =  encodeURIComponent(JSON.stringify(data.statuses[i]));
                        var enc = window.btoa(temp);
                        var element = '<div class="twitter-sec"><span style="cursor: pointer;" onclick="saveBookmark(\'twitter\',\''+ enc +'\');"><i class="fa fa-plus" aria-hidden="true"></i></span><div class="twitter-cell"><img src="'+ data.statuses[i].user.profile_image_url_https +'" alt="" title=""></div><div class="twitter-cell2"> <div class="inner"> <h2><a href="#"><b>'+data.statuses[i].user.name +'</b> <span class="twitter-icon"> <svg viewBox="0 0 24 24" aria-label="Verified account" class="blue_link r-13gxpu9 r-4qtqp9 r-yyyyoo r-1xvli5t r-9cviqr r-dnmrzs r-bnwqim r-1plcrui r-lrvibr"><g><path d="M22.5 12.5c0-1.58-.875-2.95-2.148-3.6.154-.435.238-.905.238-1.4 0-2.21-1.71-3.998-3.818-3.998-.47 0-.92.084-1.336.25C14.818 2.415 13.51 1.5 12 1.5s-2.816.917-3.437 2.25c-.415-.165-.866-.25-1.336-.25-2.11 0-3.818 1.79-3.818 4 0 .494.083.964.237 1.4-1.272.65-2.147 2.018-2.147 3.6 0 1.495.782 2.798 1.942 3.486-.02.17-.032.34-.032.514 0 2.21 1.708 4 3.818 4 .47 0 .92-.086 1.335-.25.62 1.334 1.926 2.25 3.437 2.25 1.512 0 2.818-.916 3.437-2.25.415.163.865.248 1.336.248 2.11 0 3.818-1.79 3.818-4 0-.174-.012-.344-.033-.513 1.158-.687 1.943-1.99 1.943-3.484zm-6.616-3.334l-4.334 6.5c-.145.217-.382.334-.625.334-.143 0-.288-.04-.416-.126l-.115-.094-2.415-2.415c-.293-.293-.293-.768 0-1.06s.768-.294 1.06 0l1.77 1.767 3.825-5.74c.23-.345.696-.436 1.04-.207.346.23.44.696.21 1.04z"></path></g></svg> </span> <span class="grey-txt">@'+ data.statuses[i].user.screen_name + ' ' +data.statuses[i].created_at+'</span></a></h2> <p> PM <a href="#" class="blue_link">@'+ data.statuses[i].user.screen_name+' </a> '+ data.statuses[i].created_at + ' ' + data.statuses[i].text + '</p></div></div>'
                          $(".twitter-search").append(element);
                           
                    }

                  //  console.log("data.search_metadata.next_results" , data.search_metadata.next_results);

                    $("#twitter-pagination").append('<nav aria-label="Page navigation example"> <ul class="pagination"> <li class="page-item disabled" id="page_index" onclick="setLoopingIndex(0)"><a class="page-link" href="#">Previous</a></li><li class="page-item" id="page_index" onclick="setLoopingIndex(19)"><a class="page-link" href="#">'+(twitterIndex+1)+'</a></li><li class="page-item" id="page_index" onclick="setLoopingIndex(39)"><a class="page-link" href="#">'+(twitterIndex+2)+'</a></li><li class="page-item" id="page_index" onclick="setLoopingIndex(59)"><a class="page-link" href="#">'+(twitterIndex+3)+'</a></li><li class="page-item" id="page_index" onclick="paginationForTwitter(\''+ data.search_metadata.next_results+'\')"><a class="page-link" href="#">Next</a></li></ul></nav>');                        
                },
                  complete: function(){
            $('.loading-image').hide();
          }
            });
        }
        if (sm == "youtube") {
           $('.loading-image').show(); 
            $.ajax({
                // http://43.224.136.33/~dezireit/GoogleCustomSearchAPI/search.php?query=lockdown%in%india   
                url: 'http://43.224.136.33/~dezireit/youtube-api/search.php?query='+ searchval, success: function(result) {var data =JSON.parse(result); 
                console.log(data);                                        
                        for (var i = youtubeLoopingIndex; i < youtubeLoopingIndex+8 ; i++) {
                            var temp =  encodeURIComponent(JSON.stringify(data.items[i]));
                            var enc = window.btoa(temp);                                
                            var element = '<span style="cursor: pointer;" onclick="saveBookmark(\'youtube\',\''+ enc +'\');"><i class="fa fa-plus" aria-hidden="true"></i></span><div class="youtube-sec"><div class="youtube-cell"><a href="https://www.youtube.com/watch?v=' + data.items[i].id.videoId+ '" target="_blank"><img src="' +data.items[i].snippet.thumbnails.default.url+ '"/></a></div><div class="youtube-cell2"> <div class="inner"> <h2><a href="https://www.youtube.com/watch?v=' + data.items[i].id.videoId+ '" target="_blank">' + data.items[i].snippet.title + '</a></h2> <p>' + data.items[i].snippet.channelTitle + '</p></div></div></div><div class="youtube-divider"></div>';                       
                              
                              $("#youtube-search-results").append(element);
                               
                    }
                     $("#youtube-pagination").append('<nav aria-label="Page navigation example"> <ul class="pagination"> <li class="page-item disabled" id="page_index" onclick="setIndexYoutube(0)"><a class="page-link" href="#">Previous</a></li><li class="page-item" id="page_index" onclick="setIndexYoutube(8)"><a class="page-link" href="#">'+(youtubeIndex+1)+'</a></li><li class="page-item" id="page_index" onclick="setIndexYoutube(17)"><a class="page-link" href="#">'+(youtubeIndex+2)+'</a></li><li class="page-item" id="page_index" onclick="setIndexYoutube(15)"><a class="page-link" href="#">'+(youtubeIndex+3)+'</a></li><li class="page-item" id="page_index" onclick="paginationForYouTube(\''+ data.nextPageToken+'\',\''+ searchval +'\')"><a class="page-link" href="#">Next</a></li></ul></nav>'); 
                }
                ,
          complete: function(){
            $('.loading-image').hide();
          }
                 
               
            });

        }
    }





</script>
