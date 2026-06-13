@extends('layout.student_layout')
@section('title', 'Liste des rayons')
@section('content')

{{-- Header --}}
<div class="mb-6 flex items-start justify-between gap-4 flex-wrap">
    <div>
        <div class="flex items-center gap-3 mb-1">
            <div class="w-8 h-8 bg-cyan-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-layer-group text-cyan-600 text-sm"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Liste des rayons</h2>
        </div>
        <p class="text-sm text-slate-500 ml-11">Browse all shelves and explore their book collections</p>
    </div>
    <span class="inline-flex items-center gap-1.5 bg-cyan-50 text-cyan-700 text-xs font-bold px-3 py-1.5 rounded-full border border-cyan-200">
        <i class="fas fa-layer-group text-[10px]"></i> {{ count($shelf) }} {{ Str::plural('shelf', count($shelf)) }}
    </span>
</div>

@if(count($shelf) > 0)

{{-- Shelf cards grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($shelf as $i => $row)
    @php
        $book_count   = DB::table('books')->where('Shelf_ID', $row->Shelf_ID)->count();
        $total_copies = DB::table('books')->where('Shelf_ID', $row->Shelf_ID)->sum('Amounts');
        $borrowed     = DB::table('records')
                            ->join('books', 'records.Book_ID', '=', 'books.Book_ID')
                            ->where('books.Shelf_ID', $row->Shelf_ID)
                            ->where('records.Submission_Status', 'No')
                            ->count();
        $available    = $total_copies - $borrowed;
        $fillPct      = $book_count > 0 ? min(100, round(($borrowed / max($total_copies, 1)) * 100)) : 0;
    @endphp

    <a href="{{ url('student/shelf/details/' . $row->id) }}"
       class="group bg-white rounded-2xl shadow-md p-5 hover:shadow-lg hover:border hover:border-cyan-200 transition-all duration-200 hover:-translate-y-0.5 block">

        {{-- Shelf ID badge + icon --}}
        <div class="flex items-center justify-between mb-4">
            <div class="w-11 h-11 bg-cyan-50 group-hover:bg-cyan-100 rounded-xl flex items-center justify-center transition-colors">
                <i class="fas fa-layer-group text-cyan-500 text-lg"></i>
            </div>
            <span class="font-mono text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">
                {{ $row->Shelf_ID }}
            </span>
        </div>

        {{-- Location --}}
        <div class="flex items-center gap-2 mb-1">
            <i class="fas fa-map-pin text-cyan-400 text-xs"></i>
            <p class="font-bold text-slate-800 text-sm">{{ $row->Shelf_Location }}</p>
        </div>

        {{-- Stats row --}}
        <div class="flex items-center gap-3 mt-3 mb-4 text-xs text-slate-500">
            <span class="flex items-center gap-1">
                <i class="fas fa-book text-slate-300 text-[10px]"></i>
                {{ $book_count }} {{ Str::plural('title', $book_count) }}
            </span>
            <span class="text-slate-200">·</span>
            <span class="flex items-center gap-1 {{ $available > 0 ? 'text-emerald-600' : 'text-red-500' }} font-semibold">
                <i class="fas fa-circle text-[8px]"></i>
                {{ $available }} available
            </span>
        </div>

        {{-- Taux d'occupation bar --}}
        <div class="mt-auto">
            <div class="flex items-center justify-between text-[10px] text-slate-400 mb-1">
                <span>Taux d'occupation</span>
                <span>{{ $fillPct }}%</span>
            </div>
            <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all duration-500
                    {{ $fillPct > 80 ? 'bg-red-400' : ($fillPct > 50 ? 'bg-amber-400' : 'bg-cyan-400') }}"
                     style="width: {{ $fillPct }}%"></div>
            </div>
        </div>

        {{-- View link --}}
        <div class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-cyan-600 group-hover:text-cyan-700">
            View books <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
        </div>
    </a>
    @endforeach
</div>

@else

<div class="bg-white rounded-2xl shadow-md px-6 py-24 flex flex-col items-center gap-5">
    <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center">
        <i class="fas fa-layer-group text-slate-200 text-4xl"></i>
    </div>
    <div class="text-center max-w-sm">
        <p class="text-lg font-bold text-slate-700">No shelves found</p>
        <p class="text-sm text-slate-400 mt-2">The library hasn't set up any shelves yet.</p>
    </div>
</div>

@endif

@endsection

@section('scripts')
<style>
@keyframes fade-up { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
.grid > * { animation: fade-up 0.3s ease both; }
@for($i = 1; $i <= 12; $i++)
.grid > *:nth-child({{ $i }}) { animation-delay: {{ ($i - 1) * 0.05 }}s; }
@endfor
</style>
@endsection
