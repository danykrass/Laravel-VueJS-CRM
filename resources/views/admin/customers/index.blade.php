<!-- customers/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Customer List</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Information</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->contact_information }}</td>
                    <td>
                        <a href="{{ route('customers.show', $customer->id) }}">View Details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
