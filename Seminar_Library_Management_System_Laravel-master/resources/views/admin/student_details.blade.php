@extends('layout.admin_layout')
@section('title', 'Student Details')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Student Details</h2>
        <p class="text-sm text-slate-500 mt-0.5">Full profile and borrowing history</p>
    </div>
    <nav class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <a href="{{ url('admin/student-info') }}" class="hover:text-[#4F6FCD] transition-colors">Students</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Details</span>
    </nav>
</div>

@foreach($student as $row)
@php
    $records = DB::table('records')->where('Student_ID',$row->Student_ID)->get();
    $active = DB::table('records')->where('Student_ID',$row->Student_ID)->where('Submission_Status','No')->count();
    $returned = DB::table('records')->where('Student_ID',$row->Student_ID)->where('Submission_Status','Yes')->count();
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Profile card --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-md p-6">
            <div class="flex flex-col items-center text-center gap-4">
                <img src="{{ asset($row->Image ?: 'image/default.svg') }}" class="w-24 h-24 rounded-2xl object-cover shadow-md" style="border:4px solid #dbeafe;" alt="{{ $row->Name }}" onerror="this.src='{{ asset('image/default.svg') }}'">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">{{ $row->Name }}</h3>
                    <p class="text-sm text-slate-500 mt-0.5 font-mono">{{ $row->Student_ID }}</p>
                </div>
                <span class="text-xs font-bold px-3 py-1.5 rounded-full" style="background:#D1FAE5; color:#065F46;">
                    <i class="fas fa-check-circle mr-1 text-[10px]"></i> Approuverd
                </span>
            </div>

            <div class="mt-6 space-y-3">
                <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid #f8fafc;">
                    <span class="text-xs text-slate-400 font-medium">Promotion</span>
                    <span class="text-xs font-bold text-slate-700">{{ $row->Session }}</span>
                </div>
                <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid #f8fafc;">
                    <span class="text-xs text-slate-400 font-medium">Téléphone</span>
                    <span class="text-xs font-bold text-slate-700">{{ $row->Contact_no }}</span>
                </div>
                <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid #f8fafc;">
                    <span class="text-xs text-slate-400 font-medium">Actuellement emprunté</span>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:#FEF3C7; color:#92400E;">{{ $active }}</span>
                </div>
                <div class="flex items-center justify-between py-2.5">
                    <span class="text-xs text-slate-400 font-medium">Total retournés</span>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:#D1FAE5; color:#065F46;">{{ $returned }}</span>
                </div>
            </div>

            <a href="{{ url('admin/student/Supprimer/process/'.$row->id) }}"
               onclick="return Confirmer('Remove this student permanently?')"
               class="mt-6 w-full inline-flex items-center justify-center gap-1.5 text-xs font-bold py-2.5 rounded-xl transition-colors"
               style="background:#fee2e2; color:#dc2626;"
               onmouseover="this.style.background='#fecaca';" onmouseout="this.style.background='#fee2e2';">
                <i class="fas fa-user-minus text-[10px]"></i> Supprimer étudiant
            </a>
        </div>
    </div>

    {{-- Borrowing records --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="px-6 py-4" style="border-bottom:1px solid #E8EDF2;">
                <h3 class="font-bold text-slate-800 text-sm">Borrowing History</h3>
                <p class="text-xs text-slate-400 mt-0.5">All books ever borrowed by this student</p>
            </div>
            <div class="p-4">
                @if($records->count() > 0)
                <table class="w-full text-sm">
                    <thead>
                        <tr style="background:#F8FAFC;">
                            <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">ID Livre</th>
                            <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Collected</th>
                            <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Expires</th>
                            <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $record)
                        @php $book = DB::table('books')->where('Book_ID',$record->Book_ID)->first(); @endphp
                        <tr style="border-left:3px solid transparent; transition:border-color 0.15s, background 0.15s;"
                            onmouseover="this.style.borderLeftColor='#4F6FCD'; this.style.background='#eff6ff';"
                            onmouseout="this.style.borderLeftColor='transparent'; this.style.background='';">
                            <td class="px-4 py-3">
                                <p class="font-mono text-xs font-bold" style="color:#1C1F2E;">{{ $record->Book_ID }}</p>
                                @if($book)<p class="text-xs text-slate-400">{{ $book->Book_Name }}</p>@endif
                            </td>
                            <td class="px-4 py-3 text-slate-500 text-xs">{{ $record->Collection_Date }}</td>
                            <td class="px-4 py-3 text-slate-500 text-xs">{{ $record->Expired_Date }}</td>
                            <td class="px-4 py-3">
                                @if($record->Submission_Status == 'Yes')
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full" style="background:#D1FAE5; color:#065F46;">Retourné</span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-bold px-2 py-0.5 rounded-full" style="background:#FEF3C7; color:#92400E;">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> Borrowed
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="py-16 flex flex-col items-center gap-4">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background:#F4F6FA;">
                        <i class="fas fa-book text-4xl" style="color:#cbd5e1;"></i>
                    </div>
                    <p class="text-sm font-semibold text-slate-400">No borrowing history found</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
