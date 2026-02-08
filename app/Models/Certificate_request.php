<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CertificateRequirements;

class Certificate_request extends Model
{
    use HasFactory;
    protected $table = 'certificate_requests';
    //Primary Key
    public $primaryKey = 'request_id';
    protected $fillable=['resident_id','name','description','age','gender','paid','price','account_id','request_type','cert_id','request_id','status','remarks'];

// App\Models\CertificateRequest.php
public function requirements()
{
    return $this->hasMany(
        CertificateRequirements::class,
        'request_id', // FK in certificate_requirements
        'request_id'              // PK in certificate_requests
    );
}
}
