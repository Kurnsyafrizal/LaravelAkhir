@extends('layouts.pagemaster')
@section('title', 'Transaction Page')

@section('content')
    <div class="container mb-5">
        <div class="card card-info mt-3 border-0">
            <div class="card-body">
                <form action="{{ url('/transaction/filter') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="filter" class=" font-weight-bold ml-4 h2">{{ __("Filter") }}</label>
                    </div>

                    <div class="form-group mt-4">
                        <select class="form-select form-select-lg mb-3" name="filter" id="filter" onchange="myFunction()">
                            @foreach ($filter as $fil)
                                <option value="{{ $fil->value }}" {{ ($fil->value === $id) ? "selected" : "" }}>{{ $fil->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    @if ($id == 1 )
                        {{--Bukti --}}
                        <div class="form-group mt-4">
                            <label for="bukti" class="ml-4 font-weight-bold text-md h4">{{ __("BUKTI") }}</label>
                            <select class="form-select form-select-lg mb-3" name="bukti" id="bukti">
                                <option value="TAMBAH">{{ __("TAMBAH") }}</option>
                                <option value="KURANG">{{ __("KURANG") }}</option>
                            </select>
                        </div>
                    @elseif($id == 2)
                        {{-- Lokasi --}}
                        <div class="form-group mt-2">
                            <label for="lokasi" class="ml-4 font-weight-bold text-md h4">{{ __("Lokasi") }}</label>
                            <select class="form-select form-select-lg mb-3" name="lokasi" id="lokasi">
                                @foreach ($location as $loc)
                                    <option value="{{ $loc->id }}">{{ $loc->location }}</option>
                                @endforeach
                            </select>
                        </div>
                    @elseif($id==3)
                        {{--Kode Barang --}}
                        <div class="form-group mt-2">
                            <label for="kode_barang" class="ml-4 font-weight-bold text-md h4">{{ __("Kode Barang") }}</label>
                            <select class="form-select form-select-lg mb-3" name="kode_barang" id="kode_barang">
                                @foreach ($item as $items)
                                    <option value="{{ $items->id }} ">{{ $items->kode_barang }}</option>
                                @endforeach
                            </select>
                        </div>

                    @elseif($id==4)
                        <div class="form-group mt-2">
                            <label for="date" class="ml-4 font-weight-bold text-md h4">{{ __("Tanggal") }}</label>
                            <div class="col-md-12">
                                <input type="date" name="date" id="date">
                            </div>
                        </div>
                    @endif
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-lg float-right mb-3">{{ __("Filter") }}</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card card-info card-outline mt-3">
            <div class="card-header bg-secondary">
                <a href="" class="btn btn-success">{{  __('Export Excel')  }}</a>
                <a href="" class="btn btn-danger">{{  __('Export PDF')  }}</a>
            </div>

            <div class="card-body ">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">{{ __("BUKTI") }}</th>
                            <th scope="col">{{ __("TGL TRN") }}</th>
                            <th scope="col">{{ __("JAM") }}</th>
                            <th scope="col">{{ __("LOKASI") }}</th>
                            <th scope="col">{{ __("KODE BARANG") }}</th>
                            <th scope="col">{{ __("TGL MASUK") }}</th>
                            <th scope="col">{{ __("QTY TRN") }}</th>
                            <th scope="col">{{ __("UM") }}</th>
                            <th scope="col">{{ __("PROGRAM") }}</th>
                            <th scope="col">{{ __("USERID") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $stock)
                            <tr>
                                <td>{{ $stock->bukti }}</td>
                                {{-- mengubah format datetime --}}
                                <td>{{ \Carbon\Carbon::parse($stock->tgl_transaksi)->format('Y/m/d')  }}</td>
                                {{-- mengubah format datetime menjadi jam--}}
                                <td>{{ \Carbon\Carbon::parse($stock->tgl_transaksi)->format('H:i')  }}</td>
                                <td>{{ $stock->location->location }}</td>
                                <td>{{ $stock->item->kode_barang }}</td>
                                <td>{{ \Carbon\Carbon::parse($stock->tgl_transaksi)->format('Y/m/d')  }}</td>
                                <td>{{ $stock->qty }}</td>
                                <td>{{ $stock->item->um->name }}</td>
                                <td>{{ $stock->program }}</td>
                                <td>{{ $stock->user->name }}</td>
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
            window.location.href = "http://127.0.0.1:8000/stock/transaction/" + x;
        }

    </script>

@endsection