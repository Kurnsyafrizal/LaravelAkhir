@extends('layouts.pagemaster')
@section('title', 'Issue Page')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="card border-0">
            <h2 class="text-center">{{ __("Issue Barang") }}</h2>
            <form>
                <div class="form-group mt-3">
                    <label for="bukti" class="ml-4 font-weight-bold text-md h3">{{ __("Bukti") }}</label>
                    <input type="text" class="form-control" readonly id="bukti" value="KURANG{{ $count }}">
                </div>

                <div class="form-group mt-2">
                    <label for="lokasi" class="ml-4 font-weight-bold text-md h3">{{ __("Lokasi") }}</label>
                    <select class="form-select form-select-lg mb-3" name="lokasi" id="lokasi">
                        @foreach ($location as $loc)
                            <option value="{{ $loc->id }}">{{ $loc->location }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-2">
                    <label for="kode_barang" class="ml-4 font-weight-bold text-md h3">{{ __("Kode Barang") }}</label>
                    <select class="form-select form-select-lg mb-3" name="kode_barang" id="kode_barang">
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
                    <input type="number" class="form-control" id="qty">
                </div>

                <div class="form-group mt-2">
                    <label for="um" class="ml-4 font-weight-bold text-md h3">{{ __("Satuan") }}</label>
                    <select class="form-select form-select-lg mb-3" name="um" id="um">
                        @foreach ($ums as $um)
                            <option value="{{ $um->id }}">{{ $um->name }}</option>
                        @endforeach
                    </select>
                </div>
                

                <button type="submit" class="btn btn-primary mt-4">{{ __("Add Stock") }}</button>
              </form>
        </div>
    </div>

    <script>
        
    </script>
@endsection