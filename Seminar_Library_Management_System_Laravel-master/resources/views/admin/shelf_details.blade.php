@extends('layout.admin_layout')
@section('title', 'Détails du rayon')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Détails du rayon</h2>
        <p class="text-sm text-slate-500 mt-0.5">All Livres dans ce rayon</p>
    </div>
    <nav class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <a href="{{ url('admin/shelf-list') }}" class="hover:text-[#4F6FCD] transition-colors">Liste des rayons</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Details</span>
    </nav>
</div>

@foreach($shelf as $row)
@php
    $books_on_shelf = DB::table('books')->where('Shelf_ID',$row->Shelf_ID)->get();
    $total_books = DB::table('books')->where('Shelf_ID',$row->Shelf_ID)->sum('Amounts');
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Shelf info card --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-md p-6">
            <div class="flex flex-col items-center text-center gap-4">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center shadow-md"
                     style="background:linear-gradient(135deg,#8b5cf6,#6d28d9);">
                    <i class="fas fa-layer-group text-white text-3xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">{{ $row->Shelf_ID }}</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ $row->Shelf_Location }}</p>
                </div>
            </div>

            <div class="mt-6 space-y-3">
                <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid #f8fafc;">
                    <span class="text-xs text-slate-400 font-medium">Emplacement</span>
                    <span class="text-xs font-bold text-slate-700">{{ $row->Shelf_Location }}</span>
                </div>
                <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid #f8fafc;">
                    <span class="text-xs text-slate-400 font-medium">Book Titres</span>
                    <span class="text-xs font-bold text-slate-700">{{ $books_on_shelf->count() }}</span>
                </div>
                <div class="flex items-center justify-between py-2.5">
                    <span class="text-xs text-slate-400 font-medium">Total copies</span>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:rgba(79,111,205,0.09); color:#4F6FCD;">{{ $total_books }}</span>
                </div>
            </div>

            <div class="mt-6 flex gap-2">
                <a href="{{ url('admin/shelf/edit/'.$row->id) }}"
                   class="flex-1 inline-flex items-center justify-center gap-1.5 text-white text-xs font-bold py-2.5 rounded-xl transition-colors"
                   style="background:#4F6FCD;"
                   onmouseover="this.style.background='#1e40af';" onmouseout="this.style.background='#4F6FCD';">
                    <i class="fas fa-pen text-[10px]"></i> Edit
                </a>
                <a href="{{ url('admin/shelf/Supprimer/'.$row->id) }}"
                   onclick="return Confirmer('Supprimer this shelf permanently?')"
                   class="flex-1 inline-flex items-center justify-center gap-1.5 text-xs font-bold py-2.5 rounded-xl transition-colors"
                   style="background:#fee2e2; color:#dc2626;"
                   onmouseover="this.style.background='#fecaca';" onmouseout="this.style.background='#fee2e2';">
                    <i class="fas fa-trash text-[10px]"></i> Supprimer
                </a>
            </div>
        </div>
    </div>

    {{-- Livres dans ce rayon --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="px-6 py-4" style="border-bottom:1px solid #E8EDF2;">
                <h3 class="font-bold text-slate-800 text-sm">Livres dans ce rayon</h3>
                <p class="text-xs text-slate-400 mt-0.5">All Titres stored in {{ $row->Shelf_Location }}</p>
            </div>
            <div class="p-4">
                @if($books_on_shelf->count() > 0)
                <table class="w-full text-sm">
                    <thead>
                        <tr style="background:#F8FAFC;">
                            <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">ID Livre</th>
                            <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Titre du livre</th>
                            <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Category</th>
                            <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Copies</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books_on_shelf as $book)
                        <tr style="border-left:3px solid transparent; transition:border-color 0.15s, background 0.15s;"
                            onmouseover="this.style.borderLeftColor='#4F6FCD'; this.style.background='#eff6ff';"
                            onmouseout="this.style.borderLeftColor='transparent'; this.style.background='';">
                            <td class="px-4 py-3 font-mono text-xs font-bold" style="color:#1C1F2E;">{{ $book->Book_ID }}</td>
                            <td class="px-4 py-3 font-bold text-slate-800">{{ $book->Book_Name }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold px-2 py-0.5 rounded-full" style="background:rgba(79,111,205,0.09); color:#4F6FCD;">{{ $book->Catagory }}</span>
                            </td>
                            <td class="px-4 py-3 text-slate-600 font-bold">{{ $book->Amounts }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="py-16 flex flex-col items-center gap-4">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background:#F4F6FA;">
                        <i class="fas fa-inbox text-4xl" style="color:#cbd5e1;"></i>
                    </div>
                    <p class="text-sm font-semibold text-slate-400">No Livres dans ce rayon yet</p>
                    <a href="{{ url('admin/add-book') }}" class="text-xs font-semibold hover:underline" style="color:#4F6FCD;">Add a book</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
