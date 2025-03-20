@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Trainers List</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <form action="{{ route('formateur.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-6">
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
                <div class="col-md-4 text-end d-flex align-items-end">
                    <a href="{{ route('formateur.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Add New Trainer
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 20%">Name</th>
                            <th style="width: 30%">Subject</th>
                            <th style="width: 15%" class="text-center">Total Hours</th>
                            <th style="width: 15%" class="text-center">Total Amount</th>
                            <th style="width: 20%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formateurs as $formateur)
                        <tr>
                            <td>{{ $formateur->name }}</td>
                            <td>
                                <div style="max-width: 100%; overflow: hidden; text-overflow: ellipsis;" 
                                     title="{{ $formateur->subjects }}">
                                    {{ $formateur->subjects }}
                                </div>
                            </td>
                            <td class="text-center">{{ $formateur->salary->total_hours ?? 0 }} hours</td>
                            <td class="text-center">{{ $formateur->salary->total_amount ?? 0 }} DH</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('formateur.details', ['formateur_id' => $formateur->id, 'month' => request('month', 2)]) }}" 
                                       class="btn btn-primary btn-sm">
                                       <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ route('formateur.edit', ['formateur_id' => $formateur->id]) }}"
                                       class="btn btn-warning btn-sm">
                                       <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </div>
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