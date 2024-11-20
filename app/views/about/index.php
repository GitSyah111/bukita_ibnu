<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $data['title']; ?></h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Pribadi</h3>
            </div>
            <div class="card-body">
                <p><strong>Nama   :</strong> <?= $data['nama']; ?></p>
                <p><strong>Alamat :</strong> <?= $data['alamat']; ?></p>
                <p><strong>No. HP :</strong> <?= $data['no_hp']; ?></p>
            </div>
            <div class="card-footer">
                Halaman ini menampilkan informasi tentang saya.
            </div>
        </div>
    </section>
</div>