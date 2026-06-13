@extends('layout.student_layout')
@section('title', 'Mes amendes')
@section('content')

@php
    date_default_timezone_set("Asia/Dhaka");
    $today      = strtotime(date("d-m-Y"));
    $dailyRate  = 50; // DA per day
    $totalOwed  = 0;
    $totalPaid  = 0;
    $fineRows   = [];

    foreach ($records as $row) {
        $exp     = strtotime($row->Expired_Date);
        $returned = $row->Submission_Status === 'Yes';
        $paid     = isset($row->Fine_Paid) && $row->Fine_Paid === 'Yes';

        if ($returned) {
            $subDate  = strtotime($row->Submission_Date);
            $daysLate = $exp > 0 && $subDate > $exp ? (int)(($subDate - $exp) / 86400) : 0;
        } else {
            $daysLate = $today > $exp ? (int)(($today - $exp) / 86400) : 0;
        }

        if ($daysLate <= 0) continue;

        $amount = $daysLate * $dailyRate;
        if ($paid)  $totalPaid += $amount;
        else        $totalOwed += $amount;

        $fineRows[] = (object)[
            'record'   => $row,
            'daysLate' => $daysLate,
            'amount'   => $amount,
            'paid'     => $paid,
            'returned' => $returned,
        ];
    }
@endphp

{{-- Header --}}
<div class="mb-6 flex items-start justify-between gap-4 flex-wrap">
    <div>
        <div class="flex items-center gap-3 mb-1">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#FEF2F2;">
                <i class="fas fa-triangle-exclamation text-sm" style="color:#DC2626;"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Mes amendes</h2>
        </div>
        <p class="text-sm text-slate-500 ml-11">Amendes liées aux retards de retour ({{ $dailyRate }} DA / jour)</p>
    </div>
</div>

{{-- Summary cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border p-5 flex items-center gap-4"
         style="border-color:{{ $totalOwed > 0 ? '#FECACA' : '#E2E8F0' }};">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background:{{ $totalOwed > 0 ? '#FEF2F2' : '#F8FAFC' }};">
            <i class="fas fa-circle-exclamation text-lg" style="color:{{ $totalOwed > 0 ? '#DC2626' : '#94A3B8' }};"></i>
        </div>
        <div>
            <p class="text-2xl font-extrabold" style="color:{{ $totalOwed > 0 ? '#DC2626' : '#1e293b' }};">{{ number_format($totalOwed) }} DA</p>
            <p class="text-xs text-slate-400 font-medium mt-0.5">Montant dû</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#F0FDF4;">
            <i class="fas fa-circle-check text-lg text-emerald-500"></i>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-emerald-600">{{ number_format($totalPaid) }} DA</p>
            <p class="text-xs text-slate-400 font-medium mt-0.5">Montant payé</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#F1F5F9;">
            <i class="fas fa-receipt text-lg text-slate-400"></i>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-slate-800">{{ count($fineRows) }}</p>
            <p class="text-xs text-slate-400 font-medium mt-0.5">Total infractions</p>
        </div>
    </div>
</div>

@if(count($fineRows) > 0)

<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">#</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Livre</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Date d'expiration</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Jours de retard</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Montant</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Type</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($fineRows as $i => $f)
                @php $book = DB::table('books')->where('Book_ID', $f->record->Book_ID)->first(); @endphp
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-4 text-slate-400 text-xs font-mono">{{ $i + 1 }}</td>
                    <td class="px-5 py-4">
                        <p class="font-semibold text-slate-800 text-sm">{{ $book->Book_Name ?? '—' }}</p>
                        <p class="text-xs text-slate-400 font-mono mt-0.5">{{ $f->record->Book_ID }}</p>
                    </td>
                    <td class="px-5 py-4 text-xs text-slate-600 font-medium">{{ $f->record->Expired_Date }}</td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full"
                              style="background:#FEF3C7;color:#92400E;">
                            <i class="fas fa-hourglass-half text-[9px]"></i> {{ $f->daysLate }} jour{{ $f->daysLate > 1 ? 's' : '' }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <span class="text-sm font-extrabold {{ $f->paid ? 'text-slate-400 line-through' : 'text-red-600' }}">
                            {{ number_format($f->amount) }} DA
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        @if($f->returned)
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full" style="background:#DBEAFE;color:#1E40AF;">
                            <i class="fas fa-check text-[9px]"></i> Retourné en retard
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full" style="background:#FEE2E2;color:#991B1B;">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span> En cours (en retard)
                        </span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        @if($f->paid)
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full" style="background:#D1FAE5;color:#065F46;">
                            <i class="fas fa-check text-[9px]"></i> Payée
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full" style="background:#FEE2E2;color:#991B1B;">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> En attente
                        </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if($totalOwed > 0)
<div class="mt-4 flex items-center gap-3 p-4 rounded-2xl border" style="background:#FFF7ED;border-color:#FDBA74;">
    <i class="fas fa-circle-info text-amber-500 flex-shrink-0"></i>
    <p class="text-sm text-amber-800 font-medium">
        Vous avez <strong>{{ number_format($totalOwed) }} DA</strong> d'amendes en attente. Présentez-vous à la bibliothèque pour régler votre solde.
    </p>
</div>
@endif

@else

<div class="bg-white rounded-2xl shadow-md px-6 py-24 flex flex-col items-center gap-5">
    <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background:#F0FDF4;">
        <i class="fas fa-circle-check text-5xl text-emerald-400"></i>
    </div>
    <div class="text-center max-w-sm">
        <p class="text-lg font-bold text-slate-700">Aucune amende !</p>
        <p class="text-sm text-slate-400 mt-2">Vous retournez toujours vos livres à temps. Continuez comme ça !</p>
    </div>
</div>

@endif

@endsection
