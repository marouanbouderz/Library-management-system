{{-- Shared borrow confirmation modal — @include('student._borrow_modal') --}}
<div id="borrowModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:20px;padding:36px 32px;width:380px;box-shadow:0 20px 60px rgba(0,0,0,0.18);animation:modalIn 0.18s ease;">
        <div style="width:60px;height:60px;border-radius:16px;margin:0 auto 18px;background:#D1FAE5;display:flex;align-items:center;justify-content:center;font-size:28px;">
            📖
        </div>
        <h3 style="margin:0 0 6px;font-size:17px;font-weight:700;color:#1C1F2E;text-align:center;">Emprunter ce livre ?</h3>
        <p id="modalBookTitle" style="margin:0 0 4px;font-size:14px;font-weight:600;color:#2E9E6B;text-align:center;"></p>
        <p id="modalBookAuthor" style="margin:0 0 20px;font-size:12px;color:#6B7280;text-align:center;"></p>
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
<script>
function openBorrowModal(url, title, author) {
    document.getElementById('modalBookTitle').textContent  = title;
    document.getElementById('modalBookAuthor').textContent = 'par ' + author;
    document.getElementById('borrowConfirmBtn').href = url;
    document.getElementById('borrowModal').style.display = 'flex';
}
function closeBorrowModal() {
    document.getElementById('borrowModal').style.display = 'none';
}
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('borrowModal').addEventListener('click', function(e) {
        if (e.target === this) closeBorrowModal();
    });
});
</script>
