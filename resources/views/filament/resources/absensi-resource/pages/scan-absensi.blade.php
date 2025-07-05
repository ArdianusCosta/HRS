<x-filament::page>
    <div class="space-y-4">
        <div id="reader" class="mx-auto"></div>

        <form wire:submit.prevent="submit" wire:ignore>
            <div class="space-y-2">
                <label for="kodeInput" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Kode ID Karyawan
                </label>
                <input wire:model.defer="data.kode_id" id="kodeInput" type="text" readonly
                    class="filament-input w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-white" />
            </div>

            <x-filament::button type="submit" class="mt-4">Submit</x-filament::button>
        </form>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const html5QrCode = new Html5Qrcode("reader");
        const qrCodeSuccessCallback = (decodedText, decodedResult) => {
            document.getElementById("kodeInput").value = decodedText;
            html5QrCode.stop();
            Livewire.dispatch('input', { name: 'data.kode_id', value: decodedText });
        };

        Html5Qrcode.getCameras().then(cameras => {
            if (cameras && cameras.length) {
                html5QrCode.start(
                    { facingMode: "environment" },
                    {
                        fps: 10,
                        qrbox: 250
                    },
                    qrCodeSuccessCallback
                );
            }
        });
    </script>
</x-filament::page>
