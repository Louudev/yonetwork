<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route pour récupérer les détails d'une commande
Route::get('/orders/{id}', function ($id) {
    // Vérifier si l'utilisateur est connecté
    if (!Auth::check()) {
        return response()->json(['error' => 'Non autorisé - Utilisateur non connecté'], 401);
    }
    
    try {
        $order = Order::findOrFail($id);
        
        // Vérifier que l'utilisateur a le droit de voir cette commande
        if (Auth::user()->isAdmin() || $order->user_id === Auth::id()) {
            // Assurez-vous que services_selected est un objet (et pas une chaîne JSON)
            if (is_string($order->services_selected)) {
                $order->services_selected = json_decode($order->services_selected, true);
                
                // Si le décodage JSON a échoué
                if (json_last_error() !== JSON_ERROR_NONE) {
                    // Log l'erreur et renvoyer une réponse formatée
                    \Log::error('Erreur de décodage JSON', [
                        'order_id' => $id,
                        'services_selected' => $order->services_selected,
                        'json_error' => json_last_error_msg()
                    ]);
                    
                    // Envoyer une structure vide mais valide
                    $order->services_selected = [];
                }
            } else if (is_null($order->services_selected)) {
                // Si services_selected est null, initialiser avec un tableau vide
                $order->services_selected = [];
            }
            
            // Log les informations de l'ordre pour diagnostic
            \Log::info('Détails de la commande récupérés', [
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'current_user' => Auth::id(),
                'services_count' => count((array)$order->services_selected)
            ]);
            
            return response()->json($order);
        }
        
        return response()->json(['error' => 'Non autorisé - Accès refusé à cette commande'], 403);
    } catch (\Exception $e) {
        // Log l'erreur pour diagnostic
        \Log::error('Erreur lors de la récupération de la commande', [
            'order_id' => $id,
            'user_id' => Auth::id(),
            'exception' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'error' => 'Commande non trouvée ou erreur serveur',
            'message' => $e->getMessage(),
            'code' => $e->getCode()
        ], 500);
    }
});

// Route pour diagnostiquer la structure des commandes
Route::get('/debug/order-structure', function () {
    // Vérifier si l'utilisateur est connecté
    if (!Auth::check()) {
        return response()->json(['error' => 'Non autorisé - Utilisateur non connecté'], 401);
    }
    
    try {
        // Récupérer une commande
        $order = Order::first();
        
        if (!$order) {
            return response()->json([
                'error' => 'Aucune commande trouvée',
                'user_id' => Auth::id(),
                'is_admin' => Auth::user()->isAdmin(),
                'has_teleconseiller_role' => Auth::user()->isTelesocial()
            ]);
        }
        
        // Préparer les données pour diagnostic
        $originalServicesSelected = $order->getRawOriginal('services_selected');
        
        // Tenter de décoder manuellement
        $decodedServices = null;
        $jsonError = null;
        
        if (is_string($originalServicesSelected)) {
            $decodedServices = json_decode($originalServicesSelected, true);
            $jsonError = json_last_error_msg();
        }
        
        // Construire un rapport de diagnostic
        $diagnosticData = [
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'current_user_id' => Auth::id(),
            'is_admin' => Auth::user()->isAdmin(),
            'created_at' => $order->created_at->format('Y-m-d H:i:s'),
            'services_selected_type' => gettype($order->services_selected),
            'services_selected_raw_type' => gettype($originalServicesSelected),
            'services_selected_raw' => $originalServicesSelected,
            'services_selected_as_array' => $order->services_selected,
            'manually_decoded' => $decodedServices,
            'json_error' => $jsonError,
            'model_casts' => $order->getCasts()
        ];
        
        // Ajouter quelques infos supplémentaires sur la commande
        $diagnosticData['other_fields'] = [
            'nom' => $order->nom,
            'email' => $order->email,
            'total_price' => $order->total_price,
            'status' => $order->status
        ];
        
        return response()->json($diagnosticData);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Erreur lors du diagnostic',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
}); 