-- Add delivery_method column to bookings table
ALTER TABLE bookings 
ADD COLUMN delivery_method VARCHAR(20) DEFAULT 'antar' 
AFTER alamat_pickup;
