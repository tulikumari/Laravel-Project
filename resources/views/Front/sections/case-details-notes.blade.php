<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
        .case-titl{
            font-size:12px;
            padding-left:25px;
        }
        .case-title-head{
            padding-bottom:5px !important;
        }
        .case-title2{
            font-size:16px;
            /*margin-bottom:0px;*/
        }
        .case-name{
            font-size:13px;

        }
        .case-bod{
         margin-bottom:6px;
        }
        </style>
    </head>
<?php
include 'static-includes/head.php';
?>
<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Case Management</h3>
            </div>
            <div class="container-fluid">
                <ul class="list-unstyled">
                <li>
                    <a href="javascript:;" class="case-title-head">CASE TITLE:</a>
                    <span class="case-titl">test</span>
                </li>
                <li>
                    <a href="javascript:;">CASE CATEGORY:</a>
                    <span class="case-titl">case category desc</span>
                </li>
                <li>
                    <a href="javascript:;">CASE STATUS:</a>
                    <span class="case-titl">case status desc</span>
                </li>


            </ul>
            </div>
            <ul class="list-unstyled components">
                <li class="active">
                    <a href="javascript:;">Description</a>
                </li>
                <li>
                    <a href="javascript:;">Calendar</a>
                </li>
                <li>
                    <a href="javascript:;">Files</a>
                </li>
                <li class="{{ Route::currentRouteName() == 'files'?'active':'' }}">
                    <a href="{{ route('files') }}">Tasks</a>
                </li>
                <li>
                    <a href="javascript:;">Contact people</a>
                </li>
                <li>
                    <a href="javascript:;">Notes</a>
                </li>
                <li class="{{ Route::currentRouteName() == 'discussions'?'active':'' }}">
                 <a href="{{ route('discussions', 1) }}" >Discussions</a>
               </li>
                <li>
                    <a href="javascript:;">Notifications</a>
                </li>
                <li>
                    <a href="javascript:;">Security</a>
                </li>
                <li class="{{ Route::currentRouteName() == 'post-location'?'active':'' }}">
                 <a href="{{ route('post-location', 1) }}" >Post Geo Location</a>
               </li>
                <li>
                    <a href="javascript:;">Bookmarks</a>
                </li>
                <li>
                    <a href="javascript:;">Related Cases</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    </button>
                    <div class="main_menu">
                        <?php include 'static-includes/main_nav.php'; ?>
                    </div>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-new-case" href="http://fakenews.layoutintl.com/new"><span>New
                                        Case</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-search" href="http://fakenews.layoutintl.com"><span>Search Case</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-logout"
                                    href="http://fakenews.layoutintl.com/logout"><span>Logout</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!--Info Top---->
            <div class="inner-info">
                <div class="container">
                    <h3 class="info-head">Description</h3>
                    <div class="inner-info-content cases">
                        <div class="blocked_spaced">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div>
                                            <div class="container_head">
                                                <a href="add_note.php" data-fancybox data-type="iframe" class="pull-right btn btn_primary">EDIT</a>
                                                <h3 class="info-head">My Notes</h3>
                                            </div>
                                            <div class="notes_list">
                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-md-12 case-bod">
                                                                <h5 class="case-title2" style="margin-bottom:0px">Case Title</h5>
                                                                <span class="case-name" >fsdafsadfsad</span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 case-bod">
                                                                <h5 class="case-title2" style="margin-bottom:0px">Case Category</h5>
                                                                <span class="case-name" >fsdafsadfsad</span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h5 class="case-title2">Case Keywords</h5>

                                                            </div>
                                                        </div>
                                                         <div class="row">
                                                            <div class="col-md-12">
                                                                <h5 class="case-title2">Description</h5>

                                                            </div>
                                                        </div>
                                                         <div class="row">
                                                            <div class="col-md-12">
                                                                <h5 class="case-title2">Case Creator</h5>

                                                            </div>
                                                        </div>
                                                         <div class="row">
                                                            <div class="col-md-12">
                                                                <h5 class="case-title2">Assigned To</h5>

                                                            </div>
                                                        </div>
                                                         <div class="row">
                                                            <div class="col-md-12">
                                                                <h5 class="case-title2">Country</h5>

                                                            </div>
                                                        </div>
                                                         <div class="row">
                                                            <div class="col-md-12">
                                                                <h5 class="case-title2">Case Info</h5>

                                                            </div>
                                                        </div>
                                                         <div class="row">
                                                            <div class="col-md-12">
                                                                <h5 class="case-title2">Case Status</h5>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--<div class="col-md-3">-->
                                                    <!--    <div class="note_item">-->
                                                    <!--        <div class="block_header">-->
                                                    <!--            <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>-->
                                                    <!--            <h4 class="note_title">Note title</h4>-->
                                                    <!--            <div class="small_date">2020-02-20</div>-->
                                                    <!--        </div>-->
                                                    <!--        <div class="note_content">text goes here text goes here text goes here</div>-->
                                                    <!--        <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                    <!--<div class="col-md-3">-->
                                                    <!--    <div class="note_item">-->
                                                    <!--        <div class="block_header">-->
                                                    <!--            <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>-->
                                                    <!--            <h4 class="note_title">Note title</h4>-->
                                                    <!--            <div class="small_date">2020-02-20</div>-->
                                                    <!--        </div>-->
                                                    <!--        <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>-->
                                                    <!--        <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                    <!--<div class="col-md-3">-->
                                                    <!--    <div class="note_item">-->
                                                    <!--        <div class="block_header">-->
                                                    <!--            <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>-->
                                                    <!--            <h4 class="note_title">Note title</h4>-->
                                                    <!--            <div class="small_date">2020-02-20</div>-->
                                                    <!--        </div>-->
                                                    <!--        <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>-->
                                                    <!--        <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                    <!--<div class="col-md-3">-->
                                                    <!--    <div class="note_item">-->
                                                    <!--        <div class="block_header">-->
                                                    <!--            <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>-->
                                                    <!--            <h4 class="note_title">Note title</h4>-->
                                                    <!--            <div class="small_date">2020-02-20</div>-->
                                                    <!--        </div>-->
                                                    <!--        <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>-->
                                                    <!--        <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                    <!--<div class="col-md-3">-->
                                                    <!--    <div class="note_item">-->
                                                    <!--        <div class="block_header">-->
                                                    <!--            <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>-->
                                                    <!--            <h4 class="note_title">Note title</h4>-->
                                                    <!--            <div class="small_date">2020-02-20</div>-->
                                                    <!--        </div>-->
                                                    <!--        <div class="note_content">text goes here text goes here text goes here</div>-->
                                                    <!--        <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                    <!--<div class="col-md-3">-->
                                                    <!--    <div class="note_item">-->
                                                    <!--        <div class="block_header">-->
                                                    <!--            <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>-->
                                                    <!--            <h4 class="note_title">Note title</h4>-->
                                                    <!--            <div class="small_date">2020-02-20</div>-->
                                                    <!--        </div>-->
                                                    <!--        <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>-->
                                                    <!--        <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                    <!--<div class="col-md-3">-->
                                                    <!--    <div class="note_item">-->
                                                    <!--        <div class="block_header">-->
                                                    <!--            <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>-->
                                                    <!--            <h4 class="note_title">Note title</h4>-->
                                                    <!--            <div class="small_date">2020-02-20</div>-->
                                                    <!--        </div>-->
                                                    <!--        <div class="note_content">text goes here text goes here text goes here</div>-->
                                                    <!--        <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                    <!--<div class="col-md-3">-->
                                                    <!--    <div class="note_item">-->
                                                    <!--        <div class="block_header">-->
                                                    <!--            <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>-->
                                                    <!--            <h4 class="note_title">Note title</h4>-->
                                                    <!--            <div class="small_date">2020-02-20</div>-->
                                                    <!--        </div>-->
                                                    <!--        <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>-->
                                                    <!--        <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                    <!--<div class="col-md-3">-->
                                                    <!--    <div class="note_item">-->
                                                    <!--        <div class="block_header">-->
                                                    <!--            <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>-->
                                                    <!--            <h4 class="note_title">Note title</h4>-->
                                                    <!--            <div class="small_date">2020-02-20</div>-->
                                                    <!--        </div>-->
                                                    <!--        <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>-->
                                                    <!--        <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                    <!--<div class="col-md-3">-->
                                                    <!--    <div class="note_item">-->
                                                    <!--        <div class="block_header">-->
                                                    <!--            <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>-->
                                                    <!--            <h4 class="note_title">Note title</h4>-->
                                                    <!--            <div class="small_date">2020-02-20</div>-->
                                                    <!--        </div>-->
                                                    <!--        <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>-->
                                                    <!--        <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                    <!--<div class="col-md-3">-->
                                                    <!--    <div class="note_item">-->
                                                    <!--        <div class="block_header">-->
                                                    <!--            <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>-->
                                                    <!--            <h4 class="note_title">Note title</h4>-->
                                                    <!--            <div class="small_date">2020-02-20</div>-->
                                                    <!--        </div>-->
                                                    <!--        <div class="note_content">text goes here text goes here text goes here</div>-->
                                                    <!--        <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                    <!--<div class="col-md-3">-->
                                                    <!--    <div class="note_item">-->
                                                    <!--        <div class="block_header">-->
                                                    <!--            <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>-->
                                                    <!--            <h4 class="note_title">Note title</h4>-->
                                                    <!--            <div class="small_date">2020-02-20</div>-->
                                                    <!--        </div>-->
                                                    <!--        <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>-->
                                                    <!--        <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--end of .table-responsive-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
