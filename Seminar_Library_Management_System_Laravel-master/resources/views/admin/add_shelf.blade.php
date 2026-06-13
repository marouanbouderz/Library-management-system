@extends('layout.admin_layout')
@section('title', 'Ajouter rayon')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Add New Shelf</h2>
        <p class="text-sm text-slate-500 mt-0.5">Create a new Emplacement du rayon in the library</p>
    </div>
    <nav class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <a href="{{ url('admin/shelf-list') }}" class="hover:text-[#4F6FCD] transition-colors">Liste des rayons</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Ajouter rayon</span>
    </nav>
</div>

<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-5 flex items-center gap-3" style="border-bottom:1px solid #E8EDF2;">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(79,111,205,0.09);">
                <i class="fas fa-plus-circle" style="color:#4F6FCD;"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-800 text-sm">Détails du rayon</h3>
                <p class="text-xs text-slate-400">Fill in all required fields</p>
            </div>
        </div>
        <form action="{{ url('admin/add-shelf/process') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Shelf ID <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-hashtag text-slate-400 text-sm"></i>
                    </div>
                    <input type="text" name="shelf_id" required
                           class="w-full pl-9 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4F6FCD]/30 focus:border-[#4F6FCD] bg-slate-50 transition-colors"
                           placeholder="e.g. SH001">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Emplacement du rayon <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-map-marker-alt text-slate-400 text-sm"></i>
                    </div>
                    <select class="lib-select" name="shelf_location" required>
                        <option value="">Select block</option>
                        <option value="Block A">Block A</option>
                        <option value="Block B">Block B</option>
                        <option value="Block C">Block C</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="flex-1 text-white font-bold text-sm py-2.5 rounded-xl transition-all duration-200 shadow-sm flex items-center justify-center gap-2"
                        style="background:#4F6FCD;"
                        onmouseover="this.style.background='#1e40af';" onmouseout="this.style.background='#4F6FCD';">
                    <i class="fas fa-check"></i> Ajouter rayon
                </button>
                <a href="{{ url('admin/shelf-list') }}"
                   class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm py-2.5 rounded-xl transition-colors duration-200 flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
