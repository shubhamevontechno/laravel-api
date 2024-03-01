@extends('layouts.app')
@section('content')
<div class="container mt-5">

    <div class="row">
        <div class="card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Steps</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getDatas as $getData)
                            <tr>
                                <td>{{ $getData->name }}</td>
                                <td>{{ $getData->email }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection()
