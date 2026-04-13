-- ==========================================
-- Database Schema: Northern Cafe Management System
-- Database Engine: PostgreSQL
-- Description: Core tables, inventory triggers, views, and seed data.
-- ==========================================

-- 1. Users (Owner & Pegawai)
CREATE TABLE IF NOT EXISTS users (
  id SERIAL PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(10) CHECK (role IN ('owner', 'pegawai')) NOT NULL,
  is_active BOOLEAN DEFAULT true,
  created_at TIMESTAMP DEFAULT NOW()
);

-- 2. Produk/Menu
CREATE TABLE IF NOT EXISTS products (
  id SERIAL PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  category VARCHAR(50),
  price NUMERIC(12,2) NOT NULL,
  image_url TEXT,
  is_available BOOLEAN DEFAULT true,
  created_at TIMESTAMP DEFAULT NOW()
);

-- 3. Bahan baku (Ingredients)
CREATE TABLE IF NOT EXISTS ingredients (
  id SERIAL PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  unit VARCHAR(20) NOT NULL,
  stock_qty NUMERIC(10,2) DEFAULT 0,
  min_stock NUMERIC(10,2) DEFAULT 0,
  cost_per_unit NUMERIC(12,2) DEFAULT 0,
  updated_at TIMESTAMP DEFAULT NOW()
);

-- 4. Resep produk (Relation product to ingredients)
CREATE TABLE IF NOT EXISTS product_ingredients (
  product_id INT REFERENCES products(id) ON DELETE CASCADE,
  ingredient_id INT REFERENCES ingredients(id) ON DELETE CASCADE,
  qty_used NUMERIC(10,2) NOT NULL,
  PRIMARY KEY (product_id, ingredient_id)
);

-- 5. Supplier
CREATE TABLE IF NOT EXISTS suppliers (
  id SERIAL PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  contact VARCHAR(50),
  address TEXT
);

-- 6. Barang masuk (Stock In)
CREATE TABLE IF NOT EXISTS stock_in (
  id SERIAL PRIMARY KEY,
  ingredient_id INT REFERENCES ingredients(id),
  supplier_id INT REFERENCES suppliers(id),
  qty NUMERIC(10,2) NOT NULL,
  price_per_unit NUMERIC(12,2),
  received_by INT REFERENCES users(id),
  received_at TIMESTAMP DEFAULT NOW()
);

-- 7. Barang keluar manual (Stock Out / Wastage)
CREATE TABLE IF NOT EXISTS stock_out (
  id SERIAL PRIMARY KEY,
  ingredient_id INT REFERENCES ingredients(id),
  qty NUMERIC(10,2) NOT NULL,
  reason TEXT,
  recorded_by INT REFERENCES users(id),
  recorded_at TIMESTAMP DEFAULT NOW()
);

-- 8. Transaksi kasir
CREATE TABLE IF NOT EXISTS transactions (
  id SERIAL PRIMARY KEY,
  transaction_code VARCHAR(30) UNIQUE NOT NULL,
  cashier_id INT REFERENCES users(id),
  total_amount NUMERIC(12,2) NOT NULL,
  payment_method VARCHAR(20) CHECK (payment_method IN ('cash', 'qris', 'transfer')),
  status VARCHAR(20) DEFAULT 'completed',
  created_at TIMESTAMP DEFAULT NOW()
);

-- 9. Item transaksi
CREATE TABLE IF NOT EXISTS transaction_items (
  id SERIAL PRIMARY KEY,
  transaction_id INT REFERENCES transactions(id) ON DELETE CASCADE,
  product_id INT REFERENCES products(id),
  qty INT NOT NULL,
  price_at_sale NUMERIC(12,2) NOT NULL
);

-- 10. Presensi (Attendance)
CREATE TABLE IF NOT EXISTS attendance (
  id SERIAL PRIMARY KEY,
  user_id INT REFERENCES users(id),
  check_in TIMESTAMP,
  check_out TIMESTAMP,
  date DATE NOT NULL,
  notes TEXT,
  UNIQUE(user_id, date)
);

-- ==========================================
-- Triggers & Functions
-- ==========================================

-- Function to reduce stock_qty in ingredients based on product_ingredients recipe
CREATE OR REPLACE FUNCTION fn_reduce_stock_on_transaction()
RETURNS TRIGGER AS $$
BEGIN
    -- Update stock for each ingredient in the recipe of the sold product
    UPDATE ingredients
    SET stock_qty = stock_qty - (pi.qty_used * NEW.qty),
        updated_at = NOW()
    FROM product_ingredients pi
    WHERE pi.ingredient_id = ingredients.id
    AND pi.product_id = NEW.product_id;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Trigger: Execute function after each transaction item is inserted
DROP TRIGGER IF EXISTS trg_reduce_stock ON transaction_items;
CREATE TRIGGER trg_reduce_stock
AFTER INSERT ON transaction_items
FOR EACH ROW
EXECUTE FUNCTION fn_reduce_stock_on_transaction();

-- ==========================================
-- Views & Reports
-- ==========================================

-- Daily Sales View (Revenue & Transaction Count)
CREATE OR REPLACE VIEW v_daily_sales AS
SELECT 
    DATE(created_at) AS sale_date,
    COUNT(id) AS transaction_count,
    SUM(total_amount) AS total_revenue
FROM transactions
GROUP BY DATE(created_at);

-- Low Stock Alert View
CREATE OR REPLACE VIEW v_low_stock AS
SELECT 
    id,
    name,
    unit,
    stock_qty,
    min_stock
FROM ingredients
WHERE stock_qty <= min_stock;

-- ==========================================
-- Indexes for Performance
-- ==========================================
CREATE INDEX IF NOT EXISTS idx_transactions_created_at ON transactions(created_at);
CREATE INDEX IF NOT EXISTS idx_attendance_date ON attendance(date);
CREATE INDEX IF NOT EXISTS idx_ingredients_stock_qty ON ingredients(stock_qty);

-- ==========================================
-- Seed Data
-- ==========================================

-- 3 Users: 1 owner, 2 pegawai
INSERT INTO users (name, email, password, role) VALUES
('Budi Owner', 'owner@cafe.com', 'password123', 'owner'),
('Siti Kasir', 'siti@cafe.com', 'password123', 'pegawai'),
('Agus Kasir', 'agus@cafe.com', 'password123', 'pegawai');

-- 8 Ingredients with initial stock
INSERT INTO ingredients (name, unit, stock_qty, min_stock, cost_per_unit) VALUES
('Biji Kopi Arabica', 'kg', 10.00, 2.00, 200000),
('Susu Fresh', 'liter', 20.00, 5.00, 15000),
('Gula Aren', 'liter', 5.00, 1.00, 30000),
('Es Batu', 'bag', 50.00, 10.00, 5000),
('Teh Celup', 'box', 10.00, 2.00, 20000),
('Roti Tawar', 'pack', 15.00, 3.00, 12000),
('Cokelat Bubuk', 'kg', 3.00, 1.00, 80000),
('Air Mineral', 'galon', 5.00, 1.00, 18000);

-- 6 Menu Products
INSERT INTO products (name, category, price, is_available) VALUES
('Es Kopi Susu Aren', 'Coffee', 22000, true),
('Americano Hot', 'Coffee', 18000, true),
('Thai Tea Ice', 'Tea', 15000, true),
('Roti Bakar Cokelat', 'Snack', 12000, true),
('Matcha Latte', 'Non-Coffee', 25000, true),
('French Fries', 'Snack', 15000, true);

-- Recipes (Product Ingredients)
INSERT INTO product_ingredients (product_id, ingredient_id, qty_used) VALUES
-- Es Kopi Susu Aren: Kopi (0.02kg), Susu (0.2L), Gula Aren (0.05L), Es (1bag/10)
(1, 1, 0.02), (1, 2, 0.2), (1, 3, 0.05), (1, 4, 0.1),
-- Americano Hot: Kopi (0.02kg)
(2, 1, 0.02),
-- Thai Tea: Teh (1/10 box), Susu (0.1L), Es (0.1 bag)
(3, 5, 0.1), (3, 2, 0.1), (3, 4, 0.1),
-- Roti Bakar: Roti (2 sheets ~ 0.2 pack), Cokelat (0.05kg)
(4, 6, 0.2), (4, 7, 0.05);

-- 2 Suppliers
INSERT INTO suppliers (name, contact, address) VALUES
('CV Sumber Makmur', '08123456789', 'Jl. Sukarno No. 1'),
('Toko Bahan Kue Asep', '08987654321', 'Pasar Baru Blok A');

-- 5 Sample Transactions today
INSERT INTO transactions (transaction_code, cashier_id, total_amount, payment_method, created_at) VALUES
('TXN-20240412-001', 2, 44000, 'cash', NOW()),
('TXN-20240412-002', 2, 18000, 'qris', NOW()),
('TXN-20240412-003', 3, 15000, 'transfer', NOW()),
('TXN-20240412-004', 3, 22000, 'cash', NOW()),
('TXN-20240412-005', 2, 33000, 'qris', NOW());

-- Transaction Items (this will trigger stock reduction)
INSERT INTO transaction_items (transaction_id, product_id, qty, price_at_sale) VALUES
(1, 1, 2, 22000), -- 2 Es Kopi Susu Aren
(2, 2, 1, 18000), -- 1 Americano
(3, 3, 1, 15000), -- 1 Thai Tea
(4, 1, 1, 22000), -- 1 Es Kopi Susu Aren
(5, 4, 1, 12000), -- 1 Roti Bakar
(5, 6, 1, 15000); -- 1 French Fries (no ingredients recorded yet, won't reduce anything)
