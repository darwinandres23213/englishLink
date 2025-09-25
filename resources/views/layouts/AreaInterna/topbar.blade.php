<nav class="navbar navbar-expand navbar-light bg-dark topbar mb-4 static-top shadow" style="padding: 0 1.5rem;">
    
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>


    <!-- Topbar Search -->
    {{-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="width: 350px;">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar ..." aria-label="Search" aria-describedby="basic-addon2" style="background: rgba(255,255,255,0.15); border-radius: 10px 0 0 10px; color: white; backdrop-filter: blur(10px);">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" style="border-radius: 0 10px 10px 0; background: rgba(255,255,255,0.2); border: none;">
                    <i class="fas fa-search" style="color: white;"></i>
                </button>
            </div>
        </div>
    </form> --}}


    <!-- Topbar Navbar | Menu de Usuario -->
    <ul class="navbar-nav ml-auto">
        <x-MenUser-topbar-AI/> <!-- Nav Item - User Information -->
    </ul>
</nav>