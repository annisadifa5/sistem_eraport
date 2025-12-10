<table style="margin-bottom:8px;">
  <tr><td style="width:170px">Nama Peserta Didik</td><td>: {{ $siswa->nama_siswa ?? '-' }}</td></tr>
  <tr><td>NISN</td><td>: {{ $siswa->nisn ?? '-' }}</td></tr>
  <tr><td>Kelas</td><td>: {{ $siswa->kelas->nama_kelas ?? '-' }}</td></tr>

  <tr>
    <td>Tahun Ajaran</td>
    <td>:
      @if(isset($nilai) && is_object($nilai) && $nilai->count() && isset($nilai->first()->tahunAjaran->tahun_ajaran))
          {{ $nilai->first()->tahunAjaran->tahun_ajaran }}
      @else
          {{ tahunAjaran(isset($nilai) ? $nilai : null) }}
      @endif
    </td>
  </tr>

  <tr>
    <td>Semester</td>
    <td>:
      @if(isset($nilai) && is_object($nilai) && $nilai->count() && $nilai->first()->semester)
        {{ ucfirst($nilai->first()->semester) }}
      @else
        -
      @endif
    </td>
  </tr>
</table>
