@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion des Téléconseillers</h1>

    <div class="mb-4">
        <h2>Ajouter un Nouveau Téléconseiller</h2>
        <form action="{{ route('admin.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>

    <h2>Liste des Téléconseillers</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Date de création</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teleconseillers as $teleconseiller)
                <tr>
                    <td>{{ $teleconseiller->name }}</td>
                    <td>{{ $teleconseiller->email }}</td>
                    <td>{{ $teleconseiller->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($teleconseiller->status)
                            <span class="badge badge-success">Actif</span>
                        @else
                            <span class="badge badge-danger">Bloqué</span>
                        @endif
                    </td>
                    <td>
                        @if($teleconseiller->status)
                            <form action="{{ route('admin.block', $teleconseiller->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-warning">Bloquer</button>
                            </form>
                        @else
                            <form action="{{ route('admin.unblock', $teleconseiller->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Débloquer</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.destroy', $teleconseiller->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection