@extends('layouts.public')

@section('content')
    @include('content.public.index.partials.header')
    @include('content.public.index.partials.activity')
    @include('content.public.index.partials.article')
    @include('content.public.index.partials.footer')
@endsection