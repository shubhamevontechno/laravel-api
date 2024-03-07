@extends('layouts.app')
@section('content')
<form action="" method="post">
    @csrf
    <table>
        <thead>
            <tr>
                <th>index</th>
                <th>First Name</th>
                <th>Member ID</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($csvData as $index=>$row)
            <tr>
                <td>{{$index}}</td>
                <td>{{ $row[0] }}</td>
                <td>{{ $row[1] }}</td>
                <td>{{ $row[2] }}</td>
                <td>{{ $row[3] }}</td>
                <td>
                <form method="POST" action="{{ route('csv-upload.destroy', $index) }}">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-default btn-sm">Delete</button>
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <button type="submit">Confirm and Save</button>
</form>
@endsection()
