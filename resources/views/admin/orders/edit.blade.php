<!-- orders/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Edit Order</h1>

    <form action="{{ route('customers.orders.update', [$customer->id, $order->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="details">Details:</label>
            <input type="text" id="details" name="details" value="{{ $order->details }}" required>
        </div>
        <div>
            <label for="status">Status:</label>
            <input type="text" id="status" name="status" value="{{ $order->status }}" required>
        </div>
        <button type="submit">Update Order</button>
    </form>
@endsection
