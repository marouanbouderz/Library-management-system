@extends('layout.admin_layout')
@section('title', 'Dashboard')
@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-7">

    {{-- Total Étudiants --}}
    <div class="lib-card p-6 hover:-translate-y-0.5 transition-all duration-300 cursor-default relative overflow-hidden">
        <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-[14px]" style="background:#4F6FCD;"></div>
        <div class="flex items-start justify-between mb-5">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(79,111,205,0.1);">
                <i class="fas fa-user-graduate text-xl" style="color:#4F6FCD;"></i>
            </div>
            @if($pending_students > 0)
            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full"
                  style="background:#FEF3C7; color:#92400E;">
                <i class="fas fa-clock text-[9px]"></i> {{ $pending_students }} en attente
            </span>
            @else
            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full"
                  style="background:#D1FAE5; color:#065F46;">
                <i class="fas fa-check text-[9px]"></i> Tous approuvés
            </span>
            @endif
        </div>
        <p class="leading-none mb-1" style="font-size:2rem; font-weight:800; color:#1C1F2E;">{{ $total_student }}</p>
        <p class="text-sm font-medium" style="color:#6B7280;">Total Étudiants</p>
        <div class="flex items-center justify-between mt-1 mb-1.5">
            <span class="text-[11px]" style="color:#9CA3AF;">{{ $students_borrowing }} empruntent actuellement</span>
            <span class="text-[11px] font-bold" style="color:#4F6FCD;">{{ $student_bar }}%</span>
        </div>
        <div class="h-1.5 rounded-full overflow-hidden" style="background:#E8EDF2;">
            <div class="h-full rounded-full transition-all duration-700" style="width:{{ $student_bar }}%; background:#4F6FCD;"></div>
        </div>
    </div>

    {{-- Total Livres --}}
    <div class="lib-card p-6 hover:-translate-y-0.5 transition-all duration-300 cursor-default relative overflow-hidden">
        <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-[14px]" style="background:#2E9E6B;"></div>
        <div class="flex items-start justify-between mb-5">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(46,158,107,0.1);">
                <i class="fas fa-book-open text-xl" style="color:#2E9E6B;"></i>
            </div>
            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full"
                  style="background:#D1FAE5; color:#065F46;">
                <i class="fas fa-bookmark text-[9px]"></i> {{ $borrowed_books }} borrowed
            </span>
        </div>
        <p class="leading-none mb-1" style="font-size:2rem; font-weight:800; color:#1C1F2E;">{{ $total_book }}</p>
        <p class="text-sm font-medium" style="color:#6B7280;">Total Livres</p>
        <div class="flex items-center justify-between mt-1 mb-1.5">
            <span class="text-[11px]" style="color:#9CA3AF;">{{ $book_bar }}% utilisation</span>
            <span class="text-[11px] font-bold" style="color:#2E9E6B;">{{ $total_book - $borrowed_books }} disponible</span>
        </div>
        <div class="h-1.5 rounded-full overflow-hidden" style="background:#E8EDF2;">
            <div class="h-full rounded-full transition-all duration-700" style="width:{{ $book_bar }}%; background:#2E9E6B;"></div>
        </div>
    </div>

    {{-- Total Rayons --}}
    <div class="lib-card p-6 hover:-translate-y-0.5 transition-all duration-300 cursor-default relative overflow-hidden">
        <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-[14px]" style="background:#8B5CF6;"></div>
        <div class="flex items-start justify-between mb-5">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(139,92,246,0.1);">
                <i class="fas fa-layer-group text-xl" style="color:#8B5CF6;"></i>
            </div>
            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full"
                  style="background:#EDE9FE; color:#5B21B6;">
                <i class="fas fa-database text-[9px]"></i> {{ $active_shelves }} stockés
            </span>
        </div>
        <p class="leading-none mb-1" style="font-size:2rem; font-weight:800; color:#1C1F2E;">{{ $total_shelf }}</p>
        <p class="text-sm font-medium" style="color:#6B7280;">Total Rayons</p>
        <div class="flex items-center justify-between mt-1 mb-1.5">
            <span class="text-[11px]" style="color:#9CA3AF;">{{ $total_shelf - $active_shelves }} vide</span>
            <span class="text-[11px] font-bold" style="color:#8B5CF6;">{{ $shelf_bar }}%</span>
        </div>
        <div class="h-1.5 rounded-full overflow-hidden" style="background:#E8EDF2;">
            <div class="h-full rounded-full transition-all duration-700" style="width:{{ $shelf_bar }}%; background:#8B5CF6;"></div>
        </div>
    </div>

    {{-- Emprunts actifs --}}
    <div class="lib-card p-6 hover:-translate-y-0.5 transition-all duration-300 cursor-default relative overflow-hidden">
        <div class="absolute bottom-0 left-0 right-0 h-1 rounded-b-[14px]" style="background:#E07B39;"></div>
        <div class="flex items-start justify-between mb-5">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(224,123,57,0.1);">
                <i class="fas fa-cart-shopping text-xl" style="color:#E07B39;"></i>
            </div>
            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full"
                  style="background:#D1FAE5; color:#065F46;">
                <i class="fas fa-rotate-left text-[9px]"></i> {{ $returned_orders }} retournés
            </span>
        </div>
        <p class="leading-none mb-1" style="font-size:2rem; font-weight:800; color:#1C1F2E;">{{ $total_order }}</p>
        <p class="text-sm font-medium" style="color:#6B7280;">Emprunts actifs</p>
        <div class="flex items-center justify-between mt-1 mb-1.5">
            <span class="text-[11px]" style="color:#9CA3AF;">sur {{ $total_all_records }} total records</span>
            <span class="text-[11px] font-bold" style="color:#E07B39;">{{ $order_bar }}%</span>
        </div>
        <div class="h-1.5 rounded-full overflow-hidden" style="background:#E8EDF2;">
            <div class="h-full rounded-full transition-all duration-700" style="width:{{ $order_bar }}%; background:#E07B39;"></div>
        </div>
    </div>

</div>

{{-- Emprunts récents --}}
<div class="lib-card overflow-hidden">
    <div class="flex items-center justify-between px-6 py-5" style="border-bottom:1px solid #E8EDF2;">
        <div>
            <h2 class="text-base font-bold" style="color:#1C1F2E;">Emprunts récents</h2>
            <p class="text-xs mt-0.5 font-medium" style="color:#6B7280;">Activité de la bibliothèque</p>
        </div>
        <a href="{{ url('admin/book-order') }}"
           class="inline-flex items-center gap-1.5 text-sm font-bold transition-colors duration-200"
           style="color:#4F6FCD;"
           onmouseover="this.style.color='#3d5ab8';" onmouseout="this.style.color='#4F6FCD';">
            Voir tout <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full lib-table">
            <thead>
                <tr style="background:#F8FAFC;">
                    <th class="text-left px-6 py-3.5 text-xs font-bold uppercase tracking-wider" style="color:#374151;">#</th>
                    <th class="text-left px-6 py-3.5 text-xs font-bold uppercase tracking-wider" style="color:#374151;">ID Étudiant</th>
                    <th class="text-left px-6 py-3.5 text-xs font-bold uppercase tracking-wider" style="color:#374151;">ID Livre</th>
                    <th class="text-left px-6 py-3.5 text-xs font-bold uppercase tracking-wider" style="color:#374151;">Date d'emprunt</th>
                    <th class="text-left px-6 py-3.5 text-xs font-bold uppercase tracking-wider" style="color:#374151;">Statut</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @forelse($records as $row)
                <tr>
                    <td class="px-6 py-4 text-sm font-semibold" style="color:#9CA3AF;">{{ str_pad($count, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold"
                                 style="background:rgba(79,111,205,0.12); color:#4F6FCD;">
                                {{ strtoupper(substr($row->Student_ID, 0, 2)) }}
                            </div>
                            <span class="text-sm font-semibold" style="color:#1C1F2E;">{{ $row->Student_ID }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm font-mono" style="color:#6B7280;">{{ $row->Book_ID }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold"
                              style="background:#F4F6FA; color:#6B7280;">
                            <i class="fas fa-calendar-alt text-[10px]"></i>
                            {{ $row->Collection_Date }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="badge-pending inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs">
                            <span class="w-1.5 h-1.5 rounded-full" style="background:#D97706;"></span>
                            Borrowed
                        </span>
                    </td>
                </tr>
                @php $count++; @endphp
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-20 h-20 rounded-2xl flex items-center justify-center mx-auto"
                                 style="background:#F4F6FA;">
                                <i class="fas fa-inbox text-4xl" style="color:#D1D5DB;"></i>
                            </div>
                            <p class="text-sm font-semibold" style="color:#9CA3AF;">No Emprunts récents found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
