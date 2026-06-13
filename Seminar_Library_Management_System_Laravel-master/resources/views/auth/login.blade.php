<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Gestion de Bibliothèque</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] } } }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .glass-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        /* Role toggle */
        .role-tab {
            flex: 1; padding: 8px 0; font-size: 13px; font-weight: 600;
            border-radius: 8px; cursor: pointer; transition: all .2s;
            color: rgba(255,255,255,0.45); border: none; background: transparent;
        }
        .role-tab.active {
            background: rgba(255,255,255,0.12);
            color: #fff;
            box-shadow: 0 1px 6px rgba(0,0,0,0.25);
        }

        /* Input */
        .auth-input {
            width: 100%; padding: 12px 14px 12px 42px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px; font-size: 14px; color: #fff;
            outline: none; transition: border-color .2s, box-shadow .2s;
        }
        .auth-input::placeholder { color: rgba(255,255,255,0.3); }
        .auth-input:focus {
            border-color: #2E9E6B;
            box-shadow: 0 0 0 3px rgba(46,158,107,0.2);
        }

        .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: rgba(255,255,255,0.35); font-size: 14px; pointer-events: none;
        }

        /* Submit button */
        .btn-login {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, #2E9E6B 0%, #1d7a53 100%);
            color: #fff; font-weight: 800; font-size: 14px;
            border: none; border-radius: 12px; cursor: pointer;
            transition: all .2s; box-shadow: 0 4px 20px rgba(46,158,107,0.35);
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 28px rgba(46,158,107,0.45);
        }
        .btn-login:active { transform: translateY(0); }

        /* Blob animations */
        @keyframes blob { 0%,100%{transform:translate(0,0) scale(1)} 33%{transform:translate(20px,-20px) scale(1.05)} 66%{transform:translate(-10px,15px) scale(0.97)} }
        .blob { animation: blob 8s ease-in-out infinite; }
        .blob-2 { animation-delay: -3s; }
        .blob-3 { animation-delay: -6s; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4"
      style="background:linear-gradient(135deg,#1C1F2E 0%,#1e293b 55%,#0d2444 100%);">

    {{-- Background blobs --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="blob absolute top-1/4 left-1/4 w-80 h-80 rounded-full blur-3xl opacity-20" style="background:#4F6FCD;"></div>
        <div class="blob blob-2 absolute bottom-1/4 right-1/4 w-72 h-72 rounded-full blur-3xl opacity-15" style="background:#2E9E6B;"></div>
        <div class="blob blob-3 absolute top-3/4 left-1/2 w-64 h-64 rounded-full blur-3xl opacity-10" style="background:#8B5CF6;"></div>
    </div>

    <div class="relative w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex w-16 h-16 rounded-2xl items-center justify-center mb-4 shadow-2xl"
                 style="background:linear-gradient(135deg,#2E9E6B,#1d7a53);">
                <i class="fas fa-book-open text-2xl text-white"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Bibliothèque</h1>
            <p class="text-sm mt-1" style="color:rgba(255,255,255,0.45);">Connectez-vous à votre espace</p>
        </div>

        {{-- Alerts --}}
        @if(Session::has('fail'))
        <div class="mb-4 flex items-center gap-3 rounded-xl p-4 text-sm"
             style="background:rgba(220,38,38,0.12); border:1px solid rgba(220,38,38,0.25); color:#fca5a5;">
            <i class="fas fa-circle-exclamation flex-shrink-0"></i>
            {{ Session::get('fail') }}
        </div>
        @endif

        @if(Session::has('mess3'))
        <div class="mb-4 flex items-center gap-3 rounded-xl p-4 text-sm"
             style="background:rgba(217,119,6,0.12); border:1px solid rgba(217,119,6,0.25); color:#fbbf24;">
            <i class="fas fa-clock flex-shrink-0"></i>
            Votre compte est en attente de validation par l'administrateur.
        </div>
        @endif

        {{-- Card --}}
        <div class="glass-card rounded-2xl p-8 shadow-2xl">

            {{-- Role tabs --}}
            <div class="flex gap-1 p-1 rounded-xl mb-7" style="background:rgba(255,255,255,0.05);">
                <button class="role-tab active" id="tab-student" onclick="switchTab('student')">
                    <i class="fas fa-user-graduate mr-1.5"></i> Étudiant
                </button>
                <button class="role-tab" id="tab-admin" onclick="switchTab('admin')">
                    <i class="fas fa-shield-halved mr-1.5"></i> Administrateur
                </button>
            </div>

            {{-- Role hint --}}
            <p class="text-xs mb-5 text-center" style="color:rgba(255,255,255,0.3);" id="role-hint">
                Connectez-vous avec votre email ou nom d'utilisateur étudiant
            </p>

            {{-- Form --}}
            <form action="{{ url('/login/process') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="role_hint" id="role_hint_input" value="student">

                <div>
                    <label class="block text-xs font-bold mb-2" style="color:rgba(255,255,255,0.5);">
                        Email ou nom d'utilisateur
                    </label>
                    <div class="relative">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="email" class="auth-input" required
                               placeholder="email@example.com ou username"
                               value="{{ old('email') }}">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold mb-2" style="color:rgba(255,255,255,0.5);">
                        Mot de passe
                    </label>
                    <div class="relative">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="pwd" class="auth-input" required
                               placeholder="••••••••">
                        <button type="button" onclick="togglePwd()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-xs transition-colors"
                                style="color:rgba(255,255,255,0.3);" id="eye-btn">
                            <i class="fas fa-eye" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                {{-- Forgot password --}}
                <div class="flex justify-end">
                    <a id="forgot-link" href="{{ url('/student/forget-password') }}"
                       class="text-xs font-semibold transition-colors"
                       style="color:rgba(46,158,107,0.8);"
                       onmouseover="this.style.color='#2E9E6B';" onmouseout="this.style.color='rgba(46,158,107,0.8)';">
                        Mot de passe oublié ?
                    </a>
                </div>

                <button type="submit" class="btn-login mt-2">
                    <i class="fas fa-right-to-bracket"></i> Se connecter
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px" style="background:rgba(255,255,255,0.08);"></div>
                <span class="text-xs" style="color:rgba(255,255,255,0.25);">Pas encore de compte ?</span>
                <div class="flex-1 h-px" style="background:rgba(255,255,255,0.08);"></div>
            </div>

            <a href="{{ url('/student/sign-up') }}"
               class="flex items-center justify-center gap-2 w-full py-3 rounded-xl text-sm font-bold transition-all duration-200"
               style="background:rgba(255,255,255,0.06); color:rgba(255,255,255,0.7); border:1px solid rgba(255,255,255,0.1);"
               onmouseover="this.style.background='rgba(255,255,255,0.1)';"
               onmouseout="this.style.background='rgba(255,255,255,0.06)';">
                <i class="fas fa-user-plus text-sm"></i> Créer un compte étudiant
            </a>
        </div>

        <p class="text-center text-xs mt-6" style="color:rgba(255,255,255,0.2);">
            Système de Gestion de Bibliothèque &copy; {{ date('Y') }}
        </p>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script>
toastr.options = { positionClass: 'toast-top-right', timeOut: 4000 };
@if(Session::has('message'))
    var type = "{{ Session::get('alert-type','info') }}";
    var msg  = "{{ Session::get('message') }}";
    if      (type === 'success') toastr.success(msg);
    else if (type === 'error')   toastr.error(msg);
    else if (type === 'warning') toastr.warning(msg);
    else                         toastr.info(msg);
@endif
@if(Session::has('mess2'))
    toastr.success("{{ Session::get('mess2') }}");
@endif
@if(Session::has('mess'))
    toastr.success("{{ Session::get('mess') }}");
@endif

var forgotUrls = {
    student: "{{ url('/student/forget-password') }}",
    admin:   "{{ url('/admin/forget-password') }}"
};

var hints = {
    student: "Connectez-vous avec votre email ou nom d'utilisateur étudiant",
    admin:   "Connectez-vous avec votre email ou nom d'utilisateur administrateur"
};

function switchTab(role) {
    document.getElementById('tab-student').classList.toggle('active', role === 'student');
    document.getElementById('tab-admin').classList.toggle('active', role === 'admin');
    document.getElementById('role_hint_input').value = role;
    document.getElementById('forgot-link').href = forgotUrls[role];
    document.getElementById('role-hint').textContent = hints[role];
}

function togglePwd() {
    var inp = document.getElementById('pwd');
    var icon = document.getElementById('eye-icon');
    if (inp.type === 'password') {
        inp.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        inp.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>
</body>
</html>
