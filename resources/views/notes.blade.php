@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col">
            @include('partials.header')

            @if (count($notes) == 0)
                <!-- no notes available -->
                <div class="row mt-5">
                    <div class="col text-center">
                        <p class="display-6 mb-5 text-secondary opacity-50">You have no notes available!</p>
                        <a href="{{ route('note.create') }}" class="btn btn-secondary btn-lg p-3 px-5">
                            <i class="fa-regular fa-pen-to-square me-3"></i>Create Your First Note
                        </a>
                    </div>
                </div>
            @else
                <!-- notes are available -->
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('note.create') }}" class="btn btn-secondary px-3">
                        <i class="fa-regular fa-pen-to-square me-2"></i>New Note
                    </a>
                </div>

                @foreach ($notes as $note)
                    <div class="row mb-2">
                        <div class="col">
                            <div class="card p-4">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="text-info">{{ $note['title'] }}</h4>
                                        <small class="text-secondary"><span class="opacity-75 me-2">Created at:</span><strong>{{ date('Y-m-d H:i:s', strtotime($note['created_at'])) }}</strong></small>
                                        @if ($note['created_at'] != $note['updated_at'])
                                            <small class="text-secondary ms-2"><span class="opacity-75 me-2">Updated at:</span><strong>{{ date('Y-m-d H:i:s', strtotime($note['updated_at'])) }}</strong></small>
                                        @endif
                                    </div>
                                    <div class="col text-end">
                                        <a href="{{ route('note.edit', ['id' => Crypt::encrypt($note['id'])]) }}" class="btn btn-outline-secondary btn-sm mx-1"><i class="fa-regular fa-pen-to-square"></i></a>
                                        <a href="{{ route('note.delete', ['id' => Crypt::encrypt($note['id'])]) }}" class="btn btn-outline-danger btn-sm mx-1"><i class="fa-regular fa-trash-can"></i></a>
                                    </div>
                                </div>
                                <hr>
                                <p class="text-secondary">{{ $note['content'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
