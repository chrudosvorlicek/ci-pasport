\c pasport

CREATE OR REPLACE FUNCTION public.create_schema()
    RETURNS VOID
AS
$$
DECLARE
    __user varchar;
BEGIN
    __user := usename FROM pg_user LIMIT 1;

    CREATE SCHEMA IF NOT EXISTS metadata;
    CREATE SCHEMA IF NOT EXISTS userdata;

    EXECUTE 'GRANT ALL ON SCHEMA metadata TO ' || __user || ';';
    EXECUTE 'GRANT ALL ON SCHEMA userdata TO ' || __user || ';';

    EXECUTE 'ALTER DEFAULT PRIVILEGES IN SCHEMA metadata GRANT ALL ON TABLES TO ' || __user || ';';
    EXECUTE 'ALTER DEFAULT PRIVILEGES IN SCHEMA metadata GRANT ALL ON SEQUENCES TO ' || __user || ';';
    EXECUTE 'ALTER DEFAULT PRIVILEGES IN SCHEMA userdata GRANT ALL ON TABLES TO ' || __user || ';';
    EXECUTE 'ALTER DEFAULT PRIVILEGES IN SCHEMA userdata GRANT ALL ON SEQUENCES TO ' || __user || ';';
END
$$
LANGUAGE plpgsql SECURITY DEFINER;

CREATE EXTENSION IF NOT EXISTS postgis;
SELECT public.create_schema();
