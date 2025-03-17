<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Withdraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'amount', 'payment_method', 'bank_name', 'account_number', 'account_name',
        'ewallet_type', 'phone_number', 'status', 'processed_at', 'notes',
    ];

    // ID field uses UUID
    public $incrementing = false;
    protected $keyType   = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Status badges untuk tampilan
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pending' => '<span class="badge bg-warning">Menunggu</span>',
            'processing' => '<span class="badge bg-info">Diproses</span>',
            'completed' => '<span class="badge bg-success">Selesai</span>',
            'rejected' => '<span class="badge bg-danger">Ditolak</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    // Method untuk mendapatkan detail pembayaran
    public function getPaymentDetailsAttribute()
    {
        if ($this->payment_method == 'bank_transfer') {
            return $this->bank_name . ' - ' . $this->account_number . ' (' . $this->account_name . ')';
        } else {
            return $this->ewallet_type . ' - ' . $this->phone_number;
        }
    }

    // Accessor untuk menampilkan formatted amount
    public function getFormattedAmountAttribute()
    {
        return 'Rp. ' . number_format($this->amount, 2, ',', '.');
    }
}
