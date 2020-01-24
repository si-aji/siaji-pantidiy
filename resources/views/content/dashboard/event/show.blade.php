@extends('layouts.dashboard', [
    'wsecond_title' => 'Event - Detail',
    'menu' => 'event',
    'sub_menu' => null,
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Event',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => route('dashboard.donation.index'),
                'text' => 'Event',
                'active' => true
            ], [
                'url' => '#',
                'text' => 'Detail',
                'active' => true
            ]
        ]
    ]
])

@section('content')
<div class="card">
    <div class="card-header card-primary card-outline">
        <h1 class="card-title">Detail <u>{{ $event->event_title }}</u> Event</h1>
        <div class="card-tools btn-group">
            <a href="{{ route('dashboard.event.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
            <a href="{{ route('dashboard.event.edit', $event->event_slug) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped" id="donation_table">
            <tr>
                <th>Title</th>
                <td>{{ $event->event_title ?? '-' }}</td>
            </tr>
            <tr>
                <th>Thumbnail</th>
                <td>
                    @if(!empty($event->event_thumbnail))
                    <div class="sa-preview mb-2">
                        <img class="img-responsive img-preview" src="{{ asset('img/event'.'/'.$event->event_thumbnail) }}">
                    </div>
                    @else
                    -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Start</th>
                <td>{{ date('F d, Y / H:i', strtotime($event->event_start)) }}</td>
            </tr>
            <tr>
                <th>End</th>
                <td>{{ date('F d, Y / H:i', strtotime($event->event_end)) }}</td>
            </tr>
            <tr>
                <th>Place</th>
                <td>{{ $event->event_place ?? '-' }}</td>
            </tr>
            <tr>
                <th colspan="2" class="text-center">Description</th>
            </tr>
            <tr>
                <td colspan="2">{!! $event->event_description !!}</td>
            </tr>
        </table>
    </div>
</div>
@endsection