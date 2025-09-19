@extends('layouts.admin')

@section('content')
<h1>Editar Evento</h1>

<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Editar Evento</h3>
        </div>

        <form action="{{ route('admin.eventos.update', $evento->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Título <b>*</b></label>
                            <select class="form-control @error('title') is-invalid @enderror" id="title" name="title" required>
                                @php
                                    $titulos = ['- Horario disponible', '- Reservado', '- En Espera', '- Atendido', '- Suspendido'];
                                    $selected = old('title', $evento->title);
                                @endphp
                                @foreach($titulos as $titulo)
                                    <option value="{{ $titulo }}" {{ $selected == $titulo ? 'selected' : '' }}>{{ $titulo }}</option>
                                @endforeach
                            </select>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start">Fecha y Hora de Inicio <b>*</b></label>
                            <input type="datetime-local" class="form-control @error('start') is-invalid @enderror" 
                                   id="start" name="start" 
                                   value="{{ old('start', \Carbon\Carbon::parse($evento->start)->format('Y-m-d\TH:i')) }}" required>
                            @error('start')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end">Fecha y Hora de Fin</label>
                            <input type="datetime-local" class="form-control @error('end') is-invalid @enderror" 
                                   id="end" name="end" 
                                   value="{{ old('end', $evento->end ? \Carbon\Carbon::parse($evento->end)->format('Y-m-d\TH:i') : '') }}">
                            @error('end')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="color">Color</label>
                            <input type="color" class="form-control @error('color') is-invalid @enderror" 
                                   id="color" name="color" value="{{ old('color', $evento->color ?? '#3788d8') }}">
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $evento->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <div class="card-footer">
                <a href="{{ url('admin/eventos') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
