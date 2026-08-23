@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card border-0 shadow-sm rounded-4 p-5">
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                </div>
                <h2 class="fw-bold mb-3">អរគុណសម្រាប់ការបញ្ជាទិញ!</h2>
                <p class="fs-5 text-muted mb-4">ការបញ្ជាទិញរបស់អ្នកទទួលបានជោគជ័យ។ ពួកយើងនឹងរៀបចំនិងផ្ញើទំនិញជូនអ្នកក្នុងពេលឆាប់ៗនេះ។</p>
                
                <div class="bg-light p-4 rounded-3 mb-4 d-inline-block mx-auto">
                    <span class="text-muted">លេខកូដបញ្ជាទិញរបស់អ្នកគឺ:</span><br>
                    <span class="fs-3 fw-bold text-primary-theme">#{{ $orderNumber ?? 'N/A' }}</span>
                </div>

                <div>
                    <a href="{{ route('profile.index') }}" class="btn btn-outline-primary px-4 py-2 me-2 rounded-pill">មើលប្រវត្តិទិញ</a>
                    <a href="{{ route('home') }}" class="btn btn-primary-theme px-4 py-2 rounded-pill">បន្តការទិញទំនិញ</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
