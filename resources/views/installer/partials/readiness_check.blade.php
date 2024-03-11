<h3>Readiness check</h3>
<section>

    <div class="version_wrapper">
        <div id="prerequisite-message-wrapper" class="current_version"></div>
        <div id="prerequisite-message-wrapper" class="current_version prerequisites version">PHP ( {{ lang('min_version').' '.$config['requirements']['minPhpVersion'].' '.lang('is_required') }})</div>
    </div>

    <div class="check-list">
        <ul>
            @foreach($config['requirements']['php'] as $phpReq)
                <li class="prerequisites extensions {{ $phpReq }}">{{ ucfirst($phpReq)}}</li>
            @endforeach
        </ul>
        <h4 class="prerequisites ">Apache</h4>
        <ul>
            @foreach($config['requirements']['apache'] as $apacheReq)
            <li class="prerequisites apache {{ $apacheReq }}">{{ $apacheReq }}</li>
            @endforeach
        <ul>
    </div>
</section>