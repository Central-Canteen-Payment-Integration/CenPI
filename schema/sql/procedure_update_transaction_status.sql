create or replace PROCEDURE update_transaction_status(
    p_id_transaction VARCHAR2,
    p_id_admin VARCHAR2
) AS
    v_admin_username ADMIN.username%TYPE;
    v_action LOGS_ADMIN.action%TYPE;  
BEGIN
    SELECT username INTO v_admin_username
    FROM ADMIN
    WHERE id_admin = p_id_admin;

    UPDATE TRANSACTION
    SET TRX_STATUS = 'Pending'
    WHERE ID_TRANSACTION = p_id_transaction;

    v_action := 'Admin (' || v_admin_username || ') Menerima Uang dari Transaksi (' || p_id_transaction || ') dan Mengubah Statusnya ke Pending';

    INSERT INTO LOGS_ADMIN (
        id_log, 
        id_admin, 
        action, 
        created_at
    )
    VALUES (
        SYS_GUID(),
        p_id_admin,
        v_action,
        SYSTIMESTAMP
    );

    COMMIT;
EXCEPTION
    WHEN OTHERS THEN
        ROLLBACK;
        RAISE;
END update_transaction_status;