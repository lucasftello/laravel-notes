@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col">
            @include('partials.header')

            <!-- confirm delete -->
            <div class="col card p-5 text-center">
                <span class="display-3 mb-5"><i class="fa-solid fa-triangle-exclamation text-warning opacity-50"></i></span>
                <h4 class="text-info mb-3">{{ $note['title'] }}</h4>
                <p class="text-secondary">Are you sure you want to delete this note?</p>
                <form action={{ route('note.delete.submit', ['id' => Crypt::encrypt($note['id'])]) }} method="post" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <a href="{{ route('notes') }}" class="btn btn-primary px-5 m-2"><i class="fa-solid fa-xmark me-2"></i>No</a>
                    <button type="submit" class="btn btn-danger px-5 m-2"><i class="fa-solid fa-trash me-2"></i>Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
