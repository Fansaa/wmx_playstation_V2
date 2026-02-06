@extends('layouts.app')

@section('title', 'Verifikasi Pembayaran - Admin')

@section('content')
<main class="py-8">
    <div class="container">
        <div class="card mb-6">
            <div class="flex justify-between items-center" style="flex-wrap: wrap; gap: 1rem;">
                <h2 class="text-2xl font-bold text-gray-800">💳 Verifikasi Pembayaran</h2>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">← Kembali</a>
            </div>
        </div>

        <!-- Filter -->
        <div class="card mb-6">
            <form method="GET" class="flex gap-4" style="flex-wrap: wrap;">
                <select name="status" class="form-select" style="width: auto;">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <!-- Payments List -->
        <div class="card">
            @if($payments->isEmpty())
            <p class="text-center text-gray-500 py-8">Tidak ada pembayaran</p>
            @else
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Paket</th>
                            <th>Pengirim</th>
                            <th>No. Transaksi</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td>
                                <p class="font-semibold">{{ $payment->user->full_name }}</p>
                                <p class="text-sm text-gray-500">{{ $payment->user->email }}</p>
                            </td>
                            <td>{{ $payment->package->name ?? '-' }}</td>
                            <td>{{ $payment->account_name }}</td>
                            <td><code>{{ $payment->transaction_number }}</code></td>
                            <td><span class="badge badge-{{ $payment->status_color }}">{{ ucfirst($payment->status) }}</span></td>
                            <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <div class="flex gap-2">
                                    <button onclick="viewProof('{{ asset('storage/' . $payment->proof_image) }}')" class="btn btn-outline text-sm" style="padding: 0.5rem 0.75rem;">👁️</button>
                                    @if($payment->status == 'pending')
                                    <form action="{{ route('admin.payments.approve', $payment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn text-sm" style="padding: 0.5rem 0.75rem; background: #16a34a; color: white;">✓</button>
                                    </form>
                                    <button onclick="showReject({{ $payment->id }})" class="btn text-sm" style="padding: 0.5rem 0.75rem; background: #dc2626; color: white;">✗</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $payments->links() }}</div>
            @endif
        </div>
    </div>

    <!-- Proof Modal -->
    <div id="proofModal" class="modal-overlay" style="display: none;">
        <div class="modal-content" style="max-width: 36rem;">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Bukti Transfer</h3>
                <button onclick="document.getElementById('proofModal').style.display='none'" class="text-2xl">&times;</button>
            </div>
            <img id="proofImage" src="" alt="Bukti Transfer" style="width: 100%; border-radius: 0.75rem;">
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <h3 class="text-xl font-bold mb-4">Tolak Pembayaran</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Alasan Penolakan (Opsional)</label>
                    <textarea name="rejection_reason" class="form-textarea" placeholder="Tuliskan alasan penolakan..."></textarea>
                </div>
                <div class="flex gap-4">
                    <button type="button" onclick="document.getElementById('rejectModal').style.display='none'" class="btn btn-outline" style="flex: 1;">Batal</button>
                    <button type="submit" class="btn" style="flex: 1; background: #dc2626; color: white;">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
function viewProof(url) {
    document.getElementById('proofImage').src = url;
    document.getElementById('proofModal').style.display = 'flex';
}

function showReject(paymentId) {
    document.getElementById('rejectForm').action = '/admin/payments/' + paymentId + '/reject';
    document.getElementById('rejectModal').style.display = 'flex';
}
</script>
@endpush
