<!-- Sidebar  -->
<nav id="sidebar">
	<div class="sidebar-header">
		<h3>Fake News Validator</h3>
	</div>
	<div class="container-fluid">
		<ul class="list-unstyled">
			<li>
				<p>
					{{$caseManagement->title}}
				</p>
			</li>

		</ul>
	</div> 

	@php      
	$task     = $caseManagement->task;
	$notes    = $caseManagement->notes;
	$events   = $caseManagement->events;
	$map      = $caseManagement->map;
	$files    = $caseManagement->files;
	$contactPeople  = $caseManagement->contactPeople;
	$discussion = $caseManagement->discussion;
	$bookmark   = $caseManagement->bookmark;
	$security   = $caseManagement->security;
    $relatedCases = $caseManagement->related_cases;
	@endphp
	<ul class="list-unstyled components">
		<li class="@if(Route::currentRouteName()=='cases.detail_case_desc') active @endif">
			<a href="{{route('cases.detail_case_desc',['caseManagementId'=>$caseManagement->id])}}">Description</a>
		</li>
		<li class="@if(Route::currentRouteName()=='cases.files' || Route::currentRouteName()=='cases.updatetask_case' || Route::currentRouteName()=='cases.task-management') active @endif">
			<a href="{{route('cases.files',['caseManagementId'=>$caseManagement->id])}}">Tasks ({{$task->count()?$task->count():0}})</a>
		</li>
		<li class="@if(Route::currentRouteName()=='cases.notes' || Route::currentRouteName()=='cases.addnotes') active @endif">
			<a href="{{route('cases.notes',['caseManagementId'=>$caseManagement->id])}}">Notes ({{$notes->count()?$notes->count():0}})</a>
		</li>
		<li class="@if(Route::currentRouteName()=='cases.events') active @endif">
			<a href="{{route('cases.events',['caseManagementId'=>$caseManagement->id])}}">Events ({{$events->count()?$events->count():0}})</a>
		</li>
		<li class="@if(Route::currentRouteName()=='cases.map') active @endif">
			<a href="{{route('cases.map',['caseManagementId'=>$caseManagement->id])}}">Map ({{$map->count()?$map->count():0}})</a>
		</li>
		<li class="@if(Route::currentRouteName()=='cases.files.upload') active @endif">
			<a href="{{route('cases.files.upload',['caseManagementId'=>$caseManagement->id])}}">Files ({{$files->count()?$files->count():0}})</a>
		</li>
		<li class="@if(Route::currentRouteName()=='cases.contact-people'  || Route::currentRouteName()=='cases.add-contact')active @endif">
			<a href="{{route('cases.contact-people',['caseManagementId'=>$caseManagement->id])}}">Contact People ({{$contactPeople->count()?$contactPeople->count():0}})</a>
		</li>
		<li class="@if(Route::currentRouteName()=='cases.case-discussions') active @endif">
			<a href="{{route('cases.case-discussions',['caseManagementId'=>$caseManagement->id])}}">Discussions ({{$discussion->count()?$discussion->count():0}})</a>
		</li>
		<li class="@if(Route::currentRouteName()=='cases.book-mark') active @endif">
			<a href="{{route('cases.book-mark',['caseManagementId'=>$caseManagement->id])}}">Bookmarks ({{$bookmark->count()?$bookmark->count():0}})</a>
		</li>
		<li class="@if(Route::currentRouteName()=='cases.related-cases') active @endif">
			<a href="{{route('cases.related-cases',['caseManagementId'=>$caseManagement->id])}}">Related Cases (0)</a>
		</li>
		<li class="@if(Route::currentRouteName()=='cases.security') active @endif">
			<a href="{{route('cases.security',['caseManagementId'=>$caseManagement->id])}}">Security ({{$security->count()?$security->count():0}})</a>
		</li>
	</ul>
</nav>
