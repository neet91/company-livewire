<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['first_name', 'last_name', 'company_id', 'email', 'phone'])]
class Employee extends Model
{
    use HasFactory;

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyAlpine::class, 'company_id');
    }

    public function fullName(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }
}
