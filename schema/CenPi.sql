CREATE TABLE USERS (
    id_user VARCHAR2(36) PRIMARY KEY,
    email VARCHAR2(50) NOT NULL UNIQUE,
    username VARCHAR2(30) NOT NULL UNIQUE,
    password VARCHAR2(60) NOT NULL,
    active NUMBER(1) DEFAULT 0 CHECK (active IN (0, 1)),
    token_activation VARCHAR2(36),
    forgot_password_token VARCHAR2(36),
    token_expiry TIMESTAMP DEFAULT NULL,
    image_path VARCHAR2(36)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE TENANT (
    id_tenant VARCHAR2(36) PRIMARY KEY,
    tenant_name VARCHAR2(50) NOT NULL UNIQUE,
    email VARCHAR2(50) NOT NULL UNIQUE,
    username VARCHAR2(30) NOT NULL UNIQUE,
    password VARCHAR2(60) NOT NULL,
    active NUMBER(1) DEFAULT 0 CHECK (active IN (0, 1)),
    forgot_password_token VARCHAR2(36),
    token_expiry TIMESTAMP DEFAULT NULL,
    image_path VARCHAR2(36),
    location_name VARCHAR2(20),
    location_booth VARCHAR2(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP DEFAULT NULL,
    is_open NUMBER(1) DEFAULT 0 CHECK (is_open IN (0, 1))
);

CREATE TABLE MENU (
    id_menu VARCHAR2(36) PRIMARY KEY,
    id_tenant VARCHAR2(36) NOT NULL,
    name VARCHAR2(100) NOT NULL,
    price INT NOT NULL CHECK (price > 0),
    pkg_price INT,
    image_path VARCHAR2(36),
    menu_type VARCHAR2(7) CHECK (menu_type IN ('makanan', 'minuman')),
    active NUMBER(1) DEFAULT 0 CHECK (active IN (0, 1)),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP DEFAULT NULL,
    FOREIGN KEY (id_tenant) REFERENCES TENANT(id_tenant)
);

CREATE TABLE TRANSACTION (
    id_transaction VARCHAR2(36) PRIMARY KEY,
    id_user VARCHAR2(36) NOT NULL,
    trx_price INT NOT NULL CHECK (trx_price > 0),
    trx_datetime TIMESTAMP NOT NULL,
    takeaway NUMBER(1) DEFAULT 0 CHECK (takeaway IN (0, 1)) NOT NULL,
    trx_method VARCHAR2(4) CHECK (trx_method IN ('cash', 'qris')) NOT NULL,
    midtrans_token VARCHAR2(50),
    trx_status VARCHAR2(50) CHECK (trx_status IN ('Unpaid', 'Cancelled', 'Pending', 'Completed')),
    FOREIGN KEY (id_user) REFERENCES USERS(id_user)
);

CREATE TABLE TRANSACTION_DETAIL (
    id_transaction VARCHAR2(36),
    id_menu VARCHAR2(36),
    qty INT,
    qty_price INT,
    pkg_price INT,
    notes VARCHAR2(100),
    status VARCHAR2(50) CHECK (status IN ('Cancelled', 'Pending', 'Accept', 'Pickup', 'Completed')),
    FOREIGN KEY (id_transaction) REFERENCES TRANSACTION(id_transaction),
    FOREIGN KEY (id_menu) REFERENCES MENU(id_menu)
);

CREATE TABLE CART (
    id_cart VARCHAR2(36) PRIMARY KEY,
    id_user VARCHAR2(36) NOT NULL,
    id_menu VARCHAR2(36) NOT NULL,
    qty INT NOT NULL CHECK (qty > 0),
    notes VARCHAR2(100),
    FOREIGN KEY (id_user) REFERENCES USERS(id_user),
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

CREATE TABLE ADMIN (
    id_admin VARCHAR2(36) PRIMARY KEY,
    username VARCHAR2(30) NOT NULL UNIQUE,
    password VARCHAR2(60) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE LOGS_ADMIN (
    id_log VARCHAR2(36) PRIMARY KEY,
    id_admin VARCHAR2(36) NOT NULL,
    action VARCHAR2(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_admin) REFERENCES ADMIN(id_admin)
);