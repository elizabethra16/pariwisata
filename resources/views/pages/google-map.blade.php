@extends('layouts.main')
@section('script')
<script>
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2tpcHBlcmhvYSIsImEiOiJjazE2MjNqMjkxMTljM2luejl0aGRyOTAxIn0.Wyvywisw6bsheh7wJZcq3Q';
        var map = new mapboxgl.Map({
          container: 'map',
          style: 'mapbox://styles/mapbox/streets-v11',
          center: [112.65476081002465, -7.908354831562468, ], //lng,lat 10.818746, 106.629179
          zoom: 7
        });
        var test ='<?php echo $dataArray;?>';  //ta nhận dữ liệu từ Controller
        var dataMap = JSON.parse(test); //chuyển đổi nó về dạng mà Mapbox yêu cầu
        // ta tạo dòng lặp để for ra các đối tượng
        dataMap.features.forEach(function(marker) {
            //tạo thẻ div có class là market, để hồi chỉnh css cho market
            var el = document.createElement('div');
            el.className = 'marker';
            //gắn marker đó tại vị trí tọa độ
            new mapboxgl.Marker(el)
                .setLngLat(marker.geometry.coordinates)
                .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
            .setHTML('<h3>' + marker.properties.title + '</h3><p>' + marker.properties.description + '</p>'+
            '<img src="/storage/'+marker.properties.image+'" alt="" width="100px">'))
                .addTo(map);
        });
    </script>
    <style>
        #map {
            width: 100%;
            height: 500px;
        }
        .marker {
            background-image: url('/storage/images/1.png');
            background-repeat:no-repeat;
            background-size:100%;
            width: 20px;
            height: 100px;
            cursor: pointer; 
        }
        
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2>SISTEM INFORMASI PARIWISATA</h2>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
           <form action="{{route('google.map.store')}}" method="post" id="boxmap" enctype="multipart/form-data">
           @csrf
                <div class="form-group">
                    <label for="title">Lokasi</label>
                    <input type="text" name="title" placeholder="Lokasi" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="title">Deskripsi</label>
                    <input type="text" name="description" placeholder="Deskripsi" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="lat">Latitude</label>
                    <input type="text" name="lat" placeholder="Latitude" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="lng">Longitude</label>
                    <input type="text" name="lng" placeholder="Longitude" class="form-control"/>
                </div>    
                 <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" placeholder="image" class="form-control"/>
                </div> 
                <div class="form-group">
                    <input type="submit" name="submit" value="Add Map" class="btn btn-success"/>
                </div>
            </form>     
        </div>
        <div class="col-md-8">
            <h2>Maps</h2>
            <div id="map"></div>       
        </div>
        
    </div>
</div>
@endsection