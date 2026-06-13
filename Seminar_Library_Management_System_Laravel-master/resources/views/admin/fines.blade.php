@extends('layout.admin_layout')
@section('title', 'Gestion des amendes')
@section('content')

@php
    date_default_timezone_set("Asia/Dhaka");
    $today     = strtotime(date("d-m-Y"));
    $dailyRate = 50; // DA per day

    $fineRows      = [];
    $grandOwed     = 0;
    $grandPaid     = 0;
    $totalStudents = 0;

    foreach ($records as $row) {
        $exp      = strtotime($row->Expired_Date);
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
        if ($paid)  $grandPaid += $amount;
        else        $grandOwed += $amount;

        $student = DB::table('students')->where('Student_ID', $row->Student_ID)->first();
        $book    = DB::table('books')->where('Book_ID', $row->Book_ID)->first();

        $fineRows[] = (object)[
            'record'   => $row,
            'student'  => $student,
            'book'     => $book,
            'daysLate' => $daysLate,
            'amount'   => $amount,
            'paid'     => $paid,
            'returned' => $returned,
        ];
    }

    $studentIds = collect($fineRows)->pluck('record.Student_ID')->unique()->count();
@endphp

{{-- Header --}}
<div class="mb-6 flex items-start justify-between gap-4 flex-wrap">
    <div>
        <div class="flex items-center gap-3 mb-1">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#FEF2F2;">
                <i class="fas fa-triangle-exclamation text-sm" style="color:#DC2626;"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Gestion des amendes</h2>
        </div>
        <p class="text-sm text-slate-500 ml-11">Amendes de retard — tarif {{ $dailyRate }} DA / jour</p>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#FEF2F2;">
            <i class="fas fa-circle-exclamation text-red-500 text-sm"></i>
        </div>
        <div>
            <p class="text-xl font-extrabold text-red-600">{{ number_format($grandOwed) }} DA</p>
            <p class="text-xs text-slate-400 font-medium">Total dû</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#F0FDF4;">
            <i class="fas fa-circle-check text-emerald-500 text-sm"></i>
        </div>
        <div>
            <p class="text-xl font-extrabold text-emerald-600">{{ number_format($grandPaid) }} DA</p>
            <p class="text-xs text-slate-400 font-medium">Total encaissé</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#FFF7ED;">
            <i class="fas fa-receipt text-amber-500 text-sm"></i>
        </div>
        <div>
            <p class="text-xl font-extrabold text-slate-800">{{ count($fineRows) }}</p>
            <p class="text-xs text-slate-400 font-medium">Infractions</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#EFF6FF;">
            <i class="fas fa-user-graduate text-blue-500 text-sm"></i>
        </div>
        <div>
            <p class="text-xl font-extrabold text-slate-800">{{ $studentIds }}</p>
            <p class="text-xs text-slate-400 font-medium">Étudiants concernés</p>
        </div>
    </div>
</div>

@if(count($fineRows) > 0)

<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table id="dataTable" class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">#</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Étudiant</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Livre</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Expiration</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Retour effectif</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Retard</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Amende</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Statut</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-slate-500">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($fineRows as $i => $f)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-4 text-slate-400 text-xs font-mono">{{ $i + 1 }}</td>
                    <td class="px-5 py-4">
                        <p class="font-semibold text-slate-800 text-sm">{{ $f->student->Name ?? '—' }}</p>
                        <p class="text-xs text-slate-400 font-mono mt-0.5">{{ $f->record->Student_ID }}</p>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-semibold text-slate-700 text-sm">{{ $f->book->Book_Name ?? '—' }}</p>
                        <p class="text-xs text-slate-400 font-mono mt-0.5">{{ $f->record->Book_ID }}</p>
                    </td>
                    <td class="px-5 py-4 text-xs text-slate-600 font-medium">{{ $f->record->Expired_Date }}</td>
                    <td class="px-5 py-4 text-xs font-medium">
                        @if($f->returned)
                            <span class="text-slate-600">{{ $f->record->Submission_Date }}</span>
                        @else
                            <span class="text-red-500 font-bold">Non retourné</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full"
                              style="background:#FEF3C7;color:#92400E;">
                            <i class="fas fa-hourglass-half text-[9px]"></i> {{ $f->daysLate }}j
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <span class="text-sm font-extrabold {{ $f->paid ? 'text-slate-400 line-through' : 'text-red-600' }}">
                            {{ number_format($f->amount) }} DA
                        </span>
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
                    <td class="px-5 py-4">
                        @if(!$f->paid)
                        <a href="{{ url('admin/fines/paid/'.$f->record->id) }}"
                           onclick="return confirm('Marquer cette amende ({{ number_format($f->amount) }} DA) comme payée ?')"
                           class="inline-flex items-center gap-1.5 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-all shadow-sm"
                           style="background:#2E9E6B;"
                           onmouseover="this.style.background='#1d7a53';" onmouseout="this.style.background='#2E9E6B';">
                            <i class="fas fa-check text-[10px]"></i> Marquer payée
                        </a>
                        @else
                        <span class="text-xs text-slate-300 font-medium">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@else

<div class="bg-white rounded-2xl shadow-md px-6 py-24 flex flex-col items-center gap-5">
    <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background:#F0FDF4;">
        <i class="fas fa-circle-check text-5xl text-emerald-400"></i>
    </div>
    <div class="text-center max-w-sm">
        <p class="text-lg font-bold text-slate-700">Aucune amende enregistrée</p>
        <p class="text-sm text-slate-400 mt-2">Tous les emprunts ont été retournés dans les délais.</p>
    </div>
</div>

@endif

@endsection
