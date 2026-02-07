<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certificate_request;

class CertificateRequirements extends Model
{
    use HasFactory;


    protected $table = 'certificate_requirements';

    protected $fillable = [
        'certificate_id',
        'image_path',
        'request_id'
    ];

    /**
     * Each image belongs to one certificate request
     */
    public function certificateRequest()
    {
        return $this->belongsTo(Certificate_request::class, 'request_id');
    }
     public function request()
    {
        return $this->belongsTo(Certificate_request::class, 'request_id', 'request_id');
    }
}
