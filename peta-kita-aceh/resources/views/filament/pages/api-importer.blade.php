<x-filament-panels::page>
    <form wire:submit="submit" class="space-y-6">
        {{ $this->form }}

        <div class="flex justify-start gap-4">
            <x-filament::button type="submit" icon="heroicon-m-arrow-down-tray" color="emerald" size="lg">
                🚀 Mulai Tarik Data via API
            </x-filament::button>
        </div>
    </form>

    <div class="mt-8 p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
        <h3 class="text-lg font-bold text-emerald-700 dark:text-emerald-400 mb-3 flex items-center gap-2">
            ℹ️ Petunjuk Penarikan Data Spasial via API
        </h3>
        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
            <li>• <strong>Endpoint API Aceh Default:</strong> <code>https://sig.acehprov.go.id/api/v2/datasets</code> (Otomatis menarik ~143 dataset publik SIG Aceh).</li>
            <li>• <strong>Endpoint API Kebencanaan BNPB:</strong> <code>https://sig.acehprov.go.id/api/v2/external/bnpb-disaster</code> (Menarik data rawan bencana tsunami & banjir).</li>
            <li>• <strong>Custom API Endpoint:</strong> Anda dapat memasukkan URL API GeoJSON / REST API publik mana saja untuk mengintegrasikan data spasial ke dalam geoportal PetaKita Aceh.</li>
        </ul>
    </div>
</x-filament-panels::page>
