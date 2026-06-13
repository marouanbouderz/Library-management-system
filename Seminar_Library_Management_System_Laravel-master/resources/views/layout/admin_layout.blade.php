<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tableau de bord') — Bibliothèque Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: {
                        emerald: { 50:'rgba(46,158,107,0.08)', 100:'rgba(46,158,107,0.12)', 200:'rgba(46,158,107,0.22)', 300:'#82c9a8', 400:'#52b68a', 500:'#2E9E6B', 600:'#2E9E6B', 700:'#1d7a53', 800:'#155c3f' },
                        indigo:  { 50:'rgba(79,111,205,0.08)', 100:'rgba(79,111,205,0.12)', 200:'rgba(79,111,205,0.22)', 500:'#4F6FCD', 600:'#4F6FCD', 700:'#3b5bcf' },
                        violet:  { 50:'rgba(139,92,246,0.08)', 100:'rgba(139,92,246,0.12)', 500:'#8B5CF6', 600:'#8B5CF6', 700:'#7c3aed' },
                        orange:  { 50:'rgba(224,123,57,0.08)', 100:'rgba(224,123,57,0.12)', 500:'#E07B39', 600:'#E07B39', 700:'#c4692a' }
                    }
                }
            }
        }
    </script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
        /* ─── Design Tokens ─── */
        :root {
            --sidebar-bg:         #0b2d1e;
            --sidebar-border:     #164d32;
            --sidebar-text:       #7fc4a0;
            --gold:               #C9A84C;
            --gold-bg:            rgba(201,168,76,0.12);
            --gold-bg-hover:      rgba(201,168,76,0.07);
            --page-bg:            #F4F6FA;
            --topbar-border:      #E8EDF2;
            --card-shadow:        0 2px 12px rgba(0,0,0,0.06);
            --card-radius:        14px;
            /* Section accents */
            --c-students:  #4F6FCD;
            --c-books:     #2E9E6B;
            --c-shelves:   #8B5CF6;
            --c-orders:    #E07B39;
            --c-danger:    #DC2626;
            --c-success:   #059669;
            --c-warning:   #D97706;
        }

        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }

        body { background: var(--page-bg); }

        /* ─── Sidebar scrollbar ─── */
        .sidebar-scroll::-webkit-scrollbar { width: 3px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #164d32; border-radius: 2px; }

        /* ─── Section labels ─── */
        .nav-section {
            font-size: 10px; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            color: rgba(127,196,160,0.5);
            padding: 16px 16px 5px;
        }
        .nav-divider {
            height: 1px; background: var(--sidebar-border);
            margin: 8px 12px;
        }

        /* ─── Cards ─── */
        .lib-card {
            background: #fff;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
        }

        /* ─── Buttons ─── */
        .btn-primary { background: var(--c-students) !important; color: #fff; border-radius: 8px; padding: 10px 22px; font-weight: 700; transition: filter .2s; }
        .btn-primary:hover { filter: brightness(1.1); }
        .btn-books   { background: var(--c-books)   !important; color: #fff; border-radius: 8px; padding: 10px 22px; font-weight: 700; transition: filter .2s; }
        .btn-books:hover   { filter: brightness(1.1); }
        .btn-shelves { background: var(--c-shelves) !important; color: #fff; border-radius: 8px; padding: 10px 22px; font-weight: 700; transition: filter .2s; }
        .btn-shelves:hover { filter: brightness(1.1); }
        .btn-orders  { background: var(--c-orders)  !important; color: #fff; border-radius: 8px; padding: 10px 22px; font-weight: 700; transition: filter .2s; }
        .btn-orders:hover  { filter: brightness(1.1); }
        .btn-danger  { background: var(--c-danger)  !important; color: #fff; border-radius: 8px; padding: 10px 22px; font-weight: 700; transition: filter .2s; }
        .btn-danger:hover  { filter: brightness(1.1); }
        .btn-success { background: var(--c-success) !important; color: #fff; border-radius: 8px; padding: 10px 22px; font-weight: 700; transition: filter .2s; }
        .btn-success:hover { filter: brightness(1.1); }

        /* ─── Status Badges ─── */
        .badge-pending  { background: #FEF3C7 !important; color: #92400E !important; font-weight: 700; }
        .badge-active   { background: #D1FAE5 !important; color: #065F46 !important; font-weight: 700; }
        .badge-returned { background: #DBEAFE !important; color: #1E40AF !important; font-weight: 700; }
        .badge-rejected { background: #FEE2E2 !important; color: #991B1B !important; font-weight: 700; }

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
        .lib-select option { color: #1C1F2E; background: #fff; padding: 8px; }
        /* Styled select wrapper (optional) */
        .select-wrap { position: relative; }
        .select-wrap::before {
            content: '';
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            width: 20px; height: 20px;
            background: rgba(201,168,76,0.12);
            border-radius: 6px;
            pointer-events: none;
        }

        /* ─── DataTables layout ─── */
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
            background: #fff; cursor: pointer; outline: none;
            transition: border-color 0.2s;
        }
        .dataTables_wrapper .dataTables_length select:focus { border-color: var(--gold); }
        .dataTables_wrapper .dataTables_filter input {
            border: 1.5px solid #E8EDF2; border-radius: 10px;
            padding: 7px 14px 7px 36px; font-size: 13px; color: #374151;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 11px center;
            outline: none; transition: border-color 0.2s, box-shadow 0.2s; min-width: 200px;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,0.12);
        }
        .dataTables_wrapper .dataTables_info {
            font-size: 13px; color: #6B7280; font-weight: 500; padding-top: 12px;
        }
        /* ─── DataTables pagination ─── */
        .dataTables_wrapper .dataTables_paginate { padding-top: 12px; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--gold) !important; color: #1C1F2E !important;
            border-radius: 6px; border: none !important; font-weight: 700;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: rgba(201,168,76,0.14) !important; color: var(--gold) !important;
            border-radius: 6px; border: none !important;
        }

        /* ─── Table row hover — gold left accent ─── */
        table.dataTable tbody tr {
            border-left: 3px solid transparent;
            transition: border-color 0.15s, background-color 0.15s;
        }
        table.dataTable tbody tr:hover {
            border-left-color: var(--gold) !important;
            background-color: #FAFBFF !important;
        }

        /* ─── Dashboard table (non-DataTable) ─── */
        .lib-table tbody tr {
            border-left: 3px solid transparent;
            transition: border-color 0.15s, background-color 0.15s;
        }
        .lib-table tbody tr:hover {
            border-left-color: var(--gold) !important;
            background-color: #FAFBFF !important;
        }
    </style>
</head>

<body style="background:var(--page-bg); font-family:'Plus Jakarta Sans',sans-serif;">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(Session::has('mess'))
            swal("Done!", "Successfully Approved!", "success");
        @endif
        @if(Session::has('mess2'))
            swal("Done!", "Successfully Rejected!", "success");
        @endif
        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type) {
                case 'info':    toastr.info("{{ Session::get('message') }}");    break;
                case 'success': toastr.success("{{ Session::get('message') }}"); break;
                case 'warning': toastr.warning("{{ Session::get('message') }}"); break;
                case 'error':   toastr.error("{{ Session::get('message') }}");   break;
            }
        @endif
    });
</script>

{{-- 3px gold accent top bar --}}
<div style="height:3px; background:var(--gold); position:fixed; top:0; left:0; right:0; z-index:9999;"></div>

<div class="flex h-screen overflow-hidden pt-[3px]">

    {{-- ===================== SIDEBAR ===================== --}}
    <aside class="w-64 flex flex-col fixed h-full z-30" style="background:var(--sidebar-bg);" x-data>

        {{-- Brand --}}
        <div class="flex items-center gap-3 px-5 py-5" style="border-bottom:1px solid var(--sidebar-border);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg"
                 style="background:linear-gradient(135deg,#2E9E6B,#4ade80);">
                <i class="fas fa-book-open text-white text-sm"></i>
            </div>
            <div>
                <p class="font-extrabold text-sm text-white leading-none">Bibliothèque Admin</p>
                <p class="text-[11px] mt-0.5" style="color:rgba(127,196,160,0.55);">Management System</p>
            </div>
        </div>

        {{-- Admin chip --}}
        <div class="mx-3 my-3 flex items-center gap-3 px-3 py-2.5 rounded-xl"
             style="background:rgba(46,158,107,0.12); border:1px solid rgba(46,158,107,0.25);">
            <div class="relative flex-shrink-0">
                <img src="{{ asset('image/admin.png') }}" class="w-9 h-9 rounded-full object-cover"
                     style="border:2px solid #2E9E6B;" alt="Admin">
                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-400 rounded-full"
                      style="border:1.5px solid #0b2d1e;"></span>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-bold text-white leading-tight truncate">Admin</p>
                <p class="text-[11px] truncate" style="color:rgba(127,196,160,0.6);">CSE · Administrator</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto sidebar-scroll pb-4">

            <p class="nav-section">Principal</p>

            @php
                function navItem($url, $icon, $label, $active, $badge = null) {
                    $style  = $active ? 'background:rgba(46,158,107,0.22); color:#4ade80; box-shadow:inset 3px 0 0 #2E9E6B;' : 'color:#7fc4a0;';
                    $iconBg = $active ? 'background:rgba(46,158,107,0.3);' : 'background:rgba(255,255,255,0.06);';
                    $over   = $active ? '' : "this.style.background='rgba(46,158,107,0.12)'; this.style.color='#4ade80'; this.style.boxShadow='inset 3px 0 0 #2E9E6B';";
                    $out    = $active ? '' : "this.style.background=''; this.style.color='#7fc4a0'; this.style.boxShadow='';";
                    $bHtml  = $badge !== null ? "<span class='ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full hidden' id='notify_number' style='background:#D97706; color:#fff;'></span>" : '';
                    return "<a href='{$url}' class='flex items-center gap-3 mx-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 mb-0.5' style='{$style}' onmouseover=\"{$over}\" onmouseout=\"{$out}\">
                        <span class='w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 text-sm' style='{$iconBg}'><i class='fas {$icon}'></i></span>
                        <span>{$label}</span>{$bHtml}</a>";
                }
            @endphp

            {!! navItem(url('admin/dashboard'), 'fa-gauge-high', 'Tableau de bord', request()->is('admin/dashboard')) !!}
            {!! navItem(url('admin/notification'), 'fa-bell', 'Notifications', request()->is('admin/notification'), true) !!}

            <div class="nav-divider"></div>
            <p class="nav-section">Bibliothèque</p>

            {{-- Catalogue dropdown --}}
            <div class="mx-3 mb-0.5" x-data="{ open: {{ request()->is('admin/programming-book','admin/networking-book','admin/database-book','admin/electronics-book','admin/software-book','admin/civile-book') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200"
                        style="color:#8B93A7;"
                        onmouseover="this.style.background='rgba(46,158,107,0.12)'; this.style.color='#4ade80'; this.style.boxShadow='inset 3px 0 0 #2E9E6B';"
                        onmouseout="this.style.background=''; this.style.color='#7fc4a0'; this.style.boxShadow='';">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 text-sm" style="background:rgba(255,255,255,0.06);">
                        <i class="fas fa-book-open"></i>
                    </span>
                    <span>Catalogue</span>
                    <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak x-transition class="mt-1 ml-5 pl-3 space-y-0.5"
                     style="border-left:2px solid rgba(46,158,107,0.4);">
                    @foreach([['programming-book','fa-code','Programmation'],['networking-book','fa-network-wired','Réseaux'],['database-book','fa-database','Bases de données'],['electronics-book','fa-microchip','Électronique'],['software-book','fa-laptop-code','Dev. Logiciel'],['civile-book','fa-drafting-compass','Génie Civil']] as $cat)
                    @php $a = request()->is('admin/'.$cat[0]); @endphp
                    <a href="{{ url('admin/'.$cat[0]) }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all duration-150"
                       style="{{ $a ? 'color:#4ade80; background:rgba(46,158,107,0.2);' : 'color:#7fc4a0;' }}"
                       onmouseover="{{ $a ? '' : "this.style.color='#4ade80'; this.style.background='rgba(46,158,107,0.12)';" }}"
                       onmouseout="{{ $a ? '' : "this.style.color='#7fc4a0'; this.style.background='';" }}">
                        <i class="fas {{ $cat[1] }} text-[10px] w-3 text-center"></i> {{ $cat[2] }}
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Book Management dropdown --}}
            <div class="mx-3 mb-0.5" x-data="{ open: {{ request()->is('admin/add-book','admin/update-book','admin/remove-book') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200"
                        style="color:#8B93A7;"
                        onmouseover="this.style.background='rgba(46,158,107,0.12)'; this.style.color='#4ade80'; this.style.boxShadow='inset 3px 0 0 #2E9E6B';"
                        onmouseout="this.style.background=''; this.style.color='#7fc4a0'; this.style.boxShadow='';">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 text-sm" style="background:rgba(255,255,255,0.06);">
                        <i class="fas fa-pen-to-square"></i>
                    </span>
                    <span>Gestion des livres</span>
                    <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak x-transition class="mt-1 ml-5 pl-3 space-y-0.5"
                     style="border-left:2px solid rgba(46,158,107,0.4);">
                    @foreach([['admin/add-book','fa-plus','Ajouter un livre'],['admin/update-book','fa-rotate','Modifier un livre'],['admin/remove-book','fa-trash','Supprimer un livre']] as $item)
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

            {!! navItem(url('admin/shelf-list'), 'fa-layer-group', 'Liste des rayons', request()->is('admin/shelf-list')) !!}

            {{-- Shelf Management dropdown --}}
            <div class="mx-3 mb-0.5" x-data="{ open: {{ request()->is('admin/add-shelf','admin/update-shelf','admin/remove-shelf') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200"
                        style="color:#8B93A7;"
                        onmouseover="this.style.background='rgba(46,158,107,0.12)'; this.style.color='#4ade80'; this.style.boxShadow='inset 3px 0 0 #2E9E6B';"
                        onmouseout="this.style.background=''; this.style.color='#7fc4a0'; this.style.boxShadow='';">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 text-sm" style="background:rgba(255,255,255,0.06);">
                        <i class="fas fa-boxes-stacked"></i>
                    </span>
                    <span>Gestion des rayons</span>
                    <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak x-transition class="mt-1 ml-5 pl-3 space-y-0.5"
                     style="border-left:2px solid rgba(46,158,107,0.4);">
                    @foreach([['admin/add-shelf','fa-plus','Ajouter un rayon'],['admin/update-shelf','fa-rotate','Modifier un rayon'],['admin/remove-shelf','fa-trash','Supprimer un rayon']] as $item)
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

            <div class="nav-divider"></div>
            <p class="nav-section">Emprunts</p>

            {!! navItem(url('admin/book-order'), 'fa-cart-shopping', 'Gestion emprunts', request()->is('admin/book-order')) !!}
            {!! navItem(url('admin/book-received'), 'fa-circle-check', 'Livres retournés', request()->is('admin/book-received')) !!}
            {!! navItem(url('admin/fines'), 'fa-triangle-exclamation', 'Amendes', request()->is('admin/fines')) !!}

            <div class="nav-divider"></div>
            <p class="nav-section">Étudiants</p>

            {!! navItem(url('admin/student-info'), 'fa-user-graduate', 'Fiche étudiant', request()->is('admin/student-info')) !!}
            {!! navItem(url('admin/student-request'), 'fa-comments', 'Demandes', request()->is('admin/student-request')) !!}
            {!! navItem(url('admin/remove-student'), 'fa-user-minus', 'Supprimer étudiant', request()->is('admin/remove-student')) !!}

            <div class="nav-divider"></div>
            <p class="nav-section">Mon compte</p>

            {{-- Settings dropdown --}}
            <div class="mx-3 mb-0.5" x-data="{ open: {{ request()->is('admin/edit-info','admin/change-password') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200"
                        style="color:#8B93A7;"
                        onmouseover="this.style.background='rgba(46,158,107,0.12)'; this.style.color='#4ade80'; this.style.boxShadow='inset 3px 0 0 #2E9E6B';"
                        onmouseout="this.style.background=''; this.style.color='#7fc4a0'; this.style.boxShadow='';">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 text-sm" style="background:rgba(255,255,255,0.06);">
                        <i class="fas fa-gear"></i>
                    </span>
                    <span>Paramètres</span>
                    <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak x-transition class="mt-1 ml-5 pl-3 space-y-0.5"
                     style="border-left:2px solid rgba(46,158,107,0.4);">
                    @foreach([['admin/edit-info','fa-user-pen','Modifier le profil'],['admin/change-password','fa-lock','Mot de passe']] as $item)
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
            <a href="{{ url('admin/log-out') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200"
               style="color:#E05252;"
               onmouseover="this.style.background='rgba(224,82,82,0.1)'; this.style.color='#fca5a5';"
               onmouseout="this.style.background=''; this.style.color='#E05252';">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 text-sm" style="background:rgba(224,82,82,0.1);">
                    <i class="fas fa-right-from-bracket"></i>
                </span>
                <span>Déconnexion</span>
            </a>
        </div>

    </aside>
    {{-- ==================== END SIDEBAR ==================== --}}

    <div class="flex-1 flex flex-col ml-64 min-h-screen overflow-hidden">

        {{-- Topbar --}}
        <header class="bg-white sticky top-0 z-20 px-8 py-4 flex items-center justify-between"
                style="border-bottom:1px solid var(--topbar-border);">
            <div>
                <h1 class="text-lg font-extrabold" style="color:#1C1F2E;">@yield('title', 'Tableau de bord')</h1>
                <p class="text-xs font-medium mt-0.5" style="color:#6B7280;">Système de Gestion de Bibliothèque</p>
            </div>
            <div class="flex items-center gap-5">
                <a href="{{ url('admin/notification') }}"
                   class="relative transition-colors duration-200" style="color:#8B93A7;"
                   onmouseover="this.style.color='#4F6FCD';" onmouseout="this.style.color='#8B93A7';">
                    <i class="fas fa-bell text-xl"></i>
                    <span id="notify_badge"
                          class="absolute -top-1.5 -right-1.5 text-white text-[9px] font-bold w-4 h-4 rounded-full items-center justify-center hidden"
                          style="background:#DC2626;"></span>
                </a>
                <div class="flex items-center gap-2.5 pl-5" style="border-left:1px solid var(--topbar-border);">
                    <img src="{{ asset('image/admin.png') }}" class="w-9 h-9 rounded-full object-cover"
                         style="border:2px solid var(--gold);" alt="Admin">
                    <div>
                        <p class="text-sm font-bold leading-tight" style="color:#1C1F2E;">Admin</p>
                        <p class="text-xs" style="color:#6B7280;">Administrator</p>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8" style="background:var(--page-bg);">
            @yield('content')
        </main>

    </div>
</div>

<script>
    $(document).ready(function () {
        if ($('#dataTable').length && !$('#dataTable tbody td[colspan]').length) {
            $('#dataTable').DataTable({ pageLength: 10, lengthMenu: [[5,10,20,-1],[5,10,20,'All']] });
        }
    });
    (function poll() {
        setInterval(function () {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var n = parseInt(this.responseText.trim()) || 0;
                    var el = document.getElementById('notify_number');
                    var badge = document.getElementById('notify_badge');
                    if (el)    { el.textContent = n; el.classList.toggle('hidden', n === 0); }
                    if (badge) { badge.textContent = n > 9 ? '9+' : n; badge.classList.toggle('hidden', n === 0); badge.classList.toggle('flex', n > 0); }
                }
            };
            xhr.open('GET', '{{ Url("admin/notify/count/") }}', true);
            xhr.send();
        }, 3000);
    })();
</script>
@yield('scripts')
</body>
</html>
