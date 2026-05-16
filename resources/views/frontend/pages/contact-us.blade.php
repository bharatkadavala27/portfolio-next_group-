@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    @php
        $contactUsDetails = \App\Models\ContactUsDetail::first();
    @endphp
    <div class="container my-5">
        <div class="row ">
            <div class="row">
                <div class="col-md-6">
                    @if($contactUsDetails)
                    <div class="card mb-3" style="margin-top: 50px;">
                        <div class="card-body">
                            <h5 class="card-title text-primary fs-3" style="text-align: left">NeXT SOLUTION</h5>
                            <p>{{ $contactUsDetails->address }}</p>
                        </div>
                    </div>
                    <div class="card mb-3" style="margin-top: 60px;">
                        <div class="card-body">
                            <h5 class="card-title text-primary fs-3" style="text-align: left">CALL US:</h5>
                            <p>{{ $contactUsDetails->phone }}</p>
                        </div>
                    </div>
                    <div class="card mb-3" style="margin-top: 60px;">
                        <div class="card-body">
                            <h5 class="card-title text-primary fs-3" style="text-align: left">WRITE US:</h5>
                            <p>{{ $contactUsDetails->email }}</p>
                        </div>
                    </div>
                    @endif
                    <div class="d-flex gap-3" style="margin-top: 30px;">
                        <a href="#" class="text-primary fs-4"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-primary fs-4"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-danger fs-4"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Contact Form Section -->
                <div class="col-md-6">
                    <div class="contact-form bg-light p-4 rounded shadow-sm">
                        <h1 class="title text-center text-primary">Contact Us</h1>
                        <h2 class="subtitle text-center text-muted">We are here to assist you.</h2>

                        <form action="{{ url('/submit-form') }}" method="POST">
                            @csrf
                            <!-- Name Input -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Your Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter your name" required>
                            </div>
                            <!-- Email Input -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Your Email</label>
                                <input type="email" name="e-mail" id="email" class="form-control"
                                    placeholder="Enter your email address" required>
                            </div>
                            <!-- Phone Input -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Your Phone Number</label>
                                <input type="tel" name="phone" id="phone" class="form-control"
                                    placeholder="Enter your phone number" required>
                            </div>
                            <!-- Message Textarea -->
                            <div class="mb-3">
                                <label for="message" class="form-label">Your Message</label>
                                <textarea name="text" id="message" class="form-control" rows="5" placeholder="Enter your message" required></textarea>
                            </div>
                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100">Get a Call Back</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="map-container mt-5">
                    <iframe
                        {{-- src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3670.044517676073!2d70.76460357474984!3d22.31892064222126!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3959c9909e845a83%3A0x4863465519cad832!2sMaruti%20Industrial%20Area%2C%20Ramwadi%202%2C%20Rolex%20Road%2C%20Near%20Maldhari%20Railway%20Crossing%2C%20Rajkot-4%2C%20Gujarat%2C%20India!5e0!3m2!1sen!2sin!4v1733203903876!5m2!1sen!2sin"
                        width="1270px" height="300px" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"> --}}
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3671.0118856576836!2d70.803777!3d22.2393047!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3959b5601a9a7e85%3A0xb70d6f561d9cfaee!2sNeXT%20SOLUTION!5e0!3m2!1sen!2sin!4v1733203903876!5m2!1sen!2sin"
                        width="1270px" height="300px" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

        </div>
    @endsection
