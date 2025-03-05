@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Trainers List</h1>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('formateur.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="month" class="form-label">Select Month</label>
                    <select name="month" id="month" class="form-select" onchange="this.form.submit()">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('month', 2) == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 1)) }} 2025
                            </option>
                        @endfor
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Total Hours</th>
                            <th>Total Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formateurs as $formateur)
                        <tr>
                            <td>{{ $formateur->name }}</td>
                            <td>{{ $formateur->subjects }}</td>
                            <td>{{ $formateur->salary->total_hours ?? 0 }} hours</td>
                            <td>{{ $formateur->salary->total_amount ?? 0 }} DH</td>
                            <td>
                                <a href="{{ route('formateur.details', ['formateur_id' => $formateur->id, 'month' => request('month', 2)]) }}" 
                                   class="btn btn-primary btn-sm">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 