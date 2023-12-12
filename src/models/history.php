<?php

class history
{
    public function get_history($index = 1)
    {
        include('auth.php');

        $sql = "update peminjaman set is_arsip= '1' where tanggal_pinjam<curdate()";
        if ($conn->query($sql) === TRUE) {

            if ($index > 1) {
                $page = $index;
            } else {
                $page = 1;
            }

            $start_from = ($page - 1) * 20;

            $sql = "select pm.id_peminjaman as id,pm.no_identitas as identitas,pe.nama_peminjaman as nama,(select k.kategori from kategori_penyewa k where k.id=pe.kategori) as kategori,pm.deskripsi_pinjam as deskripsi,r.nama_ruangan as ruangan,pm.tanggal_pinjam as tanggal,pm.jam_awal as jam_mulai,pm.jam_akhir as jam_akhir,pm.is_acc as status,pm.upload as upload
          from peminjaman pm
          join peminjam pe on pe.no_identitas=pm.no_identitas
          join ruang r on r.kode_ruang=pm.kode_ruang where is_arsip = '1'  limit   " . $start_from . ",20;";
            $result = $conn->query($sql);


            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
}