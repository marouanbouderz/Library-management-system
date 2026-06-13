@extends('layout.admin_layout')
@section('title', 'Book Details')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Book Details</h2>
        <p class="text-sm text-slate-500 mt-0.5">Complete information about this book</p>
    </div>
    <nav class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Book Details</span>
    </nav>
</div>

@foreach($book as $row)
@php
    $shelf_copy = DB::table('books')->where('Book_ID',$row->Book_ID)->sum('Amounts');
    $student_copy = DB::table('records')->where('Book_ID',$row->Book_ID)->where('Submission_Status','No')->count();
    $available = $shelf_copy - $student_copy;
    $shelf = DB::table('shelfs')->where('Shelf_ID',$row->Shelf_ID)->first();
@endphp
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Book info card --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-md p-6">
            <div class="flex flex-col items-center text-center gap-4">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center shadow-md"
                     style="background:linear-gradient(135deg,#3b82f6,#4F6FCD);">
                    <i class="fas fa-book text-white text-3xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg leading-tight">{{ $row->Book_Name }}</h3>
                    <p class="text-sm text-slate-500 mt-1">by {{ $row->Writer_Name }}</p>
                </div>
                <span class="text-xs font-bold px-3 py-1.5 rounded-full" style="background:rgba(79,111,205,0.09); color:#4F6FCD;">{{ $row->Catagory }}</span>
            </div>

            <div class="mt-6 space-y-3">
                <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid #f8fafc;">
                    <span class="text-xs text-slate-400 font-medium">ID Livre</span>
                    <span class="text-xs font-mono text-slate-700 font-bold">{{ $row->Book_ID }}</span>
                </div>
                <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid #f8fafc;">
                    <span class="text-xs text-slate-400 font-medium">Total copies</span>
                    <span class="text-xs font-bold text-slate-700">{{ $shelf_copy }}</span>
                </div>
                <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid #f8fafc;">
                    <span class="text-xs text-slate-400 font-medium">Currently Out</span>
                    <span class="text-xs font-bold text-slate-700">{{ $student_copy }}</span>
                </div>
                <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid #f8fafc;">
                    <span class="text-xs text-slate-400 font-medium">Disponible</span>
                    @if($available > 0)
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:#D1FAE5; color:#065F46;">{{ $available }} left</span>
                    @else
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:#fee2e2; color:#dc2626;">Out sur stock</span>
                    @endif
                </div>
                <div class="flex items-center justify-between py-2.5">
                    <span class="text-xs text-slate-400 font-medium">Emplacement</span>
                    <span class="text-xs font-bold text-slate-700">{{ $shelf ? $shelf->Shelf_Location : 'N/A' }}</span>
                </div>
            </div>

            <div class="mt-6 flex gap-2">
                <a href="{{ url('admin/book/edit/'.$row->id) }}"
                   class="flex-1 inline-flex items-center justify-center gap-1.5 text-white text-xs font-bold py-2.5 rounded-xl transition-colors"
                   style="background:#4F6FCD;"
                   onmouseover="this.style.background='#1e40af';" onmouseout="this.style.background='#4F6FCD';">
                    <i class="fas fa-pen text-[10px]"></i> Edit
                </a>
                <a href="{{ url('admin/book/Supprimer/'.$row->id) }}"
                   onclick="return Confirmer('Supprimer this book permanently?')"
                   class="flex-1 inline-flex items-center justify-center gap-1.5 text-xs font-bold py-2.5 rounded-xl transition-colors"
                   style="background:#fee2e2; color:#dc2626;"
                   onmouseover="this.style.background='#fecaca';" onmouseout="this.style.background='#fee2e2';">
                    <i class="fas fa-trash text-[10px]"></i> Supprimer
                </a>
            </div>
        </div>
    </div>

    {{-- Borrowing records --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="px-6 py-4" style="border-bottom:1px solid #E8EDF2;">
                <h3 class="font-bold text-slate-800 text-sm">Borrowing Records</h3>
                <p class="text-xs text-slate-400 mt-0.5">Students who have borrowed this book</p>
            </div>
            <div class="overflow-x-auto p-4">
                @php
                    $records = DB::table('records')->where('Book_ID',$row->Book_ID)->get();
                @endphp
                @if($records->count() > 0)
                <table class="w-full text-sm">
                    <thead>
                        <tr style="background:#F8FAFC;">
                            <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">ID Étudiant</th>
                            <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Collected</th>
                            <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Expires</th>
                            <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $record)
                        <tr style="border-left:3px solid transparent; transition:border-color 0.15s, background 0.15s;"
                            onmouseover="this.style.borderLeftColor='#4F6FCD'; this.style.background='#eff6ff';"
                            onmouseout="this.style.borderLeftColor='transparent'; this.style.background='';">
                            <td class="px-4 py-3 font-mono text-xs font-bold" style="color:#1C1F2E;">{{ $record->Student_ID }}</td>
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
                        <i class="fas fa-inbox text-4xl" style="color:#cbd5e1;"></i>
                    </div>
                    <p class="text-sm font-semibold text-slate-400">No borrowing records for this book</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
