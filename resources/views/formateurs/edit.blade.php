@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Trainer</h1>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('formateur.update', ['formateur_id' => $formateur->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <h4 class="mb-3">Basic Information</h4>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $formateur->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="subjects" class="form-label">Subjects</label>
                    <input type="text" class="form-control @error('subjects') is-invalid @enderror" 
                           id="subjects" name="subjects" value="{{ old('subjects', $formateur->subjects) }}" required>
                    @error('subjects')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <h4 class="mb-3 mt-4">Bank Information</h4>
                <div class="mb-3">
                    <label for="bank_account" class="form-label">Bank Account Number</label>
                    <input type="text" class="form-control @error('bank_account') is-invalid @enderror" 
                           id="bank_account" name="bank_account" value="{{ old('bank_account', $formateur->bank_account) }}" required maxlength="24">
                    <small id="bank_account_help" class="form-text text-muted">Enter exactly 24 digits</small>
                    @error('bank_account')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="bank_name" class="form-label">Bank Name</label>
                    <select class="form-select @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" required>
                        <option value="">Select a bank</option>
                        <option value="Banque Populaire" {{ old('bank_name', $formateur->bank_name) == 'Banque Populaire' ? 'selected' : '' }}>Banque Populaire</option>
                        <option value="CIH Banque" {{ old('bank_name', $formateur->bank_name) == 'CIH Banque' ? 'selected' : '' }}>CIH Banque</option>
                        <option value="Al Baride Bank" {{ old('bank_name', $formateur->bank_name) == 'Al Baride Bank' ? 'selected' : '' }}>Al Baride Bank</option>
                        <option value="Bank of Africa" {{ old('bank_name', $formateur->bank_name) == 'Bank of Africa' ? 'selected' : '' }}>Bank of Africa</option>
                        <option value="Banque Marocaine Du Commerce Extérieur" {{ old('bank_name', $formateur->bank_name) == 'Banque Marocaine Du Commerce Extérieur' ? 'selected' : '' }}>Banque Marocaine Du Commerce Extérieur</option>
                        <option value="Attijariwafabank" {{ old('bank_name', $formateur->bank_name) == 'Attijariwafabank' ? 'selected' : '' }}>Attijariwafabank</option>
                        <option value="Crédit Agricole" {{ old('bank_name', $formateur->bank_name) == 'Crédit Agricole' ? 'selected' : '' }}>Crédit Agricole</option>
                    </select>
                    @error('bank_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <h4 class="mb-3 mt-4">Payment Information</h4>
                <div class="mb-3">
                    <label for="price_per_hour" class="form-label">Price per Hour (DH)</label>
                    <input type="number" step="0.01" class="form-control @error('price_per_hour') is-invalid @enderror" 
                           id="price_per_hour" name="price_per_hour" value="{{ old('price_per_hour', $formateur->salary->price_per_hour) }}" required>
                    @error('price_per_hour')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <h4 class="mb-3 mt-4">Session Schedule (Applies to All Months)</h4>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Changes made here will be applied to all months.
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="total_hours" class="form-label">Total Hours per Month</label>
                            <input type="number" step="0.5" class="form-control @error('total_hours') is-invalid @enderror"
                                   id="total_hours" name="total_hours" 
                                   value="{{ old('total_hours', $monthlyData['total_hours']) }}" required>
                            @error('total_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="session_days" class="form-label">Training Days</label>
                            <div class="d-flex flex-wrap">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" name="session_days[]" value="monday" id="monday" 
                                        {{ in_array('monday', old('session_days', $monthlyData['session_days'] ?? [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="monday">Monday</label>
                                </div>
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" name="session_days[]" value="tuesday" id="tuesday"
                                        {{ in_array('tuesday', old('session_days', $monthlyData['session_days'] ?? [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tuesday">Tuesday</label>
                                </div>
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" name="session_days[]" value="wednesday" id="wednesday"
                                        {{ in_array('wednesday', old('session_days', $monthlyData['session_days'] ?? [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="wednesday">Wednesday</label>
                                </div>
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" name="session_days[]" value="thursday" id="thursday"
                                        {{ in_array('thursday', old('session_days', $monthlyData['session_days'] ?? [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="thursday">Thursday</label>
                                </div>
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" name="session_days[]" value="friday" id="friday"
                                        {{ in_array('friday', old('session_days', $monthlyData['session_days'] ?? [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="friday">Friday</label>
                                </div>
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" name="session_days[]" value="saturday" id="saturday"
                                        {{ in_array('saturday', old('session_days', $monthlyData['session_days'] ?? [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="saturday">Saturday</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="session_days[]" value="sunday" id="sunday"
                                        {{ in_array('sunday', old('session_days', $monthlyData['session_days'] ?? [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sunday">Sunday</label>
                                </div>
                            </div>
                            @error('session_days')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Typical Start Time</label>
                            <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                                   id="start_time" name="start_time" 
                                   value="{{ old('start_time', $monthlyData['typical_start_time']) }}" required>
                            @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="end_time" class="form-label">Typical End Time</label>
                            <input type="time" class="form-control @error('end_time') is-invalid @enderror"
                                   id="end_time" name="end_time" 
                                   value="{{ old('end_time', $monthlyData['typical_end_time']) }}" required>
                            @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="duration" class="form-label">Hours per Session</label>
                            <input type="number" step="0.5" class="form-control @error('duration') is-invalid @enderror"
                                   id="duration" name="duration" 
                                   value="{{ old('duration', $monthlyData['typical_duration']) }}" required>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">Update Trainer</button>
                    <a href="{{ route('formateur.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bankAccountInput = document.getElementById('bank_account');
        const bankAccountHelp = document.getElementById('bank_account_help');
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const durationInput = document.getElementById('duration');

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

        // Trigger validation on page load to set initial colors
        if (bankAccountInput) {
            const event = new Event('input', { bubbles: true });
            bankAccountInput.dispatchEvent(event);
        }

        // Auto-calculate duration when start/end times change
        if (startTimeInput && endTimeInput && durationInput) {
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
        }
    });
</script>
@endsection