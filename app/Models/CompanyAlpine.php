<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
#[Fillable(['name', 'email', 'website', 'logo'])]
class CompanyAlpine extends Model
{
    use HasFactory;

    protected $table = 'company-alpine';

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'company_id');
    }

    public function logoUrl(): ?string
    {
        return $this->logo ? Storage::disk('public')->url($this->logo) : null;
    }
}
