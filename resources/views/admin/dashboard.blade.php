<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord Admin') }}
        </h2>
    </x-slot>
    <script src="https://cdn.tailwindcss.com"></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Bonjour Admin!</h1>
                    <p class="mb-6">Bienvenue sur votre tableau de bord d'administration.</p>
                    
                    <!-- Statistiques des commandes -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4">Statistiques des commandes</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Total des commandes -->
                            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-blue-500">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">Total des commandes</p>
                                        <p class="text-2xl font-bold">{{ $totalOrders }}</p>
                                    </div>
                                    <div class="p-3 bg-blue-100 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Commandes en attente -->
                            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-yellow-500">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">En attente</p>
                                        <p class="text-2xl font-bold">{{ $pendingOrders }}</p>
                                    </div>
                                    <div class="p-3 bg-yellow-100 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Commandes terminées -->
                            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-green-500">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">Terminées</p>
                                        <p class="text-2xl font-bold">{{ $completedOrders }}</p>
                                    </div>
                                    <div class="p-3 bg-green-100 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Revenu total -->
                            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-purple-500">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">Revenu total</p>
                                        <p class="text-2xl font-bold">{{ number_format($totalRevenue, 2) }} MAD</p>
                                    </div>
                                    <div class="p-3 bg-purple-100 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Commandes récentes -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4">Commandes récentes</h2>
                        @if($recentOrders->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="py-3 px-4 text-left">ID</th>
                                            <th class="py-3 px-4 text-left">Client</th>
                                            <th class="py-3 px-4 text-left">Date</th>
                                            <th class="py-3 px-4 text-right">Total</th>
                                            <th class="py-3 px-4 text-center">Statut</th>
                                            <th class="py-3 px-4 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($recentOrders as $order)
                                            <tr class="hover:bg-gray-50">
                                                <td class="py-3 px-4">{{ $order->id }}</td>
                                                <td class="py-3 px-4">{{ $order->nom }}</td>
                                                <td class="py-3 px-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                <td class="py-3 px-4 text-right">{{ $order->total_price }} MAD</td>
                                                <td class="py-3 px-4 text-center">
                                                    <span class="px-2 py-1 rounded text-xs font-semibold 
                                                        {{ isset($order->payment_status) && $order->payment_status === 'unpaid' ? 'bg-red-100 text-red-800' : '' }}
                                                        {{ isset($order->payment_status) && $order->payment_status === 'partial' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                        {{ isset($order->payment_status) && $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                                        {{ !isset($order->payment_status) || $order->payment_status === '' ? 'bg-gray-100 text-gray-800' : '' }}
                                                    ">
                                                        {{ isset($order->payment_status) && $order->payment_status === 'unpaid' ? 'Non payé' : '' }}
                                                        {{ isset($order->payment_status) && $order->payment_status === 'partial' ? 'Partiel' : '' }}
                                                        {{ isset($order->payment_status) && $order->payment_status === 'paid' ? 'Payé' : '' }}
                                                        {{ !isset($order->payment_status) || $order->payment_status === '' ? 'Non défini' : '' }}
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
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('admin.orders') }}" class="text-blue-500 hover:text-blue-700 font-semibold">Voir toutes les commandes →</a>
                            </div>
                        @else
                            <p class="text-gray-500">Aucune commande trouvée.</p>
                        @endif
                    </div>
                    
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold mb-3">Gestion du site</h2>
                        <div class="space-y-3">
                            <a href="{{ route('admin.orders') }}" class="flex items-center text-blue-500 hover:text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                                </svg>
                                Gestion des commandes
                            </a>
                            <a href="{{ route('admin.index') }}" class="flex items-center text-blue-500 hover:text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                </svg>
                                Gestion des téléconseillers
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 