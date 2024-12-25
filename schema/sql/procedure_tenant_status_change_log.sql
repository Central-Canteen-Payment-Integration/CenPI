create or replace PROCEDURE tenant_status_change_log(
    p_id_admin VARCHAR2,
    p_id_tenant VARCHAR2,
    p_new_status NUMBER
) AS
    v_admin_username ADMIN.username%TYPE;
    v_tenant_username TENANT.username%TYPE;
    v_action LOGS_ADMIN.action%TYPE;
    v_status VARCHAR2(10);
BEGIN
    -- Fetch admin username
    SELECT username INTO v_admin_username FROM ADMIN WHERE id_admin = p_id_admin;

    -- Fetch tenant username
    SELECT username INTO v_tenant_username FROM TENANT WHERE id_tenant = p_id_tenant;

    -- Determine the status text
    IF p_new_status = 1 THEN
        v_status := 'active';
    ELSE
        v_status := 'inactive';
    END IF;

    -- Create the action log
    v_action := 'Admin (' || v_admin_username || ') mengubah status tenant (' || v_tenant_username || ') menjadi (' || v_status || ')';

    -- Insert into logs
    INSERT INTO LOGS_ADMIN (id_log, id_admin, action, created_at)
    VALUES (SYS_GUID(), p_id_admin, v_action, SYSTIMESTAMP);
    commit;
END tenant_status_change_log;