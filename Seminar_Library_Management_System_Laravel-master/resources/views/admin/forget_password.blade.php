<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié — Library Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: {
                        indigo: { 50:'rgba(79,111,205,0.08)', 100:'rgba(79,111,205,0.12)', 500:'#4F6FCD', 600:'#4F6FCD', 700:'#3b5bcf' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4" style="background:linear-gradient(135deg,#1C1F2E 0%,#1e293b 50%,#0d2444 100%);">

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 rounded-full blur-3xl" style="background:#4F6FCD18;"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 rounded-full blur-3xl" style="background:#3b82f610;"></div>
    </div>

    <div class="relative w-full max-w-md">

        <div class="text-center mb-8">
            <div class="inline-flex w-16 h-16 rounded-2xl items-center justify-center mb-4 shadow-xl" style="background:#4F6FCD;">
                <i class="fas fa-key text-white text-2xl"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-white">Mot de passe oublié ?</h1>
            <p class="text-slate-400 text-sm mt-1">Entrez votre email pour recevoir un lien de réinitialisation</p>
        </div>

        @if(Session::has('fail'))
        <div class="mb-4 flex items-center gap-3 rounded-xl p-4 text-sm" style="background:#DC262615; border:1px solid #DC262630; color:#fca5a5;">
            <i class="fas fa-circle-exclamation flex-shrink-0"></i>
            {{ Session::get('fail') }}
        </div>
        @endif

        <div class="rounded-2xl p-8 shadow-2xl" style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); backdrop-filter:blur(20px);">
            <form action="{{ url('admin/forget-password/process') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2">Adresse email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-slate-400 text-sm"></i>
                        </div>
                        <input type="email" name="email" required autocomplete="email"
                               class="w-full pl-10 pr-4 py-3 text-sm rounded-xl text-white placeholder-slate-500 focus:outline-none transition-all"
                               style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1);"
                               onfocus="this.style.borderColor='#4F6FCD'; this.style.boxShadow='0 0 0 3px rgba(26,86,219,0.2)';"
                               onblur="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.boxShadow='';"
                               placeholder="your@email.com">
                    </div>
                </div>
                <button type="submit"
                        class="w-full text-white font-bold text-sm py-3 rounded-xl transition-all duration-200 flex items-center justify-center gap-2"
                        style="background:#4F6FCD; box-shadow:0 4px 24px rgba(26,86,219,0.35);"
                        onmouseover="this.style.background='#1e40af';" onmouseout="this.style.background='#4F6FCD';">
                    <i class="fas fa-paper-plane"></i> Envoyer le lien
                </button>
            </form>
        </div>

        <div class="text-center mt-6">
            <a href="{{ url('/admin') }}" class="text-slate-400 text-sm hover:text-white transition-colors">
                <i class="fas fa-arrow-left mr-1.5"></i> Retour à la connexion
            </a>
        </div>

        <p class="text-center text-slate-500 text-xs mt-4">
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
</script>
</body>
</html>
