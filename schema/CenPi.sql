CREATE TABLE USERS (
    id_user VARCHAR2(36) PRIMARY KEY,
    email VARCHAR2(50) NOT NULL UNIQUE,
    username VARCHAR2(30) NOT NULL UNIQUE,
    password VARCHAR2(255) NOT NULL,
    active NUMBER(1) DEFAULT 0 CHECK (active IN (0, 1)),
    token_activation VARCHAR2(36),
    forgot_password_token VARCHAR2(36),
    token_expiry DATE,
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
    token_expiry DATE,
    image_path VARCHAR2(36),
);

CREATE TABLE TENANT_LOCATION (
    id_tenant_location VARCHAR2(36) PRIMARY KEY,
    location_name VARCHAR2(20),
    location_booth VARCHAR2(20)
)

CREATE TABLE MENU (
    id_menu VARCHAR2(36) PRIMARY KEY,
    id_tenant VARCHAR2(36) NOT NULL,
    name VARCHAR2(100) NOT NULL,
    price INT NOT NULL,
    pkg_price INT,
    image_path VARCHAR2(36),
    active NUMBER(1) DEFAULT 0 CHECK (active IN (0, 1)),
    FOREIGN KEY (id_tenant) REFERENCES TENANT(id_tenant)
);

CREATE TABLE TRANSACTION (
    id_transaction VARCHAR2(36) PRIMARY KEY,
    id_user VARCHAR2(36) NOT NULL,
    trx_price INT NOT NULL,
    trx_date DATE NOT NULL,
    id_status VARCHAR2(50),
    FOREIGN KEY (id_user) REFERENCES USERS(id_user),
    FOREIGN KEY (id_status) REFERENCES STATUS_DETAIL(id_status)
);

CREATE TABLE TRANSACTION_DETAIL (
    id_transaction VARCHAR2(36),
    id_menu VARCHAR2(36),
    qty INT NOT NULL,
    qty_price INT NOT NULL,
    pkg_price INT,
    notes VARCHAR2(100),
    id_status VARCHAR2(50),
    FOREIGN KEY (id_transaction) REFERENCES TRANSACTION(id_transaction),
    FOREIGN KEY (id_menu) REFERENCES MENU(id_menu),
    FOREIGN KEY (id_status) REFERENCES STATUS_DETAIL(id_status)
);

CREATE TABLE STATUS (
    id_status VARCHAR2(36) PRIMARY KEY,
    status VARCHAR2(30)
)

CREATE TABLE MENU_CATEGORY (
    id_menu VARCHAR2(36),
    id_category VARCHAR2(36),
    FOREIGN KEY (id_menu) REFERENCES MENU(id_menu),
    FOREIGN KEY (id_category) REFERENCES CATEGORY(id_category)
)

CREATE TABLE CATEGORY (
    id_category VARCHAR2(36) PRIMARY KEY,
    category_name VARCHAR2(20) NOT NULL
)

INSERT INTO TENANT (id_tenant, tenant_name, email, username, password) 
VALUES ('1', 'Warung Mas Budi', 'warungbudi@example.com', 'warungbudi', 'password123');

INSERT INTO TENANT (id_tenant, tenant_name, email, username, password) 
VALUES ('2', 'Kopi Rindu', 'kopirindu@example.com', 'kopirindu', 'securepass456');

INSERT INTO TENANT (id_tenant, tenant_name, email, username, password) 
VALUES ('3', 'Ayam Geprek Enak', 'geprekenak@example.com', 'geprek_enak', 'enakbanget789');

-- Corrected INSERT statements for MENU
INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price) 
VALUES ('1', '1', 'Nasi Goreng', 20000, 2000);

INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price) 
VALUES ('2', '1', 'Mie Goreng', 18000, 2000);

INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price) 
VALUES ('3', '2', 'Es Kopi Susu', 15000, 0);

INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price) 
VALUES ('4', '2', 'Kopi Hitam', 12000, 0);

INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price) 
VALUES ('5', '3', 'Ayam Geprek Original', 25000, 2000);

INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price) 
VALUES ('6', '3', 'Ayam Geprek Keju', 30000, 2000);

INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price) 
VALUES ('7', '3', 'Nasi Bakar', 15000, 2000);

COMMIT;