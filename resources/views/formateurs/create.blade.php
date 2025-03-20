@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add New Trainer</h5>
                    <a href="{{ route('formateur.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back to List
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

                    <form action="{{ route('formateur.store') }}" method="POST">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5>Personal Information</h5>
                                <hr>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Trainer Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subjects" class="form-label">Subjects Taught</label>
                                <input type="text" class="form-control" id="subjects" name="subjects" value="{{ old('subjects') }}" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5>Banking Information</h5>
                                <hr>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="bank_name" class="form-label">Bank Name</label>
                                <select class="form-select" id="bank_name" name="bank_name" required>
                                    <option value="">Select a bank</option>
                                    <option value="Banque Populaire" {{ old('bank_name') == 'Banque Populaire' ? 'selected' : '' }}>Banque Populaire</option>
                                    <option value="CIH Banque" {{ old('bank_name') == 'CIH Banque' ? 'selected' : '' }}>CIH Banque</option>
                                    <option value="Al Baride Bank" {{ old('bank_name') == 'Al Baride Bank' ? 'selected' : '' }}>Al Baride Bank</option>
                                    <option value="Bank of Africa" {{ old('bank_name') == 'Bank of Africa' ? 'selected' : '' }}>Bank of Africa</option>
                                    <option value="Banque Marocaine Du Commerce Extérieur" {{ old('bank_name') == 'Banque Marocaine Du Commerce Extérieur' ? 'selected' : '' }}>Banque Marocaine Du Commerce Extérieur</option>
                                    <option value="Attijariwafabank" {{ old('bank_name') == 'Attijariwafabank' ? 'selected' : '' }}>Attijariwafabank</option>
                                    <option value="Crédit Agricole" {{ old('bank_name') == 'Crédit Agricole' ? 'selected' : '' }}>Crédit Agricole</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="bank_account" class="form-label">Bank Account Number</label>
                                <input type="text" class="form-control" id="bank_account" name="bank_account" value="{{ old('bank_account') }}" required maxlength="24">
                                <small id="bank_account_help" class="form-text text-muted">Enter exactly 24 digits</small>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5>Session Information</h5>
                                <hr>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="month" class="form-label">Month</label>
                                <select name="month" id="month" class="form-select" required>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ old('month', date('n')) == $i ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }} 2025
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="price_per_hour" class="form-label">Price Per Hour (DH)</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="price_per_hour" name="price_per_hour" value="{{ old('price_per_hour', 0) }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="session_days" class="form-label">Training Days</label>
                                <div class="d-flex flex-wrap">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="checkbox" name="session_days[]" value="monday" id="monday" 
                                            {{ in_array('monday', old('session_days', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="monday">Monday</label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="checkbox" name="session_days[]" value="tuesday" id="tuesday"
                                            {{ in_array('tuesday', old('session_days', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tuesday">Tuesday</label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="checkbox" name="session_days[]" value="wednesday" id="wednesday"
                                            {{ in_array('wednesday', old('session_days', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="wednesday">Wednesday</label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="checkbox" name="session_days[]" value="thursday" id="thursday"
                                            {{ in_array('thursday', old('session_days', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="thursday">Thursday</label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="checkbox" name="session_days[]" value="friday" id="friday"
                                            {{ in_array('friday', old('session_days', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="friday">Friday</label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="checkbox" name="session_days[]" value="saturday" id="saturday"
                                            {{ in_array('saturday', old('session_days', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="saturday">Saturday</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="session_days[]" value="sunday" id="sunday"
                                            {{ in_array('sunday', old('session_days', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sunday">Sunday</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', '09:00') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', '12:00') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="duration" class="form-label">Duration (hours)</label>
                                <input type="number" step="0.5" min="0" class="form-control" id="duration" name="duration" value="{{ old('duration', 3) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Save Trainer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-calculate duration when start/end times change
    document.addEventListener('DOMContentLoaded', function() {
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const durationInput = document.getElementById('duration');
        const bankAccountInput = document.getElementById('bank_account');
        const bankAccountHelp = document.getElementById('bank_account_help');

        // Bank account validation
        bankAccountInput.addEventListener('input', function() {
            // Allow only numbers
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Check length
            const length = this.value.length;
            
            if (length < 24) {
                this.style.borderColor = 'red';
                bankAccountHelp.className = 'form-text text-danger';
                bankAccountHelp.textContent = `Enter exactly 24 digits (${length}/24)`;
            } else {
                this.style.borderColor = 'green';
                bankAccountHelp.className = 'form-text text-success';
                bankAccountHelp.textContent = 'Valid account number format';
            }
            
            // Prevent typing more than 24 characters
            if (length > 24) {
                this.value = this.value.slice(0, 24);
            }
        });

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

        startTimeInput.addEventListener('change', calculateDuration);
        endTimeInput.addEventListener('change', calculateDuration);
    });
</script>
@endsection
