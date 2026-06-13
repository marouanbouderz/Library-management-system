@extends('layout.student_layout')
@section('title', 'Catalogue — Emprunter un livre')
@section('content')

{{-- Borrow Confirm Modal --}}
<div id="borrowModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:20px;padding:36px 32px;width:380px;box-shadow:0 20px 60px rgba(0,0,0,0.18);animation:modalIn 0.18s ease;">
        <div style="width:60px;height:60px;border-radius:16px;margin:0 auto 18px;background:#D1FAE5;display:flex;align-items:center;justify-content:center;font-size:24px;">
            📖
        </div>
        <h3 style="margin:0 0 6px;font-size:17px;font-weight:700;color:#1C1F2E;text-align:center;">Emprunter ce livre ?</h3>
        <p id="modalBookTitle" style="margin:0 0 6px;font-size:14px;font-weight:600;color:#2E9E6B;text-align:center;"></p>
        <p id="modalBookAuthor" style="margin:0 0 24px;font-size:12px;color:#6B7280;text-align:center;"></p>
        <div style="background:#F0FDF4;border-radius:10px;padding:12px 16px;margin-bottom:24px;font-size:12px;color:#374151;">
            <i class="fas fa-calendar-alt text-emerald-500 mr-1.5"></i>
            Durée d'emprunt : <strong>2 semaines</strong> à partir d'aujourd'hui
        </div>
        <div style="display:flex;gap:10px;">
            <button onclick="closeBorrowModal()" style="flex:1;padding:11px;border:1.5px solid #E8EDF2;border-radius:10px;background:#fff;font-size:13px;font-weight:600;color:#6B7280;cursor:pointer;">
                Annuler
            </button>
            <a id="borrowConfirmBtn" href="#" style="flex:1;padding:11px;border-radius:10px;font-size:13px;font-weight:700;color:#fff;background:#2E9E6B;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;">
                <i class="fas fa-check text-xs"></i> Confirmer
            </a>
        </div>
    </div>
</div>

<style>
@keyframes modalIn { from{transform:scale(0.92);opacity:0} to{transform:scale(1);opacity:1} }
</style>

{{-- Header --}}
<div class="flex items-start justify-between gap-4 flex-wrap mb-6">
    <div>
        <div class="flex items-center gap-3 mb-1">
            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-book-open text-emerald-600 text-sm"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Catalogue</h2>
        </div>
        <p class="text-sm text-slate-500 ml-11">Tous les livres disponibles à l'emprunt</p>
    </div>
    <span class="inline-flex items-center gap-2 text-xs font-bold px-3 py-1.5 rounded-full border" style="background:#F0FDF4;color:#2E9E6B;border-color:#A7F3D0;">
        <i class="fas fa-books text-[10px]"></i> {{ $books->count() }} titres
    </span>
</div>

{{-- Category filter tabs --}}
<div class="flex items-center gap-2 flex-wrap mb-5">
    <button onclick="filterCat('all')" id="tab-all"
            class="cat-tab px-4 py-1.5 rounded-full text-xs font-bold border transition-all"
            style="background:#2E9E6B;color:#fff;border-color:#2E9E6B;">
        Tous
    </button>
    @foreach($categories as $cat)
    <button onclick="filterCat('{{ $cat }}')" id="tab-{{ Str::slug($cat) }}"
            class="cat-tab px-4 py-1.5 rounded-full text-xs font-bold border transition-all"
            style="background:#fff;color:#6B7280;border-color:#E8EDF2;">
        {{ $cat }}
    </button>
    @endforeach
</div>

{{-- Book grid --}}
<div id="bookGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @forelse($books as $row)
    @php
        $borrowed = DB::table('records')->where('Book_ID',$row->Book_ID)->where('Submission_Status','No')->count();
        $available = $row->Amounts - $borrowed;
        $shelf = DB::table('shelfs')->where('Shelf_ID',$row->Shelf_ID)->first();
    @endphp
    <div class="book-card bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col transition-all duration-200 hover:shadow-md hover:-translate-y-0.5"
         data-cat="{{ $row->Catagory }}">

        {{-- Color strip per category --}}
        @php
            $colors = [
                'Programming'        => ['#3B82F6','#EFF6FF','fa-code'],
                'Networking'         => ['#8B5CF6','#F5F3FF','fa-network-wired'],
                'Database'           => ['#F59E0B','#FFFBEB','fa-database'],
                'Electronics'        => ['#10B981','#ECFDF5','fa-microchip'],
                'Software Development'=> ['#06B6D4','#ECFEFF','fa-laptop-code'],
                'Civile'             => ['#F97316','#FFF7ED','fa-drafting-compass'],
            ];
            $c = $colors[$row->Catagory] ?? ['#6B7280','#F9FAFB','fa-book'];
        @endphp

        <div class="h-1.5" style="background:{{ $c[0] }};"></div>

        <div class="p-5 flex-1 flex flex-col">
            {{-- Icon + category --}}
            <div class="flex items-center justify-between mb-3">
                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold px-2 py-0.5 rounded-full"
                      style="background:{{ $c[1] }};color:{{ $c[0] }};">
                    <i class="fas {{ $c[2] }} text-[9px]"></i> {{ $row->Catagory }}
                </span>
                @if($available > 0)
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full" style="background:#D1FAE5;color:#065F46;">
                    {{ $available }} dispo
                </span>
                @else
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full" style="background:#FEE2E2;color:#991B1B;">
                    Épuisé
                </span>
                @endif
            </div>

            {{-- Title & author --}}
            <h3 class="font-bold text-slate-800 text-sm leading-snug mb-1 flex-1">{{ $row->Book_Name }}</h3>
            <p class="text-xs text-slate-500 mb-1">{{ $row->Writer_Name }}</p>
            <p class="text-[11px] text-slate-400 font-mono mb-4">
                <i class="fas fa-tag text-[9px] mr-1"></i>{{ $row->Book_ID }}
                @if($shelf) · <i class="fas fa-map-pin text-[9px] mr-1"></i>{{ $shelf->Shelf_Location }} @endif
            </p>

            {{-- Borrow button --}}
            @if($available > 0)
            <button onclick="openBorrowModal('{{ url('student/borrow/'.$row->id) }}', '{{ addslashes($row->Book_Name) }}', '{{ addslashes($row->Writer_Name) }}')"
                    class="w-full py-2.5 rounded-xl text-xs font-bold text-white flex items-center justify-center gap-2 transition-all"
                    style="background:#2E9E6B;"
                    onmouseover="this.style.background='#1d7a53';" onmouseout="this.style.background='#2E9E6B';">
                <i class="fas fa-hand-holding-medical text-[11px]"></i> Emprunter
            </button>
            @else
            <button disabled class="w-full py-2.5 rounded-xl text-xs font-bold flex items-center justify-center gap-2 cursor-not-allowed"
                    style="background:#F1F5F9;color:#94A3B8;">
                <i class="fas fa-ban text-[11px]"></i> Indisponible
            </button>
            @endif
        </div>
    </div>
    @empty
    <div class="col-span-4 py-24 text-center">
        <div class="w-20 h-20 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-book text-slate-300 text-4xl"></i>
        </div>
        <p class="font-bold text-slate-400">Aucun livre dans le catalogue</p>
    </div>
    @endforelse
</div>

<p id="noResults" style="display:none;" class="text-center py-20 text-slate-400 font-semibold">Aucun livre dans cette catégorie.</p>

<script>
function filterCat(cat) {
    document.querySelectorAll('.cat-tab').forEach(function(btn) {
        btn.style.background = '#fff';
        btn.style.color = '#6B7280';
        btn.style.borderColor = '#E8EDF2';
    });
    var active = document.getElementById('tab-' + (cat === 'all' ? 'all' : cat.toLowerCase().replace(/[^a-z0-9]+/g,'-')));
    if (active) { active.style.background = '#2E9E6B'; active.style.color = '#fff'; active.style.borderColor = '#2E9E6B'; }

    var cards = document.querySelectorAll('.book-card');
    var visible = 0;
    cards.forEach(function(c) {
        var show = cat === 'all' || c.dataset.cat === cat;
        c.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    document.getElementById('noResults').style.display = visible === 0 ? 'block' : 'none';
}

function openBorrowModal(url, title, author) {
    document.getElementById('modalBookTitle').textContent  = title;
    document.getElementById('modalBookAuthor').textContent = 'par ' + author;
    document.getElementById('borrowConfirmBtn').href = url;
    document.getElementById('borrowModal').style.display = 'flex';
}
function closeBorrowModal() {
    document.getElementById('borrowModal').style.display = 'none';
}
document.getElementById('borrowModal').addEventListener('click', function(e) {
    if (e.target === this) closeBorrowModal();
});
</script>

@endsection
