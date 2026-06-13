@extends('layout.student_layout')
@section('title', 'My Submission')
@section('content')

{{-- Header --}}
<div class="mb-6 flex items-start justify-between gap-4 flex-wrap">
    <div>
        <div class="flex items-center gap-3 mb-1">
            <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-rotate-left text-teal-600 text-sm"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">My Submission</h2>
        </div>
        <p class="text-sm text-slate-500 ml-11">History sur books you have retournés</p>
    </div>
    <span class="inline-flex items-center gap-1.5 bg-teal-50 text-teal-700 text-xs font-bold px-3 py-1.5 rounded-full border border-teal-200">
        <i class="fas fa-check-double text-[10px]"></i> {{ count($submission) }} retournés
    </span>
</div>

@if(count($submission) > 0)

<div class="bg-white rounded-2xl shadow-md overflow-hidden">

    {{-- Mini stats strip --}}
    <div class="px-6 py-4 bg-teal-50/50 flex items-center gap-6 flex-wrap" style="border-bottom:1px solid #ccfbf1;">
        <div class="flex items-center gap-2 text-xs text-teal-700">
            <i class="fas fa-circle-check text-teal-500"></i>
            <span><strong>{{ count($submission) }}</strong> {{ Str::plural('book', count($submission)) }} retournés on time</span>
        </div>
        <div class="h-3 w-px bg-teal-200 hidden sm:block"></div>
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <i class="fas fa-calendar-check text-slate-400"></i>
            <span>Full borrowing history below</span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table id="dataTable" class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">#</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">ID Livre</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Titre du livre</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Auteur</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Collected</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Due Date</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($submission as $i => $row)
                @php
                    $book_info = DB::table('books')->where('Book_ID', $row->Book_ID)->first();
                @endphp
                <tr class="hover:bg-teal-50/30 transition-colors">
                    <td class="px-5 py-4 text-slate-400 text-xs font-mono">{{ $i + 1 }}</td>
                    <td class="px-5 py-4">
                        <span class="font-mono text-xs font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">{{ $row->Book_ID }}</span>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-semibold text-slate-800">{{ $book_info->Book_Name ?? '—' }}</p>
                    </td>
                    <td class="px-5 py-4 text-slate-500 text-xs">{{ $book_info->Writer_Name ?? '—' }}</td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <i class="fas fa-calendar-plus text-slate-300 text-[10px]"></i>
                            {{ $row->Collection_Date }}
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <i class="fas fa-calendar-minus text-slate-300 text-[10px]"></i>
                            {{ $row->Expired_Date }}
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center gap-1.5 bg-teal-50 text-teal-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                            <i class="fas fa-circle-check text-[10px]"></i> retournés
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@else

{{-- vide state --}}
<div class="bg-white rounded-2xl shadow-md px-6 py-24 flex flex-col items-center gap-5">
    <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center">
        <i class="fas fa-rotate-left text-slate-200 text-4xl"></i>
    </div>
    <div class="text-center max-w-sm">
        <p class="text-lg font-bold text-slate-700">No submissions yet</p>
        <p class="text-sm text-slate-400 mt-2 leading-relaxed">
            Once you return a borrowed book, it will appear here as part sur your history.
        </p>
    </div>
    <a href="{{ url('student/my-collection') }}"
       class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-all duration-200 shadow-sm">
        <i class="fas fa-bookmark text-xs"></i> View My Collection
    </a>
</div>

@endif

@endsection
