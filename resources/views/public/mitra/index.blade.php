<x-layouts.public>
    <x-slot:title>Daftar Mitra — YSSC</x-slot:title>
    <x-slot:metaDescription>Daftar sebagai mitra Yayasan Seribu Satu Cita untuk berkontribusi dan berkolaborasi.</x-slot:metaDescription>

    {{-- Hero --}}
    <section class="bg-gradient-to-br from-teal-700 via-teal-600 to-emerald-500 text-white py-16 md:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="material-symbols-outlined text-[48px]! text-teal-200 mb-4">handshake</span>
            <h1 class="text-3xl md:text-5xl font-extrabold mb-4">Jadilah Mitra Kami</h1>
            <p class="text-teal-100 text-lg max-w-2xl mx-auto leading-relaxed">
                Bergabunglah bersama kami untuk membuat dampak sosial yang lebih besar.
                Daftar sebagai mitra dan mari berkolaborasi untuk Indonesia yang lebih baik.
            </p>
        </div>
    </section>

    {{-- Form Section --}}
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto">
                {{-- Info card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-teal-600 text-[24px]! mt-0.5">info</span>
                        <div>
                            <h3 class="font-bold text-gray-800 mb-1">Informasi Pendaftaran</h3>
                            <ul class="text-sm text-gray-500 space-y-1">
                                <li>• Pastikan semua data yang diisi benar dan valid</li>
                                <li>• Dokumen yang diupload harus jelas dan terbaca</li>
                                <li>• Proses verifikasi memakan waktu 1-3 hari kerja</li>
                                <li>• Anda akan menerima email konfirmasi setelah pendaftaran ditinjau</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Registration form --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h2 class="text-xl font-extrabold text-gray-800 mb-6">Formulir Pendaftaran Mitra</h2>
                    <livewire:public-pages.mitra-registration-form />
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
