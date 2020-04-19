<div class="inner-info-content flag_button">
    {{ Form::open(['url'=> route('section-flag', [$sectionId, $case->id]), 'class' => 'flag_trusted']) }}
        {{ Form::hidden('flag', 'trusted')}}
        {{ Form::button('<i class="fa fa-check"></i> Flag Trusted', ['type' => 'submit', 'class' => 'btn pull-left btn_primary']) }}
    {{ Form::close() }}
    {{ Form::open(['url'=> route('section-flag', [$sectionId, $case->id]), 'class' => 'flag_fake']) }}
        {{ Form::hidden('flag', 'fake')}}
        {{ Form::button('<i class="fa fa-times"></i> Flag Fake', ['type' => 'submit', 'class' => 'btn pull-right btn_secondary']) }}
    {{ Form::close() }}
</div>
