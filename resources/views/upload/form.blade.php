@extends('layouts.app')
@section('content')
<form action="{{ route('upload.process') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="csv_file">
    <button type="submit">Upload</button>
</form>
@endsection()
