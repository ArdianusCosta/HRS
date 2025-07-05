<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use EightyNine\Approvals\Models\ApprovableModel;
use RingleSoft\LaravelProcessApproval\Models\ProcessApproval;

class PengejuanCuti extends ApprovableModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_type',
        'mulai_hari',
        'akhir_hari',
        'alasan',
        'total_hari',
        'status',
        'approved_by',
        'approved_at',
    ];

    /**
     * Override label approval status (untuk badge atau tampilan)
     */
    public function getApprovalStatusLabelAttribute(): string
    {
        $status = $this->approvalStatus->status ?? null;

        return match ($status) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'pending' => 'Menunggu',
            default => 'Belum diajukan',
        };
    }

    /**
     * Method override dari ApprovableModel untuk proses approval
     */
    public function approve($comment = null, ?Authenticatable $user = null): ProcessApproval|bool
    {
        $user = $user ?: auth()->user();

        $approval = parent::approve($comment, $user);

        $this->update([
            'status' => 'approved',
            'approved_by' => $user->id,
            'approved_at' => now(),
        ]);

        return $approval;
    }

    /**
     * Method override dari ApprovableModel untuk proses penolakan
     */
    public function reject($comment = null, ?Authenticatable $user = null): ProcessApproval|bool
    {
        $user = $user ?: auth()->user();

        $rejection = parent::reject($comment, $user);

        $this->update([
            'status' => 'rejected',
            'approved_by' => $user->id,
            'approved_at' => now(),
        ]);

        return $rejection;
    }

    /**
     * Siapa saja yang boleh menyetujui
     */
    public function canBeApprovedBy(?\Illuminate\Contracts\Auth\Authenticatable $user): bool
    {
        if (! $user || $this->status !== 'pending') {
            return false;
        }
    
        $approvalStatus = $this->approvalStatus;
    
        if (! $approvalStatus || ! $approvalStatus->currentStep) {
            return false;
        }
    
        return $approvalStatus->currentStep->approvers->contains(function ($approver) use ($user) {
            return $approver->id === $user->id;
        });
    }
    
    public function canBeRejectedBy(?\Illuminate\Contracts\Auth\Authenticatable $user): bool
    {
        return $this->canBeApprovedBy($user);
    }    

}
