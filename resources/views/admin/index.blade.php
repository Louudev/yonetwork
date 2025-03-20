<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Téléconseillers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Formulaire d'ajout -->
            <div class="mb-8 p-6 bg-white shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Ajouter un téléconseiller</h3>
                <form method="POST" action="{{ route('admin.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="name" value="Nom"/>
                            <x-text-input id="name" name="name" class="block w-full mt-1" required/>
                        </div>
                        <div>
                            <x-input-label for="email" value="Email"/>
                            <x-text-input id="email" type="email" name="email" class="block w-full mt-1" required/>
                        </div>
                        <div>
                            <x-input-label for="password" value="Mot de passe"/>
                            <x-text-input id="password" type="password" name="password" class="block w-full mt-1" required/>
                        </div>
                    </div>
                    <x-primary-button class="mt-4">Ajouter</x-primary-button>
                </form>
            </div>

            <!-- Liste des téléconseillers -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($teleconseillers->isEmpty())
                        <p class="text-gray-500">Aucun téléconseiller trouvé.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($teleconseillers as $teleconseiller)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $teleconseiller->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $teleconseiller->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $teleconseiller->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $teleconseiller->status ? 'Actif' : 'Bloqué' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
    @if($teleconseiller->status)
        <form method="POST" action="{{ route('admin.block', $teleconseiller->id) }}" class="inline">
            @csrf
            <x-danger-button>Bloquer</x-danger-button>
        </form>
    @else
        <form method="POST" action="{{ route('admin.unblock', $teleconseiller->id) }}" class="inline">
            @csrf
            <x-primary-button>Débloquer</x-primary-button>
        </form>
    @endif
</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>