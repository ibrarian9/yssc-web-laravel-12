<x-layout>
    <x-slot:title>Beranda - Seribu Satu Cita Foundation</x-slot:title>

    <header class="relative min-h-162.5 flex items-center pt-20 md:pt-0 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070" 
                 class="w-full h-full object-cover" alt="Hero Background">
            <div class="absolute inset-0 bg-black/50"></div> 
        </div>
        <div class="container mx-auto px-6 md:px-20 relative z-10 text-white">
            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-7xl font-extrabold leading-tight tracking-tight uppercase mb-4">
                    Seribu Satu Cita<br>Foundation
                </h1>
                <p class="text-lg md:text-xl italic font-light leading-relaxed border-l-4 border-foundation-yellow pl-5 py-2 mb-8 opacity-90">
                    "Tumbuhkan anak dengan ilmu, sayapnya akan terbang bebas di dunia. 
                    Berikanlah cahaya pendidikan, untuk membentuk masa depan yang tak terbatas"
                </p>
                <a href="#" class="inline-flex items-center gap-3 bg-foundation-yellow text-foundation-dark font-bold px-8 py-3 rounded-full hover:bg-yellow-400 transition-all shadow-lg hover:scale-105 group">
                    <span>Explore</span>
                    <span class="material-symbols-outlined text-[18px]! flex items-center justify-center leading-none">
                        arrow_forward_ios
                    </span>
                </a>
            </div>
        </div>

    </header>

    <div class="relative w-full">
        <div class="w-full h-3 bg-foundation-yellow"></div>
            <div class="absolute top-1/2 left-0 w-full -translate-y-1/2 z-30">
                <div class="container mx-auto px-6 md:px-20 lg:px-32"> 
                    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-[0_15px_50px_-15px_rgba(0,0,0,0.3)] py-6 flex flex-col md:flex-row justify-around items-center gap-4 border border-gray-100">
                
                        <div class="flex items-center gap-5 w-full md:w-auto">
                            <div class="p-3 bg-emerald-50 rounded-xl text-emerald-800">
                                <span class="material-symbols-outlined text-[48px]!">badge</span>
                            </div>
                        <div>
                        <h2 class="text-4xl font-black text-gray-800">150+</h2>
                        <p class="text-gray-500 font-semibold text-sm">Pengurus</p>
                    </div>
                    
                </div>

                    <div class="flex items-center gap-5 w-full md:w-auto">
                        <div class="p-3 bg-emerald-50 rounded-xl text-emerald-800">
                        <span class="material-symbols-outlined text-[48px]!">group</span>
                        </div>
                    <div>
                        <h2 class="text-4xl font-black text-gray-800">900+</h2>
                        <p class="text-gray-500 font-semibold text-sm">Relawan</p>
                    </div>
                    </div>


                <div class="flex items-center gap-5 w-full md:w-auto">
                    <div class="p-3 bg-emerald-50 rounded-xl text-emerald-800">
                        <span class="material-symbols-outlined text-[48px]!">volunteer_activism</span>                
                    </div>
                    <div>
                        <h2 class="text-4xl font-black text-gray-800">10.000+</h2>
                        <p class="text-gray-500 font-semibold text-sm">Penerima Manfaat</p>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>

    <section class="py-24 bg-white" style="background-image: url('{{ asset('assets/back-gambar.png') }}');">
        <div class="container mx-auto px-6 md:px-20">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-16">Highlight Terbaru</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <article class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all group">
                    <div class="overflow-hidden h-52">
                        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="Edukasi">
                    </div>
                    <div class="p-6">
                        <span class="inline-block bg-emerald-800 text-white text-[10px] font-bold px-3 py-1 rounded-md uppercase tracking-wider mb-4">Program Edukasi</span>
                        <h3 class="text-xl font-bold text-gray-800 leading-tight mb-6 group-hover:text-emerald-800 transition">Aksi Cinta Anak Negeri 2025</h3>
                        <div class="flex justify-between items-center text-xs text-gray-400 font-medium">
                            <div class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Pekanbaru, Riau
                            </div>
                            <span>7 November 2025</span>
                        </div>
                    </div>
                </article>

                <article class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all group">
                    <div class="overflow-hidden h-52">
                        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=800" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="Sosial">
                    </div>
                    <div class="p-6">
                        <span class="inline-block bg-emerald-800 text-white text-[10px] font-bold px-3 py-1 rounded-md uppercase tracking-wider mb-4">Program Sosial</span>
                        <h3 class="text-xl font-bold text-gray-800 leading-tight mb-6 group-hover:text-emerald-800 transition">Bantu Keberlangsungan Hidup</h3>
                        <div class="flex justify-between items-center text-xs text-gray-400 font-medium">
                            <div class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Pekanbaru, Riau
                            </div>
                            <span>20 Juni 2025</span>
                        </div>
                    </div>
                </article>

                <article class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all group">
                    <div class="overflow-hidden h-52">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=800" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="Kepemudaan">
                    </div>
                    <div class="p-6">
                        <span class="inline-block bg-emerald-800 text-white text-[10px] font-bold px-3 py-1 rounded-md uppercase tracking-wider mb-4">Program Kepemudaan</span>
                        <h3 class="text-xl font-bold text-gray-800 leading-tight mb-6 group-hover:text-emerald-800 transition">Beasiswa Permata Cita 2025</h3>
                        <div class="flex justify-between items-center text-xs text-gray-400 font-medium">
                            <div class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Pekanbaru, Riau
                            </div>
                            <span>13 Mei 2025</span>
                        </div>
                    </div>
                </article>
            </div>

            <div class="mt-16 text-center">
                <a href="#" class="inline-block bg-foundation-yellow hover:bg-yellow-400 text-foundation-dark font-bold px-10 py-3 rounded-full shadow-md transition-transform hover:scale-105">
                    Semua Berita
                </a>
            </div>
        </div>
    </section>
</x-layout>