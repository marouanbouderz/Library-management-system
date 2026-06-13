@extends('layout.student_layout')
@section('title', 'Livres — Programmation')
@section('content')

@include('student._borrow_modal')

<div class="mb-6 flex items-start justify-between gap-4 flex-wrap">
    <div>
        <div class="flex items-center gap-3 mb-1">
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-code text-blue-600 text-sm"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Livres — Programmation</h2>
        </div>
        <p class="text-sm text-slate-500 ml-11">Algorithms, data structures, languages and more</p>
    </div>
    <span class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1.5 rounded-full border border-blue-200">
        <i class="fas fa-layer-group text-[10px]"></i> {{ count($book) }} Titres
    </span>
</div>

<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table id="dataTable" class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">#</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">ID Livre</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Titre du livre</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Auteur</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Qté rayon</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Disponible</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Rayon</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Emplacement</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($book as $i => $row)
                @php
                    $shelf_copy = DB::table('books')->where('Book_ID', $row->Book_ID)->first();
                    $student_copy = DB::table('records')->where('Book_ID', $row->Book_ID)->where('Submission_Status', 'No')->count();
                    $shelf = DB::table('shelfs')->where('Shelf_ID', $row->Shelf_ID)->first();
                    $available = ($shelf_copy->Amounts ?? 0) - $student_copy;
                @endphp
                <tr class="hover:bg-blue-50/40 transition-colors">
                    <td class="px-5 py-3.5 text-slate-400 text-xs font-mono">{{ $i + 1 }}</td>
                    <td class="px-5 py-3.5">
                        <span class="font-mono text-xs font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">{{ $row->Book_ID }}</span>
                    </td>
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $row->Book_Name }}</td>
                    <td class="px-5 py-3.5 text-slate-500">{{ $row->Writer_Name }}</td>
                    <td class="px-5 py-3.5 text-slate-700 font-medium">{{ $shelf_copy->Amounts ?? 0 }}</td>
                    <td class="px-5 py-3.5">
                        @if($available > 0)
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full" style="background:#D1FAE5;color:#065F46;">
                                <span class="w-1.5 h-1.5 rounded-full" style="background:#2E9E6B;"></span> {{ $available }} disponible
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 text-xs font-semibold px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Épuisé
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 font-mono text-xs text-slate-600">{{ $row->Shelf_ID }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-1.5 text-slate-500 text-xs">
                            <i class="fas fa-map-pin text-blue-300 text-[10px]"></i>
                            {{ $shelf->Shelf_Location ?? '—' }}
                        </div>
                    </td>
                    <td class="px-5 py-3.5">
                        @if($available > 0)
                        <button onclick="openBorrowModal('{{ url('student/borrow/'.$row->id) }}','{{ addslashes($row->Book_Name) }}','{{ addslashes($row->Writer_Name) }}')"
                                class="inline-flex items-center gap-1.5 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-all shadow-sm"
                                style="background:#2E9E6B;" onmouseover="this.style.background='#1d7a53';" onmouseout="this.style.background='#2E9E6B';">
                            <i class="fas fa-hand-holding-medical text-[10px]"></i> Emprunter
                        </button>
                        @else
                        <span class="text-xs text-slate-400 font-medium">Indisponible</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-20 text-center">
                        <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-code text-blue-200 text-4xl"></i>
                        </div>
                        <p class="text-slate-500 font-semibold">No Livres — Programmation yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
