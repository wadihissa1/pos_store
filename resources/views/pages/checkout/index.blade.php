@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container">
        <h1 class="title">Checkout</h1>
        <p class="subtitle is-6">UI only. No payment or stock logic.</p>

        <div class="box" style="max-width: 32rem;">
            <form action="#" method="post" novalidate>
                @csrf
                <div class="field">
                    <label class="label" for="email">Email</label>
                    <div class="control">
                        <input class="input" type="email" id="email" name="email" required>
                    </div>
                </div>

                <hr>

                <div class="field">
                    <label class="label" for="name">Full name</label>
                    <div class="control">
                        <input class="input" type="text" id="name" name="name" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="address">Address</label>
                    <div class="control">
                        <textarea class="textarea" id="address" name="address" rows="3" required></textarea>
                    </div>
                </div>

                <div class="field mt-5">
                    <div class="control">
                        <button type="submit" class="button is-primary">Place order (UI only)</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
