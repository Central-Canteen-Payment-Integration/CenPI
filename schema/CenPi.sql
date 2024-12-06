CREATE TABLE USERS (
    id_user VARCHAR2(36) PRIMARY KEY,
    email VARCHAR2(50) NOT NULL UNIQUE,
    username VARCHAR2(30) NOT NULL UNIQUE,
    password VARCHAR2(255) NOT NULL,
    active NUMBER(1) DEFAULT 0 CHECK (active IN (0, 1)),
    token_activation VARCHAR2(36),
    forgot_password_token VARCHAR2(36),
    token_expiry TIMESTAMP DEFAULT NULL,
    image_path VARCHAR2(36)
);

CREATE TABLE TENANT (
    id_tenant VARCHAR2(36) PRIMARY KEY,
    tenant_name VARCHAR2(50) NOT NULL UNIQUE,
    email VARCHAR2(50) NOT NULL UNIQUE,
    username VARCHAR2(30) NOT NULL UNIQUE,
    password VARCHAR2(255) NOT NULL,
    active NUMBER(1) DEFAULT 0 CHECK (active IN (0, 1)),
    forgot_password_token VARCHAR2(36),
    token_expiry TIMESTAMP DEFAULT NULL,
    image_path VARCHAR2(36),
    location_name VARCHAR2(20),
    location_booth VARCHAR2(20),
    deleted_at TIMESTAMP DEFAULT NULL
);

CREATE TABLE MENU (
    id_menu VARCHAR2(36) PRIMARY KEY,
    id_tenant VARCHAR2(36) NOT NULL,
    name VARCHAR2(100) NOT NULL,
    price INT NOT NULL CHECK (price >= 0),
    pkg_price INT,
    image_path VARCHAR2(36),
    active NUMBER(1) DEFAULT 0 CHECK (active IN (0, 1)),
    FOREIGN KEY (id_tenant) REFERENCES TENANT(id_tenant)
);

CREATE TABLE TRANSACTION (
    id_transaction VARCHAR2(36) PRIMARY KEY,
    id_user VARCHAR2(36) NOT NULL,
    trx_price INT NOT NULL CHECK (trx_price >= 0),
    trx_date DATE NOT NULL,
    takeaway NUMBER(1) DEFAULT 0 CHECK (active IN (0, 1)),
    trx_status VARCHAR2(50) CHECK (trx_status IN ('pending', 'completed')),
    trx_expiry TIMESTAMP DEFAULT NULL,
    FOREIGN KEY (id_user) REFERENCES USERS(id_user)
);

CREATE TABLE TRANSACTION_DETAIL (
    id_transaction VARCHAR2(36),
    id_menu VARCHAR2(36),
    qty INT,
    qty_price INT,
    pkg_price INT,
    notes VARCHAR2(100),
    status VARCHAR2(50) CHECK (status IN ('waiting' ,'pending', 'completed')),
    FOREIGN KEY (id_transaction) REFERENCES TRANSACTION(id_transaction),
    FOREIGN KEY (id_menu) REFERENCES MENU(id_menu)
);

CREATE TABLE CATEGORY (
    id_category VARCHAR2(36) PRIMARY KEY,
    category_name VARCHAR2(20) NOT NULL
);

CREATE TABLE MENU_CATEGORY (
    id_menu VARCHAR2(36),
    id_category VARCHAR2(36),
    FOREIGN KEY (id_menu) REFERENCES MENU(id_menu),
    FOREIGN KEY (id_category) REFERENCES CATEGORY(id_category)
);

CREATE TABLE CART (
    id_cart VARCHAR2(36) PRIMARY KEY,
    id_user VARCHAR2(36) NOT NULL,
    id_menu VARCHAR2(36) NOT NULL,
    qty INT NOT NULL CHECK (qty >= 0),
    notes VARCHAR2(100),
    FOREIGN KEY (id_user) REFERENCES USERS(id_user),
    FOREIGN KEY (id_menu) REFERENCES MENU(id_menu)
);

INSERT INTO TENANT (
    id_tenant, tenant_name, email, username, password, active, forgot_password_token, token_expiry, image_path, location_name, location_booth
) VALUES (
    '4b6482e0-09a9-4d1b-a9ad-c6c6c6f8d1f1', 'Warung Mas Budi', 'warungbudi@example.com', 'warungbudi', 'password123', 0, NULL, NULL, 'image001.png', 'Food Court A', 'Booth 12'
);

INSERT INTO TENANT (
    id_tenant, tenant_name, email, username, password, active, forgot_password_token, token_expiry, image_path, location_name, location_booth
) VALUES (
    '64d492bc-8c56-41b7-a29c-3f3f9e6cb662', 'Kopi Rindu', 'kopirindu@example.com', 'kopirindu', 'securepass456', 1, NULL, NULL, 'image002.png', 'Food Court B', 'Booth 8'
);

INSERT INTO TENANT (
    id_tenant, tenant_name, email, username, password, active, forgot_password_token, token_expiry, image_path, location_name, location_booth
) VALUES (
    '1e27f13a-b6a2-4312-9c37-5d1e9b9a6d7e', 'Ayam Geprek Enak', 'geprekenak@example.com', 'geprek_enak', 'enakbanget789', 1, NULL, NULL, 'image003.png', 'Food Court C', 'Booth 15'
);

INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price, image_path, active) 
VALUES ('da678372-2b89-4b23-a2a2-64ed3c3f9201', '4b6482e0-09a9-4d1b-a9ad-c6c6c6f8d1f1', 'Nasi Goreng', 20000, 2000, 'nasigoreng.jpeg', 1);

INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price, image_path, active) 
VALUES ('72824bc6-4d9f-41eb-93a7-546dfc6beec7', '4b6482e0-09a9-4d1b-a9ad-c6c6c6f8d1f1', 'Mie Goreng', 18000, 2000, 'miegoreng.jpg', 1);

INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price, image_path, active) 
VALUES ('9d15e442-47cc-419b-a8a2-b56d6f4a2e2c', '64d492bc-8c56-41b7-a29c-3f3f9e6cb662', 'Es Kopi Susu', 15000, 0, 'eskopisusu.jpeg', 1);

INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price, image_path, active) 
VALUES ('b3f8440d-9536-45d3-9cb4-3a3426a73f0b', '64d492bc-8c56-41b7-a29c-3f3f9e6cb662', 'Kopi Hitam', 12000, 0, 'kopihitam.jpg', 1);

INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price, image_path, active) 
VALUES ('b95852c5-5cdd-4696-bd99-86c264a85a1d', '1e27f13a-b6a2-4312-9c37-5d1e9b9a6d7e', 'Ayam Geprek Original', 25000, 2000, 'ayamgeprekoriginal.jpg', 1);

INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price, image_path, active) 
VALUES ('ee8979fa-483c-4d87-8b3b-c2ec4f318162', '1e27f13a-b6a2-4312-9c37-5d1e9b9a6d7e', 'Ayam Geprek Keju', 30000, 2000, 'ayamgeprekkeju.jpg', 1);

INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price, image_path, active) 
VALUES ('a4de849e-34a9-45f9-8e69-1964c34434ab', '1e27f13a-b6a2-4312-9c37-5d1e9b9a6d7e', 'Nasi Bakar', 15000, 2000, null, 1);

COMMIT;