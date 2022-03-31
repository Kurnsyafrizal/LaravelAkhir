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

        <nav class=" bg-light" style="padding-left: 5%; padding-right: 5%">
            <form class="">
                <a href="{{url('/stock')}}" class="btn btn-outline-success me-2 ml-3">Stock</a>
                <a href="{{url('/stock/add')}}" class="btn btn-outline-success me-2">Add Stock</a>
                <a href="{{url('/stock/issue')}}" class="btn btn-outline-success me-2">Issue Stock</a>
                <a href="{{url('/transaction')}}" class="btn btn-outline-success me-2">Transaction History</a>
                <a href="{{url('/logout')}}" class="btn btn-outline-success me-2" style="float: right;">Logout</a>
                <strong><span style="float: right; padding-top: 5px; margin-right: 4%">Hello {{Auth::user()->name}}!</span></strong>
            </form>
        </nav>

        @yield('content')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    </body>
</html>