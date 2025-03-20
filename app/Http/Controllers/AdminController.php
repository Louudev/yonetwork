<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\User;

class AdminController extends Controller
{
    // ==================== DASHBOARD ====================
    public function dashboard()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/login');
        }

        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->take(5)->get();

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

    // ==================== GESTION DES COMMANDES ====================
    public function orders(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/login');
        }

        $status = $request->input('status');
        $search = $request->input('search');
        $sort = $request->input('sort', 'newest');
        $teleconseiller = $request->input('teleconseiller');
        $payment_status = $request->input('payment_status');

        $query = Order::with('user');

        if ($status && in_array($status, ['pending', 'completed', 'cancelled'])) {
            $query->where('status', $status);
        }

        if ($payment_status && in_array($payment_status, ['unpaid', 'partial', 'paid'])) {
            $query->where('payment_status', $payment_status);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('tel', 'like', "%{$search}%")
                  ->orWhere('entreprise', 'like', "%{$search}%");
            });
        }

        if ($teleconseiller) {
            $query->whereHas('user', function($q) use ($teleconseiller) {
                $q->where('id', $teleconseiller);
            });
        }

        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'price_high') {
            $query->orderByDesc('total_price');
        } elseif ($sort === 'price_low') {
            $query->orderBy('total_price');
        } else {
            $query->latest();
        }

        $orders = $query->paginate(10);
        $teleconseillerUsers = User::where('role', 'teleconseillers')->get();

        return view('admin.orders', compact('orders', 'status', 'search', 'sort', 'teleconseiller', 'teleconseillerUsers'));
    }

    public function showOrder($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/login');
        }

        $order = Order::with('user')->findOrFail($id);
        return view('admin.order-details', compact('order'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $validated['status'];
        $order->save();

        return redirect()->route('admin.orders.show', $id)
            ->with('success', 'Le statut de la commande a été mis à jour avec succès.');
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'payment_status' => 'required|in:unpaid,partial,paid',
        ]);

        $order = Order::findOrFail($id);
        $order->payment_status = $validated['payment_status'];
        $order->save();

        return redirect()->route('admin.orders.show', $id)
            ->with('success', 'Le statut de paiement de la commande a été mis à jour avec succès.');
    }

    // ==================== GESTION DES TÉLÉCONSEILLERS ====================
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/login');
        }
        $teleconseillers = User::where('role', 'teleconseillers')
                              ->orderBy('created_at', 'desc')
                              ->get();
    
        return view('admin.index', compact('teleconseillers'));
    
}
    public function store(Request $request)
    {if (!Auth::check() || !Auth::user()->isAdmin()) {
        return redirect('/login');
    }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'teleconseillers',
            'status' => true,
        ]);

        return redirect()->route('admin.index')->with('success', 'Téléconseiller ajouté avec succès.');
    }

    // Bloque un téléconseiller
public function block($id)
{if (!Auth::check() || !Auth::user()->isAdmin()) {
    return redirect('/login');
}
    $user = User::findOrFail($id);
    $user->status = false; // 0 = bloqué
    $user->save();

    return redirect()->back()->with('success', 'Téléconseiller bloqué !');
}

// Débloque un téléconseiller
public function unblock($id)
{
    if (!Auth::check() || !Auth::user()->isAdmin()) {
    return redirect('/login');
}
    $user = User::findOrFail($id);
    $user->status = true; // 1 = actif
    $user->save();

    return redirect()->back()->with('success', 'Téléconseiller débloqué !');
}

    // public function block($id)
    // {
    //     $teleconseiller = User::findOrFail($id);
    //     $teleconseiller->status = false;
    //     $teleconseiller->save();

    //     return redirect()->route('admin.index')->with('success', 'Téléconseiller bloqué avec succès.');
    // }

    // public function unblock($id)
    // {
    //     $teleconseiller = User::findOrFail($id);
    //     $teleconseiller->status = true;
    //     $teleconseiller->save();

    //     return redirect()->route('admin.index')->with('success', 'Téléconseiller débloqué avec succès.');
    // }
}