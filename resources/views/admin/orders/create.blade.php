<!-- orders/create.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Create Order</h1>

    <form action="{{ route('customers.orders.store', $customer->id) }}" method="POST">
        @csrf
        <div>
            <label for="details">Details:</label>
            <input type="text" id="details" name="details" required>
        </div>
        <div>
            <label for="status">Status:</label>
            <input type="text" id="status" name="status" required>
        </div>
        <button type="submit">Create Order</button>
    </form>
@endsection
