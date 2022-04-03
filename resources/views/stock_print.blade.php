@extends('layouts.pagemaster')
@section('title', 'Stock Page')

@section('content')
<div class="card card-info card-outline mt-3">
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

@endsection