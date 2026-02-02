-- Simplify customer_details table
-- Menghapus kolom: member_sejak, pesanan_terakhir, poin_loyalitas
-- Hanya menyimpan: id, id_user, total_pesanan, total_belanja, catatan, dibuat_pada, diupdate_pada

USE cuciriobabang;

-- Hapus kolom yang tidak diperlukan
ALTER TABLE customer_details 
  DROP COLUMN member_sejak,
  DROP COLUMN pesanan_terakhir,
  DROP COLUMN poin_loyalitas;

-- Struktur akhir customer_details:
-- id, id_user, total_pesanan, total_belanja, catatan, dibuat_pada, diupdate_pada

-- Update data existing (optional - hapus catatan jika tidak diperlukan)
UPDATE customer_details SET catatan = NULL WHERE catatan IS NOT NULL;
