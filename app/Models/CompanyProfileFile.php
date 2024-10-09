<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyProfileFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_profile_id',
        'file_name',
        'file_type',
        'file_path',
    ];

    public function company_profile(): BelongsTo
    {
        return $this->belongsTo(CompanyProfile::class);
    }
}
