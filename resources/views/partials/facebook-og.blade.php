{{--meta tags for facebook open graph protocol--}}
<meta property="og:title" content="Always be Running.net"/>
<meta property="og:image" content="http://www.alwaysberunning.net/ms-icon-310x310.png" />
@if (@$tournament)
    <meta property="og:description" content="{!! substr($tournament->title.' - '.strip_tags(Markdown::convertToHtml($tournament->description)),0,300).'...' !!}" />
@else
    <meta property="og:description" content="Tournament finder and tournament results for Android: Netrunner card game" />
@endif