{{--Claim tournament spot modal--}}
<div class="modal fade" id="claimModal" tabindex="-1" role="dialog" aria-labelledby="claim modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Claim spot on tournament<br/>
                    <div class="modal-subtitle" id="modal-subtitle"></div>
                </h4>
            </div>
            <div class="modal-tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-with-decks" role="tab">
                            <i class="fa fa-id-card-o" aria-hidden="true"></i>
                            With decks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-without-decks" role="tab">
                            <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                            Without decks
                        </a>
                    </li>
                </ul>
            </div>
            <div class="modal-body tab-content">
                <div class="container-fluid bd-example-row tab-pane active" id="tab-with-decks" role="tabpanel">
                    {!! Form::open(['url' => "", 'id' => 'create-claim']) !!}
                        <input name="top_number" type="hidden" value="" id="hidden-top-value" />
                        {{--Rank selectors--}}
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    {!! Form::label('rank', 'rank after swiss rounds') !!}
                                    {!! Form::select('rank', [], null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6" id="claim-top-section">
                                <div class="form-group">
                                    {!! Form::label('rank_top', 'rank after top cut') !!}
                                    {!! Form::select('rank_top', [], null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        {{--Dropdown selectors for decks--}}
                        <div class="row" id="claim-deck-row">
                            <div class="col-xs-12 col-md-6">
                                <div class="deck-loader">loading</div>
                                <div class="form-group">
                                    {!! Form::label('corp_deck', 'corporation deck') !!}
                                    {!! Form::select('corp_deck', [], null, ['class' => 'form-control',
                                        'id' => 'corp_deck', 'onchange' => 'setCheckBoxes()']) !!}
                                    <div class="alert alert-danger hidden-xs-up" id="no-corp-deck">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        You don't have any decklist available on NetrunnerDB.
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="deck-loader">loading</div>
                                <div class="form-group">
                                    {!! Form::label('runner_deck', 'runner deck') !!}
                                    {!! Form::select('runner_deck', [], null, ['class' => 'form-control',
                                        'id' => 'runner_deck', 'onchange' => 'setCheckBoxes()']) !!}
                                    <div class="alert alert-danger hidden-xs-up" id="no-runner-deck">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        You don't have any decklist available on NetrunnerDB.
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--Login prompt if user is not logged in--}}
                        <div class="text-xs-center hidden-xs-up m-b-1" id="claim-user-login">
                            <div class="alert alert-danger" id="no-runner-deck">
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                There was a problem with reaching NetrunnerDB.<br/>
                                Please try logging in again.
                            </div>
                            <a href="/oauth2/redirect">Login via NetrunnerDB</a> to claim spot.
                        </div>
                        {{--Publish private decks--}}
                        <div class="form-group text-xs-center m-b-0">
                            {!! Form::checkbox('auto_publish', null, true, ['id' => 'auto_publish']) !!}
                            {!! Form::label('auto_publish', 'publish selected private decks') !!}
                            @include('partials.popover', ['direction' => 'top', 'content' =>
                                'Selecting this option will create a published copy of the private decks you
                                used.'])
                        </div>
                        {{--more options--}}
                        <div class="row">
                            <div class="col-xs-12 text-xs-right">
                                <a data-toggle="collapse" href="#collapse-other-decks" aria-expanded="false" aria-controls="collapse-other-decks">
                                    <i class="fa fa-caret-right" aria-hidden="true" id="caret-more"></i>
                                    <em id="text-more">more options</em>
                                </a>
                            </div>
                        </div>
                        <div class="collapse" id="collapse-other-decks">
                            <div class="card card-darker">
                                <div class="card-block">
                                {{--Claim with someone else's decks--}}
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="text-xs-center p-b-1">
                                            claim with someone else's deck
                                            @include('partials.popover', ['direction' => 'top', 'content' =>
                                                'Use this option if you want to claim with a <strong>published</strong> deck
                                                of another user. You can find the deck ID in the URL:<br/>
                                                <em>e.g.: netrunnerdb.com/en/decklist/<strong>38734</strong></em>'])
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('other_corp_deck', 'corporation deck ID') !!}
                                            {!! Form::text('other_corp_deck', null, ['class' => 'form-control',
                                                'oninput' => "switchDeck('corp_deck', 'other_corp_deck')",
                                                'placeholder' => 'published deck ID']) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('other_runner_deck', 'runner deck ID') !!}
                                            {!! Form::text('other_runner_deck', null, ['class' => 'form-control',
                                                'oninput' => "switchDeck('runner_deck', 'other_runner_deck')",
                                                'placeholder' => 'published deck ID']) !!}
                                        </div>
                                    </div>
                                </div>
                                {{--NetrunnerDB claim checkbox--}}
                                <hr/>
                                <div class="row">
                                    <div class="col-xs-12 text-xs-center">
                                        {!! Form::checkbox('netrunnerdb_link', null, env('DEFAULT_NETRUNNERDB_CLAIM'), ['id' => 'netrunnerdb_link']) !!}
                                        {!! Form::label('netrunnerdb_link', 'add claim to decklists on NetrunnerDB', ['class' => 'm-b-0']) !!}
                                        @include('partials.popover', ['direction' => 'bottom', 'content' =>
                                            'Selecting this option will also add your claim to the decklist page of NetrunnerDB.
                                            This is only available for published deckslists. It might take couple of
                                            minutes to appear.'])
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        {{--Sumbit claim--}}
                        <div class="text-xs-center">
                            <button type="submit" class="btn btn-claim disabled" id="submit-claim" disabled>
                                Claim spot
                            </button>
                        </div>
                        <div class="text-xs-center legal-bullshit p-t-1">
                            Confused about "private" and "published" decks? Read the <a href="/faq#ndb-private">F.A.Q.</a>
                        </div>
                    {!! Form::close() !!}
                    {{--Reminder for users not sharing private decks and not having published decks--}}
                    @if ($user && !$user->sharing && !$user->published_decks)
                        <div class="alert alert-warning view-indicator text-xs-center" id="warning-not-sharing">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            You are not sharing your <em>private decks</em>. This is fine.<br/>
                            If you want to claim with a <em>private deck</em>, go to
                            <a href="https://netrunnerdb.com/en/user/profile"><strong>NetrunnerDB&nbsp;account&nbsp;settings</strong></a>,
                            enable <strong>Share&nbsp;your&nbsp;decks</strong> and <strong>relogin</strong> to AlwaysBeRunning.net.
                        </div>
                    @endif
                </div>
                <div class="container-fluid bd-example-row tab-pane" id="tab-without-decks" role="tabpanel">
                    {{--Claim without decks--}}
                    {!! Form::open(['url' => "", 'id' => 'create-claim-nodeck']) !!}
                        {!! Form::hidden('corp_deck_title', '', ['id' => 'corp_deck_title']) !!}
                        {!! Form::hidden('runner_deck_title', '', ['id' => 'runner_deck_title']) !!}
                        <input name="top_number" type="hidden" value="" id="hidden-top-value-nodeck" />
                        {{--Rank selectors--}}
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    {!! Form::label('rank_nodeck', 'rank after swiss rounds') !!}
                                    {!! Form::select('rank_nodeck', [], null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6" id="claim-top-section-nodeck">
                                <div class="form-group">
                                    {!! Form::label('rank_top_nodeck', 'rank after top cut') !!}
                                    {!! Form::select('rank_top_nodeck', [], null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    {!! Form::label('corp_deck_identity', 'corporation identity') !!}
                                    <select name="corp_deck_identity" class="form-control" id="corp_deck_identity" onchange="recalculateDeckNames('')">
                                        @foreach($corpIDs as $key => $faction)
                                            <optgroup label="{{ $key }}">
                                                @foreach($faction as $code => $id)
                                                    <option value="{{ $code }}">{{ $id }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    {!! Form::label('runner_deck_identity', 'runner identity') !!}
                                    <select name="runner_deck_identity" class="form-control" id="runner_deck_identity" onchange="recalculateDeckNames('')">
                                        @foreach($runnerIDs as $key => $faction)
                                            <optgroup label="{{ $key }}">
                                                @foreach($faction as $code => $id)
                                                    <option value="{{ $code }}">{{ $id }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{--Sumbit claim without decklists--}}
                        <div class="text-xs-center p-t-1">
                            <button type="submit" class="btn btn-danger" id="submit-claim">
                                Claim spot without decks
                            </button>
                            <div class="legal-bullshit p-t-1">
                                Please consider sharing your decks. The data gods would be pleased.<br/>
                                You get no <a href="/badges">badges</a> for claiming without decks.
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
{{--Script to fill tournament claim modal--}}
<script type="text/javascript">
    var deckData = null, loading = false, swissEntriesRunner = [], swissEntriesCorp = [];
    @if (@$entries_swiss)
        swissEntriesRunner = [@foreach($entries_swiss as $entry) '{{count($entry) ? $entry[0]->runner_deck_identity : ''}}', @endforeach];
        swissEntriesCorp = [@foreach($entries_swiss as $entry) '{{count($entry) ? $entry[0]->corp_deck_identity : ''}}', @endforeach];
    @endif

    $('#claimModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var subtitle = button.data('subtitle'), // module subtitle
                id = button.data('tournament-id'),  // tournament ID
                players_number = button.data('players-number'),
                top_number = button.data('top-number');
        var modal = $(this);
        modal.find('.modal-subtitle').text(subtitle);
        modal.find('#create-claim').attr("action", "/tournaments/" + id + "/claim");
        modal.find('#create-claim-nodeck').attr("action", "/tournaments/" + id + "/claim-no-deck");
        modal.find('#hidden-top-value').val(top_number);
        modal.find('#hidden-top-value-nodeck').val(top_number);

        // ranks
        modal.find('#rank').empty();
        modal.find('#rank_nodeck').empty();
        for (var count = 1; count <= players_number; count++) {
            modal.find('#rank').append($('<option>', {value: count, text: count}));
            modal.find('#rank_nodeck').append($('<option>', {value: count, text: count}));
        }

        // top rank
        if (top_number) {
            modal.find('#claim-top-section').removeClass('hidden-xs-up');
            modal.find('#claim-top-section-nodeck').removeClass('hidden-xs-up');
            modal.find('#rank_top').empty().append($('<option>', {value: '0', text: 'below top cut'}));
            modal.find('#rank_top_nodeck').empty().append($('<option>', {value: '0', text: 'below top cut'}));
            for (count = 1; count <= top_number; count++) {
                modal.find('#rank_top').append($('<option>', {value: count, text: count}));
                modal.find('#rank_top_nodeck').append($('<option>', {value: count, text: count}));
            }
        } else {
            modal.find('#claim-top-section').addClass('hidden-xs-up');
            modal.find('#claim-top-section-nodeck').addClass('hidden-xs-up');
        }

        // update identities according to rank
        setIdentities();

        // load deck via API
        if (!deckData) {
            loadDecks();
        }

        function loadDecks() {
            if (!loading) { // don't start loading multiple times
                modal.find('.deck-loader').addClass('loader').removeClass('hidden-xs-up');
                loading = true;
                $.ajax({
                    url: '/api/userdecks',
                    dataType: "json",
                    async: true,
                    success: function (data) {
                        // hide loader animation
                        modal.find('.deck-loader').removeClass('loader').addClass('hidden-xs-up');

                        // user needs to login
                        if (data.error) {
                            modal.find('#claim-user-login').removeClass('hidden-xs-up');
                            modal.find('#claim-deck-row').addClass('hidden-xs-up');
                            return 0;
                        }

                        displayListOfDecksForClaims('runner', data);
                        displayListOfDecksForClaims('corp', data);

                        // enable submission if there were decks on both sides
                        if (data.privateNetrunnerDB.runner.length + data.publicNetrunnerDB.runner.length > 0 &&
                                data.privateNetrunnerDB.corp.length + data.publicNetrunnerDB.corp.length > 0) {
                            modal.find('#submit-claim').removeClass('disabled').prop("disabled", false);
                        }

                        deckData = data;
                        loading = false;
                    }
                });
            }
        }

        // populates select element for tournament claim form deck selector
        function displayListOfDecksForClaims(side, data) {
            var rootElement = '#'+side+'_deck',
                    publicRoot = modal.find(rootElement),
                    privateRoot = modal.find(rootElement);

            modal.find(rootElement).empty();

            // no deck warning
            if (data.privateNetrunnerDB[side].length + data.publicNetrunnerDB[side].length == 0) {
                modal.find('#no-'+side+'-deck').removeClass('hidden-xs-up');
                modal.find('#'+side+'_deck').addClass('hidden-xs-up');

            } else {

                // add optgroups
                if (data.privateNetrunnerDB[side].length && data.publicNetrunnerDB[side].length) {
                    modal.find(rootElement).append($('<optgroup>', {
                        label: '--- published decks ---',
                        id: side + '_public'
                    }));
                    modal.find(rootElement).append($('<optgroup>', {
                        label: '--- private decks ---',
                        id: side + '_private'
                    }));
                    publicRoot = modal.find('#' + side + '_public');
                    privateRoot = modal.find('#' + side + '_private');
                }

                // add public decks
                if (data.publicNetrunnerDB) {
                    displayDecksForClaims(data.publicNetrunnerDB[side], publicRoot, 1);
                }
                // add private decks
                if (data.privateNetrunnerDB) {
                    displayDecksForClaims(data.privateNetrunnerDB[side], privateRoot, 2);
                }

                setCheckBoxes();
            }
        }

        // populates option lines for tournament claim form deck selector
        function displayDecksForClaims(data, rootElement, type) {
            // note: ordering by date is note done, relying on NetrunnerDB
            $.each(data, function (index, element) {
                rootElement.append($('<option>', {
                    value: "{ \"title\": \"" + element.name.replace(/'/g, "\\'").replace(/"/g, "\\\\\"") +
                    "\", \"id\": \"" + element.id + "\", \"identity\": \"" + element.identity +
                    "\", \"type\": \"" + type + "\" }",
                    text: element.name
                }));
            });
        }
    });

    // more options collapse display fix
    $('#collapse-other-decks').on('shown.bs.collapse', function () {
        $('#collapse-other-decks').css({
            'display': 'block'
        });
        $('#caret-more').removeClass('fa-caret-right').addClass('fa-caret-down');
        $('#text-more').text('less options');
        $('.popover').popover('hide');
    }).on('hidden.bs.collapse', function () {
        $('#collapse-other-decks').css({
            'display': 'none'
        });
        $('#caret-more').removeClass('fa-caret-down').addClass('fa-caret-right');
        $('#text-more').text('more options');
        $('.popover').popover('hide');
    });

    // copy rank values between tabs
    $('#rank').on('change', function () {
        $('#rank_nodeck').val(this.value);
        setIdentities();
    });
    $('#rank_nodeck').on('change', function () {
        $('#rank').val(this.value);
        setIdentities();
    });
    $('#rank_top').on('change', function () {
        $('#rank_top_nodeck').val(this.value);
    });
    $('#rank_top_nodeck').on('change', function () {
        $('#rank_top').val(this.value);
    });

    function switchDeck(idOwn, idOther) {
        setCheckBoxes();

        // claim modal: disable own decks if other deck ID is provided
        if (document.getElementById(idOther).value.length > 0) {
            document.getElementById(idOwn).setAttribute('disabled','');
        } else {
            document.getElementById(idOwn).removeAttribute('disabled');
        }
    }

    // sets publishing checkbox visibility and NetrunnerDB claim eligibility
    function setCheckBoxes() {
        var runnerPublic = $('#runner_deck :selected').parent().prop("id") === 'runner_public',
                corpPublic = $('#corp_deck :selected').parent().prop("id") === 'corp_public',
                otherCorpUsed = document.getElementById('other_corp_deck').value.length > 0,
                otherRunnerUsed = document.getElementById('other_runner_deck').value.length > 0,
                autoPublish = document.getElementById('auto_publish').checked;

        // auto-publish
        if ((!runnerPublic && !otherRunnerUsed) || (!corpPublic && !otherCorpUsed)) {
            $('#auto_publish').prop("disabled", false);
        } else {
            $('#auto_publish').prop("disabled", true);
        }

        // Netrunner claim
        if (runnerPublic || corpPublic || otherCorpUsed || otherRunnerUsed || autoPublish) {
            $('#netrunnerdb_link').prop("disabled", false);
        } else {
            $('#netrunnerdb_link').prop("disabled", true);
        }
    }

    // set deck identities for claiming without decks
    function setIdentities() {
        if (swissEntriesCorp.length) {
            var rank_swiss = document.getElementById('rank').value - 1;
            if (swissEntriesCorp[rank_swiss].length) {
                document.getElementById('corp_deck_identity').value = swissEntriesCorp[rank_swiss];
            }
            if (swissEntriesRunner[rank_swiss].length) {
                document.getElementById('runner_deck_identity').value = swissEntriesRunner[rank_swiss];
            }
        }
        recalculateDeckNames('');
    }

</script>