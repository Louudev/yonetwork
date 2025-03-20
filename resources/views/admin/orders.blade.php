<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des commandes') }}
        </h2>
    </x-slot>
    <script src="https://cdn.tailwindcss.com"></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Liste des commandes</h1>
                        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
                            Retour au tableau de bord
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            <strong class="font-bold">Succès!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Filtres de recherche -->
                    <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
                        <form action="{{ route('admin.orders') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                    placeholder="Nom, email, téléphone..." 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                                <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Tous les statuts</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Terminée</option>
                                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Statut de paiement</label>
                                <select name="payment_status" id="payment_status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Tous</option>
                                    <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Non payé</option>
                                    <option value="partial" {{ request('payment_status') === 'partial' ? 'selected' : '' }}>Partiellement payé</option>
                                    <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Payé</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="teleconseiller" class="block text-sm font-medium text-gray-700 mb-1">Téléconseiller</label>
                                <select name="teleconseiller" id="teleconseiller" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Tous les téléconseillers</option>
                                    @foreach($teleconseillerUsers as $user)
                                        <option value="{{ $user->id }}" {{ request('teleconseiller') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
                                <select name="sort" id="sort" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="newest" {{ request('sort') === 'newest' || !request('sort') ? 'selected' : '' }}>Plus récentes</option>
                                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Plus anciennes</option>
                                    <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Prix (élevé → bas)</option>
                                    <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Prix (bas → élevé)</option>
                                </select>
                            </div>
                            
                            <div class="flex items-end space-x-2">
                                <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2.5 px-6 rounded-md shadow-sm flex items-center transition duration-150 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                    </svg>
                                    Valider
                                </button>
                                <a href="{{ route('admin.orders') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2.5 px-6 rounded-md shadow-sm flex items-center transition duration-150 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                    </svg>
                                    Réinitialiser
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white rounded-lg overflow-hidden">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 text-left">ID</th>
                                    <th class="py-3 px-4 text-left">Client</th>
                                    <th class="py-3 px-4 text-left">Téléconseiller</th>
                                    <th class="py-3 px-4 text-left">Date</th>
                                    <th class="py-3 px-4 text-right">Total</th>
                                    <th class="py-3 px-4 text-center">Statut</th>
                                    <th class="py-3 px-4 text-center">Paiement</th>
                                    <th class="py-3 px-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($orders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4">{{ $order->id }}</td>
                                        <td class="py-3 px-4">
                                            <div>{{ $order->nom }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->email }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->tel }}</div>
                                        </td>
                                        <td class="py-3 px-4">{{ $order->user->name ?? 'N/A' }}</td>
                                        <td class="py-3 px-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="py-3 px-4 text-right font-semibold">{{ $order->total_price }} MAD</td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="px-2 py-1 rounded text-xs font-semibold 
                                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                            ">
                                                {{ $order->status === 'pending' ? 'En attente' : '' }}
                                                {{ $order->status === 'completed' ? 'Terminée' : '' }}
                                                {{ $order->status === 'cancelled' ? 'Annulée' : '' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="px-2 py-1 rounded text-xs font-semibold 
                                                {{ $order->payment_status === 'unpaid' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $order->payment_status === 'partial' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                            ">
                                                {{ $order->payment_status === 'unpaid' ? 'Non payé' : '' }}
                                                {{ $order->payment_status === 'partial' ? 'Partiel' : '' }}
                                                {{ $order->payment_status === 'paid' ? 'Payé' : '' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-8 text-center text-gray-500">Aucune commande trouvée</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 