@extends('layouts.admin')

@section('links-content')
    <div class="col-sm-6">
        <div class="page-title">
            <h4>Dashboard</h4>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Whelson Ticketing</a></li>
                <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
            </ol>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="float-end d-none d-sm-block">
            <a href="{{ route('change-requests.create') }}" class="btn btn-success">Add Change Request</a>
        </div>
    </div>
@endsection

@section('content')
    <div>
        <div class="row g-3 mb-4">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card border-danger">
                    <a href="{{ url('/pending') }}">
                        <div class="card-body bg-danger bg-opacity-10">
                            <div class="d-flex justify-content-between align-items-center">
                                <div
                                    class="bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <i class="mdi-account-clock text-danger"></i>
                                </div>
                                <div class="text-end">
                                    <h3 class="text-dark fw-bold">{{ $unattendedCount }}</h3>
                                    <p class="text-muted">Pending Tickets</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card border-warning">
                    <a href="{{ url('acknowledged') }}">
                        <div class="card-body bg-warning bg-opacity-10">
                            <div class="d-flex justify-content-between align-items-center">
                                <div
                                    class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <i class="mdi-alarm-multiple text-warning"></i>
                                </div>
                                <div class="text-end">
                                    <h3 class="text-dark fw-bold">{{ $pendingCount }}</h3>
                                    <p class="text-muted">Acknowledged Tickets</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card border-success">
                    <a href="{{ url('resolved') }}">
                        <div class="card-body bg-success bg-opacity-10">
                            <div class="d-flex justify-content-between align-items-center">
                                <div
                                    class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <i class="mdi-alarm-off text-success"></i>
                                </div>
                                <div class="text-end">
                                    <h3 class="text-dark fw-bold">{{ $resolvedCount }}</h3>
                                    <p class="text-muted">Resolved Tickets</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card border-primary">
                    <a href="{{ url('escalated') }}">
                        <div class="card-body bg-primary bg-opacity-10">
                            <div class="d-flex justify-content-between align-items-center">
                                <div
                                    class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <i class="mdi-alarm-snooze text-primary"></i>
                                </div>
                                <div class="text-end">
                                    <h3 class="text-dark fw-bold">{{ $escalatedCount }}</h3>
                                    <p class="text-muted">Escalated Tickets</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div>
        <canvas style="max-width: 100%; max-height: 40vh" id="barChart"></canvas>
    </div>

    <div class="mt-5">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="header-title">Pending and Unattended Tickets Overview</h4>
                <div class="row align-items-center mb-3">

                    <div class="col-md-4">
                        <div class="d-flex justify-content-end">
                            <input class="form-control" wire:model.live="search" type="search" placeholder="Search"
                                   aria-label="Search">
                        </div>
                    </div>
                </div>

                <div class="table-responsive table-striped">
                    <table class="table mb-0">

                        <thead>
                        <tr>
                            <th>#Ref</th>
                            <th>Depot</th>
                            <th>Requested By</th>
                            <th>Subject</th>
                            <th>Acknowledged By</th>
                            <th>Status</th>
                            <th>Date Reported</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <th scope="row">{{ $ticket->reference_key }}</th>
                                <td>{{ $ticket->depot_name }}</td>
                                <td>{{ $ticket->name }}</td>
                                <td>{{ $ticket->subject }}</td>
                                <td>{{ $ticket->ack_by }}</td>
                                <td>{{ $ticket->status }}</td>
                                <td>{{ $ticket->created_at }}</td>
                                <td id="tooltip-container11">
                                    <button type="button" data-bs-toggle="modal"
                                            data-reference="{{ $ticket->reference_key }}"
                                            data-description="{{ $ticket->description }}"
                                            data-id="{{ $ticket->id }}"
                                            data-subject="{{ $ticket->subject }}" data-bs-target="#acknowledgeModal"
                                            class="me-3 text-warning btn btn-sm"
                                            data-bs-container="#tooltip-container11" data-bs-placement="top"
                                            title="Acknowledge">
                                        <i class="mdi mdi-eye font-size-18"></i>
                                    </button>
                                    <a href="{{ route('resolve',$ticket->id) }}" class="me-3 text-primary"
                                       data-bs-container="#tooltip-container11" data-bs-toggle="tooltip"
                                       data-bs-placement="top" title="Resolve">
                                        <i class="mdi mdi-pencil font-size-18"></i>
                                    </a>
                                    <button type="button" data-bs-toggle="modal"
                                            data-reference="{{ $ticket->reference_key }}"
                                            data-description="{{ $ticket->description }}"
                                            data-id="{{ $ticket->id }}"
                                            data-subject="{{ $ticket->subject }}" data-bs-target="#escalateModal"
                                            class="text-danger btn btn-sm" data-bs-container="#tooltip-container11"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Escalate">
                                        <i class="mdi mdi-trash-can font-size-18"></i>
                                    </button>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No records found
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                        @if ($tickets->hasPages())
                            <tfoot>
                            <tr>
                                <td colspan="8">
                                    <div class="p-3 d-flex justify-content-end">
                                        {{ $tickets->links() }}
                                    </div>
                                </td>
                            </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>

            </div>
        </div>
    </div>

    @include('partials.modals')
@endsection

@section('footer_scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('barChart');

        // Array of months from January to December
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // Example counts of resolved tickets for each month
        const resolvedTicketCounts = @json(array_values($resolvedCounts));

        // Example counts of escalated tickets for each month
        const escalatedTicketCounts = @json(array_values($escalatedCounts));

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Resolved Tickets',
                    data: resolvedTicketCounts,
                    backgroundColor: 'rgba(54,235,111,0.2)',
                    borderColor: 'rgb(54,235,63)',
                    borderWidth: 1
                }, {
                    label: 'Escalated Tickets',
                    data: escalatedTicketCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true, // Allows the chart to resize based on the container dimensions
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Adjust the step size of ticks as needed
                        }
                    }
                }
            }
        });
    </script>
@endsection
