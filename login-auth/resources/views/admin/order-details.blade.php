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
                            <a href="{{ route('admin.orders') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
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
                                <p><span class="font-medium">Téléconseiller:</span> 
                                    {{ $order->user->name }} 
                                    <a href="{{ route('admin.orders', ['teleconseiller' => $order->user->id]) }}" class="ml-2 text-blue-500 hover:text-blue-700 text-sm">
                                        Voir toutes les commandes
                                    </a>
                                </p>
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

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="status" class="block font-medium text-sm text-gray-700 mb-1">Mettre à jour le statut</label>
                                        <select name="status" id="status" class="block w-full border-gray-300 rounded-md shadow-sm">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>En attente</option>
                                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Terminée</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
                                        Mettre à jour
                                    </button>
                                </form>

                                <form action="{{ route('admin.orders.update-payment', $order->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="payment_status" class="block font-medium text-sm text-gray-700 mb-1">Mettre à jour le paiement</label>
                                        <select name="payment_status" id="payment_status" class="block w-full border-gray-300 rounded-md shadow-sm">
                                            <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Non payé</option>
                                            <option value="partial" {{ $order->payment_status === 'partial' ? 'selected' : '' }}>Partiellement payé</option>
                                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Payé</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
                                        Mettre à jour le paiement
                                    </button>
                                </form>
                            </div>
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
                                    @php
                                        $serviceLabels = [
                                            'web_mobile' => 'Création web et mobile',
                                            'telemarketing' => 'Télémarketing',
                                            'seo' => 'SEO',
                                            'digital_marketing' => 'Digital Marketing',
                                            'conception' => 'Conception et impression',
                                            'crm' => 'Configuration de CRMs'
                                        ];
                                        
                                        $optionLabels = [
                                            // Options web
                                            'site_base' => 'Site web de base',
                                            'site_pro' => 'Site web professionnel',
                                            'site_ecom' => 'Site web E-commerce',
                                            
                                            // Options télémarketing
                                            'support_client' => 'Forfait de Support Client Téléphonique',
                                            'generation_leads' => 'Forfait de Génération de Leads',
                                            'vente_tel' => 'Forfait de Vente Téléphonique',
                                            
                                            // Options SEO
                                            'seo_base' => 'Site Web de Base',
                                            'seo_pro' => 'Site Web Professionnel',
                                            'seo_ecom' => 'Site Web E-commerce',
                                            
                                            // Options Digital Marketing
                                            'pub_ligne' => 'Publicité en Ligne',
                                            'marketing_influence' => 'Marketing d\'Influence',
                                            'marketing_social' => 'Marketing des Médias Sociaux',
                                            
                                            // Options Conception
                                            'standard_essentiel' => 'Standard- Essentiel',
                                            'professionnelle' => 'Professionnelle',
                                            'marketing_sociaux_conception' => 'Marketing des Médias Sociaux',
                                            
                                            // Options CRM
                                            'crm_essentiel' => 'Configuration de CRM Essentiel',
                                            'crm_premium' => 'Configuration de CRM Premium',
                                            'crm_avancee' => 'Configuration de CRM Avancée'
                                        ];
                                    @endphp
                                    
                                    @forelse($order->services_selected as $service => $details)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3 px-4">
                                                <div class="font-medium">{{ $serviceLabels[$service] ?? $service }}</div>
                                            </td>
                                            <td class="py-3 px-4">
                                                @if(isset($details['option']))
                                                    {{ $optionLabels[$details['option']] ?? $details['option'] }}
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 text-right">{{ $details['price'] ?? '' }} MAD</td>
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
            </div>
        </div>
    </div>
</x-app-layout>