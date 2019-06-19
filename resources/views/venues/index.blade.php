@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Venues</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Location</th>
                                <th>Capacity</th>
                                <th>Status</th>
                            </tr>
                            <tr>
                                @foreach($venues as $venue):
                                    <td>{{$venue->name}}</td>
                                    <td>{{$venue->description}}</td>
                                    <td>{{$venue->location}}</td>
                                    <td>{{$venue->capacity}}</td>
                                    <td>{{$venue->status}}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection