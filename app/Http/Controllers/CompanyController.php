<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\CompanyAlpine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index(): View
    {
        $search = request()->string('search')->trim()->toString();

        $companies = CompanyAlpine::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('website', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('companies.index', compact('companies', 'search'));
    }

    public function create(): View
    {
        return view('companies.create', [
            'company' => new CompanyAlpine(),
        ]);
    }

    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['logo'] = $request->hasFile('logo')
            ? $this->storeLogo($request->file('logo'))
            : null;

        CompanyAlpine::create($validated);

        return to_route('companies.index')
            ->with('success', __('Company created successfully.'));
    }

    public function show(CompanyAlpine $company): View
    {
        return view('companies.show', compact('company'));
    }

    public function edit(CompanyAlpine $company): View
    {
        return view('companies.edit', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, CompanyAlpine $company): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            $validated['logo'] = $this->storeLogo($request->file('logo'));
            $this->deleteLogo($company->logo);
        } else {
            unset($validated['logo']);
        }

        $company->update($validated);

        return to_route('companies.index')
            ->with('success', __('Company updated successfully.'));
    }

    public function destroy(CompanyAlpine $company): RedirectResponse
    {
        $this->deleteLogo($company->logo);
        $company->delete();

        return to_route('companies.index')
            ->with('success', __('Company deleted successfully.'));
    }

    protected function storeLogo(UploadedFile $file): string
    {
        $contents = file_get_contents($file->getRealPath());

        if ($contents === false) {
            throw ValidationException::withMessages([
                'logo' => __('The logo image could not be read.'),
            ]);
        }

        $source = imagecreatefromstring($contents);

        if ($source === false) {
            throw ValidationException::withMessages([
                'logo' => __('The logo image could not be processed.'),
            ]);
        }

        $width = imagesx($source);
        $height = imagesy($source);
        $cropSize = min($width, $height);
        $srcX = (int) floor(($width - $cropSize) / 2);
        $srcY = (int) floor(($height - $cropSize) / 2);

        $target = imagecreatetruecolor(100, 100);
        imagealphablending($target, false);
        imagesavealpha($target, true);
        $transparent = imagecolorallocatealpha($target, 0, 0, 0, 127);
        imagefill($target, 0, 0, $transparent);

        imagecopyresampled($target, $source, 0, 0, $srcX, $srcY, 100, 100, $cropSize, $cropSize);

        $path = 'company-logos/'.Str::uuid()->toString().'.png';
        Storage::disk('public')->makeDirectory('company-logos');
        imagepng($target, Storage::disk('public')->path($path));

        imagedestroy($source);
        imagedestroy($target);

        return $path;
    }

    protected function deleteLogo(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
