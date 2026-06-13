@extends('layout.student_layout')
@section('title', 'Historique des emprunts')
@section('content')

@php
    date_default_timezone_set("Asia/Dhaka");
    $today      = strtotime(date("d-m-Y"));
    $totalAll   = $history->count();
    $totalActive = $history->where('Submission_Status','No')->count();
    $totalReturn = $history->where('Submission_Status','Yes')->count();
    $totalOver  = 0;
    foreach ($history as $r) {
        if ($r->Submission_Status === 'No' && $today >= strtotime($r->Expired_Date)) $totalOver++;
    }
@endphp

{{-- Header --}}
<div class="mb-6 flex items-start justify-between gap-4 flex-wrap">
    <div>
        <div class="flex items-center gap-3 mb-1">
            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock-rotate-left text-emerald-600 text-sm"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Historique des emprunts</h2>
        </div>
        <p class="text-sm text-slate-500 ml-11">Tous vos emprunts passés et en cours</p>
    </div>
</div>

{{-- Stats row --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#F0FDF4;">
            <i class="fas fa-book-open text-emerald-500 text-sm"></i>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-slate-800">{{ $totalAll }}</p>
            <p class="text-xs text-slate-400 font-medium">Total emprunts</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#ECFDF5;">
            <i class="fas fa-bookmark text-emerald-500 text-sm"></i>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-slate-800">{{ $totalActive }}</p>
            <p class="text-xs text-slate-400 font-medium">En cours</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#EFF6FF;">
            <i class="fas fa-rotate-left text-blue-500 text-sm"></i>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-slate-800">{{ $totalReturn }}</p>
            <p class="text-xs text-slate-400 font-medium">Retournés</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#FEF2F2;">
            <i class="fas fa-circle-exclamation text-red-500 text-sm"></i>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-slate-800">{{ $totalOver }}</p>
            <p class="text-xs text-slate-400 font-medium">En retard</p>
        </div>
    </div>
</div>

@if($totalAll > 0)

{{-- Table --}}
<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table id="dataTable" class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">#</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">ID Livre</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Titre</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Auteur</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Catégorie</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Date d'emprunt</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Date d'expiration</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($history as $i => $row)
                @php
                    $book     = DB::table('books')->where('Book_ID', $row->Book_ID)->first();
                    $exp      = strtotime($row->Expired_Date);
                    $returned = $row->Submission_Status === 'Yes';
                    $overdue  = !$returned && $today >= $exp;
                    $daysLeft = (int)(($exp - $today) / 86400);
                    $soon     = !$returned && !$overdue && $daysLeft <= 3;
                @endphp
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-3.5 text-slate-400 text-xs font-mono">{{ $i + 1 }}</td>
                    <td class="px-5 py-3.5">
                        <span class="font-mono text-xs font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">{{ $row->Book_ID }}</span>
                    </td>
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $book->Book_Name ?? '—' }}</td>
                    <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $book->Writer_Name ?? '—' }}</td>
                    <td class="px-5 py-3.5">
                        @if($book)
                        @php
                            $catColors = [
                                'Programming'          => ['#3B82F6','#EFF6FF'],
                                'Networking'           => ['#8B5CF6','#F5F3FF'],
                                'Database'             => ['#F59E0B','#FFFBEB'],
                                'Electronics'          => ['#10B981','#ECFDF5'],
                                'Software Development' => ['#06B6D4','#ECFEFF'],
                                'Civile'               => ['#F97316','#FFF7ED'],
                            ];
                            $cc = $catColors[$book->Catagory] ?? ['#6B7280','#F9FAFB'];
                        @endphp
                        <span class="inline-flex items-center text-[10px] font-bold px-2 py-0.5 rounded-full"
                              style="background:{{ $cc[1] }};color:{{ $cc[0] }};">
                            {{ $book->Catagory }}
                        </span>
                        @else
                        <span class="text-slate-400 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs font-medium">{{ $row->Collection_Date }}</td>
                    <td class="px-5 py-3.5 text-xs font-medium {{ $overdue ? 'text-red-600' : ($soon ? 'text-amber-600' : 'text-slate-600') }}">
                        {{ $row->Expired_Date }}
                    </td>
                    <td class="px-5 py-3.5">
                        @if($returned)
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full" style="background:#DBEAFE;color:#1E40AF;">
                                <i class="fas fa-check text-[9px]"></i> Retourné
                            </span>
                        @elseif($overdue)
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full" style="background:#FEE2E2;color:#991B1B;">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span> En retard
                            </span>
                        @elseif($soon)
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full" style="background:#FEF3C7;color:#92400E;">
                                <i class="fas fa-hourglass-half text-[9px]"></i> {{ $daysLeft }}j restants
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full" style="background:#D1FAE5;color:#065F46;">
                                <span class="w-1.5 h-1.5 rounded-full" style="background:#2E9E6B;"></span> Actif
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@else

{{-- Empty state --}}
<div class="bg-white rounded-2xl shadow-md px-6 py-24 flex flex-col items-center gap-5">
    <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center">
        <i class="fas fa-clock-rotate-left text-slate-200 text-4xl"></i>
    </div>
    <div class="text-center max-w-sm">
        <p class="text-lg font-bold text-slate-700">Aucun historique</p>
        <p class="text-sm text-slate-400 mt-2 leading-relaxed">
            Vous n'avez encore emprunté aucun livre. Visitez le catalogue pour commencer.
        </p>
    </div>
    <a href="{{ url('student/catalogue') }}"
       class="inline-flex items-center gap-2 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-all"
       style="background:#2E9E6B;"
       onmouseover="this.style.background='#1d7a53';" onmouseout="this.style.background='#2E9E6B';">
        <i class="fas fa-book-open text-xs"></i> Parcourir le catalogue
    </a>
</div>

@endif

@endsection
