{{--Tournament videos--}}
<div class="bracket">
    <h5>
        <i class="fa fa-video-camera" aria-hidden="true"></i>
        Videos
    </h5>
    {{--Add video--}}
    @if ($user)
        <button class="btn btn-primary btn-xs" id="button-add-videos"
                onclick="toggleVideoAdd(true)">
            <i class="fa fa-video-camera" aria-hidden="true"></i> Add videos
        </button>
        <button class="btn btn-primary btn-xs hidden-xs-up" id="button-done-videos"
                onclick="toggleVideoAdd(false)">
            <i class="fa fa-check" aria-hidden="true"></i> Done
        </button>
        <div id="section-add-videos" class="hidden-xs-up">
            <hr/>
            <div class="p-b-1">
                Add a Youtube video
            </div>
            {!! Form::open(['method' => 'POST', 'url' => "/videos",
                'class' => 'form-inline']) !!}
            {!! Form::hidden('tournament_id', $tournament->id) !!}
            <div class="form-group">
                {!! Form::label('video_id', 'Youtube Video ID or URL', ['class' => 'small-text']) !!}
                {!! Form::text('video_id', '', ['class' => 'form-control']) !!}
            </div><br/>
            {!! Form::button('Add video', array('type' => 'submit',
                'class' => 'btn btn-success btn-xs', 'id' => 'button-add-video')) !!}
            {!! Form::close() !!}
        </div>
        <hr/>
    @endif
    {{--List of videos--}}
    @if (count($tournament->videos) > 0)
        @include('tournaments.viewer.videolist',
            ['videos' => $tournament->videos, 'creator' => $tournament->creator, 'id' => 'videos'])
    @else
        <p><em id="no-videos">no videos yet</em></p>
    @endif
    <div id="section-watch-video" class="hidden-xs-up">
        <hr/>
        <p>
            <button class="btn btn-danger btn-xs" onclick="watchVideo(false)">
                <i class="fa fa-window-close" aria-hidden="true"></i> Close
            </button>
        </p>
        <div id="section-video-player"></div>
    </div>
</div>