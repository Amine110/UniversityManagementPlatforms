@extends('layouts.Menu')

@section('content')
    <div class="container">
        <h1>Create Classe</h1>
        <hr>
        <form action="{{ route('classes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Classe Name</label>
                <input type="text" class="form-control" @error('classe_name') is-invalide @enderror name="classe_name" id="classe_name">
                @error('classe_name')
                    <div class="invalide-feedback">{{ $errors->first('classe_name') }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="title">Department Name</label>
                <br>
                <select class="form-control" name="department_id" id="department_id">
                    <option value="">Select Department</option>
                    @foreach ($departements as $details)
                    <option value="{{$details->id}}">{{$details->department_name}}</option>   
                    @endforeach
                </select> 
            </div>
            <div class="form-group">
                <label for="title">Specialite</label>
                <input type="text" class="form-control" @error('specialite') is-invalide @enderror name="specialite" id="specialite">
                @error('specialite')
                    <div class="invalide-feedback">{{ $errors->first('specialite') }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Create </button>
        </form>
    </div>
    
@endsection