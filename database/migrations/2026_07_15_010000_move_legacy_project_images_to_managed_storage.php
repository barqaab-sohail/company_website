<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('project_images')->orderBy('id')->each(function ($image): void {
            if (! Str::startsWith($image->path, '/uploads/')) {
                return;
            }

            $source = public_path(ltrim($image->path, '/'));

            if (! File::isFile($source)) {
                return;
            }

            $extension = File::extension($source);
            $filename = Str::slug(File::name($source));
            $destination = 'project-gallery/imported/'.$image->project_id.'-'.$image->id.'-'.$filename.($extension ? '.'.$extension : '');

            Storage::disk('public')->put($destination, File::get($source));
            DB::table('project_images')->where('id', $image->id)->update([
                'path' => $destination,
                'updated_at' => now(),
            ]);
        });
    }

    public function down(): void
    {
        // Keep managed copies so rolling back does not break project pictures.
    }
};
