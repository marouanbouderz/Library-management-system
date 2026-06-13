<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Portal') — Library</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"','sans-serif'] }, colors: { emerald: { 50:'rgba(46,158,107,0.08)', 100:'rgba(46,158,107,0.12)', 200:'rgba(46,158,107,0.22)', 300:'#82c9a8', 400:'#52b68a', 500:'#2E9E6B', 600:'#2E9E6B', 700:'#1d7a53', 800:'#155c3f' }, indigo: { 50:'rgba(79,111,205,0.08)', 100:'rgba(79,111,205,0.12)', 200:'rgba(79,111,205,0.22)', 500:'#4F6FCD', 600:'#4F6FCD', 700:'#3b5bcf' }, cyan: { 50:'rgba(139,92,246,0.06)', 100:'rgba(139,92,246,0.10)', 400:'#a78bfa', 500:'#8B5CF6', 600:'#8B5CF6' } } } } }</script>
    <style>
        /* ─── Shared Design Tokens ─── */
        :root {
            --sidebar-bg:      #0b2d1e;
            --sidebar-border:  #164d32;
            --sidebar-text:    #7fc4a0;
            --green:           #2E9E6B;
            --green-bg:        rgba(46,158,107,0.18);
            --green-bg-hover:  rgba(46,158,107,0.10);
            --gold:            #C9A84C;
            --page-bg:         #F4F6FA;
            --topbar-border:   #E8EDF2;
            --card-shadow:     0 2px 12px rgba(0,0,0,0.06);
            --card-radius:     14px;
            --c-danger:  #DC2626;
            --c-warning: #D97706;
            --c-success: #059669;
        }

        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        body { background: var(--page-bg); }

        .sidebar-scroll::-webkit-scrollbar { width: 3px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #2A2D3E; border-radius: 2px; }

        .nav-section {
            font-size: 10px; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            color: rgba(127,196,160,0.5);
            padding: 16px 16px 5px;
        }
        .nav-divider { height: 1px; background: var(--sidebar-border); margin: 8px 12px; }

        .lib-card { background: #fff; border-radius: var(--card-radius); box-shadow: var(--card-shadow); }

        /* DataTables */
        .dataTables_wrapper { padding: 0; }
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter { margin-bottom: 14px; }
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: #6B7280; font-weight: 500;
        }
        .dataTables_wrapper .dataTables_length select {
            border: 1.5px solid #E8EDF2; border-radius: 8px;
            padding: 6px 10px; font-size: 13px; color: #374151;
            background: #fff; cursor: pointer; outline: none; transition: border-color 0.2s;
        }
        .dataTables_wrapper .dataTables_length select:focus { border-color: var(--green); }
        .dataTables_wrapper .dataTables_filter input {
            border: 1.5px solid #E8EDF2; border-radius: 10px;
            padding: 7px 14px 7px 36px; font-size: 13px; color: #374151;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 11px center;
            outline: none; transition: border-color 0.2s, box-shadow 0.2s; min-width: 200px;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--green); box-shadow: 0 0 0 3px rgba(46,158,107,0.12);
        }
        .dataTables_wrapper .dataTables_info {
            font-size: 13px; color: #6B7280; font-weight: 500; padding-top: 12px;
        }
        .dataTables_wrapper .dataTables_paginate { padding-top: 12px; }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 6px !important; margin: 0 2px; padding: 4px 10px !important; font-size: 12px !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--green) !important; color: white !important; border-color: var(--green) !important; font-weight: 700;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
            background: rgba(46,158,107,0.12) !important; color: var(--green) !important; border-color: transparent !important;
        }
        table.dataTable tbody tr { border-left: 3px solid transparent; }
        table.dataTable tbody tr:hover { border-left-color: var(--green) !important; background-color: #f0fdf4 !important; }

        /* Status badges */
        .badge-pending  { background: #FEF3C7; color: #92400E; font-weight: 700; }
        .badge-active   { background: #D1FAE5; color: #065F46; font-weight: 700; }
        .badge-returned { background: #DBEAFE; color: #1E40AF; font-weight: 700; }
        .badge-rejected { background: #FEE2E2; color: #991B1B; font-weight: 700; }

        /* ─── Form inputs ─── */
        .lib-input { border: 1.5px solid #E8EDF2; border-radius: 10px; padding: 10px 14px; font-size: 14px; color: #1C1F2E; background: #fff; width: 100%; transition: border-color .2s, box-shadow .2s; }
        .lib-input:focus { outline: none; border-color: var(--gold) !important; box-shadow: 0 0 0 3px rgba(201,168,76,0.18) !important; }
        .lib-input:hover:not(:focus) { border-color: #C9A84C88; }

        /* ─── Modern Select ─── */
        .lib-select {
            appearance: none; -webkit-appearance: none;
            background-color: #fff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%238B93A7' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 14px;
            border: 1.5px solid #E8EDF2;
            border-radius: 10px;
            padding: 10px 40px 10px 40px;
            font-size: 14px;
            color: #1C1F2E;
            width: 100%;
            cursor: pointer;
            transition: border-color .2s, box-shadow .2s;
        }
        .lib-select:focus { outline: none; border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,0.18); }
        .lib-select:hover:not(:focus) { border-color: #C9A84C88; }
        .lib-select option { color: #1C1F2E; background: #fff; }
    </style>
</head>
<body style="background:var(--page-bg);">

{{-- 3px accent bar (forest green) --}}
<div style="height:3px; background:var(--green); position:fixed; top:0; left:0; right:0; z-index:9999;"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(Session::has('mess'))
        swal("Success!", "Operation completed successfully!", "success");
    @endif
    @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        var msg = "{{ Session::get('message') }}";
        if (type === 'success') toastr.success(msg);
        else if (type === 'error') toastr.error(msg);
        else if (type === 'warning') toastr.warning(msg);
        else toastr.info(msg);
    @endif
    if ($('#dataTable').length && !$('#dataTable tbody td[colspan]').length) {
        $('#dataTable').DataTable({ pageLength: 10, lengthMenu: [[5,10,25,-1],[5,10,25,'All']] });
    }
});
</script>

<div class="flex h-screen overflow-hidden pt-[3px]" x-data>

    {{-- ===================== SIDEBAR ===================== --}}
    <aside class="fixed inset-y-0 left-0 z-40 w-64 flex flex-col sidebar-scroll overflow-y-auto"
           style="background:var(--sidebar-bg); padding-top:3px;">

        {{-- Brand --}}
        <div class="flex items-center gap-3 px-5 py-5" style="border-bottom:1px solid var(--sidebar-border);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg"
                 style="background:linear-gradient(135deg,#2E9E6B,#4ade80);">
                <i class="fas fa-book-open text-white text-sm"></i>
            </div>
            <div>
                <p class="text-white font-extrabold text-sm leading-none">Library</p>
                <p class="text-[11px] mt-0.5" style="color:rgba(127,196,160,0.55);">Student Portal</p>
            </div>
        </div>

        {{-- Student chip --}}
        @foreach($student as $s)
        <div class="mx-3 my-3 flex items-center gap-3 px-3 py-2.5 rounded-xl"
             style="background:rgba(46,158,107,0.12); border:1px solid rgba(46,158,107,0.25);">
            <img src="{{ asset($s->Image ?: 'image/default.svg') }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0"
                 style="border:2px solid #2E9E6B;" alt="{{ $s->Name }}" onerror="this.src='{{ asset('image/default.svg') }}'">
            <div class="min-w-0">
                <p class="text-white text-sm font-bold truncate">{{ $s->Name }}</p>
                <p class="text-[11px] font-mono truncate" style="color:rgba(127,196,160,0.6);">{{ $s->Student_ID }}</p>
            </div>
        </div>
        @endforeach

        {{-- Navigation --}}
        <nav class="flex-1 pb-4">

            <p class="nav-section">Principal</p>

            @php
                function sNavItem($url, $icon, $label, $active, $badge = false) {
                    $style  = $active ? 'background:rgba(46,158,107,0.22); color:#4ade80; box-shadow:inset 3px 0 0 #2E9E6B;' : 'color:#7fc4a0;';
                    $iconBg = $active ? 'background:rgba(46,158,107,0.3);' : 'background:rgba(255,255,255,0.06);';
                    $over   = $active ? '' : "this.style.background='rgba(46,158,107,0.12)'; this.style.color='#4ade80'; this.style.boxShadow='inset 3px 0 0 #2E9E6B';";
                    $out    = $active ? '' : "this.style.background=''; this.style.color='#7fc4a0'; this.style.boxShadow='';";
                    $bHtml  = $badge ? "<span class='ml-auto text-[10px] font-bold px-1.5 py-0.5 rounded-full hidden' id='student_notify_number' style='background:#D97706; color:#fff;'></span>" : '';
                    return "<a href='{$url}' class='flex items-center gap-3 mx-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 mb-0.5' style='{$style}' onmouseover=\"{$over}\" onmouseout=\"{$out}\">
                        <span class='w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 text-sm' style='{$iconBg}'><i class='fas {$icon}'></i></span>
                        <span>{$label}</span>{$bHtml}</a>";
                }
            @endphp

            {!! sNavItem(url('student/dashboard'), 'fa-gauge-high', 'Tableau de bord', request()->is('student/dashboard')) !!}
            {!! sNavItem(url('student/notification'), 'fa-bell', 'Notifications', request()->is('student/notification'), true) !!}

            <div class="nav-divider"></div>
            <p class="nav-section">Bibliothèque</p>

            {!! sNavItem(url('student/catalogue'), 'fa-hand-holding-medical', 'Emprunter un livre', request()->is('student/catalogue')) !!}

            {{-- Book List dropdown --}}
            <div class="mx-3 mb-0.5" x-data="{ open: {{ request()->is('student/book-list/*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200"
                        style="color:#7fc4a0;"
                        onmouseover="this.style.background='rgba(46,158,107,0.12)'; this.style.color='#4ade80'; this.style.boxShadow='inset 3px 0 0 #2E9E6B';"
                        onmouseout="this.style.background=''; this.style.color='#7fc4a0'; this.style.boxShadow='';">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 text-sm" style="background:rgba(255,255,255,0.06);">
                        <i class="fas fa-book-open"></i>
                    </span>
                    <span>Catalogue</span>
                    <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-transition class="mt-1 ml-5 pl-3 space-y-0.5"
                     style="border-left:2px solid rgba(46,158,107,0.4);">
                    @foreach([['programming','fa-code','Programmation'],['networking','fa-network-wired','Réseaux'],['database','fa-database','Bases de données'],['electronics','fa-microchip','Électronique'],['software-development','fa-laptop-code','Dev. Logiciel'],['civile','fa-drafting-compass','Génie Civil']] as $cat)
                    @php $a = request()->is('student/book-list/'.$cat[0]); @endphp
                    <a href="{{ url('student/book-list/'.$cat[0]) }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all duration-150"
                       style="{{ $a ? 'color:#4ade80; background:rgba(46,158,107,0.2);' : 'color:#7fc4a0;' }}"
                       onmouseover="{{ $a ? '' : "this.style.color='#4ade80'; this.style.background='rgba(46,158,107,0.12)';" }}"
                       onmouseout="{{ $a ? '' : "this.style.color='#7fc4a0'; this.style.background='';" }}">
                        <i class="fas {{ $cat[1] }} text-[10px] w-3 text-center"></i> {{ $cat[2] }}
                    </a>
                    @endforeach
                </div>
            </div>

            {!! sNavItem(url('student/shelf-list'), 'fa-layer-group', 'Liste des rayons', request()->is('student/shelf-list*')) !!}

            <div class="nav-divider"></div>
            <p class="nav-section">Mes livres</p>

            {!! sNavItem(url('student/my-collection'), 'fa-bookmark', 'Mes emprunts', request()->is('student/my-collection')) !!}
            {!! sNavItem(url('student/my-submission'), 'fa-rotate-left', 'Mes retours', request()->is('student/my-submission')) !!}
            {!! sNavItem(url('student/borrow-history'), 'fa-clock-rotate-left', 'Historique', request()->is('student/borrow-history')) !!}
            {!! sNavItem(url('student/fines'), 'fa-triangle-exclamation', 'Amendes', request()->is('student/fines')) !!}

            <div class="nav-divider"></div>
            <p class="nav-section">Mon compte</p>

            {{-- Settings dropdown --}}
            <div class="mx-3 mb-0.5" x-data="{ open: {{ request()->is('student/edit-info') || request()->is('student/change-password') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200"
                        style="color:#7fc4a0;"
                        onmouseover="this.style.background='rgba(46,158,107,0.12)'; this.style.color='#4ade80'; this.style.boxShadow='inset 3px 0 0 #2E9E6B';"
                        onmouseout="this.style.background=''; this.style.color='#7fc4a0'; this.style.boxShadow='';">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 text-sm" style="background:rgba(255,255,255,0.06);">
                        <i class="fas fa-cog"></i>
                    </span>
                    <span>Paramètres</span>
                    <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-transition class="mt-1 ml-5 pl-3 space-y-0.5"
                     style="border-left:2px solid rgba(46,158,107,0.4);">
                    @foreach([['student/edit-info','fa-user-pen','Modifier le profil'],['student/change-password','fa-lock','Mot de passe']] as $item)
                    @php $a = request()->is($item[0]); @endphp
                    <a href="{{ url($item[0]) }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all duration-150"
                       style="{{ $a ? 'color:#4ade80; background:rgba(46,158,107,0.2);' : 'color:#7fc4a0;' }}"
                       onmouseover="{{ $a ? '' : "this.style.color='#4ade80'; this.style.background='rgba(46,158,107,0.12)';" }}"
                       onmouseout="{{ $a ? '' : "this.style.color='#7fc4a0'; this.style.background='';" }}">
                        <i class="fas {{ $item[1] }} text-[10px] w-3 text-center"></i> {{ $item[2] }}
                    </a>
                    @endforeach
                </div>
            </div>

        </nav>

        {{-- Log Out --}}
        <div class="px-3 pb-4 pt-2" style="border-top:1px solid var(--sidebar-border);">
            <a href="{{ url('student/log-out') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200"
               style="color:#E05252;"
               onmouseover="this.style.background='rgba(224,82,82,0.1)'; this.style.color='#fca5a5';"
               onmouseout="this.style.background=''; this.style.color='#E05252';">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(224,82,82,0.1);">
                    <i class="fas fa-right-from-bracket text-sm"></i>
                </span>
                <span>Log Out</span>
            </a>
        </div>

    </aside>
    {{-- ==================== END SIDEBAR ==================== --}}

    <div class="flex-1 flex flex-col ml-64 min-h-screen overflow-auto">

        <header class="bg-white sticky top-0 z-30 px-8 py-4 flex items-center justify-between"
                style="border-bottom:1px solid var(--topbar-border);">
            <div>
                <h1 class="text-base font-extrabold" style="color:#1C1F2E;">@yield('title', 'Student Portal')</h1>
                <p class="text-xs font-medium" style="color:#6B7280;">Library Management System</p>
            </div>
            <div class="flex items-center gap-3">
                @foreach($student as $s)
                <span class="text-sm font-semibold" style="color:#374151;">{{ $s->Name }}</span>
                <img src="{{ asset($s->Image ?: 'image/default.svg') }}" class="w-8 h-8 rounded-full object-cover"
                     style="border:2px solid var(--green);" alt="" onerror="this.src='{{ asset('image/default.svg') }}'">
                @endforeach
            </div>
        </header>

        <main class="flex-1 p-8" style="background:var(--page-bg);">
            @yield('content')
        </main>
    </div>
</div>

<script>
setInterval(function() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var el = document.getElementById('student_notify_number');
            if (el) {
                var count = parseInt(this.responseText);
                el.innerText = count > 0 ? count : '';
                el.classList.toggle('hidden', count <= 0);
            }
        }
    };
    xhttp.open("GET", "{{ url('student/notify/count/') }}", true);
    xhttp.send();
}, 3000);
</script>
@yield('scripts')
</body>
</html>
