@extends('layout.admin_layout')
@section('title', 'Book Returns')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Book Returns</h2>
        <p class="text-sm text-slate-500 mt-0.5">Process book returns from students</p>
    </div>
    <nav class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Book Returns</span>
    </nav>
</div>

<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid #E8EDF2;">
        <div class="w-9 h-9 bg-emerald-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-rotate-left text-emerald-600"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-800 text-sm">Pending Returns</h3>
            <p class="text-xs text-slate-400">Books awaiting return Confirmeration</p>
        </div>
    </div>
    <div class="overflow-x-auto p-4">
        <table id="dataTable" class="w-full text-sm">
            <thead>
                <tr style="background:#F8FAFC;">
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">#</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Student</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Book</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Date d'emprunt</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Expiry Date</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Statut</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @forelse($book_order as $row)
                @php
                    $book = DB::table('books')->where('Book_ID',$row->Book_ID)->first();
                    $student = DB::table('students')->where('Student_ID',$row->Student_ID)->first();
                @endphp
                <tr>
                    <td class="px-4 py-4 text-slate-400 font-semibold">{{ str_pad($count, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background:#4F6FCD;">
                                {{ strtoupper(substr($row->Student_ID, 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-xs">{{ $row->Student_ID }}</p>
                                @if($student)<p class="text-xs text-slate-400">{{ $student->Name }}</p>@endif
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <p class="font-bold text-slate-800 text-xs">{{ $row->Book_ID }}</p>
                        @if($book)<p class="text-xs text-slate-400">{{ $book->Book_Name }}</p>@endif
                    </td>
                    <td class="px-4 py-4 text-slate-600 text-xs">{{ $row->Collection_Date }}</td>
                    <td class="px-4 py-4">
                        @php $expired = strtotime($row->Expired_Date) < time(); @endphp
                        <span class="text-xs {{ $expired ? 'font-bold' : 'text-slate-600' }}" style="{{ $expired ? 'color:#DC2626;' : '' }}">
                            {{ $row->Expired_Date }}
                            @if($expired)<span class="ml-1 text-[10px] font-bold px-1.5 py-0.5 rounded" style="background:#fee2e2; color:#DC2626;">Overdue</span>@endif
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full" style="background:#FEF3C7; color:#92400E;">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> Borrowed
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <a href="{{ url('admin/book-received/process/'.$row->id) }}"
                           onclick="return Confirmer('Mark this book as retournés?')"
                           class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-all duration-200 shadow-sm">
                            <i class="fas fa-check text-[10px]"></i> Mark retournés
                        </a>
                    </td>
                </tr>
                @php $count++; @endphp
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background:#ecfdf5;">
                                <i class="fas fa-check-circle text-4xl text-emerald-400"></i>
                            </div>
                            <p class="font-bold text-slate-500">All books retournés</p>
                            <p class="text-xs text-slate-400">No en attente returns at this time</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
