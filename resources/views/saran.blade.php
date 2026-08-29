@extends('layouts.public')

@section('title', 'Saran & Pesan - Museum Pusaka Karo')

@push('styles')
<style>
    :root {
        --primary-red: #7a1b1b;
        --dark-red: #4a0f0f;
        --gold: #c9a84c;
        --cream: #f8f4ed;
        --text-dark: #1a1a2e;
        --text-gray: #43536a;
    }

    .saran-hero {
        background: linear-gradient(135deg, var(--dark-red) 0%, var(--primary-red) 100%);
        padding: 70px 5% 90px;
        color: white;
        text-align: center;
    }
    .saran-hero .badge-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--gold);
        margin-bottom: 15px;
    }
    .saran-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 38px;
        margin-bottom: 15px;
    }
    .saran-hero p {
        max-width: 640px;
        margin: 0 auto;
        opacity: 0.9;
        line-height: 1.7;
        font-size: 15px;
    }

    .saran-container {
        max-width: 800px;
        margin: -50px auto 40px;
        padding: 0 5%;
        position: relative;
        z-index: 2;
    }

    .saran-section {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(15, 23, 42, 0.06);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        padding: 40px 45px;
    }

    .saran-section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        color: var(--text-dark);
        margin-bottom: 15px;
    }

    .saran-section p {
        color: var(--text-gray);
        font-size: 14.5px;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .saran-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .saran-form .full-width {
        grid-column: 1 / -1;
    }

    .saran-form label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .saran-form input,
    .saran-form textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-family: 'Inter', sans-serif;
        font-size: 14.5px;
        outline: none;
        transition: border-color 0.2s;
    }

    .saran-form input:focus,
    .saran-form textarea:focus {
        border-color: var(--primary-red);
    }

    .btn-submit-saran {
        background-color: var(--primary-red);
        color: white;
        border: none;
        padding: 14px 30px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        font-size: 14.5px;
        transition: background-color 0.2s, transform 0.2s;
        display: inline-block;
        margin-top: 10px;
        width: 100%;
    }

    .btn-submit-saran:hover {
        background-color: var(--dark-red);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .saran-form {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="saran-hero">
    <div class="badge-label">KOTAK MASUK</div>
    <h1>Saran & Pesan</h1>
    <p>Kami sangat menghargai setiap masukan, kritik, dan saran dari Anda untuk pengembangan Museum Pusaka Karo menjadi lebih baik lagi.</p>
</div>

<div class="saran-container">
    <div class="saran-section">
        <h2>Kritik & Saran</h2>
        <p>Bantu kami memberikan layanan pelestarian budaya yang lebih optimal. Silakan tuliskan pengalaman, kesan, ataupun masukan Anda selama menggunakan sistem kami atau saat mengunjungi museum.</p>
        
        <form action="{{ route('saran.store') }}" method="POST" class="saran-form" id="saranForm">
            @csrf
            <div>
                <label>Nama Lengkap <span style="color:red">*</span></label>
                <input type="text" name="nama" required placeholder="Masukkan nama Anda">
            </div>
            <div>
                <label>Email (Opsional)</label>
                <input type="email" name="email" placeholder="Masukkan alamat email Anda">
            </div>
            <div class="full-width">
                <label>Pesan / Masukan <span style="color:red">*</span></label>
                <textarea name="pesan" rows="6" required placeholder="Tuliskan kritik dan saran Anda di sini..."></textarea>
            </div>
            <div class="full-width">
                <button type="submit" class="btn-submit-saran" id="btnSubmitSaran">
                    <i class="fa-solid fa-paper-plane" style="margin-right: 6px;"></i> Kirim Pesan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const saranForm = document.getElementById('saranForm');
        if (saranForm) {
            saranForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const btnSubmit = document.getElementById('btnSubmitSaran');
                const originalText = btnSubmit.innerHTML;
                
                // Loading state
                btnSubmit.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="margin-right: 6px;"></i> Mengirim...';
                btnSubmit.disabled = true;

                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Reset loading state
                    btnSubmit.innerHTML = originalText;
                    btnSubmit.disabled = false;

                    if (data.success) {
                        // Reset form
                        saranForm.reset();
                        
                        // SweetAlert Success
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Terimakasih telah mengisi saran dan pesan',
                            confirmButtonColor: '#7a1b1b',
                            confirmButtonText: 'Tutup'
                        });
                    }
                })
                .catch(error => {
                    // Reset loading state
                    btnSubmit.innerHTML = originalText;
                    btnSubmit.disabled = false;

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.',
                        confirmButtonColor: '#7a1b1b'
                    });
                });
            });
        }
    });
</script>
@endpush
