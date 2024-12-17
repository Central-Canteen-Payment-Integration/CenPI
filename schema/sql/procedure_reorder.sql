CREATE OR REPLACE PROCEDURE reorder(
    p_id_transaction IN TRANSACTION_DETAIL.id_transaction%TYPE,
    p_id_user IN TRANSACTION.id_user%TYPE
) IS
BEGIN
    FOR v_detail IN (
        SELECT id_menu, qty, notes
        FROM TRANSACTION_DETAIL
        WHERE id_transaction = p_id_transaction
    ) LOOP
        MERGE INTO CART c
        USING (SELECT v_detail.id_menu AS id_menu, v_detail.notes AS notes FROM DUAL) src
        ON (c.id_user = p_id_user 
            AND c.id_menu = src.id_menu
            AND NVL(c.notes, ' ') = NVL(src.notes, ' '))
        WHEN MATCHED THEN
            UPDATE SET c.qty = c.qty + v_detail.qty
        WHEN NOT MATCHED THEN
            INSERT (id_cart, id_user, id_menu, qty, notes)
            VALUES (
                generate_uuid(),
                p_id_user,
                v_detail.id_menu, 
                v_detail.qty, 
                v_detail.notes
            );
    END LOOP;

    COMMIT;

EXCEPTION
    WHEN OTHERS THEN
        ROLLBACK;
        RAISE;
END reorder;
