@extends('layout.admin_layout')
@section('title', 'Ajouter livre')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Add New Book</h2>
        <p class="text-sm text-slate-500 mt-0.5">Add a new book to the library collection</p>
    </div>
    <nav class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Ajouter livre</span>
    </nav>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-5 flex items-center gap-3" style="border-bottom:1px solid #E8EDF2;">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(79,111,205,0.09);">
                <i class="fas fa-book-medical" style="color:#4F6FCD;"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-800 text-sm">Book Details</h3>
                <p class="text-xs text-slate-400">Fill in all required fields</p>
            </div>
        </div>
        <form action="{{ url('admin/add-book/process') }}" method="POST" class="p-6">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Book ID <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-hashtag text-slate-400 text-sm"></i>
                        </div>
                        <input type="text" name="book_id" required
                               class="w-full pl-9 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4F6FCD]/30 focus:border-[#4F6FCD] bg-slate-50 transition-colors"
                               placeholder="e.g. BK001">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Titre du livre <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-book text-slate-400 text-sm"></i>
                        </div>
                        <input type="text" name="book_name" required
                               class="w-full pl-9 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4F6FCD]/30 focus:border-[#4F6FCD] bg-slate-50 transition-colors"
                               placeholder="Book title">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Author / Writer <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-pen-nib text-slate-400 text-sm"></i>
                        </div>
                        <input type="text" name="writer_name" required
                               class="w-full pl-9 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4F6FCD]/30 focus:border-[#4F6FCD] bg-slate-50 transition-colors"
                               placeholder="Author name">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Category <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-tag text-slate-400 text-sm"></i>
                        </div>
                        <select class="lib-select" name="catagory" required>
                            <option value="">Choisir une catégorie</option>
                            <option value="Programming">Programming</option>
                            <option value="Networking">Networking</option>
                            <option value="Database">Database</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Software">Software</option>
                            <option value="Civile">Civile</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Quantity / Quantités <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-layer-group text-slate-400 text-sm"></i>
                        </div>
                        <input type="number" name="amounts" required min="1"
                               class="w-full pl-9 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4F6FCD]/30 focus:border-[#4F6FCD] bg-slate-50 transition-colors"
                               placeholder="1">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Shelf <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-archive text-slate-400 text-sm"></i>
                        </div>
                        <select class="lib-select" name="shelf_id" required>
                            <option value="">Choisir un rayon</option>
                            @foreach($shelf as $row)
                                <option value="{{ $row->Shelf_ID }}">{{ $row->Shelf_ID }} — {{ $row->Shelf_Location }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 mt-7">
                <button type="submit"
                        class="flex-1 text-white font-bold text-sm py-2.5 rounded-xl transition-all duration-200 shadow-sm flex items-center justify-center gap-2"
                        style="background:#4F6FCD;"
                        onmouseover="this.style.background='#1e40af';" onmouseout="this.style.background='#4F6FCD';">
                    <i class="fas fa-check"></i> Ajouter livre
                </button>
                <a href="{{ url('admin/dashboard') }}"
                   class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm py-2.5 rounded-xl transition-colors duration-200 flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
