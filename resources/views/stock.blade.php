@extends('layouts.pagemaster')
@section('title', 'Stock Page')

@section('content')
    <div class="container">
        <div class="card card-info mt-3 border-0">
            <div class="card-body">
                <form action="{{ url('/stock/detail', [
                    'id' => $id,
                    ]) }}" method="GET">
                    @csrf
                    <div class="form-group">
                        <label for="filter" class=" font-weight-bold ml-4 h4">{{ __("Filter") }}</label>
                    </div>

                    <div class="form-group mt-4">
                        <select class="form-select form-select-lg mb-3" name="filter" id="filter" onchange="myFunction()">
                            @foreach ($filter as $fil)
                                <option value="{{ $fil->value }}" {{ ($fil->value === $id) ? "selected" : "" }}>{{ $fil->label }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if ($id == 1 )
                    {{--Kode Barang --}}
                    <div class="form-group mt-2">
                        <label for="kode_barang" class="ml-4 font-weight-bold text-md h3">{{ __("Kode Barang") }}</label>
                        <select class="form-select form-select-lg mb-3" name="kode_barang" id="kode_barang">
                            @foreach ($item as $items)
                                <option value="{{ $items->id }}">{{ $items->kode_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    @elseif ($id == 2 )
                    {{-- Lokasi --}}
                    <div class="form-group mt-2">
                        <label for="lokasi" class="ml-4 font-weight-bold text-md h3">{{ __("Lokasi") }}</label>
                        <select class="form-select form-select-lg mb-3" name="lokasi" id="lokasi">
                            @foreach ($location as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->location }}</option>
                            @endforeach
                        </select>
                    </div>

                    @endif
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-lg float-right mb-3">{{ __("Cari") }}</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card card-info card-outline mt-3">
            <div class="card-header bg-secondary">
                <a href="{{url('/stock/export/excel', ['params' => base64_encode(json_encode(Request::all()))])}}" class="btn btn-success">{{  __('Export Excel')  }}</a>
                <a href="{{url('/stock/export/pdf', ['params' => base64_encode(json_encode(Request::all()))])}}" class="btn btn-danger">{{  __('Export PDF')  }}</a>
            </div>

            <div class="card-body ">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">{{ __("Location") }}</th>
                        <th scope="col">{{ __("Kode Barang") }}</th>
                        <th scope="col">{{ __("Nama Barang") }}</th>
                        <th scope="col">{{ __("Saldo") }}</th>
                        <th scope="col">{{ __("UM") }}</th>
                        <th scope="col">{{ __("Tgl Masuk") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $stock)
                            <tr>
                                <td>{{ $stock->location->location }}</td>
                                <td>{{ $stock->item->kode_barang }}</td>
                                <td>{{ $stock->item->nama_barang }}</td>
                                <td>{{ $stock->saldo }}</td>
                                <td>{{ $stock->item->um->name }}</td>
                                {{-- mengubah format tanggal --}}
                                <td>{{ \Carbon\Carbon::parse($stock->transaction_date)->format('Y/m/d')  }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    
    <script type ="text/javascript"> 
        function myFunction() 
        {   
            //ambil value id filter
            var x = document.getElementById("filter").value;
            //memindahkan url sesuai value id yang di pilih
            window.location.href = "http://127.0.0.1:8000/stock/detail/" + x;
        }

    </script>
@endsection