@extends('layouts.app')

@section('title', 'Pembayaran - WMX PLAY & WIN')

@section('content')
<main class="py-8">
    <div class="container" style="max-width: 32rem;">
        <div class="card">
            <div class="text-center mb-6">
                <div style="width: 4rem; height: 4rem; background: linear-gradient(135deg, #38bdf8, #0284c7); border-radius: 1rem; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 1.5rem; color: white;">💳</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran Paket</h2>
                <p class="text-gray-600">{{ $package->name }}</p>
            </div>

            <!-- Bank Info -->
            <div style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); border-radius: 1rem; padding: 1.5rem; margin-bottom: 1.5rem;">
                <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span>🏦</span> Transfer ke Rekening
                </h4>
                <div style="background: white; border-radius: 0.75rem; padding: 1rem;">
                    <div class="grid gap-3" style="font-size: 0.875rem;">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Bank</span>
                            <span class="font-semibold">BCA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">No. Rekening</span>
                            <span class="font-semibold font-mono">1234567890</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Atas Nama</span>
                            <span class="font-semibold">WMX PLAYSTATION</span>
                        </div>
                        <hr style="border-color: #e5e7eb;">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Jumlah Transfer</span>
                            <span class="font-bold text-sky-600 text-lg">{{ $package->formatted_price }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <form action="{{ route('dashboard.packages.payment', $package) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Nama Pengirim</label>
                    <input 
                        type="text" 
                        name="account_name" 
                        class="form-input" 
                        placeholder="Nama sesuai rekening pengirim"
                        value="{{ old('account_name') }}"
                        required
                    >
                    @error('account_name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Transaksi</label>
                    <input 
                        type="text" 
                        name="transaction_number" 
                        class="form-input" 
                        placeholder="No. referensi/transaksi dari bank"
                        value="{{ old('transaction_number') }}"
                        required
                    >
                    @error('transaction_number')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Upload Bukti Transfer</label>
                    <div style="background: #f3f4f6; border: 2px dashed #d1d5db; border-radius: 1rem; padding: 2rem; text-align: center;">
                        <input 
                            type="file" 
                            name="proof_image" 
                            id="proof_image"
                            accept="image/*"
                            required
                            style="display: none;"
                            onchange="previewImage(this)"
                        >
                        <label for="proof_image" style="cursor: pointer;">
                            <div id="uploadPlaceholder">
                                <p class="text-3xl mb-2">📤</p>
                                <p class="font-semibold text-gray-700">Klik untuk upload gambar</p>
                                <p class="text-sm text-gray-500">Format: JPG, PNG (Maks 5MB)</p>
                            </div>
                            <img id="imagePreview" src="" alt="Preview" style="display: none; max-width: 100%; border-radius: 0.5rem;">
                        </label>
                    </div>
                    @error('proof_image')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('dashboard.packages') }}" class="btn btn-outline" style="flex: 1;">Batal</a>
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Upload Bukti</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
            document.getElementById('uploadPlaceholder').style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
