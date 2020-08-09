@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
        <h3>
            {{ $post->title }}
        </h3>
        <small class="text-muted">
            Author: {{ $post->author->name }} -
            {{ \Carbon\Carbon::parse($post->created_at)->format('F jS Y') }}
            <i class="far fa-clock"></i>
            {{ \Carbon\Carbon::parse($post->created_at)->format('H:i') }}
        </small>
        <hr />
        <p class="pre-formatted">{{ $post->post }}</p>
    </div>
</div>
@endsection