<!-- Pembayaran Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-credit-card"></i> Pembayaran</h1>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-top: 30px;">
    <!-- Main Payment Form -->
    <div>
        <div class="form-card" style="padding: 30px;">
            <h3 style="color: #333; margin-bottom: 25px; font-size: 20px;">
                <i class="fas fa-wallet"></i> Pilih Metode Pembayaran
            </h3>

            <form method="POST" action="index.php?module=pembayaran&action=process" id="paymentForm">
                <input type="hidden" name="pemesanan_id" value="<?= $pemesanan['id'] ?>">

                <!-- E-Wallet Options -->
                <div style="margin-bottom: 30px;">
                    <h4 style="color: #666; margin-bottom: 15px; font-size: 16px; font-weight: 600;">
                        <i class="fas fa-mobile-alt"></i> E-Wallet
                    </h4>
                    <div style="display: grid; gap: 12px;">
                        <label class="payment-option">
                            <input type="radio" name="metode_pembayaran" value="GoPay" required>
                            <div class="payment-card">
                                <i class="fas fa-wallet" style="color: #00AA13;"></i>
                                <span>GoPay</span>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="metode_pembayaran" value="OVO" required>
                            <div class="payment-card">
                                <i class="fas fa-wallet" style="color: #4C3494;"></i>
                                <span>OVO</span>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="metode_pembayaran" value="DANA" required>
                            <div class="payment-card">
                                <i class="fas fa-wallet" style="color: #118EEA;"></i>
                                <span>DANA</span>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="metode_pembayaran" value="ShopeePay" required>
                            <div class="payment-card">
                                <i class="fas fa-wallet" style="color: #EE4D2D;"></i>
                                <span>ShopeePay</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Bank Transfer Options -->
                <div style="margin-bottom: 30px;">
                    <h4 style="color: #666; margin-bottom: 15px; font-size: 16px; font-weight: 600;">
                        <i class="fas fa-university"></i> Transfer Bank
                    </h4>
                    <div style="display: grid; gap: 12px;">
                        <label class="payment-option">
                            <input type="radio" name="metode_pembayaran" value="BCA" required>
                            <div class="payment-card">
                                <i class="fas fa-university" style="color: #003d7a;"></i>
                                <span>Bank BCA</span>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="metode_pembayaran" value="Mandiri" required>
                            <div class="payment-card">
                                <i class="fas fa-university" style="color: #0066AE;"></i>
                                <span>Bank Mandiri</span>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="metode_pembayaran" value="BNI" required>
                            <div class="payment-card">
                                <i class="fas fa-university" style="color: #E6761B;"></i>
                                <span>Bank BNI</span>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="metode_pembayaran" value="BRI" required>
                            <div class="payment-card">
                                <i class="fas fa-university" style="color: #004B96;"></i>
                                <span>Bank BRI</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Digital Payment Options -->
                <div style="margin-bottom: 30px;">
                    <h4 style="color: #666; margin-bottom: 15px; font-size: 16px; font-weight: 600;">
                        <i class="fas fa-qrcode"></i> Pembayaran Digital Lainnya
                    </h4>
                    <div style="display: grid; gap: 12px;">
                        <label class="payment-option">
                            <input type="radio" name="metode_pembayaran" value="QRIS" required>
                            <div class="payment-card">
                                <i class="fas fa-qrcode" style="color: #dc3545;"></i>
                                <span>QRIS</span>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="metode_pembayaran" value="Alfamart" required>
                            <div class="payment-card">
                                <i class="fas fa-store" style="color: #dc3545;"></i>
                                <span>Alfamart</span>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="metode_pembayaran" value="Indomaret" required>
                            <div class="payment-card">
                                <i class="fas fa-store" style="color: #F7A800;"></i>
                                <span>Indomaret</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 15px; margin-top: 35px; padding-top: 25px; border-top: 2px solid #e5e7eb;">
                    <button type="button" onclick="confirmPayment()" class="btn-submit" style="flex: 1;">
                        <i class="fas fa-check-circle"></i> Bayar Sekarang
                    </button>
                    <a href="index.php?module=pemesanan&action=my_orders" class="btn-cancel" style="text-decoration: none; text-align: center;">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar - Order Summary -->
    <div>
        <div class="form-card" style="padding: 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; position: sticky; top: 20px;">
            <h4 style="margin-bottom: 20px; font-size: 18px; border-bottom: 1px solid rgba(255,255,255,0.3); padding-bottom: 15px;">
                <i class="fas fa-receipt"></i> Ringkasan Pesanan
            </h4>
            
            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">Event</div>
                <div style="font-weight: bold; font-size: 16px;"><?= htmlspecialchars($pemesanan['nama_event'] ?? 'Event') ?></div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">Kode Booking</div>
                <div style="font-weight: bold; font-family: monospace;"><?= htmlspecialchars($pemesanan['kode_booking']) ?></div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">
                    <i class="fas fa-ticket-alt"></i> Jenis Tiket
                </div>
                <div style="font-weight: bold;"><?= htmlspecialchars($pemesanan['nama_tiket'] ?? '-') ?></div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">
                    <i class="fas fa-hashtag"></i> Jumlah Tiket
                </div>
                <div style="font-weight: bold;"><?= $pemesanan['jumlah_tiket'] ?> Tiket</div>
            </div>

            <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.3);">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 10px;">Total Pembayaran</div>
                <div style="font-size: 28px; font-weight: bold;">
                    Rp <?= number_format($pemesanan['total_harga'], 0, ',', '.') ?>
                </div>
            </div>

            <div style="margin-top: 25px; padding: 15px; background: rgba(255,255,255,0.1); border-radius: 8px; font-size: 13px;">
                <i class="fas fa-shield-alt"></i> Pembayaran Anda Aman & Terenkripsi
            </div>
        </div>
    </div>
</div>

<style>
.payment-option {
    cursor: pointer;
    display: block;
}

.payment-option input[type="radio"] {
    display: none;
}

.payment-card {
    border: 2px solid #e5e7eb;
    padding: 18px 20px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: all 0.3s ease;
    background: white;
}

.payment-card i {
    font-size: 24px;
}

.payment-card span {
    font-weight: 500;
    color: #333;
    font-size: 15px;
}

.payment-option input[type="radio"]:checked + .payment-card {
    border-color: #7c3aed;
    background: #f5f3ff;
    box-shadow: 0 4px 6px rgba(124, 58, 237, 0.1);
}

.payment-card:hover {
    border-color: #a78bfa;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
</style>

<script>
function confirmPayment() {
    const selectedPayment = document.querySelector('input[name="metode_pembayaran"]:checked');
    
    if (!selectedPayment) {
        alert('Silakan pilih metode pembayaran terlebih dahulu!');
        return;
    }
    
    const metodeName = selectedPayment.value;
    const totalHarga = '<?= number_format($pemesanan['total_harga'], 0, ',', '.') ?>';
    
    if (confirm(`Konfirmasi Pembayaran\n\nMetode: ${metodeName}\nTotal: Rp ${totalHarga}\n\nApakah Anda yakin ingin melanjutkan pembayaran?`)) {
        document.getElementById('paymentForm').submit();
    }
}
</script>