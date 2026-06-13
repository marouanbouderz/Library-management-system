@extends('layout.admin_layout')
@section('title', 'Emprunts actifs')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Emprunts actifs</h2>
        <p class="text-sm text-slate-500 mt-0.5">All current borrowing records</p>
    </div>
    <div class="flex items-center gap-3">
        <nav class="flex items-center gap-2 text-xs text-slate-400">
            <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-slate-600 font-medium">Emprunts actifs</span>
        </nav>
        <a href="{{ url('admin/add-order') }}"
           class="inline-flex items-center gap-1.5 text-white text-xs font-bold px-4 py-2 rounded-lg transition-all duration-200 shadow-sm ml-2"
           style="background:#4F6FCD;"
           onmouseover="this.style.background='#1e40af';" onmouseout="this.style.background='#4F6FCD';">
            <i class="fas fa-plus text-[10px]"></i> Ajouter emprunt
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid #E8EDF2;">
        <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-cart-shopping text-orange-500"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-800 text-sm">All Orders</h3>
            <p class="text-xs text-slate-400">Complete borrowing history</p>
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
                    <td class="px-4 py-4 text-slate-600 text-xs">{{ $row->Expired_Date }}</td>
                    <td class="px-4 py-4">
                        @if($row->Submission_Status == 'Yes')
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full" style="background:#D1FAE5; color:#065F46;">
                                <i class="fas fa-check-circle text-[10px]"></i> retournés
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full" style="background:#FEF3C7; color:#92400E;">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> Borrowed
                            </span>
                        @endif
                    </td>
                </tr>
                @php $count++; @endphp
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background:#F4F6FA;">
                                <i class="fas fa-book-open text-4xl" style="color:#cbd5e1;"></i>
                            </div>
                            <p class="font-bold text-slate-500">No orders found</p>
                            <a href="{{ url('admin/add-order') }}" class="text-xs font-semibold hover:underline" style="color:#4F6FCD;">Create first order</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
