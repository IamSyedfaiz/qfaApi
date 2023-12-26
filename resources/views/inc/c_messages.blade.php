<main class="main" id="main">
    @if (Session::has('success'))
        <div class="alert alert-success show col-md-12">
            <strong>Success!</strong> {{ session('success') }}
            {{-- <button type="button" class="close" data-dismiss="alert">&times;</button> --}}
        </div>
    @endif
    @if (Session::has('warning'))
        <div class="alert alert-danger show col-md-12">
            <strong>Warning!</strong> {{ session('warning') }}
            {{-- <button type="button" class="close" data-dismiss="alert">&times;</button> --}}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger show col-md-12">
            <strong>Error!</strong> {{ session('error') }}
            {{-- <button type="button" class="close" data-dismiss="alert">&times;</button> --}}
        </div>
    @endif

</main>
