<?php

namespace App\Traits;

use App\Models\ActivityLog;
use App\Helpers\ActivityHelper;

trait LogsActivity
{
    /**
     * Boot the trait
     */
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            self::logActivity('create', $model, 'yaratildi');
        });

        static::updated(function ($model) {
            self::logActivity('update', $model, 'yangilandi');
        });

        static::deleted(function ($model) {
            self::logActivity('delete', $model, 'o\'chirildi');
        });
    }

    /**
     * Log activity
     */
    protected static function logActivity($action, $model, $actionText)
    {
        // Agar authentication yo'q bo'lsa yoki ActivityLog o'zi o'zgarayotgan bo'lsa, log yozma
        if (!auth()->check() || $model instanceof ActivityLog) {
            return;
        }

        try {
            $properties = [];

            if ($action === 'create') {
                $properties = [
                    'new' => $model->getAttributes(),
                ];
            } elseif ($action === 'update') {
                // Faqat muhim field-lar o'zgarganda log yozish
                // last_login_at o'zgarishi log yozmasligi uchun
                $ignoreFields = ['last_login_at', 'updated_at', 'remember_token'];
                $oldData = $model->getOriginal();
                $newData = $model->getAttributes();

                $filteredOld = array_diff_key($oldData, array_flip($ignoreFields));
                $filteredNew = array_diff_key($newData, array_flip($ignoreFields));

                // Agar muhim field-lar o'zgarmagan bo'lsa, log yozma
                if ($filteredOld === $filteredNew) {
                    return;
                }

                $properties = [
                    'old' => $filteredOld,
                    'new' => $filteredNew,
                ];
            } elseif ($action === 'delete') {
                $properties = [
                    'deleted' => $model->getAttributes(),
                ];
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'subject_type' => get_class($model),
                'subject_id' => $model->id,
                'action' => $action,
                'description' => self::getDescription($action, $model, $actionText),
                'properties' => $properties,
                'ip_address' => ActivityHelper::getIpAddress(),
                'user_agent' => request()->userAgent(),
                'device' => ActivityHelper::detectDevice(),
                'browser' => ActivityHelper::detectBrowser(),
                'platform' => ActivityHelper::detectPlatform(),
            ]);
        } catch (\Exception $e) {
            // Log xatolarini yutib qo'yamiz, asosiy funksiyaga ta'sir qilmasin
            \Log::error('Activity logging failed: ' . $e->getMessage());
        }
    }

    /**
     * Get description
     */
    protected static function getDescription($action, $model, $actionText)
    {
        $modelName = class_basename($model);
        $identifier = $model->name ?? $model->email ?? $model->id;

        return auth()->user()->name . " {$modelName} \"{$identifier}\" ni {$actionText}";
    }

    /**
     * Get activity logs for this model
     */
    public function activities()
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }
}

