<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cafe Makmur</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icon -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins', sans-serif;
    overflow:hidden;
    background:#000;
}

/* =========================
   BACKGROUND
========================= */

.hero-bg{
    position:absolute;
    inset:0;

    background:
    linear-gradient(
        to bottom right,
        rgba(0,0,0,0.92),
        rgba(0,0,0,0.65),
        rgba(0,0,0,0.92)
    );

    z-index:2;
}

/* =========================
   ANIMATION
========================= */

.fade-up{
    animation:fadeUp 1.2s ease;
}

@keyframes fadeUp{

    from{
        opacity:0;
        transform:translateY(50px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}

.float{
    animation:float 4s ease-in-out infinite;
}

@keyframes float{

    0%{
        transform:translateY(0px);
    }

    50%{
        transform:translateY(-12px);
    }

    100%{
        transform:translateY(0px);
    }

}

/* =========================
   GLASSMORPHISM
========================= */

.glass{
    background:rgba(255,255,255,0.08);

    backdrop-filter:blur(18px);

    border:1px solid rgba(255,255,255,0.12);

    box-shadow:
    0 10px 40px rgba(0,0,0,0.35);
}

/* =========================
   BUTTON
========================= */

.neo-btn{
    position:relative;

    overflow:hidden;

    transition:0.25s ease;
}

.neo-btn:hover{
    transform:translateY(-5px) scale(1.03);
}

.neo-btn::before{
    content:"";

    position:absolute;

    top:0;
    left:-100%;

    width:100%;
    height:100%;

    background:
    linear-gradient(
        120deg,
        transparent,
        rgba(255,255,255,0.4),
        transparent
    );

    transition:0.6s;
}

.neo-btn:hover::before{
    left:100%;
}

/* =========================
   GLOW
========================= */

.glow{
    box-shadow:
    0 0 30px rgba(255,200,100,0.18),
    0 0 100px rgba(255,180,80,0.12);
}

/* =========================
   BADGE
========================= */

.badge{
    animation:pulse 2s infinite;
}

@keyframes pulse{

    0%{
        transform:scale(1);
    }

    50%{
        transform:scale(1.05);
    }

    100%{
        transform:scale(1);
    }

}

/* =========================
   FEATURE CARD
========================= */

.feature-box{
    transition:0.3s ease;
}

.feature-box:hover{
    transform:translateY(-8px);
    background:rgba(255,255,255,0.12);
}

/* =========================
   BLUR CIRCLE
========================= */

.blur-circle{
    position:absolute;
    border-radius:999px;
    filter:blur(120px);
    opacity:.25;
}

/* =========================
   FLOATING ICON
========================= */

.floating-icon{
    position:absolute;

    font-size:28px;

    opacity:.12;

    animation:floatingIcon 8s linear infinite;
}

@keyframes floatingIcon{

    0%{
        transform:translateY(0px);
    }

    50%{
        transform:translateY(-25px);
    }

    100%{
        transform:translateY(0px);
    }

}

/* =========================
   MOBILE
========================= */

@media(max-width:768px){

    body{
        overflow:auto;
    }

    .main-title{
        font-size:42px !important;
    }

    .main-card{
        padding:30px 22px !important;
    }

}

</style>
</head>

<body class="text-white">

<div class="relative w-full min-h-screen overflow-hidden">

    <!-- BACKGROUND IMAGE -->
    <img
    src="{{ asset('image/mkr.jpeg') }}"
    class="absolute inset-0 w-full h-full object-cover scale-110"
    >

    <!-- OVERLAY -->
    <div class="hero-bg"></div>

    <!-- BLUR EFFECT -->
    <div class="blur-circle w-72 h-72 bg-yellow-500 top-[-80px] left-[-80px] z-[3]"></div>

    <div class="blur-circle w-96 h-96 bg-orange-500 bottom-[-100px] right-[-100px] z-[3]"></div>

    <!-- FLOATING ICONS -->
    <div class="floating-icon top-[10%] left-[8%]">☕</div>

    <div class="floating-icon top-[70%] left-[15%]">✨</div>

    <div class="floating-icon top-[20%] right-[12%]">🥐</div>

    <div class="floating-icon bottom-[15%] right-[10%]">🍵</div>

    <!-- MAIN -->
    <div
    class="
    relative
    z-10
    min-h-screen
    flex
    items-center
    justify-center
    px-5
    py-10
    ">

        <!-- MAIN CARD -->
        <div
        class="
        main-card
        glass
        glow
        rounded-[40px]
        p-8
        md:p-14
        max-w-6xl
        w-full
        fade-up
        relative
        overflow-hidden
        ">

            <!-- DECOR -->
            <div
            class="
            absolute
            -top-20
            -right-20
            w-60
            h-60
            bg-yellow-400/10
            rounded-full
            blur-3xl
            ">
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">

                <!-- LEFT -->
                <div>

                    <!-- LOGO -->
                    <div
                    class="
                    w-20
                    h-20
                    rounded-[24px]
                    bg-gradient-to-br
                    from-yellow-300
                    to-orange-500
                    text-black
                    flex
                    items-center
                    justify-center
                    text-4xl
                    shadow-2xl
                    mb-8
                    float
                    ">
                        ☕
                    </div>

                    <!-- BADGE -->
                    <div
                    class="
                    badge
                    inline-flex
                    items-center
                    gap-2
                    px-5
                    py-2
                    rounded-full
                    bg-yellow-500/20
                    border
                    border-yellow-400/30
                    text-sm
                    font-medium
                    mb-6
                    ">

                        ✨ Cafe Premium & Modern

                    </div>

                    <!-- TITLE -->
                    <h1
                    class="
                    main-title
                    text-5xl
                    md:text-7xl
                    font-extrabold
                    leading-tight
                    mb-6
                    ">

                        Cafe
                        <span class="text-yellow-300">
                            Makmur
                        </span>

                    </h1>

                    <!-- DESCRIPTION -->
                    <p
                    class="
                    text-gray-200
                    text-lg
                    leading-relaxed
                    mb-8
                    ">

                        Tempat terbaik untuk menikmati kopi premium,
                        nongkrong santai,
                        bekerja nyaman,
                        dan menikmati suasana aesthetic modern.

                    </p>

                    <!-- BUTTON -->
                    @if (Route::has('login') && Route::has('register'))

                    <div class="flex flex-col sm:flex-row gap-4">

                        <!-- LOGIN -->
                        <a
                        href="{{ route('login') }}"
                        class="
                        neo-btn
                        px-8
                        py-4
                        rounded-2xl
                        bg-yellow-400
                        text-black
                        font-bold
                        shadow-2xl
                        text-center
                        ">

                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login

                        </a>

                        <!-- REGISTER -->
                        <a
                        href="{{ route('register') }}"
                        class="
                        neo-btn
                        px-8
                        py-4
                        rounded-2xl
                        border
                        border-white/30
                        bg-white/10
                        backdrop-blur-md
                        text-white
                        font-bold
                        text-center
                        ">

                            <i class="fas fa-user-plus mr-2"></i>
                            Register

                        </a>

                    </div>

                    @endif

                </div>

                <!-- RIGHT -->
                <div class="relative hidden md:flex justify-center">

                    <!-- MAIN CIRCLE -->
                    <div
                    class="
                    relative
                    w-[380px]
                    h-[380px]
                    rounded-full
                    bg-gradient-to-br
                    from-yellow-300
                    to-orange-500
                    flex
                    items-center
                    justify-center
                    shadow-[0_0_80px_rgba(255,180,50,0.35)]
                    float
                    ">

                        <!-- INNER -->
                        <div
                        class="
                        absolute
                        inset-6
                        rounded-full
                        bg-black/20
                        border
                        border-white/20
                        backdrop-blur-xl
                        flex
                        items-center
                        justify-center
                        ">

                            <div class="text-[140px]">
                                ☕
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- FEATURES -->
            <div
            class="
            mt-14
            grid
            grid-cols-1
            md:grid-cols-3
            gap-5
            ">

                <!-- ITEM -->
                <div
                class="
                feature-box
                glass
                rounded-3xl
                p-6
                text-center
                ">

                    <div class="text-4xl mb-4">
                        🚀
                    </div>

                    <h3 class="font-bold text-lg mb-2">
                        Fast Service
                    </h3>

                    <p class="text-sm text-gray-300">
                        Pelayanan cepat dan nyaman setiap hari.
                    </p>

                </div>

                <!-- ITEM -->
                <div
                class="
                feature-box
                glass
                rounded-3xl
                p-6
                text-center
                ">

                    <div class="text-4xl mb-4">
                        🌐
                    </div>

                    <h3 class="font-bold text-lg mb-2">
                        Free Wifi
                    </h3>

                    <p class="text-sm text-gray-300">
                        Tempat ideal untuk kerja dan nongkrong.
                    </p>

                </div>

                <!-- ITEM -->
                <div
                class="
                feature-box
                glass
                rounded-3xl
                p-6
                text-center
                ">

                    <div class="text-4xl mb-4">
                        🎵
                    </div>

                    <h3 class="font-bold text-lg mb-2">
                        Cozy Music
                    </h3>

                    <p class="text-sm text-gray-300">
                        Suasana santai dengan musik terbaik.
                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- FOOTER -->
    <div
    class="
    absolute
    bottom-5
    left-0
    w-full
    text-center
    text-sm
    text-gray-300
    z-20
    ">

        © {{ date('Y') }} Cafe Makmur • Open 10:00 - 23:00

    </div>

</div>

</body>
</html>