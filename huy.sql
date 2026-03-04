CREATE DATABASE IF NOT EXISTS chunguyengiabao;
USE chunguyengiabao;

CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES category(id)
);

INSERT INTO category (name, description) VALUES
('Điện tử', 'Các sản phẩm điện tử'),
('Vật dụng', 'Các vật dụng gia đình'),
('Thời trang', 'Quần áo và phụ kiện thời trang');
categoryproductcategorychunguyengiabaoinformation_schemaADMINISTRABLE_ROLE_AUTHORIZATIONSAPPLICABLE_ROLES