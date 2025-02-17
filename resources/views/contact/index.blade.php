@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Contact List</h2>

    <a href="{{ route('contacts.create') }}" class="btn btn-primary mb-3">Add Contact</a>

    <form action="{{ route('contacts.importXML') }}" method="POST" enctype="multipart/form-data" class="mb-3">
        @csrf
        <input type="file" name="xml_file" required>
        <button type="submit" class="btn btn-info">Import XML</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
        @foreach($contacts as $contact)
        <tr>
            <td>{{ $contact->id }}</td>
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->phone }}</td>
            <td>
                <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
