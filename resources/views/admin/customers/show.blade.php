<!-- customers/show.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Customer Details</h1>

    <h2>{{ $customer->name }}</h2>
    <p>Email: {{ $customer->email }}</p>
    <p>Contact Information: {{ $customer->contact_information }}</p>

    <h2>Order History</h2>
    <table>
        <thead>
            <tr>
                <th>Details</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->details }}</td>
                    <td>{{ $order->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
