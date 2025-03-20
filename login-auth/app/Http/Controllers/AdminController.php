<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class AdminController extends Controller
{
    /**
     * Afficher le tableau de bord admin
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function dashboard()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        // Vérifier si l'utilisateur est un admin
        if (!Auth::user()->isAdmin()) {
            return redirect('/teleconseiller/dashboard');
        }

        // Obtenir des statistiques sur les commandes
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        
        
        // Calcul du revenu total
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        
        // Commandes récentes
        $recentOrders = Order::with('user')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
        
        // S'assurer que toutes les commandes ont un statut de paiement défini
        foreach ($recentOrders as $order) {
            if (!isset($order->payment_status)) {
                $order->payment_status = 'unpaid';
            }
        }
        
        return view('admin.dashboard', compact(
            'totalOrders', 
            'pendingOrders', 
            'completedOrders', 
            'cancelledOrders',
            'totalRevenue',
            'recentOrders'
        ));
    }
    
    /**
     * Afficher la liste des commandes
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function orders(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        // Vérifier si l'utilisateur est un admin
        if (!Auth::user()->isAdmin()) {
            return redirect('/teleconseiller/dashboard');
        }
        
        // Récupérer les filtres
        $status = $request->input('status');
        $search = $request->input('search');
        $sort = $request->input('sort', 'newest');
        $teleconseiller = $request->input('teleconseiller');
        $payment_status = $request->input('payment_status');
        
        // Requête de base pour les commandes
        $query = Order::with('user');
        
        // Appliquer le filtre de statut
        if ($status && in_array($status, ['pending', 'completed', 'cancelled'])) {
            $query->where('status', $status);
        }
        // Appliquer le filtre de statut de paiement
    if ($payment_status && in_array($payment_status, ['unpaid', 'partial', 'paid'])) {
        $query->where('payment_status', $payment_status);
    }
        // Appliquer la recherche
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('tel', 'like', "%{$search}%")
                  ->orWhere('entreprise', 'like', "%{$search}%");
            });
        }
        
        // Filtrer par utilisateur de teleconseiller
        if ($teleconseiller) {
            $query->whereHas('user', function($q) use ($teleconseiller) {
                $q->where('id', $teleconseiller);
            });
        }
        
        // Appliquer le filtre de tri
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'price_high') {
            $query->orderByDesc('total_price');
        } elseif ($sort === 'price_low') {
            $query->orderBy('total_price');
        } else {
            $query->latest(); // Par défaut: les plus récentes d'abord
        }
        
        // Paginer les résultats
        $orders = $query->paginate(10);
        
        // Récupérer la liste des utilisateurs de teleconseillers pour le filtre
        $teleconseillerUsers = \App\Models\User::where('role', 'teleconseillers')->get();
        
        // Retourner la vue avec les résultats
        return view('admin.orders', compact('orders', 'status', 'search', 'sort', 'teleconseiller', 'teleconseillerUsers'));
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
        
        // Vérifier si l'utilisateur est un admin
        if (!Auth::user()->isAdmin()) {
            return redirect('/teleconseiller/dashboard');
        }
        
        // Récupérer la commande avec son utilisateur associé
        $order = Order::with('user')->findOrFail($id);
        
        return view('admin.order-details', compact('order'));
    }
    
    /**
     * Mettre à jour le statut d'une commande
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateOrderStatus(Request $request, $id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        // Vérifier si l'utilisateur est un admin
        if (!Auth::user()->isAdmin()) {
            return redirect('/teleconseiller/dashboard');
        }
        
        // Valider les données
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);
        
        // Mettre à jour le statut de la commande
        $order = Order::findOrFail($id);
        $order->status = $validated['status'];
        $order->save();
        
        return redirect()->route('admin.orders.show', $id)
            ->with('success', 'Le statut de la commande a été mis à jour avec succès.');
    }
    
    /**
     * Mettre à jour le statut de paiement d'une commande
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        // Vérifier si l'utilisateur est un admin
        if (!Auth::user()->isAdmin()) {
            return redirect('/teleconseiller/dashboard');
        }
        
        // Valider les données
        $validated = $request->validate([
            'payment_status' => 'required|in:unpaid,partial,paid',
        ]);
        
        // Mettre à jour le statut de paiement de la commande
        $order = Order::findOrFail($id);
        $order->payment_status = $validated['payment_status'];
        $order->save();
        
        return redirect()->route('admin.orders.show', $id)
            ->with('success', 'Le statut de paiement de la commande a été mis à jour avec succès.');
            
    }
}


