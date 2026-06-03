<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ThirteenPlusMigrationService
{
    /**
     * Soft-delete migration: set migration_status = 3 for matching user_id and enrollment.
     */
    public function softDeleteByUserAndEnrollment($userId, $enrollmentId)
    {
        $updated = DB::table('13plus_migration')
            ->where('user_id', $userId)
            ->where('enrollment', $enrollmentId)
            ->update(['migration_status' => 3]);

        return [
            'response_status' => $updated > 0 ? 200 : 404,
            'updated_count' => $updated,
        ];
    }

    /**
     * Remigrate to ISMS: set migration_status = 4 for enrollment (from status 3).
     */
    public function remigrateIsmsByEnrollment($enrollmentId, array $extraFields = [])
    {
        $update = array_merge(['migration_status' => 4], $extraFields);

        $updated = DB::table('13plus_migration')
            ->where('enrollment', $enrollmentId)
            ->where('migration_status', 3)
            ->update($update);

        return [
            'response_status' => $updated > 0 ? 200 : 404,
            'updated_count' => $updated,
        ];
    }
}
