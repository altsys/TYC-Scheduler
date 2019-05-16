@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Events</div>

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
                                <th>Type</th>
                                <th>Priority</th>
                                <th>Frequency</th>
                            </tr>
                            <tr>
                                @foreach($events as $event):
                                    <td>{{$event->name}}</td>
                                    <td>{{$event->description}}</td>
                                    <td>{{$event->type}}</td>
                                    <td>{{$event->priority}}</td>
                                    <td>{{$event->frequency}}</td>
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