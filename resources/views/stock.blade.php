@extends('masterpage')
@section('title', 'Stock Page')

@section('content')
<div class="container">
    <h3 class="mt-5 mb-5">Stock Barang</h3>
    
    <div class="mb-3">
      <h5>FILTER</h5>
      <form action="{{url('/stock/filter')}}" method="POST">
        @csrf
        <p>LOKASI</p>
        <select name="location" id="location">
          @foreach ($loc as $location)
              <option value="{{$location->id}}">{{$location->location}}</option>
          @endforeach
        </select>

        <p>KODE BARANG</p>
        <select name="part" id="part">
          @foreach ($item as $item)
              <option value="{{$item->id}}">{{$item->part}}</option>
          @endforeach
        </select>
        <br>
        <input type="submit" class="btn btn-primary mt-3 mb-3" value="Filter">
      </form>

      <h5>Order By</h5>
      <h6>*note: menghilangkan filter</h6>
      <a href="{{url('/stock')}}" class="btn btn-primary">Default</a>
      <a href="{{url('/stock/location')}}" class="btn btn-primary">Lokasi</a>
      <a href="{{url('/stock/code')}}" class="btn btn-primary">Kode Barang</a>
    </div>

    <table class="table mt-2s">
        <thead class="table-dark">
          <tr>
            <th scope="col">LOKASI</th>
            <th scope="col">KODE BARANG</th>
            <th scope="col">NAMA BARANG</th>
            <th scope="col">SALDO</th>
            <th scope="col">UM</th>
            <th scope="col">TGL MASUK</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $stock)
          <tr>
            <td>{{$stock->location->location}}</td>
            <td>{{$stock->item->part}}</td>
            <td>{{$stock->item->desc}}</td>
            <td>{{$stock->stored}}</td>
            <td>{{$stock->item->um->name}}</td>
            <td>{{\Carbon\Carbon::parse($stock->transaction_date)->format('d/m/y')}}</td>
            
          </tr>
          @endforeach
        </tbody>
      </table>

      <div style="text-align: center">
        <form action="{{url('/stock/export/pdf')}}" method="GET">
          @csrf
          <input type="text" hidden name="partsearch" id="partsearch" value="{{isset($oldpart)?$oldpart:''}}">
          <input type="text" hidden name="locationsearch" id="locationsearch" value="{{isset($oldlocation)?$oldlocation:''}}">
          <input type="submit" class="btn btn-danger" value="EXPORT PDF">
        </form>
    
        <form action="{{url('/stock/export/excel')}}" method="GET">
          @csrf
          <input type="text" hidden name="partsearch" id="partsearch" value="{{isset($oldpart)?$oldpart:''}}">
          <input type="text" hidden name="locationsearch" id="locationsearch" value="{{isset($oldlocation)?$oldlocation:''}}">
          <input type="submit" class="btn btn-success mt-2" value="EXPORT EXCEL">
        </form>
      </div>
</div>
    
@endsection