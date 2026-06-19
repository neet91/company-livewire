<?php

namespace App\Http\Controllers;

use App\Models\CompanyAlpine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index(): View
    {
        $companies = CompanyAlpine::query()
            ->latest()
            ->paginate(10);

        return view('companies.index', compact('companies'));
    }

    public function create(): View
    {
        return view('companies.create', [
            'company' => new CompanyAlpine(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateCompany($request);

        $validated['logo'] = $this->storeLogo($request->file('logo'));

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

    public function update(Request $request, CompanyAlpine $company): RedirectResponse
    {
        $validated = $this->validateCompany($request, $company);

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

    /**
     * @return array{name:string,email:string,website?:string|null,logo?:string|null}
     */
    protected function validateCompany(Request $request, ?CompanyAlpine $company = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('company-alpine', 'email')->ignore($company?->getKey()),
            ],
            'website' => ['nullable', 'url', 'max:255'],
            'logo' => [$company ? 'nullable' : 'required', 'image', 'max:4096'],
        ]);
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
