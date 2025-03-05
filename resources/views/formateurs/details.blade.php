@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Formateur Details</h1>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-2">
                    <strong>Name</strong>
                </div>
                <div class="col-md-10">
                    {{ $formateur->name }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-2">
                    <strong>Subject</strong>
                </div>
                <div class="col-md-10">
                    {{ $formateur->subjects }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-2">
                    <strong>Bank Account</strong>
                </div>
                <div class="col-md-10">
                    {{ $formateur->bank_account }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-2">
                    <strong>Month</strong>
                </div>
                <div class="col-md-10">
                    {{ date('F', mktime(0, 0, 0, request('month'), 1)) }} 2025
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h2 class="card-title mb-4">Sessions</h2>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Duration</th>
                            <th>Price per Hour</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seances as $seance)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($seance->date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($seance->start_time)->format('H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($seance->end_time)->format('H:i') }}</td>
                            <td>{{ $seance->duration }} hours</td>
                            <td>{{ $seance->price_per_hour }} DH</td>
                            <td>{{ $seance->duration * $seance->price_per_hour }} DH</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Total</strong></td>
                            <td><strong>{{ $seances->sum('duration') }} hours</strong></td>
                            <td></td>
                            <td><strong>{{ $seances->sum(function($s) { return $s->duration * $s->price_per_hour; }) }} DH</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-4">
                <form action="{{ route('formateur.download') }}" method="GET" class="d-inline">
                    <input type="hidden" name="formateur_id" value="{{ $formateur->id }}">
                    <input type="hidden" name="month" value="{{ request('month') }}">
                    <button type="submit" class="btn btn-success">Download Formular</button>
                </form>
                <a href="{{ route('formateur.index', ['month' => request('month')]) }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection 