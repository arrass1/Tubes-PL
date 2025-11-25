-- Migration for MySQL (tested on 8.0+)
-- WARNING: BACKUP your database before running this script.
USE `event_management`;

-- 1) Remove `harga_tiket` and `kapasitas` from `events` (these fields will live in `tiket`)
ALTER TABLE `events` DROP COLUMN `kapasitas`;
ALTER TABLE `events` DROP COLUMN `harga_tiket`;

-- 2) Add `tiket_id` column to `pemesanan`
ALTER TABLE `pemesanan` ADD COLUMN `tiket_id` INT NULL AFTER `event_id`;

-- 3) Map existing pemesanan.event_id -> pemesanan.tiket_id by joining to tiket
--    This will set tiket_id to one matching tiket per event (first matched by JOIN)
UPDATE `pemesanan` p
JOIN `tiket` t ON t.event_id = p.event_id
SET p.tiket_id = t.id
WHERE p.tiket_id IS NULL;

-- 4) Drop foreign key that references events (use the actual constraint name from your DB)
--    If your FK name differs, change `pemesanan_ibfk_2` to the correct name.
ALTER TABLE `pemesanan` DROP FOREIGN KEY `pemesanan_ibfk_2`;

-- 5) Drop the old event_id column
ALTER TABLE `pemesanan` DROP COLUMN `event_id`;

-- 6) Add foreign key from pemesanan.tiket_id -> tiket.id
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`tiket_id`) REFERENCES `tiket` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Done. Verify the results and update any remaining application code references.
