<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {!! Meta::toHtml() !!}
    @vite('resources/scss/app.scss')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
</head>
<body>
    <header>

    </header>
    <div class="container">
        @include('layouts.partials.flash')
        @yield('content')
    </div>

    <div class="modal fade" id="mainModal" tabindex="-1" aria-labelledby="mainModalTitle" style="display: none;"
         aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="h1 modal-title fs-5" id="mainModalTitle"></div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    @vite('resources/js/app.js')
    @yield('scripts')
</body>
</html>
