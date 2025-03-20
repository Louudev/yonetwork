<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nom',
        'email',
        'tel',
        'ville',
        'entreprise',
        'services_selected',
        'total_price',
        'status',
        'payment_status',
    ];

    /**
     * Les attributs qui doivent être convertis.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'services_selected' => 'array',
        'total_price' => 'decimal:2',
    ];

    /**
     * Obtenir l'utilisateur à qui appartient cette commande.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
