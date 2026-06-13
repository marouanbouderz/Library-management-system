@extends('layout.student_layout')
@section('title', 'My Collection')
@section('content')

@php
    date_default_timezone_set("Asia/Dhaka");
    $today = strtotime(date("d-m-Y"));
    $overdueCount = 0;
    $warningCount = 0;
    foreach ($collection as $row) {
        $exp = strtotime($row->Expired_Date);
        if ($today >= $exp) $overdueCount++;
        elseif (($exp - $today) <= (3 * 86400)) $warningCount++;
    }
@endphp

{{-- Header --}}
<div class="mb-6 flex items-start justify-between gap-4 flex-wrap">
    <div>
        <div class="flex items-center gap-3 mb-1">
            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-bookmark text-emerald-600 text-sm"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">My Collection</h2>
        </div>
        <p class="text-sm text-slate-500 ml-11">Books you currently have borrowed</p>
    </div>
    <div class="flex items-center gap-2">
        @if($overdueCount > 0)
        <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs font-bold px-3 py-1.5 rounded-full">
            <i class="fas fa-circle-exclamation text-[10px]"></i> {{ $overdueCount }} overdue
        </span>
        @endif
        @if($warningCount > 0)
        <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1.5 rounded-full">
            <i class="fas fa-hourglass-half text-[10px]"></i> {{ $warningCount }} expiring
        </span>
        @endif
        <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-600 text-xs font-bold px-3 py-1.5 rounded-full">
            <i class="fas fa-book text-[10px]"></i> {{ count($collection) }} books
        </span>
    </div>
</div>

@if(count($collection) > 0)

{{-- Collection list — card rows instead sur a bare table --}}
<div class="space-y-3">
    @foreach($collection as $row)
    @php
        $book_info = DB::table('books')->where('Book_ID', $row->Book_ID)->first();
        $exp       = strtotime($row->Expired_Date);
        $isOverdue  = $today >= $exp;
        $daysLeft   = (int)(($exp - $today) / 86400);
        $expiringSoon = !$isOverdue && $daysLeft <= 3;
    @endphp

    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden transition-all duration-200 hover:shadow-md
        {{ $isOverdue ? 'border-red-200' : ($expiringSoon ? 'border-amber-200' : 'border-slate-100') }}">
        <div class="flex items-stretch">

            {{-- Left accent bar --}}
            <div class="w-1 flex-shrink-0 {{ $isOverdue ? 'bg-red-500' : ($expiringSoon ? 'bg-amber-400' : 'bg-emerald-400') }}"></div>

            <div class="flex-1 p-5 flex items-center gap-5">

                {{-- Book icon --}}
                <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0
                    {{ $isOverdue ? 'bg-red-50' : ($expiringSoon ? 'bg-amber-50' : 'bg-emerald-50') }}">
                    <i class="fas fa-book text-lg
                        {{ $isOverdue ? 'text-red-400' : ($expiringSoon ? 'text-amber-400' : 'text-emerald-400') }}"></i>
                </div>

                {{-- Book info --}}
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-slate-800 truncate">{{ $book_info->Book_Name ?? 'Unknown Book' }}</p>
                    <div class="flex items-center gap-3 mt-1 flex-wrap">
                        <span class="text-xs text-slate-400 font-mono">{{ $row->Book_ID }}</span>
                        @if($book_info)
                        <span class="text-slate-300 text-xs">·</span>
                        <span class="text-xs text-slate-500">{{ $book_info->Writer_Name }}</span>
                        @endif
                    </div>
                </div>

                {{-- Dates --}}
                <div class="hidden sm:flex items-center gap-6 flex-shrink-0 text-right">
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wide font-semibold mb-0.5">Collected</p>
                        <p class="text-xs text-slate-600 font-medium">{{ $row->Collection_Date }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wide font-semibold mb-0.5">Due Date</p>
                        <p class="text-xs font-semibold {{ $isOverdue ? 'text-red-600' : ($expiringSoon ? 'text-amber-600' : 'text-slate-600') }}">
                            {{ $row->Expired_Date }}
                        </p>
                    </div>
                </div>

                {{-- Status badge --}}
                <div class="flex-shrink-0 ml-2">
                    @if($isOverdue)
                        <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs font-bold px-3 py-1.5 rounded-full whitespace-nowrap">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                            Overdue
                        </span>
                    @elseif($expiringSoon)
                        <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1.5 rounded-full whitespace-nowrap">
                            <i class="fas fa-hourglass-half text-[9px]"></i>
                            {{ $daysLeft }} {{ Str::plural('day', $daysLeft) }} left
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-full whitespace-nowrap">
                            <i class="fas fa-check text-[9px]"></i>
                            {{ $daysLeft }} {{ Str::plural('day', $daysLeft) }} left
                        </span>
                    @endif
                </div>

            </div>
        </div>
    </div>
    @endforeach
</div>

@else

{{-- vide state --}}
<div class="bg-white rounded-2xl shadow-md px-6 py-24 flex flex-col items-center gap-5">
    <div class="relative">
        <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center">
            <i class="fas fa-bookmark text-slate-200 text-4xl"></i>
        </div>
    </div>
    <div class="text-center max-w-sm">
        <p class="text-lg font-bold text-slate-700">Aucun livre borrowed yet</p>
        <p class="text-sm text-slate-400 mt-2 leading-relaxed">
            Visit the book list to find Titres available in the library. Ask your admin to assign a book to you.
        </p>
    </div>
    <a href="{{ url('student/book-list/programming') }}"
       class="inline-flex items-center gap-2 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-all duration-200 shadow-sm"
       style="background:#2E9E6B;"
       onmouseover="this.style.background='#1d7a53';" onmouseout="this.style.background='#2E9E6B';">
        <i class="fas fa-book-open text-xs"></i> Browse Books
    </a>
</div>

@endif

@endsection

@section('scripts')
<style>
@keyframes fade-in { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }
.space-y-3 > * { animation: fade-in 0.3s ease both; }
.space-y-3 > *:nth-child(2) { animation-delay: .05s; }
.space-y-3 > *:nth-child(3) { animation-delay: .1s; }
.space-y-3 > *:nth-child(4) { animation-delay: .15s; }
.space-y-3 > *:nth-child(5) { animation-delay: .2s; }
</style>
@endsection
