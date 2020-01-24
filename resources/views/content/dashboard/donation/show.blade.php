@extends('layouts.dashboard', [
    'wsecond_title' => 'Donation - Detail',
    'menu' => 'donation',
    'sub_menu' => null,
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Donation',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => route('dashboard.donation.index'),
                'text' => 'Donation',
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
        <h1 class="card-title">Detail <u>{{ $donation->panti->panti_name }}</u> Donation</h1>
        <div class="card-tools btn-group">
            <a href="{{ route('dashboard.donation.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
            <a href="{{ route('dashboard.donation.edit', $donation->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped" id="donation_table">
            <tr>
                <th>Panti</th>
                <td><a href="{{ $donation->panti->panti_slug }}">{{ $donation->panti->panti_name }}</a></td>
            </tr>
            <tr>
                <th>Title</th>
                <td>{{ $donation->donation_title ?? '-' }}</td>
            </tr>
            <tr>
                <th>Amount Needed</th>
                <td>{{ $donation->donation_needed }}</td>
            </tr>
            <tr>
                <th>Start</th>
                <td>{{ date('F d, Y', strtotime($donation->donation_start)) }}</td>
            </tr>
            <tr>
                <th>End</th>
                <td>{{ $donation->donation_hasdeadline ? date('F d, Y', strtotime($donation->donation_end)) : 'No Deadline' }}</td>
            </tr>
            <tr>
                <th colspan="2" class="text-center">Description</th>
            </tr>
            <tr>
                <td colspan="2">{!! $donation->donation_description !!}</td>
            </tr>
        </table>
    </div>
</div>
@endsection