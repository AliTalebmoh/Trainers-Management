@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Session</h5>
                    <a href="{{ route('formateur.details', ['formateur_id' => $formateur->id, 'month' => $session->duration_month]) }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back to Details
                    </a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="alert alert-info">
                        <strong>Trainer:</strong> {{ $formateur->name }} | 
                        <strong>Month:</strong> {{ date('F', mktime(0, 0, 0, $session->duration_month, 1)) }} 2025
                    </div>

                    <form action="{{ route('session.update', ['session_id' => $session->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="date" class="form-label">Session Date</label>
                            <div class="input-group">
                                <input type="date" class="form-control" id="date" name="date" 
                                       value="{{ old('date', $session->date ? $session->date->format('Y-m-d') : '') }}" required>
                                <span class="input-group-text bg-light" id="day-of-week">
                                    {{ $session->date ? $session->date->format('l') : '' }}
                                </span>
                            </div>
                            <small class="text-muted">You can change the date to any day of the week as needed.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" class="form-control" id="start_time" name="start_time" 
                                       value="{{ old('start_time', $session->start_time ? $session->start_time->format('H:i') : '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" class="form-control" id="end_time" name="end_time" 
                                       value="{{ old('end_time', $session->end_time ? $session->end_time->format('H:i') : '') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="duration" class="form-label">Duration (hours)</label>
                                <input type="number" step="0.5" min="0" class="form-control" id="duration" name="duration" 
                                       value="{{ old('duration', $session->duration) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="price_per_hour" class="form-label">Price Per Hour (DH)</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="price_per_hour" name="price_per_hour" 
                                       value="{{ old('price_per_hour', $session->price_per_hour) }}" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Session
                            </button>
                            <a href="{{ route('formateur.details', ['formateur_id' => $formateur->id, 'month' => $session->duration_month]) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const durationInput = document.getElementById('duration');
        const dateInput = document.getElementById('date');
        const dayOfWeekDisplay = document.getElementById('day-of-week');

        function calculateDuration() {
            if (startTimeInput.value && endTimeInput.value) {
                const startParts = startTimeInput.value.split(':');
                const endParts = endTimeInput.value.split(':');
                
                const startDate = new Date();
                startDate.setHours(parseInt(startParts[0]), parseInt(startParts[1]), 0);
                
                const endDate = new Date();
                endDate.setHours(parseInt(endParts[0]), parseInt(endParts[1]), 0);
                
                if (endDate > startDate) {
                    const diff = (endDate - startDate) / 1000 / 60 / 60;
                    durationInput.value = diff.toFixed(1);
                }
            }
        }

        function updateDayOfWeek() {
            if (dateInput.value) {
                const date = new Date(dateInput.value);
                const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                const dayOfWeek = days[date.getDay()];
                dayOfWeekDisplay.innerHTML = dayOfWeek;
            }
        }

        startTimeInput.addEventListener('change', calculateDuration);
        endTimeInput.addEventListener('change', calculateDuration);
        dateInput.addEventListener('change', updateDayOfWeek);
        
        // Initialize day of week display
        updateDayOfWeek();
    });
</script>
@endsection
