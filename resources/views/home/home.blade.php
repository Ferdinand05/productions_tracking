<x-app-layout title="Tracking Produksi | PT Nilosa Rama Buana">

    {{-- Hero Section --}}
    <section class="text-center py-16 bg-linear-to-r from-indigo-500 to-purple-600 text-white rounded-md">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl font-extrabold mb-4">Lacak Status Produksi Anda</h1>
            <p class="text-lg mb-8">
                Masukkan Kode Customer Anda di bawah ini untuk melihat progres, bahan, dan status produksi.
            </p>
        </div>
    </section>

    {{-- Komponen Livewire Check Production --}}
    <section class="py-10  bg-gray-50 rounded-md mt-2.5">
        <div class=" max-w-5xl mx-auto">
            <livewire:check-production>
        </div>
    </section>





</x-app-layout>
