<?= $this->extend('layout_admin'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3"><?= $title ?></div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/artikel') ?>">Artikel</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <?php if (session()->has('success')) : ?>
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
            <div class="text-white"><?= session('success') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>
    <?php if (session()->has('danger')) : ?>
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
            <div class="text-white"><?= session('danger') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Form Artikel</h5>
            <hr />
            <?php
            $selectedTagIds = old('tag_ids');
            if ($selectedTagIds === null) {
                $selectedTagIds = $selectedTags ?? [];
            } elseif (!is_array($selectedTagIds)) {
                $selectedTagIds = [$selectedTagIds];
            }
            ?>
            <div id="successAlert"></div>
            <form id="artikelForm" action="<?= base_url('admin/artikel/' . $url) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= esc(old('id', $artikel->id ?? '')) ?>">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group mb-4">
                            <label for="judul"><span class="text-danger">*</span> Judul</label>
                            <input type="text" class="form-control <?= (isset(session('errors')['judul'])) ? 'is-invalid' : '' ?>" id="judul" name="judul" value="<?= esc(old('judul', $artikel->judul ?? '')) ?>">
                            <div class="invalid-feedback">
                                <?= session('errors')['judul'] ?? '' ?>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="isi"><span class="text-danger">*</span> Isi</label>
                            <textarea rows="15" class="form-control <?= (isset(session('errors')['isi'])) ? 'is-invalid' : '' ?>" id="editor2" name="isi"><?= old('isi', $artikel->isi ?? '') ?></textarea>
                            <div class="invalid-feedback">
                                <?= session('errors')['isi'] ?? '' ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-4">
                                <label for="status">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="draft" <?= old('status', $artikel->status ?? 'draft') === 'draft' ? 'selected' : '' ?>>Draft</option>
                                    <option value="published" <?= old('status', $artikel->status ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-4">
                                <label for="published_at">Tanggal Publikasi</label>
                                <input type="datetime-local" class="form-control" id="published_at" name="published_at" value="<?= old('published_at', isset($artikel->published_at) && $artikel->published_at ? date('Y-m-d\TH:i', strtotime($artikel->published_at)) : '') ?>">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <button type="submit" class="btn btn-primary">Simpan Artikel</button>
                            <a href="<?= base_url('admin/artikel') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card border mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Tag Artikel</h6>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tagModal">Tambah Tag</button>
                                </div>
                                <div id="tag-list" class="mb-3">
                                    <?php if (!empty($tags)) : ?>
                                        <?php foreach ($tags as $tag) : ?>
                                            <divpanduan rotasi menit 0–10 khusus roamer Mythic solo ran class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tag_ids[]" value="<?= esc($tag['id']) ?>" id="tag-<?= esc($tag['id']) ?>" <?= in_array($tag['id'], $selectedTagIds) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="tag-<?= esc($tag['id']) ?>"><?= esc($tag['nama']) ?></label>
                                            </divpanduan>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <div class="text-muted">Belum ada tag.</div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="modal fade" id="tagModal" tabindex="-1" aria-labelledby="tagModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tagModalLabel">Tambah Tag</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="tagForm">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label for="tag_name" class="form-label">Nama Tag</label>
                                    <input type="text" class="form-control" id="tag_name" name="nama" required>
                                    <div class="invalid-feedback" id="tagError"></div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" id="saveTagBtn" class="btn btn-primary">Simpan Tag</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script>
    CKEDITOR.replace('editor2', {
        extraPlugins: ['justify', 'btgrid'],
        versionCheck: false
    });

    // Handle form submission via AJAX
    // document.getElementById('submitBtn').addEventListener('click', async function() {
    //     const btn = this;
    //     const form = document.getElementById('artikelForm');
    //     const successAlert = document.getElementById('successAlert');

    //     // Get form data
    //     const formData = new FormData(form);

    //     // Update CKEditor content
    //     if (CKEDITOR.instances.editor2) {
    //         formData.set('isi', CKEDITOR.instances.editor2.getData());
    //     }

    //     btn.disabled = true;
    //     btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...';

    //     try {
    //         const response = await fetch(form.action, {
    //             method: 'POST',
    //             body: formData,
    //             credentials: 'same-origin',
    //         });

    //         const result = await response.json();

    //         if (result.success) {
    //             // Update CSRF token
    //             if (result.csrf_hash) {
    //                 const csrfField = form.querySelector('input[name="<?= csrf_token() ?>"]');
    //                 if (csrfField) {
    //                     csrfField.value = result.csrf_hash;
    //                 }
    //             }

    //             // Show success alert
    //             successAlert.innerHTML = '<div class="alert alert-success border-0 bg-success alert-dismissible fade show"><div class="text-white">' + (result.message || 'Artikel berhasil disimpan!') + '</div><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    //             successAlert.scrollIntoView({
    //                 behavior: 'smooth',
    //                 block: 'nearest'
    //             });

    //             // Clear old errors
    //             form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    //             form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

    //             // Reset form if creating new
    //             if ('<?= $url ?>' === 'insert') {
    //                 form.reset();
    //                 if (CKEDITOR.instances.editor2) {
    //                     CKEDITOR.instances.editor2.setData('');
    //                 }
    //             }
    //         } else {
    //             // Handle validation errors
    //             if (result.errors) {
    //                 Object.keys(result.errors).forEach(field => {
    //                     const input = form.querySelector('[name="' + field + '"]');
    //                     if (input) {
    //                         input.classList.add('is-invalid');
    //                         const feedback = input.nextElementSibling;
    //                         if (feedback && feedback.classList.contains('invalid-feedback')) {
    //                             feedback.textContent = result.errors[field];
    //                         }
    //                     }
    //                 });
    //                 successAlert.innerHTML = '<div class="alert alert-danger border-0 bg-danger alert-dismissible fade show"><div class="text-white">Ada kesalahan validasi. Silakan periksa kembali.</div><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    //             } else {
    //                 successAlert.innerHTML = '<div class="alert alert-danger border-0 bg-danger alert-dismissible fade show"><div class="text-white">' + (result.message || 'Gagal menyimpan artikel.') + '</div><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    //             }
    //         }
    //     } catch (error) {
    //         successAlert.innerHTML = '<div class="alert alert-danger border-0 bg-danger alert-dismissible fade show"><div class="text-white">Terjadi kesalahan: ' + error.message + '</div><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    //     } finally {
    //         btn.disabled = false;
    //         btn.innerHTML = 'Simpan Artikel';
    //     }
    // });

    document.getElementById('saveTagBtn').addEventListener('click', async function(e) {
        e.preventDefault();
        const btn = this;
        const tagNameInput = document.getElementById('tag_name');
        const tagError = document.getElementById('tagError');
        const tagForm = document.getElementById('tagForm');
        const name = tagNameInput.value.trim();

        tagError.textContent = '';
        tagNameInput.classList.remove('is-invalid');

        if (!name) {
            tagError.textContent = 'Nama tag tidak boleh kosong.';
            tagNameInput.classList.add('is-invalid');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...';

        const formData = new FormData(tagForm);
        try {
            const response = await fetch('<?= base_url('admin/artikel/tag-add') ?>', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
            });

            const result = await response.json();
            console.log('Tag response:', result);

            if (!result.success) {
                tagError.textContent = result.message || 'Gagal menambahkan tag.';
                tagNameInput.classList.add('is-invalid');
                return;
            }

            // Update CSRF token
            if (result.csrf_hash) {
                const csrfField = tagForm.querySelector('input[name="<?= csrf_token() ?>"]');
                if (csrfField) {
                    csrfField.value = result.csrf_hash;
                    console.log('CSRF token updated');
                }
            }

            // Save previously checked tag IDs before updating list
            const previouslyChecked = Array.from(document.querySelectorAll('input[name="tag_ids[]"]:checked')).map(input => String(input.value));
            console.log('Previously checked tags:', previouslyChecked);
            console.log('New tag ID:', result.tag.id);
            console.log('All tags:', result.tags);

            updateTagList(result.tags, result.tag.id, previouslyChecked);
            tagNameInput.value = '';
            const tagModal = bootstrap.Modal.getInstance(document.getElementById('tagModal'));
            tagModal.hide();
            console.log('Tag added successfully');
        } catch (error) {
            console.error('Error adding tag:', error);
            tagError.textContent = 'Terjadi kesalahan saat menyimpan tag.';
            tagNameInput.classList.add('is-invalid');
        } finally {
            btn.disabled = false;
            btn.innerHTML = 'Simpan Tag';
        }
    });

    // Prevent form submission on Enter key
    document.getElementById('tagForm').addEventListener('submit', function(e) {
        e.preventDefault();
    });

    function updateTagList(tags, newTagId, previouslyChecked = []) {
        const container = document.getElementById('tag-list');
        container.innerHTML = '';
        tags.forEach(function(tag) {
            const tagIdStr = String(tag.id);
            const wasChecked = previouslyChecked.includes(tagIdStr);
            const isNewTag = tagIdStr === String(newTagId);

            const wrapper = document.createElement('div');
            wrapper.className = 'form-check mb-1';

            const input = document.createElement('input');
            input.className = 'form-check-input';
            input.type = 'checkbox';
            input.name = 'tag_ids[]';
            input.value = tag.id;
            input.id = 'tag-' + tag.id;
            input.checked = wasChecked || isNewTag;

            const label = document.createElement('label');
            label.className = 'form-check-label';
            label.htmlFor = 'tag-' + tag.id;
            label.textContent = tag.nama;

            wrapper.appendChild(input);
            wrapper.appendChild(label);
            container.appendChild(wrapper);
        });
    }
</script>
<?= $this->endSection(); ?>