@extends('layouts.pagemaster')
@section('title', 'Transaction Page')

@section('content')
<div class="card card-info card-outline mt-3">
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

@endsection