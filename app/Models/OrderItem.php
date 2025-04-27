<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'download_link',
        'download_count',
        'downloaded_at',
        'download_token',
        'token_expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'downloaded_at' => 'datetime',
        'token_expires_at' => 'datetime',
    ];

    /**
     * Get the order that this item belongs to.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product associated with this order item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the licenses associated with this order item.
     */
    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }

    /**
     * Generate a new download token for this order item.
     */
    public function generateDownloadToken(int $expireDays = 7): void
    {
        // Tạo một token ngẫu nhiên bằng cách kết hợp nhiều thông tin
        $token = md5(uniqid() . time() . $this->id . $this->product_id);
        
        $this->download_token = $token;
        $this->token_expires_at = now()->addDays($expireDays);
        $this->save();
    }

    /**
     * Check if the download token is valid.
     */
    public function isDownloadTokenValid(): bool
    {
        // Token không tồn tại hoặc đã hết hạn
        if (!$this->download_token || 
            ($this->token_expires_at && $this->token_expires_at->isPast())) {
            return false;
        }
        
        return true;
    }

    /**
     * Get the remaining time for the download token.
     */
    public function getTokenRemainingTime(): ?string
    {
        if (!$this->token_expires_at) {
            return null;
        }
        
        if ($this->token_expires_at->isPast()) {
            return 'Đã hết hạn';
        }
        
        return $this->token_expires_at->diffForHumans();
    }

    /**
     * Get the downloadable file name.
     */
    public function getDownloadableFileName(): ?string
    {
        if (!$this->download_link) {
            return null;
        }
        
        return basename($this->download_link);
    }

    /**
     * Get the download URL.
     */
    public function getDownloadUrl(): ?string
    {
        if (!$this->download_token || !$this->isDownloadTokenValid()) {
            return null;
        }
        
        return route('download', ['token' => $this->download_token]);
    }
}
