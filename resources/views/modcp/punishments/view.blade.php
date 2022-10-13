@include('layout.head')

<body style="overflow-x:hidden;">
@include('layout.navigation.mobile-nav')
<div id="modal-wrapper">
    @include('layout.navigation.topbar')
    @include('layout.navigation.navbar')
    @include('layout.header-content')
</div>
<div class="content" id="main-content">
    <div class="container" style="width:95%;">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <div class="row" style="margin: 0;">
                            <h5 class="center-align">
                                Viewing punishment log ID: <span class="pal-green">{{ $punishment->id }}</span> for user <a href="#" class="pal-red">{{ $punishment->offender }}</a>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.modcp_sidebar')
            <div class="col s12 xl9">
                <div class="card">
                    <div class="card-content" id="punish-log">
                        <div class="row" style="padding: 15px">
                            <div class="left">
                                <h6 class="pal-gold">Staff member</h6>
                                <p style="color:#93B045">{{ $punishment->mod_name }}</p>
                                <div class="mg-b-10"></div>

                                <h6 class="pal-gold">Offender</h6>
{{--                                TODO: Need to be able to view individual player punishments?--}}
{{--                                https://zenyte.com/modcp/player/xxxdddddd like that--}}
                                <a style="color:#ea4335" href="#">{{ $punishment->offender }}</a>
                                <div class="mg-b-10"></div>

                                <h6 class="pal-gold">IP address</h6>
                                <p style="color:#00BDF5">{{ $punishment->ip_address ?? 'N/A' }}</p>
                                <div class="mg-b-10"></div>

                                <h6 class="pal-gold">MAC address</h6>
                                <p style="color:#00BDF5">{{ $punishment->mac_address ?? 'N/A' }}</p>
                                <div class="mg-b-10"></div>
                            </div>
                            <div class="right">
                                <h6 class="pal-gold right">Punished on</h6><br>
                                <p style="color:#00BDF5" class="right">{{ Carbon\Carbon::parse($punishment->punished_on)->format('F j, Y, g:i:a') }}</p><br>
                                <div class="mg-b-10"></div>

                                <h6 class="pal-gold right">Expires</h6><br>
                                <p style="color:#00BDF5" class="right">{{  Carbon\Carbon::createFromTimestamp($punishment->expires)->format('F j, Y, g:i:a') }}</p><br>
                                <div class="mg-b-10"></div>
                            </div>
                            <div class="row center-align" style="margin-top: 15px">
                                <h6 class="pal-gold">Reason</h6>
                                <p style="color:#00BDF5">{{ $punishment->reason }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <h5 class="center-align">Proof information</h5>
                <div class="mg-b-10"></div>
                <div class="center-align">

                    <div class="mg-b-25"></div>
                    <a id="proof-onclick" class="skill-dropdown btn pal-green modal-trigger" href="#proof-modal">Upload proof</a>
                    <div class="mg-b-25"></div>

                    <div class="proof">
                        <ul class="collapsible" data-collapsible="accordion" style="box-shadow: none;" id="proof-hid">
                            @foreach($proof as $individualProof)
                                <li style="margin-bottom:10px;background-color: #171412;">
                                    <div class="collapsible-header">
                                        <i class="far fa-comment-alt"></i>
                                        <span style="color:#c9aa71;">Proof #{{ $loop->iteration }}</span>
                                        <span class="badge right">
										<small>
											{{ Carbon\Carbon::createFromTimestamp($individualProof->timestamp)->format('F j, Y, g:i a') }} by
                                            <a href="{{ route('account', $individualProof->seo_member_name) }}">{{ ucfirst($individualProof->staff_member) }}</a>
										</small>
									</span>
                                    </div>
                                    <div class="collapsible-body discordblock news-text" id="newsblock" style="max-height:750px;">
                                        @if($forumUser->isAdmin())
                                            <div style="margin-bottom:20px;">
                                                <a class="right pal-red mg-l-30 del-proof modal-trigger" href="#deleteProof-modal" data-id="{{ $individualProof->id }}"><i class="fal fa-eye"></i> REMOVE EVIDENCE</a>
                                                <hr>
                                            </div>
                                        @endif
                                        {{-- Below is for legacy support --}}
                                        @if($individualProof->url !== null)
                                            <a class="right g-link" href="{{ $individualProof->url }}" target="_blank"><i class="fal fa-eye"></i> SEE FULL IMAGE</a>
                                            <img class="proof-thumb left" src="{{ $individualProof->url }}"/>
                                        @else
                                            <div class="row">
                                                @foreach($punishment->getProofURLS($individualProof->id) as $url)
                                                    <div class="col s4 xl6">
                                                        <a class="right g-link" href="{{ $url }}" target="_blank"><i class="fal fa-eye"></i> SEE FULL IMAGE</a>
                                                        <img class="proof-thumb" src="{{ $url }}" height="200px"/>
                                                        <hr>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <span>{{ $individualProof->notes }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <div id="proof-modal" class="modal">
            <form method="post" action="{{ route('modcp.punishments.uploadProof', $punishment->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <h5>Submit evidence</h5>
                    <div style="line-height:1em;font-size:12px;margin-bottom:10px;">
                        Use this dialogue to submit files and notes as proof.
                        The accepted file types are:
                        <span class="pal-blue">
                        @foreach(config('modcp.accepted_punishment_file_types') as $type)
                                {{ $type }},
                            @endforeach
                    </span>
                    </div>
                    <hr>
                    <div class="input-field">
                        <span>Notes</span>
                        <textarea id="notes" name="notes" class="materialize-textarea" placeholder="This is an optional notes field. You can use it to explain any of the files you upload, or provide more context to this punishment."></textarea>
                    </div>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Upload Proof</span>
                            <input type="file" name="files[]" multiple>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload one or more files">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="modal-action modal-close btn custom-btn skill-dropdown">Submit proof</button>
                </div>
            </form>
        </div>

        <div id="deleteProof-modal" class="modal">
            <form method="GET" action="{{ route('modcp.punishments.deleteProof', $punishment->id) }}">
                @csrf
                <div class="modal-content">
                    <h5>Delete evidence</h5>
                    <div style="line-height:1em;font-size:12px;margin-bottom:10px;">
                        Use this dialogue to delete punishment-related evidence.
                    </div>
                    <hr>
                    <p style="font-size: 20px" class="pal-blue center-align">Are you sure you want to delete this evidence? This cannot be undone!</p>
                    <input type="hidden" name="proofId" id="del-proofId" value="">
                    <hr>
                    <div class="center-align">
                        <button type="submit" class="skill-dropdown btn pal-green modal-action modal-close">Yes, delete evidence</button>
                        <div class="skill-dropdown btn pal-red mg-l-30 modal-action modal-close mg-l-30">No, exit menu</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
@include('layout.scripts')
<script>
    $(document).on("click", ".del-proof", function (e) {
        var proofId = $(this).data('id');
        $('#del-proofId').val(proofId);
    });
</script>
</body>
@include('layout.footer')
</html>