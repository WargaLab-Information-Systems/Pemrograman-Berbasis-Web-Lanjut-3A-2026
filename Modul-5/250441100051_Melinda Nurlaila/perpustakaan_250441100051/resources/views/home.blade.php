<x-app-layout>
    <div class="min-h-[calc(100vh-64px)] flex items-center justify-center bg-[#fff7f9] px-6 py-12">

        <section class="w-full max-w-6xl min-h-[380px] bg-white border border-[#f3d9e1] rounded-2xl shadow-lg px-12 py-12 md:px-14 flex flex-col md:flex-row items-center justify-between gap-10">

            <div class="w-full md:max-w-2xl">
                <span class="inline-block bg-[#fce4ea] text-[#be185d] px-4 py-2 rounded-full text-xs font-semibold mb-5">
                    PERPUSTAKAAN
                </span>

                <h1 class="text-3xl md:text-4xl font-bold text-[#3c2f33] leading-tight mb-5">
                    Selamat Datang di<br>
                    Mylibrary
                </h1>

                <p class="text-[#7a6b6f] text-base leading-7 mb-7">
                    Temukan berbagai koleksi buku menarik, mulai dari novel,
                    sejarah, hingga pengembangan diri.
                </p>

                <a href="{{ route('buku.index') }}"
                   class="inline-flex items-center bg-[#db2777] hover:bg-[#be185d] text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-200">
                    Lihat Daftar Buku
                </a>
            </div>

            <div class="flex-shrink-0 flex items-center justify-center">
                <svg viewBox="0 0 150 150"
                     class="w-44 h-44 md:w-52 md:h-52"
                     xmlns="http://www.w3.org/2000/svg"
                     role="img"
                     aria-label="Ilustrasi rak buku">

                    <rect x="15" y="12" width="120" height="126"
                          rx="10" fill="#fce4ea"
                          stroke="#dc718b" stroke-width="5"/>

                    <path d="M17 75 H133" stroke="#dc718b" stroke-width="5"/>

                    <rect x="27" y="27" width="12" height="45" rx="2" fill="#dc718b"/>
                    <rect x="42" y="37" width="10" height="35" rx="2" fill="#efa0b2"/>
                    <rect x="55" y="25" width="13" height="47" rx="2" fill="#bd536e"/>
                    <rect x="71" y="33" width="11" height="39" rx="2" fill="#e88da4"/>
                    <rect x="85" y="38" width="10" height="34" rx="2" fill="#efa0b2"/>
                    <rect x="98" y="27" width="13" height="45" rx="2" fill="#bd536e"/>
                    <rect x="114" y="34" width="10" height="38" rx="2" fill="#dc718b"/>

                    <rect x="27" y="85" width="12" height="42" rx="2" fill="#e88da4"/>
                    <rect x="42" y="91" width="12" height="36" rx="2" fill="#bd536e"/>
                    <rect x="57" y="84" width="13" height="43" rx="2" fill="#efa0b2"/>
                    <rect x="73" y="94" width="11" height="33" rx="2" fill="#dc718b"/>
                    <rect x="87" y="84" width="13" height="43" rx="2" fill="#bd536e"/>
                    <rect x="103" y="90" width="11" height="37" rx="2" fill="#efa0b2"/>
                    <rect x="117" y="83" width="9" height="44" rx="2" fill="#dc718b"/>
                </svg>
            </div>

        </section>
    </div>
</x-app-layout>
