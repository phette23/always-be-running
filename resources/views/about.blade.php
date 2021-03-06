@extends('layout.general')

@section('content')
    <h4 class="page-header">About</h4>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="bracket">
                <h5 class="p-b-1">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    Contact
                </h5>
                <p>This site is created by <strong>Necro</strong>.</p>
                <p>You can contact me via: alwaysberunning (at) gmail.comt</p>
                <p>All ideas, suggestions, feedback are welcome.</p>
                <p>Bugs and feaure requests: <a href="https://github.com/madarasz/always-be-running">Github</a></p>
            </div>
            <div class="bracket">
                <h5 class="p-b-1">
                    <i class="fa fa-laptop" aria-hidden="true"></i>
                    Developers
                </h5>
                <ul>
                    <li><a href="http://alwaysberunning.net/profile/1276">Necro</a> - site owner, main developer</li>
                    <li><a href="http://alwaysberunning.net/profile/1221">johno</a> - tournament videos</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="bracket">
                <h5 class="p-b-1">
                    <i class="fa fa-child" aria-hidden="true"></i>
                    Acknowledgements
                </h5>
                <p>
                    Thank you to the wonderful people for making these software available:
                    <ul>
                        <li><a href="https://netrunnerdb.com">NetrunnerDB</a></li>
                        <li><a href="https://laravel.com/">Laravel</a></li>
                        <li><a href="https://github.com/haleks/laravel-markdown">Laravel Markdown</a></li>
                        <li><a href="https://github.com/webpatser/laravel-countries">Laravel Countries</a></li>
                        <li><a href="https://github.com/eternicode/bootstrap-datepicker">Datepicker for Bootstrap</a></li>
                        <li><a href="http://www.codrops.com">jquery.calendario.js</a></li>
                        <li><a href="https://github.com/Lusitanian/PHPoAuthLib">PHPoAuthLib</a></li>
                        <li><a href="http://www.aropupu.fi/bracket">jQuery Bracket</a></li>
                        <li><a href="http://fontawesome.io/">Font Awesome</a></li>
                    </ul>
                    Thank you to these awesome people for their technical help, sending ideas or bug reports:
                    <ul class="p-t-1">
                        @foreach($helpers as $helper)
                            <li><a href="profile/{{$helper->id}}">{{$helper->name}}</a></li>
                        @endforeach
                    </ul>
                </p>
            </div>
        </div>
    </div>
@stop

