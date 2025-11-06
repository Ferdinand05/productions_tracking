<html>
    <head>
    
    {{-- Vite + Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <livewire:production-stage-manager :record="$record" wire:key="stage-manager-{{ $record->id }}" >
    
    </body>
</html>
