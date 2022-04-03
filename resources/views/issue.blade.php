@extends('layouts.pagemaster')
@section('title', 'Issue Page')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="card border-0">
            <h2 class="text-center">{{ __("Issue Barang") }}</h2>
            <form action="{{ url('/stock/issue') }}" method="POST">
                @csrf
                @method("POST")
                <div class="form-group mt-2"> 
                    <label for="location" class="ml-4 font-weight-bold text-md h3">{{ __("Lokasi") }}</label>
                    <select class="form-select form-select-lg mb-3" name="location" id="location">
                        @foreach ($location as $loc)
                            <option value="{{ $loc->id }}">{{ $loc->location }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-2">
                    <label for="kode_barang" class="ml-4 font-weight-bold text-md h3">{{ __("Kode Barang") }}</label>
                    <select class="form-select form-select-lg mb-3" name="kode_barang" id="kode_barang">
                        <option>Pilih</option>
                        @foreach ($item as $items)
                            <option value="{{ $items->id }}">{{ $items->kode_barang }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-2">
                    <label for="nama_barang" class="ml-4 font-weight-bold text-md h3">{{ __("Nama Barang") }}</label>
                    <input type="text" class="form-control" readonly id="nama_barang" name="nama_barang">
                </div>

                <div class="form-group mt-2">
                    <label for="qty" class="ml-4 font-weight-bold text-md h3">{{ __("Quantity") }}</label>
                    <input type="number" class="form-control" id="qty" name="qty">
                </div>

                <div class="form-group mt-2">
                    <label for="um" class="ml-4 font-weight-bold text-md h3">{{ __("Satuan") }}</label>
                    <select class="form-select form-select-lg mb-3" name="um" id="um">
                        @foreach ($ums as $um)
                            <option value="{{ $um->id }}">{{ $um->name }}</option>
                        @endforeach
                    </select>
                </div>
                

                <button type="submit" class="btn btn-primary mt-4">{{ __("Add Issue") }}</button>
              </form>
        </div>
    </div>

    <script>
    
        $(function() 
        {
            $('select[name=kode_barang]').change(function() 
            {
                var url = '{{ url('/item') }}' +'/'+ $(this).val();
                console.log(url);
                
                //$ = JQUERY
                $.get(url, function(data) 
                {
                    var inputbox = $('form input[name=nama_barang]');
    
                    console.log(inputbox);
                    inputbox.val(data['nama_barang']);
                });
            });
        });
    </script>
@endsection