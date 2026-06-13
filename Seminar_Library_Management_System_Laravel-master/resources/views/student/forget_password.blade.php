<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié — Library</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"','sans-serif'] }, colors: { emerald: { 50:'rgba(46,158,107,0.08)', 100:'rgba(46,158,107,0.12)', 200:'rgba(46,158,107,0.22)', 300:'#82c9a8', 400:'#52b68a', 500:'#2E9E6B', 600:'#2E9E6B', 700:'#1d7a53', 800:'#155c3f' } } } } }</script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-100 to-emerald-50 flex items-center justify-center p-4">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(Session::has('message'))
        var type = "{{ Session::get('alert-type','info') }}";
        var msg  = "{{ Session::get('message') }}";
        if      (type === 'success') toastr.success(msg);
        else if (type === 'error')   toastr.error(msg);
        else if (type === 'warning') toastr.warning(msg);
        else                         toastr.info(msg);
    @endif
});
</script>

<div class="w-full max-w-md">

    {{-- Logo --}}
    <div class="flex items-center justify-center gap-3 mb-8">
        <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
            <i class="fas fa-book-open text-white"></i>
        </div>
        <span class="font-bold text-slate-800 text-lg">Library Portal</span>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-8">

        {{-- Icon header --}}
        <div class="flex flex-col items-center mb-7">
            <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mb-4">
                <i class="fas fa-envelope-open-text text-emerald-600 text-2xl"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Forgot your Mot de passe?</h2>
            <p class="text-sm text-slate-500 text-center mt-2 leading-relaxed">
                Enter your registered Adresse email and we'll send you a recovery link.
            </p>
        </div>

        <form action="{{ url('student/forget-password/process') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Adresse email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-slate-400 text-sm"></i>
                    </span>
                    <input type="email" name="email" required autofocus
                           class="w-full pl-10 py-3 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                           placeholder="you@example.com">
                </div>
                <p class="text-[11px] text-slate-400 mt-2 ml-1">Must be the email you registered with.</p>
            </div>

            <button type="submit"
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                <i class="fas fa-paper-plane text-sm"></i> Send Recovery Link
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-slate-100 text-center">
            <a href="{{ url('/') }}"
               class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-emerald-600 font-medium transition-colors">
                <i class="fas fa-arrow-left text-xs"></i> Retour à la connexion
            </a>
        </div>
    </div>
</div>

</body>
</html>
