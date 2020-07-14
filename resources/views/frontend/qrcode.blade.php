@extends('frontend.layouts.app')

@section('title', $customer['name'] )

@section('content')
    <div class="row">
        <div class="col">
                <img src="{{ asset('storage/'.$customer['avatar']) }}" alt="" srcset="" style="width:100%;margin-top:10px">
                {{--  <img src="http://3.3china.org/uploads/picture/2020-06-29/5ef9a1df79c74.jpg" alt="" srcset="" >  --}}
        </div>
    </div>
@endsection
