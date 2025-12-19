{{-- Modal tahap produksi --}}
<html>

<head>

    {{-- Vite + Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    {{-- table  daftar tahap produksi --}}
    <livewire:production-stage-manager :record="$record" wire:key="stage-manager-{{ $record->id }}">

</body>

</html>
