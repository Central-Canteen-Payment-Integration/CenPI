CREATE OR REPLACE TRIGGER update_expired_transaction
AFTER UPDATE OF trx_status ON transaction
FOR EACH ROW
BEGIN
    IF :NEW.trx_status = 'Cancelled' AND :OLD.trx_status != 'Cancelled' THEN
        UPDATE transaction_detail
        SET status = 'Cancelled'
        WHERE id_transaction = :OLD.id_transaction;
    END IF;
END;