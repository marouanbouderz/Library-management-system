@extends('layout.admin_layout')
@section('title', 'Demandes étudiantss')
@section('content')

{{-- Custom Confirm Modal --}}
<div id="confirmModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:20px;padding:36px 32px;width:360px;box-shadow:0 20px 60px rgba(0,0,0,0.18);text-align:center;animation:modalIn 0.18s ease;">
        <div id="modalIcon" style="width:60px;height:60px;border-radius:16px;margin:0 auto 18px;display:flex;align-items:center;justify-content:center;font-size:26px;"></div>
        <h3 id="modalTitle" style="margin:0 0 8px;font-size:17px;font-weight:700;color:#1C1F2E;"></h3>
        <p id="modalMessage" style="margin:0 0 28px;font-size:13px;color:#6B7280;line-height:1.6;"></p>
        <div style="display:flex;gap:10px;">
            <button onclick="closeModal()" style="flex:1;padding:11px;border:1.5px solid #E8EDF2;border-radius:10px;background:#fff;font-size:13px;font-weight:600;color:#6B7280;cursor:pointer;transition:all 0.15s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='#fff';">
                Annuler
            </button>
            <a id="modalConfirmBtn" href="#" style="flex:1;padding:11px;border-radius:10px;font-size:13px;font-weight:700;color:#fff;cursor:pointer;text-decoration:none;display:flex;align-items:center;justify-content:center;transition:opacity 0.15s;" onmouseover="this.style.opacity='0.88';" onmouseout="this.style.opacity='1';">
                Confirmer
            </a>
        </div>
    </div>
</div>

<style>
@keyframes modalIn {
    from { transform: scale(0.92); opacity: 0; }
    to   { transform: scale(1);    opacity: 1; }
}
</style>

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Demandes étudiantss</h2>
        <p class="text-sm text-slate-500 mt-0.5">Review and Approuver en attente student registrations</p>
    </div>
    <nav class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Demandes étudiantss</span>
    </nav>
</div>

<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid #E8EDF2;">
        <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-clock text-amber-500"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-800 text-sm">Pending Approvals</h3>
            <p class="text-xs text-slate-400">Students awaiting admin review</p>
        </div>
    </div>
    <div class="overflow-x-auto p-4">
        <table id="dataTable" class="w-full text-sm">
            <thead>
                <tr style="background:#F8FAFC;">
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">#</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Student</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">ID Étudiant</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Promotion</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Statut</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @forelse($student as $row)
                <tr>
                    <td class="px-4 py-4 text-slate-400 font-semibold">{{ str_pad($count, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset($row->Image ?: 'image/default.svg') }}" class="w-9 h-9 rounded-full object-cover border-2 border-amber-100" alt="{{ $row->Name }}" onerror="this.src='{{ asset('image/default.svg') }}'">
                            <span class="font-bold text-slate-800">{{ $row->Name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-4 font-mono text-slate-600 text-xs">{{ $row->Student_ID }}</td>
                    <td class="px-4 py-4">
                        <span class="bg-slate-100 text-slate-600 text-xs font-bold px-2.5 py-1 rounded-full">{{ $row->Session }}</span>
                    </td>
                    <td class="px-4 py-4">
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full" style="background:#FEF3C7; color:#92400E;">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> en attente
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-2">
                            <button
                               onclick="openModal('approve', '{{ url('student/approve/'.$row->id) }}', '{{ addslashes($row->Name) }}')"
                               class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-all duration-200 shadow-sm">
                                <i class="fas fa-check text-[10px]"></i> Approuver
                            </button>
                            <button
                               onclick="openModal('reject', '{{ url('student/reject/'.$row->id) }}', '{{ addslashes($row->Name) }}')"
                               class="inline-flex items-center gap-1.5 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-all duration-200 shadow-sm"
                               style="background:#DC2626;"
                               onmouseover="this.style.background='#b91c1c';" onmouseout="this.style.background='#DC2626';">
                                <i class="fas fa-times text-[10px]"></i> Rejeter
                            </button>
                        </div>
                    </td>
                </tr>
                @php $count++; @endphp
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background:#ecfdf5;">
                                <i class="fas fa-check-circle text-4xl text-emerald-400"></i>
                            </div>
                            <p class="font-bold text-slate-500">All caught up!</p>
                            <p class="text-xs text-slate-400">No en attente Demandes étudiantss</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function openModal(type, url, name) {
    const modal = document.getElementById('confirmModal');
    const icon  = document.getElementById('modalIcon');
    const title = document.getElementById('modalTitle');
    const msg   = document.getElementById('modalMessage');
    const btn   = document.getElementById('modalConfirmBtn');

    if (type === 'approve') {
        icon.style.background = '#D1FAE5';
        icon.innerHTML = '<i class="fas fa-check" style="color:#059669;"></i>';
        title.textContent = 'Approuver cet étudiant ?';
        msg.textContent   = name + ' sera notifié et pourra accéder à la bibliothèque.';
        btn.style.background = '#059669';
    } else {
        icon.style.background = '#FEE2E2';
        icon.innerHTML = '<i class="fas fa-times" style="color:#DC2626;"></i>';
        title.textContent = 'Rejeter cet étudiant ?';
        msg.textContent   = 'La demande de ' + name + ' sera refusée.';
        btn.style.background = '#DC2626';
    }

    btn.href = url;
    modal.style.display = 'flex';
}

function closeModal() {
    document.getElementById('confirmModal').style.display = 'none';
}

document.getElementById('confirmModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

@endsection
