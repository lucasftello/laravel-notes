<div class="row mb-3 align-items-center">
    <div class="col">
        <a href="{{ route('notes') }}">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Notes logo">
        </a>
    </div>
    <div class="col">
        <div class="d-flex justify-content-end align-items-center">
            <span class="me-4"><i class="fa-solid fa-user-circle fa-lg text-secondary me-1"></i> {{ session('user.name') }}</span>
            <a href="{{ route('logout') }}" class="btn btn-outline-secondary px-3">
                Logout<i class="fa-solid fa-arrow-right-from-bracket ms-2"></i>
            </a>
        </div>
    </div>
</div>

<hr>
