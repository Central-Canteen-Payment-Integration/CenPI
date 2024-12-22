CREATE OR REPLACE PROCEDURE process_cart_to_transaction(
    p_id_transaction TRANSACTION.id_transaction%TYPE, 
    p_id_user CART.id_user%TYPE,
    p_trx_method TRANSACTION.trx_method%TYPE, 
    p_takeaway TRANSACTION.takeaway%TYPE
) AS
    v_trx_price TRANSACTION.trx_price%TYPE;
    v_cart_count NUMBER;
BEGIN 
    SELECT COUNT(*)
    INTO v_cart_count 
    FROM CART 
    WHERE id_user = p_id_user;

    IF v_cart_count = 0 THEN
        RAISE_APPLICATION_ERROR(-20001, 'Cart is empty for the user.');
    END IF;

    SELECT SUM(
        CASE 
            WHEN p_takeaway = 1 THEN (c.qty * m.price) + (c.qty * m.pkg_price) 
            ELSE (c.qty * m.price) 
        END
    ) INTO v_trx_price 
    FROM CART c 
    JOIN MENU m ON c.id_menu = m.id_menu 
    WHERE c.id_user = p_id_user;

    IF p_trx_method = 'qris' THEN
        v_trx_price := v_trx_price + 2000;
    END IF;

    INSERT INTO TRANSACTION (
        id_transaction, 
        id_user, 
        trx_price, 
        trx_datetime, 
        takeaway, 
        trx_method, 
        trx_status,
        trx_admin
    ) 
    VALUES (
        p_id_transaction, 
        p_id_user, 
        v_trx_price, 
        SYSDATE, 
        p_takeaway, 
        p_trx_method, 
        'Unpaid',
        2000
    );

    FOR cart_item IN (
        SELECT 
            c.*, 
            m.PRICE, 
            m.PKG_PRICE 
        FROM 
            CART c 
        JOIN MENU m ON c.id_menu = m.id_menu 
        WHERE 
            c.id_user = p_id_user
    ) LOOP 
        INSERT INTO TRANSACTION_DETAIL (
            id_transaction, 
            id_menu, 
            qty, 
            qty_price, 
            pkg_price, 
            notes, 
            status
        ) 
        VALUES (
            p_id_transaction, 
            cart_item.id_menu, 
            cart_item.qty, 
            cart_item.PRICE, 
            cart_item.PKG_PRICE, 
            cart_item.notes, 
            'Pending'
        );
    END LOOP;

    DELETE FROM CART 
    WHERE id_user = p_id_user;

    COMMIT;

EXCEPTION 
    WHEN OTHERS THEN 
        ROLLBACK;
        RAISE;
END process_cart_to_transaction;