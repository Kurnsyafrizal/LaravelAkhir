<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>@yield('title')</title>
  </head>
    <body>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
      {{-- INI UNTUK AJAX JQUERY --}}

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse " id="navbarNavAltMarkup">
              <div class="navbar-nav p-2">
                <a class="nav-link nav-item"  aria-pressed="true" href="{{ url('/halamanutama') }}">{{ __('Halaman Utama') }}</a>
              </div>
                <div class="navbar-nav p-2">
                    <a class="nav-link nav-item"  aria-pressed="true" href="{{ url('/stock/{id}') }}">{{ __('Stock') }}</a>
                </div>
                <div class="navbar-nav p-2">
                    <a class="nav-link nav-item"  aria-pressed="true" href="{{ url('/stock/{id}/addstock') }}">{{ __('Add Stock') }}</a>
                </div>
                <div class="navbar-nav p-2">
                  <a class="nav-link nav-item"  aria-pressed="true" href="{{ url('/stock/{id}/issue') }}">{{ __('Issue Stock') }}</a>
                </div>
                <div class="navbar-nav p-2">
                    <a class="nav-link nav-item"  aria-pressed="true" href="{{ url('/stock/transaction/{id}') }}">{{ __('Transaction History') }}</a>
                  </div>
                <div class="navbar-nav p-2">
                    <a class="nav-link nav-item"  aria-pressed="true" href="{{ url('/logout') }}">{{ __('Logout') }}</a>
                </div>
            </div>
            <span style="float: right; padding-top: 5px; margin-right: 4%" class="text-white h5">{{ __('Hello : ') }} {{ Auth::user()->name }}</span>
        </nav>

        @yield('content')

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    </body>
</html>