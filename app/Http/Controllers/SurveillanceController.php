<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class TelesocialController extends Controller
{
    /**
     * Afficher le tableau de bord des teleconseillers
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function dashboard()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        // Vérifier si l'utilisateur est un teleconseiller
        if (!Auth::user()->isTelesocial()) {
            return redirect('/');
        }
        
        // Récupérer les commandes récentes de l'utilisateur
        $orders = Auth::user()->orders()->orderBy('created_at', 'desc')->take(5)->get();
        
        return view('surveillance.dashboard', [
            'orders' => $orders
        ]);
    }

    /**
     * Afficher l'historique des commandes
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function orderHistory()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        // Vérifier si l'utilisateur est un teleconseiller
        if (!Auth::user()->isTelesocial()) {
            return redirect('/');
        }
        
        // Récupérer toutes les commandes de l'utilisateur
        $orders = Auth::user()->orders()->orderBy('created_at', 'desc')->paginate(10);
        
        return view('surveillance.order-history', compact('orders'));
    }

    /**
     * Traiter la soumission du formulaire de services
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitForm(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        // Vérifier si l'utilisateur est un teleconseiller
        if (!Auth::user()->isTelesocial()) {
            return redirect('/');
        }
        
        // Valider les données du formulaire
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tel' => 'required|string|max:20',
            'ville' => 'required|string|max:100',
            'entreprise' => 'required|string|max:255',
            'services' => 'nullable|array',
            'total_price' => 'required|numeric',
            // Options de services
            'web_mobile_option' => 'nullable|string',
            'telemarketing_option' => 'nullable|string',
            'seo_option' => 'nullable|string',
            'digital_marketing_option' => 'nullable|string',
            'conception_option' => 'nullable|string',
            'crm_option' => 'nullable|string',
        ]);
        
        // Collecter les services sélectionnés avec leurs options
        $selectedServices = [];
        
        if ($request->has('services')) {
            foreach ($request->services as $service) {
                $optionName = $service . '_option';
                $selectedOption = $request->$optionName ?? null;
                $optionPrice = 0;
                
                if ($selectedOption) {
                    $priceMap = [
                        // Web options
                        'site_base' => 3500,
                        'site_pro' => 7500,
                        'site_ecom' => 12000,
                        
                        // Telemarketing options
                        'support_client' => 5000,
                        'generation_leads' => 7000,
                        'vente_tel' => 6000,
                        
                        // SEO options
                        'seo_base' => 2500,
                        'seo_pro' => 4500,
                        'seo_ecom' => 6500,
                        
                        // Digital Marketing options
                        'pub_ligne' => 3000,
                        'marketing_influence' => 4000,
                        'marketing_social' => 2500,
                        
                        // Conception options
                        'standard_essentiel' => 1500,
                        'professionnelle' => 3000,
                        'marketing_sociaux_conception' => 2500,
                        
                        // CRM options
                        'crm_essentiel' => 3000,
                        'crm_premium' => 6000,
                        'crm_avancee' => 9000,
                    ];
                    
                    $optionPrice = $priceMap[$selectedOption] ?? 0;
                }
                
                $selectedServices[$service] = [
                    'option' => $selectedOption,
                    'price' => $optionPrice
                ];
            }
        }
        
        try {
            // Créer une nouvelle commande dans la base de données
            $order = new Order();
            $order->user_id = Auth::id();
            $order->nom = $validated['nom'];
            $order->email = $validated['email'];
            $order->tel = $validated['tel'];
            $order->ville = $validated['ville'];
            $order->entreprise = $validated['entreprise'];
            
            // S'assurer que services_selected est bien encodé
            $order->services_selected = $selectedServices;
            
            // Vérifier que l'encodage JSON fonctionne correctement
            $jsonServices = json_encode($selectedServices);
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Log l'erreur JSON
                Log::error('Erreur d\'encodage JSON des services', [
                    'error' => json_last_error_msg(),
                    'services' => $selectedServices
                ]);
                
                // Utiliser un tableau vide en cas d'erreur
                $order->services_selected = [];
            }
            
            $order->total_price = $validated['total_price'];
            $order->status = 'pending';
            $order->save();
            
            // Logger l'action
            Log::info('Nouvelle commande enregistrée', [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'total' => $validated['total_price'],
                'services_count' => count($selectedServices)
            ]);
            
            // Rediriger avec un message de succès
            return redirect()->route('surveillance.dashboard')
                ->with('success', 'Votre commande a été enregistrée avec succès. Total: ' . $validated['total_price'] . ' MAD');
            
        } catch (\Exception $e) {
            // Log l'erreur
            Log::error('Erreur lors de l\'enregistrement de la commande', [
                'user_id' => Auth::id(),
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Rediriger avec un message d'erreur
            return redirect()->route('surveillance.dashboard')
                ->with('error', 'Une erreur est survenue lors de l\'enregistrement de votre commande. Veuillez réessayer.');
        }
    }

    /**
     * Afficher les détails d'une commande
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showOrder($id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        // Vérifier si l'utilisateur est un teleconseiller
        if (!Auth::user()->isTelesocial()) {
            return redirect('/');
        }
        
        try {
            // Récupérer la commande
            $order = Order::findOrFail($id);
            
            // Vérifier que l'utilisateur a le droit de voir cette commande
            if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
                return redirect()->route('surveillance.orders')
                    ->with('error', 'Vous n\'êtes pas autorisé à voir cette commande.');
            }
            
            // S'assurer que services_selected est un tableau
            if (is_string($order->services_selected)) {
                $order->services_selected = json_decode($order->services_selected, true);
            }
            
            if (is_null($order->services_selected)) {
                $order->services_selected = [];
            }
            
            // Définir la correspondance des codes de services et d'options
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
            
            // Logger l'action
            Log::info('Affichage des détails de la commande', [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'services_count' => is_array($order->services_selected) ? count($order->services_selected) : 0
            ]);
            
            return view('surveillance.order-details', compact('order', 'serviceLabels', 'optionLabels'));
            
        } catch (\Exception $e) {
            // Logger l'erreur
            Log::error('Erreur lors de l\'affichage des détails de la commande', [
                'order_id' => $id,
                'user_id' => Auth::id(),
                'exception' => $e->getMessage()
            ]);
            
            return redirect()->route('surveillance.orders')
                ->with('error', 'Une erreur est survenue lors de la récupération des détails de la commande.');
        }
    }
}
