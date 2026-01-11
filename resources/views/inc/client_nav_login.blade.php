<header class="header-blue py-2" style="background-color: #1E3A8A;"> <!-- Modern blue header -->
    <nav class="navbar navbar-expand-md navbar-dark container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <!-- Logo -->
            <img src="
{{  Storage::url($image->image ?? 'Logo not set')  }}" alt="Barangay Logo"
                style="width: 80px; height: auto; margin-right: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.3);">

            <!-- Barangay Name -->
            <span id="client_header_login"
                style="font-size: 1.8rem; font-weight: 600; font-family: 'Roboto', sans-serif; color: #F3F4F6;">
                {{ $image->barangay_name ?? 'No logo found' }}
            </span>
        </a>

        <!-- Optional: Add a navbar toggler for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


    </nav>

</header>
