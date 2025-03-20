<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Withdraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'amount', 'payment_method', 'bank_name',
        'account_number', 'account_name', 'ewallet_type',
        'phone_number', 'notes',
    ];

    // Tentukan kolom yang harus dikonversi ke Carbon
    protected $dates = ['created_at', 'updated_at', 'processed_at'];

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

            // Otomatis set status ke completed saat dibuat
            $model->status       = 'completed';
            $model->processed_at = now();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Hanya satu status sekarang
    public function getStatusBadgeAttribute()
    {
        return '<span class="badge bg-success">Selesai</span>';
    }

    public function getPaymentDetailsAttribute()
    {
        if ($this->payment_method == 'bank_transfer') {
            return $this->bank_name . ' - ' . $this->account_number . ' (' . $this->account_name . ')';
        } else {
            return $this->ewallet_type . ' - ' . $this->phone_number;
        }
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp. ' . number_format($this->amount, 2, ',', '.');
    }
}
