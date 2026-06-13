@extends('layout.student_layout')
@section('title', 'Dashboard')
@section('content')

@foreach($student as $s)
@php
    date_default_timezone_set("Asia/Dhaka");
    $today = strtotime(date("d-m-Y"));

    $borrowed   = DB::table('records')->where('Student_ID', $s->Student_ID)->where('Submission_Status', 'No')->count();
    $returned   = DB::table('records')->where('Student_ID', $s->Student_ID)->where('Submission_Status', 'Yes')->count();
    $allRecords = DB::table('records')->where('Student_ID', $s->Student_ID)->where('Submission_Status', 'No')->get();

    $overdueCount = 0; $expiringSoon = 0;
    foreach ($allRecords as $r) {
        $exp = strtotime($r->Expired_Date);
        if ($today >= $exp) $overdueCount++;
        elseif (($exp - $today) <= (3 * 86400)) $expiringSoon++;
    }

    $totalBooks   = DB::table('books')->count();
    $totalShelves = DB::table('shelfs')->count();

    $recent = DB::table('records')
                ->where('Student_ID', $s->Student_ID)
                ->orderByDesc('id')->limit(5)->get();

    $hour     = (int)date('H');
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
@endphp

{{-- Welcome banner --}}
<div class="rounded-2xl p-6 mb-6 shadow-md relative overflow-hidden" style="background:linear-gradient(135deg,#1d7a53,#2E9E6B);">
    <div class="absolute right-0 top-0 w-48 h-48 bg-white/5 rounded-full -translate-y-16 translate-x-16"></div>
    <div class="absolute right-12 bottom-0 w-24 h-24 bg-white/5 rounded-full translate-y-8"></div>
    <div class="relative flex items-center gap-5">
        <img src="{{ asset($s->Image ?: 'image/default.svg') }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-white/30 shadow flex-shrink-0" alt="" onerror="this.src='{{ asset('image/default.svg') }}'">
        <div>
            <p class="text-green-100 text-sm font-medium">{{ $greeting }}</p>
            <h2 class="text-white text-2xl font-extrabold leading-tight">{{ $s->Name }}</h2>
            <p class="text-green-200 text-xs mt-0.5 font-mono">{{ $s->Student_ID }}</p>
        </div>
        @if($overdueCount > 0)
        <div class="ml-auto flex-shrink-0 text-white text-xs font-bold px-4 py-2 rounded-xl flex items-center gap-2 shadow"
             style="background:rgba(220,38,38,0.85);">
            <i class="fas fa-triangle-exclamation text-sm"></i>
            {{ $overdueCount }} overdue {{ Str::plural('book', $overdueCount) }}
        </div>
        @endif
    </div>
</div>

{{-- Stat cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    <div class="lib-card p-5 relative overflow-hidden">
        <div class="absolute bottom-0 left-0 right-0 h-0.5" style="background:#2E9E6B;"></div>
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(46,158,107,0.1);">
                <i class="fas fa-bookmark text-base" style="color:#2E9E6B;"></i>
            </div>
            <span class="text-2xl font-extrabold" style="color:#1C1F2E;">{{ $borrowed }}</span>
        </div>
        <p class="text-sm font-bold" style="color:#374151;">Actuellement emprunté</p>
        <p class="text-xs mt-0.5" style="color:#9CA3AF;">+12% this month</p>
    </div>

    <div class="lib-card p-5 relative overflow-hidden">
        <div class="absolute bottom-0 left-0 right-0 h-0.5" style="background:#4F6FCD;"></div>
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(79,111,205,0.1);">
                <i class="fas fa-rotate-left text-base" style="color:#4F6FCD;"></i>
            </div>
            <span class="text-2xl font-extrabold" style="color:#1C1F2E;">{{ $returned }}</span>
        </div>
        <p class="text-sm font-bold" style="color:#374151;">Total retournés</p>
        <p class="text-xs mt-0.5" style="color:#9CA3AF;">All time submissions</p>
    </div>

    <div class="lib-card p-5 relative overflow-hidden {{ $overdueCount > 0 ? 'border border-red-200' : '' }}">
        <div class="absolute bottom-0 left-0 right-0 h-0.5" style="background:{{ $overdueCount > 0 ? '#DC2626' : '#E8EDF2' }};"></div>
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                 style="background:{{ $overdueCount > 0 ? 'rgba(220,38,38,0.1)' : 'rgba(0,0,0,0.04)' }};">
                <i class="fas fa-clock text-base" style="color:{{ $overdueCount > 0 ? '#DC2626' : '#9CA3AF' }};"></i>
            </div>
            <span class="text-2xl font-extrabold" style="color:{{ $overdueCount > 0 ? '#DC2626' : '#1C1F2E' }};">{{ $overdueCount }}</span>
        </div>
        <p class="text-sm font-bold" style="color:#374151;">Overdue</p>
        <p class="text-xs mt-0.5" style="color:{{ $overdueCount > 0 ? '#DC2626' : '#9CA3AF' }};">
            {{ $overdueCount > 0 ? 'Return immediately' : 'All good' }}
        </p>
    </div>

    <div class="lib-card p-5 relative overflow-hidden {{ $expiringSoon > 0 ? 'border border-amber-200' : '' }}">
        <div class="absolute bottom-0 left-0 right-0 h-0.5" style="background:{{ $expiringSoon > 0 ? '#D97706' : '#E8EDF2' }};"></div>
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                 style="background:{{ $expiringSoon > 0 ? 'rgba(217,119,6,0.1)' : 'rgba(0,0,0,0.04)' }};">
                <i class="fas fa-hourglass-half text-base" style="color:{{ $expiringSoon > 0 ? '#D97706' : '#9CA3AF' }};"></i>
            </div>
            <span class="text-2xl font-extrabold" style="color:{{ $expiringSoon > 0 ? '#D97706' : '#1C1F2E' }};">{{ $expiringSoon }}</span>
        </div>
        <p class="text-sm font-bold" style="color:#374151;">Expiring Soon</p>
        <p class="text-xs mt-0.5" style="color:{{ $expiringSoon > 0 ? '#D97706' : '#9CA3AF' }};">Within 3 days</p>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Recent activity --}}
    <div class="lg:col-span-2">
        <div class="lib-card overflow-hidden">
            <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid #E8EDF2;">
                <p class="text-sm font-bold" style="color:#1C1F2E;">Recent Activity</p>
                <a href="{{ url('student/my-collection') }}" class="text-xs font-bold transition-colors" style="color:#2E9E6B;"
                   onmouseover="this.style.color='#1d7a53';" onmouseout="this.style.color='#2E9E6B';">
                    Voir tout →
                </a>
            </div>
            @if(count($recent) > 0)
            <div>
                @foreach($recent as $r)
                @php
                    $bk  = DB::table('books')->where('Book_ID', $r->Book_ID)->first();
                    $exp = strtotime($r->Expired_Date);
                    $isOverdue  = $today >= $exp;
                    $isExpiring = !$isOverdue && ($exp - $today) <= (3 * 86400);
                    $isReturned = $r->Submission_Status === 'Yes';
                @endphp
                <div class="flex items-center gap-4 px-6 py-3.5 transition-colors"
                     style="border-bottom:1px solid #F4F6FA;"
                     onmouseover="this.style.background='#F4F6FA';" onmouseout="this.style.background='';">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background:{{ $isReturned ? 'rgba(79,111,205,0.1)' : ($isOverdue ? 'rgba(220,38,38,0.1)' : ($isExpiring ? 'rgba(217,119,6,0.1)' : 'rgba(46,158,107,0.1)')) }};">
                        <i class="fas {{ $isReturned ? 'fa-rotate-left' : 'fa-book' }} text-sm"
                           style="color:{{ $isReturned ? '#4F6FCD' : ($isOverdue ? '#DC2626' : ($isExpiring ? '#D97706' : '#2E9E6B')) }};"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold truncate" style="color:#1C1F2E;">{{ $bk->Book_Name ?? $r->Book_ID }}</p>
                        <p class="text-xs mt-0.5" style="color:#9CA3AF;">Collected {{ $r->Collection_Date }}</p>
                    </div>
                    @if($isReturned)
                        <span class="flex-shrink-0 badge-retournés text-xs px-2.5 py-1 rounded-full">Retourné</span>
                    @elseif($isOverdue)
                        <span class="flex-shrink-0 badge-Rejetered text-xs px-2.5 py-1 rounded-full">Overdue</span>
                    @elseif($isExpiring)
                        <span class="flex-shrink-0 badge-pending text-xs px-2.5 py-1 rounded-full">Due soon</span>
                    @else
                        <span class="flex-shrink-0 text-xs" style="color:#9CA3AF;">Due {{ $r->Expired_Date }}</span>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="px-6 py-12 text-center">
                <p class="text-sm font-semibold" style="color:#9CA3AF;">No borrowing activity yet.</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Quick links + library stats --}}
    <div class="space-y-4">

        <div class="lib-card p-5">
            <p class="text-xs font-bold uppercase tracking-wide mb-4" style="color:#9CA3AF;">Library at a Glance</p>
            <div class="space-y-3">
                @foreach([[['fas fa-book','#2E9E6B','rgba(46,158,107,0.08)'],'Total Livres',$totalBooks],[['fas fa-layer-group','#8B5CF6','rgba(139,92,246,0.08)'],'Shelves',$totalShelves],[['fas fa-bookmark','#E07B39','rgba(224,123,57,0.08)'],'Active Loans',$borrowed]] as $stat)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background:{{ $stat[0][2] }};">
                            <i class="{{ $stat[0][0] }} text-[11px]" style="color:{{ $stat[0][1] }};"></i>
                        </div>
                        <span class="text-sm font-medium" style="color:#6B7280;">{{ $stat[1] }}</span>
                    </div>
                    <span class="font-extrabold text-sm" style="color:#1C1F2E;">{{ $stat[2] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="lib-card p-5">
            <p class="text-xs font-bold uppercase tracking-wide mb-4" style="color:#9CA3AF;">Quick Links</p>
            <div class="space-y-1">
                @foreach([[url('student/notification'),'fa-bell','#D97706','rgba(217,119,6,0.08)','Notifications','Overdue & expiring alerts'],[url('student/my-collection'),'fa-bookmark','#2E9E6B','rgba(46,158,107,0.08)','My Collection','Books you currently hold'],[url('student/shelf-list'),'fa-layer-group','#8B5CF6','rgba(139,92,246,0.08)','Browse Shelves','Explore the library']] as $link)
                <a href="{{ $link[0] }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200"
                   onmouseover="this.style.background='{{ $link[3] }}';" onmouseout="this.style.background='';">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                         style="background:{{ $link[3] }};">
                        <i class="fas {{ $link[1] }} text-xs" style="color:{{ $link[2] }};"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold" style="color:#374151;">{{ $link[4] }}</p>
                        <p class="text-xs" style="color:#9CA3AF;">{{ $link[5] }}</p>
                    </div>
                    <i class="fas fa-chevron-right text-xs" style="color:#D1D5DB;"></i>
                </a>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endforeach
@endsection
