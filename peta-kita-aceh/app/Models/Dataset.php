<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dataset extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::updating(function ($dataset) {
            $user = auth()->user();

            if ($user && !$user->isAdmin()) {
                // Protect status
                if ($dataset->isDirty('status') && $dataset->status === 'published') {
                    throw new \Illuminate\Auth\Access\AuthorizationException('Hanya Admin yang dapat mempublikasikan dataset.');
                }
                
                // Protect agency_id
                if ($dataset->isDirty('agency_id') && $dataset->getOriginal('agency_id') !== $dataset->agency_id) {
                    throw new \Illuminate\Auth\Access\AuthorizationException('Anda tidak berhak mengubah kepemilikan dataset (Instansi/SKPA).');
                }
            }
        });

        static::created(function ($dataset) {
            self::logAudit('dataset_created', $dataset);
        });

        static::updated(function ($dataset) {
            $changes = $dataset->getChanges();
            // Don't log if no meaningful changes
            if (empty($changes)) return;
            
            // Check specific events
            if ($dataset->wasChanged('status')) {
                $action = $dataset->status === 'published' ? 'dataset_approved' : ($dataset->status === 'rejected' ? 'dataset_rejected' : 'status_changed');
                self::logAudit($action, $dataset, $changes);
            } elseif ($dataset->wasChanged('access_level')) {
                self::logAudit('privacy_changed', $dataset, $changes);
            } elseif ($dataset->wasChanged('agency_id')) {
                self::logAudit('ownership_changed', $dataset, $changes);
            } else {
                self::logAudit('dataset_updated', $dataset, $changes);
            }
        });

        static::deleted(function ($dataset) {
            self::logAudit('dataset_deleted', $dataset);
        });
    }

    protected static function logAudit($action, $dataset, $changes = null)
    {
        $payload = null;
        if ($changes) {
            $old = [];
            $new = [];
            foreach ($changes as $key => $value) {
                if ($key === 'updated_at') continue;
                $old[$key] = $dataset->getOriginal($key);
                $new[$key] = $value;
            }
            if (!empty($new)) {
                $payload = ['old' => $old, 'new' => $new];
            }
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => get_class($dataset),
            'model_id' => $dataset->id,
            'payload' => $payload,
            'ip_address' => request()->ip(),
        ]);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function layers(): HasMany
    {
        return $this->hasMany(Layer::class);
    }

    public function metadata(): HasOne
    {
        return $this->hasOne(DatasetMetadata::class);
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(DatasetDownload::class);
    }

    // Analytics Accessors
    public function getTotalDownloadsAttribute()
    {
        return $this->downloads()->count();
    }

    public function getDownloadsTodayAttribute()
    {
        return $this->downloads()->whereDate('created_at', today())->count();
    }

    public function getDownloadsThisMonthAttribute()
    {
        return $this->downloads()->whereMonth('created_at', now()->month)
                                 ->whereYear('created_at', now()->year)
                                 ->count();
    }

    public function getUniqueDownloadersAttribute()
    {
        return $this->downloads()->distinct('ip_address')->count('ip_address');
    }

    public function getLastDownloadedAtAttribute()
    {
        $last = $this->downloads()->latest('created_at')->first();
        return $last ? $last->created_at : null;
    }

    public function allowedAgencies()
    {
        return $this->belongsToMany(Agency::class, 'dataset_allowed_agencies');
    }

    /**
     * Scope query to filter datasets accessible by the current user context
     */
    public function scopeAccessibleBy($query, ?User $user = null)
    {
        if ($user && $user->isAdmin()) {
            return $query;
        }

        if ($user && $user->agency_id) {
            $userAgencyId = $user->agency_id;
            return $query->where(function ($q) use ($userAgencyId) {
                // Operator can see all datasets from their own agency
                $q->where('agency_id', $userAgencyId)
                  // Or published public datasets
                  ->orWhere(function ($pubQ) use ($userAgencyId) {
                      $pubQ->where('status', 'published')
                           ->where(function ($accessQ) use ($userAgencyId) {
                               $accessQ->where('access_level', 'public')
                                       ->orWhere(function ($restQ) use ($userAgencyId) {
                                           $restQ->where('access_level', 'restricted')
                                                 ->whereHas('allowedAgencies', function ($agQ) use ($userAgencyId) {
                                                     $agQ->where('agencies.id', $userAgencyId);
                                                 });
                                       });
                           });
                  });
            });
        }

        // Guest / Public users: published & access_level == public only
        return $query->where('status', 'published')
                     ->where(function ($q) {
                         $q->where('access_level', 'public')
                           ->orWhereNull('access_level');
                     });
    }
}

