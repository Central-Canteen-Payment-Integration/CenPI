CREATE OR REPLACE PROCEDURE toggle_tenant_proc(p_id_tenant IN VARCHAR2)
IS
    v_current_status NUMBER(1);
    v_new_status NUMBER(1);
BEGIN
    SELECT is_open
    INTO v_current_status
    FROM TENANT
    WHERE id_tenant = p_id_tenant;

    v_new_status := CASE v_current_status WHEN 0 THEN 1 ELSE 0 END;

    UPDATE TENANT
    SET is_open = v_new_status
    WHERE id_tenant = p_id_tenant;

    COMMIT;
EXCEPTION
    WHEN OTHERS THEN 
        ROLLBACK;
        RAISE;
END;
/