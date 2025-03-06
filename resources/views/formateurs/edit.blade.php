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
                           id="bank_account" name="bank_account" value="{{ old('bank_account', $formateur->bank_account) }}" required>
                    @error('bank_account')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="bank_name" class="form-label">Bank Name</label>
                    <select class="form-select @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" required>
                        <option value="">Select Bank</option>
                        <option value="CIH Bank" {{ old('bank_name', $formateur->bank_name) == 'CIH Bank' ? 'selected' : '' }}>CIH Bank</option>
                        <option value="Banque Populaire" {{ old('bank_name', $formateur->bank_name) == 'Banque Populaire' ? 'selected' : '' }}>Banque Populaire</option>
                        <option value="Attijariwafa Bank" {{ old('bank_name', $formateur->bank_name) == 'Attijariwafa Bank' ? 'selected' : '' }}>Attijariwafa Bank</option>
                        <option value="BMCE Bank" {{ old('bank_name', $formateur->bank_name) == 'BMCE Bank' ? 'selected' : '' }}>BMCE Bank</option>
                        <option value="Bank Al-Maghrib" {{ old('bank_name', $formateur->bank_name) == 'Bank Al-Maghrib' ? 'selected' : '' }}>Bank Al-Maghrib</option>
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
@endsection 