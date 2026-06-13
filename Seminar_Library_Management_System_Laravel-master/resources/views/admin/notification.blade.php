@extends('layout.admin_layout')
@section('title', 'Notifications')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Notifications</h2>
        <p class="text-sm text-slate-500 mt-0.5">New student registration requests</p>
    </div>
    <nav class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Notifications</span>
    </nav>
</div>

@php $count = 0; @endphp
@foreach($notification as $row)
    @php $count++; @endphp
@endforeach

@if($count > 0)
<div class="space-y-3">
    @foreach($notification as $row)
    <div class="bg-white rounded-2xl shadow-md p-5 flex items-start gap-4 hover:shadow-lg transition-all duration-200">
        <div class="relative flex-shrink-0">
            <div class="w-11 h-11 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm"
                 style="background:linear-gradient(135deg,#3b82f6,#4F6FCD);">
                {{ strtoupper(substr($row->Name, 0, 1)) }}
            </div>
            <span class="absolute -top-0.5 -right-0.5 w-3.5 h-3.5 bg-amber-400 border-2 border-white rounded-full"></span>
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-bold text-slate-800">{{ $row->Name }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">Soumettreted a new registration request and is awaiting approval.</p>
                </div>
                <span class="flex-shrink-0 inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full"
                      style="background:#FEF3C7; color:#92400E;">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> en attente
                </span>
            </div>
            <div class="mt-3">
                <a href="{{ url('admin/student-request') }}"
                   class="inline-flex items-center gap-1.5 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-all duration-200 shadow-sm"
                   style="background:#4F6FCD;"
                   onmouseover="this.style.background='#1e40af';" onmouseout="this.style.background='#4F6FCD';">
                    <i class="fas fa-eye text-[10px]"></i> Review Request
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="bg-white rounded-2xl shadow-md px-6 py-24 flex flex-col items-center gap-4">
    <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background:rgba(79,111,205,0.09);">
        <i class="fas fa-bell-slash text-4xl" style="color:#93c5fd;"></i>
    </div>
    <div class="text-center">
        <p class="font-bold text-slate-600 text-lg">You're all caught up!</p>
        <p class="text-sm text-slate-400 mt-1">No new notifications at this time.</p>
    </div>
</div>
@endif

@endsection
