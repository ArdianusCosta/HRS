<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait ShieldableResource
{
    protected static function getResourcePermissionName(): string
    {
        return static::getSlug(); 
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_any_' . static::getResourcePermissionName());
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()?->can('view_' . static::getResourcePermissionName());
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_' . static::getResourcePermissionName());
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('update_' . static::getResourcePermissionName());
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete_' . static::getResourcePermissionName());
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->can('delete_any_' . static::getResourcePermissionName());
    }

    public static function canForceDelete(Model $record): bool
    {
        return auth()->user()?->can('force_delete_' . static::getResourcePermissionName());
    }

    public static function canForceDeleteAny(): bool
    {
        return auth()->user()?->can('force_delete_any_' . static::getResourcePermissionName());
    }

    public static function canRestore(Model $record): bool
    {
        return auth()->user()?->can('restore_' . static::getResourcePermissionName());
    }

    public static function canRestoreAny(): bool
    {
        return auth()->user()?->can('restore_any_' . static::getResourcePermissionName());
    }

    public static function canReplicate(Model $record): bool
    {
        return auth()->user()?->can('replicate_' . static::getResourcePermissionName());
    }

    public static function canReorder(): bool
    {
        return auth()->user()?->can('reorder_' . static::getResourcePermissionName());
    }
}
