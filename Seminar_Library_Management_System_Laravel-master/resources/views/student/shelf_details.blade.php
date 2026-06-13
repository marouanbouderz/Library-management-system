@extends('layout.student_layout')
@section('title', 'Détails du rayon')
@section('content')

@foreach($shelf as $s)

{{-- Back + header --}}
<div class="mb-6">
    <a href="{{ url('student/shelf-list') }}"
       class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-slate-600 font-medium mb-4 transition-colors">
        <i class="fas fa-arrow-left text-[10px]"></i> Retour Liste des rayons
    </a>
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 bg-cyan-100 rounded-lg flex items-center justify-center">
            <i class="fas fa-layer-group text-cyan-600 text-sm"></i>
        </div>
        <h2 class="text-2xl font-bold text-slate-800">Détails du rayon</h2>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Left: shelf info panel --}}
    <div class="lg:col-span-1 space-y-4">

        <div class="bg-white rounded-2xl shadow-md p-6">
            <div class="w-14 h-14 bg-cyan-50 rounded-2xl flex items-center justify-center mb-5">
                <i class="fas fa-layer-group text-cyan-500 text-2xl"></i>
            </div>

            <h3 class="font-bold text-slate-800 text-lg mb-1">{{ $s->Shelf_Location }}</h3>
            <span class="inline-block font-mono text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg mb-5">
                {{ $s->Shelf_ID }}
            </span>

            <div class="space-y-3 pt-4" style="border-top:1px solid #E8EDF2;">
                @php
                    $book_count   = count($book);
                    $total_copies = DB::table('books')->where('Shelf_ID', $s->Shelf_ID)->sum('Amounts');
                    $borrowed     = DB::table('records')
                                        ->join('books', 'records.Book_ID', '=', 'books.Book_ID')
                                        ->where('books.Shelf_ID', $s->Shelf_ID)
                                        ->where('records.Submission_Status', 'No')
                                        ->count();
                    $available = $total_copies - $borrowed;
                @endphp

                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-500">Titres</span>
                    <span class="text-sm font-bold text-slate-800">{{ $book_count }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-500">Total copies</span>
                    <span class="text-sm font-bold text-slate-800">{{ $total_copies }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-500">Actuellement emprunté</span>
                    <span class="text-sm font-bold text-amber-600">{{ $borrowed }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-500">Disponible</span>
                    <span class="text-sm font-bold {{ $available > 0 ? 'style="color:#2E9E6B;"' : 'text-red-500' }}">
                        {{ $available }}
                    </span>
                </div>
            </div>

            {{-- Taux d'occupation bar --}}
            @php $fillPct = $total_copies > 0 ? min(100, round(($borrowed / $total_copies) * 100)) : 0; @endphp
            <div class="mt-5 pt-4" style="border-top:1px solid #E8EDF2;">
                <div class="flex items-center justify-between text-[10px] text-slate-400 mb-1.5">
                    <span>Taux d'occupation</span>
                    <span>{{ $fillPct }}%</span>
                </div>
                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full {{ $fillPct > 80 ? 'bg-red-400' : ($fillPct > 50 ? 'bg-amber-400' : 'bg-cyan-400') }}"
                         style="width: {{ $fillPct }}%"></div>
                </div>
                <p class="text-[10px] text-slate-400 mt-1.5">
                    {{ $fillPct > 80 ? 'Presque plein' : ($fillPct > 50 ? 'Modérément occupé' : 'Plenty sur space') }}
                </p>
            </div>
        </div>

    </div>

    {{-- Right: Livres dans ce rayon --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="px-6 py-4" style="border-bottom:1px solid #E8EDF2;">
                <p class="text-sm font-semibold text-slate-700">
                    Livres dans ce rayon
                    <span class="text-slate-400 font-normal ml-1">({{ $book_count }} {{ Str::plural('title', $book_count) }})</span>
                </p>
            </div>

            @if($book_count > 0)
            <div class="overflow-x-auto">
                <table id="dataTable" class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">#</th>
                            <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">ID Livre</th>
                            <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Titre du livre</th>
                            <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Auteur</th>
                            <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Qté</th>
                            <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($book as $i => $b)
                        @php
                            $borrow_count = DB::table('records')->where('Book_ID', $b->Book_ID)->where('Submission_Status', 'No')->count();
                            $avail = ($b->Amounts ?? 0) - $borrow_count;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-5 py-3.5 text-slate-400 text-xs font-mono">{{ $i + 1 }}</td>
                            <td class="px-5 py-3.5">
                                <span class="font-mono text-xs font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">{{ $b->Book_ID }}</span>
                            </td>
                            <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $b->Book_Name }}</td>
                            <td class="px-5 py-3.5 text-xs text-slate-500">{{ $b->Writer_Name }}</td>
                            <td class="px-5 py-3.5 text-slate-600 font-medium text-xs">{{ $b->Amounts ?? 0 }}</td>
                            <td class="px-5 py-3.5">
                                @if($avail > 0)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full" style="background:#D1FAE5;color:#065F46;">
                                        <span class="w-1.5 h-1.5 rounded-full rounded-full" style="background:#2E9E6B;"></span> {{ $avail }} disponible
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Épuisé
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="px-6 py-16 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-book text-slate-200 text-4xl"></i>
                </div>
                <p class="text-slate-500 font-semibold text-sm">No Livres dans ce rayon yet</p>
            </div>
            @endif
        </div>
    </div>

</div>

@endforeach

@endsection
