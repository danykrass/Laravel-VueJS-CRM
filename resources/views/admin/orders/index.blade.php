<!-- orders/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Order List</h1>

    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Details</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->details }}</td>
                    <td>{{ $order->status }}</td>
                    <td>
                        <a href="{{ route('customers.orders.edit', [$order->customer->id, $order->id]) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
