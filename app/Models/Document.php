<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'placement_id',
        'type',
        'file_path',
        'original_name',
        'uploaded_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'uploaded_at' => 'datetime',
        ];
    }

    /**
     * Document types.
     */
    public const TYPES = [
        'acceptance_letter' => 'Acceptance Letter',
        'insurance' => 'Insurance Document',
        'resume' => 'Resume/CV',
        'transcript' => 'Academic Transcript',
        'id_card' => 'ID Card',
        'other' => 'Other',
    ];

    // Relationships

    /**
     * Get the user who uploaded this document.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the placement for this document.
     */
    public function placement(): BelongsTo
    {
        return $this->belongsTo(Placement::class);
    }

    // Helper Methods

    /**
     * Get the document type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    /**
     * Get the file URL.
     */
    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Get the file extension.
     */
    public function getFileExtensionAttribute(): string
    {
        return pathinfo($this->original_name, PATHINFO_EXTENSION);
    }

    /**
     * Check if the document is an image.
     */
    public function isImage(): bool
    {
        return in_array(strtolower($this->file_extension), ['jpg', 'jpeg', 'png', 'gif']);
    }

    /**
     * Check if the document is a PDF.
     */
    public function isPdf(): bool
    {
        return strtolower($this->file_extension) === 'pdf';
    }
}
