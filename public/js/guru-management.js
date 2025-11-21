// Data Guru Management Script
document.addEventListener('DOMContentLoaded', function() {
    // Alpine.js data
    Alpine.data('guruManager', function() {
        return {
            openTambah: false,
            openEdit: false,
            openDetail: false,
            openDelete: false,
            deleteId: null,
            currentEditId: null,
            currentDetailId: null,
            dataGuru: {!! json_encode($guru) !!},
            pembelajaran: {!! json_encode($pembelajaran) !!},
            formData: {
                // Data Guru
                nama_guru: '',
                nip: '',
                nuptk: '',
                jenis_kelamin: 'L',
                jenis_ptk: '',
                role: 'guru_mapel',
                status: 'aktif',
                id_pembelajaran: '',

                // Data Detail Guru
                tempat_lahir: '',
                tanggal_lahir: '',
                status_kepegawaian: '',
                agama: '',
                alamat: '',
                rt: '',
                rw: '',
                dusun: '',
                kelurahan: '',
                kecamatan: '',
                kode_pos: '',
                no_telp: '',
                no_hp: '',
                email: '',
                tugas_tambahan: '',
                sk_cpns: '',
                tgl_cpns: '',
                sk_pengangkatan: '',
                tmt_pengangkatan: '',
                lembaga_pengangkatan: '',
                pangkat_gol: '',
                sumber_gaji: '',
                nama_ibu_kandung: '',
                status_perkawinan: '',
                nama_suami_istri: '',
                nip_suami_istri: '',
                pekerjaan_suami_istri: '',
                tmt_pns: '',
                lisensi_kepsek: 'Tidak',
                diklat_kepengawasan: 'Tidak',
                keahlian_braille: 'Tidak',
                keahlian_isyarat: 'Tidak',
                npwp: '',
                nama_wajib_pajak: '',
                kewarganegaraan: 'WNI',
                bank: '',
                norek_bank: '',
                nama_rek: '',
                nik: '',
                no_kk: '',
                karpeg: '',
                karis_karsu: '',
                lintang: '',
                bujur: '',
                nuks: ''
            },

            resetForm() {
                this.formData = {
                    // Data Guru
                    nama_guru: '',
                    nip: '',
                    nuptk: '',
                    jenis_kelamin: 'L',
                    jenis_ptk: '',
                    role: 'guru_mapel',
                    status: 'aktif',
                    id_pembelajaran: '',

                    // Data Detail Guru
                    tempat_lahir: '',
                    tanggal_lahir: '',
                    status_kepegawaian: '',
                    agama: '',
                    alamat: '',
                    rt: '',
                    rw: '',
                    dusun: '',
                    kelurahan: '',
                    kecamatan: '',
                    kode_pos: '',
                    no_telp: '',
                    no_hp: '',
                    email: '',
                    tugas_tambahan: '',
                    sk_cpns: '',
                    tgl_cpns: '',
                    sk_pengangkatan: '',
                    tmt_pengangkatan: '',
                    lembaga_pengangkatan: '',
                    pangkat_gol: '',
                    sumber_gaji: '',
                    nama_ibu_kandung: '',
                    status_perkawinan: '',
                    nama_suami_istri: '',
                    nip_suami_istri: '',
                    pekerjaan_suami_istri: '',
                    tmt_pns: '',
                    lisensi_kepsek: 'Tidak',
                    diklat_kepengawasan: 'Tidak',
                    keahlian_braille: 'Tidak',
                    keahlian_isyarat: 'Tidak',
                    npwp: '',
                    nama_wajib_pajak: '',
                    kewarganegaraan: 'WNI',
                    bank: '',
                    norek_bank: '',
                    nama_rek: '',
                    nik: '',
                    no_kk: '',
                    karpeg: '',
                    karis_karsu: '',
                    lintang: '',
                    bujur: '',
                    nuks: ''
                };
            },

            async saveGuru() {
                try {
                    const url = this.currentEditId ?
                        `/dashboard/data_guru/${this.currentEditId}` :
                        '/dashboard/data_guru';

                    const method = this.currentEditId ? 'PUT' : 'POST';

                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(this.formData)
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Show success notification
                        this.showNotification('success', data.message);

                        // Close modal
                        this.openTambah = false;
                        this.openEdit = false;

                        // Refresh data
                        await this.loadData();

                        // Reset form
                        this.resetForm();
                        this.currentEditId = null;
                    } else {
                        // Show error notification
                        this.showNotification('error', data.message);
                        if (data.errors) {
                            console.error('Validation errors:', data.errors);
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showNotification('error', 'Terjadi kesalahan saat menyimpan data');
                }
            },

            async loadGuruData(id) {
                try {
                    const response = await fetch(`/dashboard/data_guru/${id}`);
                    const data = await response.json();

                    if (data.success) {
                        // Fill form with guru data
                        const guru = data.data;

                        // Data Guru
                        this.formData.nama_guru = guru.nama_guru || '';
                        this.formData.nip = guru.nip || '';
                        this.formData.nuptk = guru.nuptk || '';
                        this.formData.jenis_kelamin = guru.jenis_kelamin || 'L';
                        this.formData.jenis_ptk = guru.jenis_ptk || '';
                        this.formData.role = guru.role || 'guru_mapel';
                        this.formData.status = guru.status || 'aktif';
                        this.formData.id_pembelajaran = guru.id_pembelajaran || '';

                        // Data Detail Guru
                        if (guru.detail_guru) {
                            this.formData.tempat_lahir = guru.detail_guru.tempat_lahir || '';
                            this.formData.tanggal_lahir = guru.detail_guru.tanggal_lahir || '';
                            this.formData.status_kepegawaian = guru.detail_guru.status_kepegawaian || '';
                            this.formData.agama = guru.detail_guru.agama || '';
                            this.formData.alamat = guru.detail_guru.alamat || '';
                            this.formData.rt = guru.detail_guru.rt || '';
                            this.formData.rw = guru.detail_guru.rw || '';
                            this.formData.dusun = guru.detail_guru.dusun || '';
                            this.formData.kelurahan = guru.detail_guru.kelurahan || '';
                            this.formData.kecamatan = guru.detail_guru.kecamatan || '';
                            this.formData.kode_pos = guru.detail_guru.kode_pos || '';
                            this.formData.no_telp = guru.detail_guru.no_telp || '';
                            this.formData.no_hp = guru.detail_guru.no_hp || '';
                            this.formData.email = guru.detail_guru.email || '';
                            this.formData.tugas_tambahan = guru.detail_guru.tugas_tambahan || '';
                            this.formData.sk_cpns = guru.detail_guru.sk_cpns || '';
                            this.formData.tgl_cpns = guru.detail_guru.tgl_cpns || '';
                            this.formData.sk_pengangkatan = guru.detail_guru.sk_pengangkatan || '';
                            this.formData.tmt_pengangkatan = guru.detail_guru.tmt_pengangkatan || '';
                            this.formData.lembaga_pengangkatan = guru.detail_guru.lembaga_pengangkatan || '';
                            this.formData.pangkat_gol = guru.detail_guru.pangkat_gol || '';
                            this.formData.sumber_gaji = guru.detail_guru.sumber_gaji || '';
                            this.formData.nama_ibu_kandung = guru.detail_guru.nama_ibu_kandung || '';
                            this.formData.status_perkawinan = guru.detail_guru.status_perkawinan || '';
                            this.formData.nama_suami_istri = guru.detail_guru.nama_suami_istri || '';
                            this.formData.nip_suami_istri = guru.detail_guru.nip_suami_istri || '';
                            this.formData.pekerjaan_suami_istri = guru.detail_guru.pekerjaan_suami_istri || '';
                            this.formData.tmt_pns = guru.detail_guru.tmt_pns || '';
                            this.formData.lisensi_kepsek = guru.detail_guru.lisensi_kepsek || 'Tidak';
                            this.formData.diklat_kepengawasan = guru.detail_guru.diklat_kepengawasan || 'Tidak';
                            this.formData.keahlian_braille = guru.detail_guru.keahlian_braille || 'Tidak';
                            this.formData.keahlian_isyarat = guru.detail_guru.keahlian_isyarat || 'Tidak';
                            this.formData.npwp = guru.detail_guru.npwp || '';
                            this.formData.nama_wajib_pajak = guru.detail_guru.nama_wajib_pajak || '';
                            this.formData.kewarganegaraan = guru.detail_guru.kewarganegaraan || 'WNI';
                            this.formData.bank = guru.detail_guru.bank || '';
                            this.formData.norek_bank = guru.detail_guru.norek_bank || '';
                            this.formData.nama_rek = guru.detail_guru.nama_rek || '';
                            this.formData.nik = guru.detail_guru.nik || '';
                            this.formData.no_kk = guru.detail_guru.no_kk || '';
                            this.formData.karpeg = guru.detail_guru.karpeg || '';
                            this.formData.karis_karsu = guru.detail_guru.karis_karsu || '';
                            this.formData.lintang = guru.detail_guru.lintang || '';
                            this.formData.bujur = guru.detail_guru.bujur || '';
                            this.formData.nuks = guru.detail_guru.nuks || '';
                        }

                        return true;
                    } else {
                        this.showNotification('error', data.message);
                        return false;
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showNotification('error', 'Terjadi kesalahan saat mengambil data guru');
                    return false;
                }
            },

            async editGuru(id) {
                const dataLoaded = await this.loadGuruData(id);
                if (dataLoaded) {
                    this.currentEditId = id;
                    this.openEdit = true;
                }
            },

            async detailGuru(id) {
                const dataLoaded = await this.loadGuruData(id);
                if (dataLoaded) {
                    this.currentDetailId = id;
                    this.openDetail = true;
                }
            },

            deleteGuru(id) {
                this.deleteId = id;
                this.openDelete = true;
            },

            async confirmDelete() {
                try {
                    const response = await fetch(`/dashboard/data_guru/${this.deleteId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.showNotification('success', data.message);
                        this.openDelete = false;
                        this.deleteId = null;
                        await this.loadData();
                    } else {
                        this.showNotification('error', data.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showNotification('error', 'Terjadi kesalahan saat menghapus data');
                }
            },

            async loadData() {
                try {
                    const response = await fetch('/dashboard/data_guru');
                    const text = await response.text();

                    // Extract data from the page
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(text, 'text/html');

                    // Get the updated data from Alpine.js data attribute
                    // This is a workaround since we're using server-side rendering
                    location.reload();
                } catch (error) {
                    console.error('Error:', error);
                    this.showNotification('error', 'Terjadi kesalahan saat memuat data');
                }
            },

            showNotification(type, message) {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all transform ${
                    type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
                }`;
                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
                        <span>${message}</span>
                    </div>
                `;

                document.body.appendChild(notification);

                // Remove notification after 3 seconds
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        }
    });
});