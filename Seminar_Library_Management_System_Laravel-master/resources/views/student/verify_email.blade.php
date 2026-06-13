<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérifier l'email — Library</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"','sans-serif'] }, colors: { emerald: { 50:'rgba(46,158,107,0.08)', 100:'rgba(46,158,107,0.12)', 200:'rgba(46,158,107,0.22)', 300:'#82c9a8', 400:'#52b68a', 500:'#2E9E6B', 600:'#2E9E6B', 700:'#1d7a53', 800:'#155c3f' } } } } }</script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .code-input {
            letter-spacing: 0.4em;
            font-variant-numeric: tabular-nums;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-100 to-emerald-50 flex items-center justify-center p-4">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(Session::has('mess'))
        swal("Success!", "Account created! Please wait for admin approval.", "success");
    @endif
    @if(Session::has('mess2'))
        swal("Error!", "Invalid code. Please try again.", "error");
    @endif
    @if(Session::has('message'))
        var type = "{{ Session::get('alert-type','info') }}";
        var msg  = "{{ Session::get('message') }}";
        if      (type === 'success') toastr.success(msg);
        else if (type === 'error')   toastr.error(msg);
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

        {{-- Step indicator --}}
        <div class="flex items-center gap-2 mb-7">
            <div class="flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 text-xs font-bold">1</div>
            <div class="flex-1 h-px bg-emerald-200"></div>
            <div class="flex items-center justify-center w-6 h-6 rounded-full bg-emerald-600 text-white text-xs font-bold">2</div>
            <div class="flex-1 h-px bg-slate-200"></div>
            <div class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-slate-400 text-xs font-bold">3</div>
        </div>

        {{-- Icon header --}}
        <div class="flex flex-col items-center mb-7">
            <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mb-4 relative">
                <i class="fas fa-shield-halved text-emerald-600 text-2xl"></i>
                <div class="absolute -top-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-white text-[9px]"></i>
                </div>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Check your email</h2>
            <p class="text-sm text-slate-500 text-center mt-2 leading-relaxed">
                We've sent a Confirmeration code to your email address. Enter it below to verify your account.
            </p>
        </div>

        <form action="{{ url('student/confirm-email') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Confirmeration Code</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-hashtag text-slate-400 text-sm"></i>
                    </span>
                    <input type="text" name="code" required autofocus
                           class="code-input w-full pl-10 py-3.5 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all font-mono text-center text-base"
                           placeholder="Enter code"
                           maxlength="20">
                </div>
                <p class="text-[11px] text-slate-400 mt-2 text-center">The code was sent to the email you registered with.</p>
            </div>

            <button type="submit"
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                <i class="fas fa-circle-check text-sm"></i> Verify Account
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-slate-100">
            <div class="flex items-start gap-3 p-3 bg-amber-50 rounded-xl">
                <i class="fas fa-circle-info text-amber-500 text-sm mt-0.5 flex-shrink-0"></i>
                <p class="text-xs text-amber-700 leading-relaxed">
                    After verification, your account will be reviewed by the admin before you can log in.
                </p>
            </div>
        </div>
    </div>

    <p class="text-center text-xs text-slate-400 mt-5">
        Didn't receive an email? Check your spam folder or
        <a href="{{ url('/') }}" class="text-emerald-600 hover:text-emerald-700 font-medium">register again</a>.
    </p>
</div>

</body>
</html>
