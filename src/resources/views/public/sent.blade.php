@extends('pages::public.master')

@section('bodyClass', 'body-contacts body-contact-sent body-page body-page-'.$page->id)

@section('main')

<div class="container">
    {!! $page->body !!}

    <div class="jubotron alert alert-success text-center">
        <h1>@lang('db.message when contact form is sent')</h1>
    </div>
</div>

@endsection
