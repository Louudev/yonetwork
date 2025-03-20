<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails de la commande') }}
        </h2>
    </x-slot>
    <script src="https://cdn.tailwindcss.com"></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Commande #{{ $order->id }}</h1>
                        <div>
                            <a href="{{ route('teleconseiller.orders') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
                                Retour à la liste
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            <strong class="font-bold">Succès!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <strong class="font-bold">Erreur!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h2 class="text-lg font-semibold mb-3">Informations client</h2>
                            <div class="space-y-2">
                                <p><span class="font-medium">Nom:</span> {{ $order->nom }}</p>
                                <p><span class="font-medium">Email:</span> {{ $order->email }}</p>
                                <p><span class="font-medium">Téléphone:</span> {{ $order->tel }}</p>
                                <p><span class="font-medium">Ville:</span> {{ $order->ville }}</p>
                                <p><span class="font-medium">Entreprise:</span> {{ $order->entreprise ?: 'Non spécifié' }}</p>
                                <p><span class="font-medium">Date de commande:</span> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h2 class="text-lg font-semibold mb-3">État de la commande</h2>
                            <div class="mb-4">
                                <p><span class="font-medium">Statut actuel:</span> 
                                    <span class="px-2 py-1 rounded text-xs font-semibold 
                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                    ">
                                        {{ $order->status === 'pending' ? 'En attente' : '' }}
                                        {{ $order->status === 'completed' ? 'Terminée' : '' }}
                                        {{ $order->status === 'cancelled' ? 'Annulée' : '' }}
                                    </span>
                                </p>
                                <p class="mt-2"><span class="font-medium">Statut de paiement:</span> 
                                    <span class="px-2 py-1 rounded text-xs font-semibold 
                                        {{ $order->payment_status === 'unpaid' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $order->payment_status === 'partial' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                    ">
                                        {{ $order->payment_status === 'unpaid' ? 'Non payé' : '' }}
                                        {{ $order->payment_status === 'partial' ? 'Partiellement payé' : '' }}
                                        {{ $order->payment_status === 'paid' ? 'Payé' : '' }}
                                    </span>
                                </p>
                            </div>
                            
                            <form action="{{ route('teleconseiller.orders.update-payment', $order->id) }}" method="POST" class="mt-4">
                                @csrf
                                <div class="mb-3">
                                    <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Mettre à jour le statut de paiement</label>
                                    <select name="payment_status" id="payment_status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Non payé</option>
                                        <option value="partial" {{ $order->payment_status === 'partial' ? 'selected' : '' }}>Partiellement payé</option>
                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Payé</option>
                                    </select>
                                </div>
                                <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                                    Mettre à jour le paiement
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-6">
                        <h2 class="text-lg font-semibold mb-3">Services commandés</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-4 text-left">Service</th>
                                        <th class="py-3 px-4 text-left">Option</th>
                                        <th class="py-3 px-4 text-right">Prix</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($order->services_selected as $service => $details)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3 px-4">
                                                <div class="font-medium">{{ $serviceLabels[$service] ?? ucfirst(str_replace('_', ' ', $service)) }}</div>
                                            </td>
                                            <td class="py-3 px-4">
                                                @php
                                                    $optionKey = isset($details['option']) ? $details['option'] : null;
                                                @endphp
                                                
                                                @if($optionKey)
                                                    {{ $optionLabels[$optionKey] ?? ucfirst(str_replace('_', ' ', $optionKey)) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 text-right">{{ $details['price'] ?? 0 }} MAD</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-8 text-center text-gray-500">Aucun service trouvé</td>
                                        </tr>
                                    @endforelse
                                    <tr class="bg-gray-50 font-semibold">
                                        <td colspan="2" class="py-3 px-4 text-right">Total:</td>
                                        <td class="py-3 px-4 text-right">{{ $order->total_price }} MAD</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('teleconseiller.orders') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Retour à la liste
                    </a>
                    
                    <form action="{{ route('teleconseiller.orders.delete', $order->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commande? Cette action est irréversible.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Supprimer la commande
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 