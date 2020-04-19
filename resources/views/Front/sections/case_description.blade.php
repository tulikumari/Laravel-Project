<!DOCTYPE html>
<html lang="en">
<?php
include 'static-includes/head.php';
?>
<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Case Management</h3>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="javascript:;">Description</a>
                </li>
                <li>
                    <a href="javascript:;">Calendar</a>
                </li>
                <li>
                    <a href="javascript:;">Files</a>
                </li>
                <li>
                    <a href="javascript:;">Tasks</a>
                </li>
                <li>
                    <a href="javascript:;">Contact people</a>
                </li>
                <li class="active">
                    <a href="javascript:;">Notes</a>
                </li>
                <li>
                    <a href="javascript:;">Discussion</a>
                </li>
                <li>
                    <a href="javascript:;">Notifications</a>
                </li>
                <li>
                    <a href="javascript:;">Security</a>
                </li>
                <li>
                    <a href="javascript:;">Map</a>
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
                    <h3 class="info-head">Case Name goes here <span>Category: <a href="javascript:;">Category 5</a></span><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span><span>Status: <a href="javascript:;">Category 5</a></span></h3>
                    <div class="inner-info-content cases">
                        <div class="blocked_spaced">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div>
                                            <div class="container_head">
                                                <a href="add_note.php" data-fancybox data-type="iframe" class="pull-right btn btn_primary">Add New Note</a>
                                                <h3 class="info-head">My Notes</h3>
                                            </div>
                                            <div class="notes_list">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="note_item">
                                                            <div class="block_header">
                                                                <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>
                                                                <h4 class="note_title">Note title</h4>
                                                                <div class="small_date">2020-02-20</div>
                                                            </div>
                                                            <div class="note_content">text goes here text goes here text goes here</div>
                                                            <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="note_item">
                                                            <div class="block_header">
                                                                <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>
                                                                <h4 class="note_title">Note title</h4>
                                                                <div class="small_date">2020-02-20</div>
                                                            </div>
                                                            <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>
                                                            <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="note_item">
                                                            <div class="block_header">
                                                                <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>
                                                                <h4 class="note_title">Note title</h4>
                                                                <div class="small_date">2020-02-20</div>
                                                            </div>
                                                            <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>
                                                            <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="note_item">
                                                            <div class="block_header">
                                                                <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>
                                                                <h4 class="note_title">Note title</h4>
                                                                <div class="small_date">2020-02-20</div>
                                                            </div>
                                                            <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>
                                                            <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="note_item">
                                                            <div class="block_header">
                                                                <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>
                                                                <h4 class="note_title">Note title</h4>
                                                                <div class="small_date">2020-02-20</div>
                                                            </div>
                                                            <div class="note_content">text goes here text goes here text goes here</div>
                                                            <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="note_item">
                                                            <div class="block_header">
                                                                <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>
                                                                <h4 class="note_title">Note title</h4>
                                                                <div class="small_date">2020-02-20</div>
                                                            </div>
                                                            <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>
                                                            <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="note_item">
                                                            <div class="block_header">
                                                                <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>
                                                                <h4 class="note_title">Note title</h4>
                                                                <div class="small_date">2020-02-20</div>
                                                            </div>
                                                            <div class="note_content">text goes here text goes here text goes here</div>
                                                            <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="note_item">
                                                            <div class="block_header">
                                                                <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>
                                                                <h4 class="note_title">Note title</h4>
                                                                <div class="small_date">2020-02-20</div>
                                                            </div>
                                                            <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>
                                                            <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="note_item">
                                                            <div class="block_header">
                                                                <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>
                                                                <h4 class="note_title">Note title</h4>
                                                                <div class="small_date">2020-02-20</div>
                                                            </div>
                                                            <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>
                                                            <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="note_item">
                                                            <div class="block_header">
                                                                <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>
                                                                <h4 class="note_title">Note title</h4>
                                                                <div class="small_date">2020-02-20</div>
                                                            </div>
                                                            <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>
                                                            <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="note_item">
                                                            <div class="block_header">
                                                                <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>
                                                                <h4 class="note_title">Note title</h4>
                                                                <div class="small_date">2020-02-20</div>
                                                            </div>
                                                            <div class="note_content">text goes here text goes here text goes here</div>
                                                            <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="note_item">
                                                            <div class="block_header">
                                                                <div class="right_side_actions actions_td"><a href="javascript:;"><i class="fa fa-trash"></i></a><a href="javascript:;"><i class="fa fa-edit"></i></a></div>
                                                                <h4 class="note_title">Note title</h4>
                                                                <div class="small_date">2020-02-20</div>
                                                            </div>
                                                            <div class="note_content">text goes here text goes here text goes here text goes here text goes here text goes here</div>
                                                            <div class="small_date author_content">By: <a href="javascript:;">Root Administrator</a></div>
                                                        </div>
                                                    </div>
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
