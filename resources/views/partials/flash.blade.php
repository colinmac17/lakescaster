@if ($flash = session('message'))

    <div id="flash-message" class="alert alert-success" role="alert">
        {{ $flash }}
        <span id="close-flash" class="float-right" style="cursor:pointer;">Close X</span>
    </div>

@endif