<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historique des commandes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Mes commandes</h1>
                        <a href="{{ route('surveillance.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
                            Retour au tableau de bord
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            <strong class="font-bold">Succès!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white rounded-lg overflow-hidden">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 text-left">ID</th>
                                    <th class="py-3 px-4 text-left">Date</th>
                                    <th class="py-3 px-4 text-left">Client</th>
                                    <th class="py-3 px-4 text-right">Total</th>
                                    <th class="py-3 px-4 text-center">Statut</th>
                                    <th class="py-3 px-4 text-center">Détails</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($orders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4">{{ $order->id }}</td>
                                        <td class="py-3 px-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="py-3 px-4">{{ $order->nom }}</td>
                                        <td class="py-3 px-4 text-right">{{ $order->total_price }} MAD</td>
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
                                            <a href="{{ route('surveillance.orders.show', $order->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-gray-500">Aucune commande trouvée</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>

                    <!-- Messages d'erreur -->
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4">
                            <strong class="font-bold">Erreur!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Bouton temporaire pour diagnostic (à enlever après débogage) -->
                    <div class="fixed bottom-4 right-4 z-40">
                        <button 
                            id="debugBtn" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-lg"
                            onclick="debugOrderStructure()"
                        >
                            Diagnostiquer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fonction de diagnostic temporaire
        function debugOrderStructure() {
            // Récupérer la première commande pour analyse
            fetch('/api/debug/order-structure', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                console.log('===== DIAGNOSTIC DES COMMANDES =====');
                console.log('Structure de la commande:', data);
                alert('Diagnostic terminé. Consultez la console pour les détails.');
            })
            .catch(error => {
                console.error('Erreur de diagnostic:', error);
                alert('Erreur lors du diagnostic: ' + error.message);
            });
        }
    </script>
</x-app-layout> 