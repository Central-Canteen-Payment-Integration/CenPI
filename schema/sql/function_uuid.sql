CREATE OR REPLACE FUNCTION generate_uuid
  RETURN VARCHAR2
IS
  uuid_raw RAW(16);
BEGIN
  uuid_raw := SYS_GUID();
  
  RETURN LOWER(
    SUBSTR(RAWTOHEX(uuid_raw), 1, 8) || '-' ||
    SUBSTR(RAWTOHEX(uuid_raw), 9, 4) || '-' ||
    SUBSTR(RAWTOHEX(uuid_raw), 13, 4) || '-' ||
    SUBSTR(RAWTOHEX(uuid_raw), 17, 4) || '-' ||
    SUBSTR(RAWTOHEX(uuid_raw), 21, 12)
  );
END generate_uuid;