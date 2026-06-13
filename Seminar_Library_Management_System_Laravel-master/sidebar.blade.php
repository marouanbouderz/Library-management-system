<aside class="modern-sidebar">
    <div class="sidebar-header">
        <div class="logo-circle">
            <i class="fas fa-book-reader"></i>
        </div>
        <span class="brand-text">Seminar<span>Lib</span></span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <p class="section-title">Core</p>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
        </div>

        <div class="nav-section">
            <p class="section-title">Management</p>
            <a href="{{ route('books.index') }}" class="nav-item {{ request()->is('books*') ? 'active' : '' }}">
                <i class="fas fa-book"></i>
                <span>Library Books</span>
            </a>
            <a href="{{ route('members.index') }}" class="nav-item {{ request()->is('members*') ? 'active' : '' }}">
                <i class="fas fa-id-card"></i>
                <span>Members</span>
            </a>
            <a href="{{ route('seminars.index') }}" class="nav-item {{ request()->is('seminars*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i>
                <span>Seminars</span>
            </a>
        </div>

        <div class="nav-section">
            <p class="section-title">System</p>
            <a href="{{ route('settings') }}" class="nav-item {{ request()->is('settings*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="user-pill">
            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=6366f1&color=fff" alt="User">
            <span class="user-name">{{ auth()->user()->name }}</span>
        </div>
    </div>
</aside>