

CREATE SEQUENCE healthstudio.public.appaccount_id_seq;

CREATE TABLE healthstudio.public.appaccount (
                id BIGINT NOT NULL DEFAULT nextval('healthstudio.public.appaccount_id_seq'),
                name VARCHAR(120) NOT NULL,
                email VARCHAR(255) NOT NULL,
                created TIMESTAMP NOT NULL,
                objid BIGINT NOT NULL,
                CONSTRAINT appaccount_pk PRIMARY KEY (id)
);
COMMENT ON TABLE healthstudio.public.appaccount IS 'The owners of accounts in the system';


ALTER SEQUENCE healthstudio.public.appaccount_id_seq OWNED BY healthstudio.public.appaccount.id;


CREATE SEQUENCE healthstudio.public.media_id_seq;

CREATE TABLE healthstudio.public.media (
                id BIGINT NOT NULL DEFAULT nextval('healthstudio.public.media_id_seq'),
                title VARCHAR(140) DEFAULT 'No title specified' NOT NULL,
                folder VARCHAR(140) DEFAULT '/' NOT NULL,
                file VARCHAR(140) NOT NULL,
                filesize BIGINT NOT NULL,
                objid BIGINT NOT NULL,
                CONSTRAINT media_pk PRIMARY KEY (id)
);
COMMENT ON COLUMN healthstudio.public.media.folder IS 'The sub folders tree, can be something like: /person/logo';
COMMENT ON COLUMN healthstudio.public.media.file IS 'The name and extension of the file: user-1.png';
COMMENT ON COLUMN healthstudio.public.media.filesize IS 'The size in bytes of the file';


ALTER SEQUENCE healthstudio.public.media_id_seq OWNED BY healthstudio.public.media.id;

CREATE SEQUENCE healthstudio.public.objectidentity_objid_seq;

CREATE TABLE healthstudio.public.objectidentity (
                objid BIGINT NOT NULL DEFAULT nextval('healthstudio.public.objectidentity_objid_seq'),
                tablename VARCHAR(60) NOT NULL,
                CONSTRAINT obj_pk PRIMARY KEY (objid)
);
COMMENT ON COLUMN healthstudio.public.objectidentity.tablename IS 'Table name of the object referenced';


ALTER SEQUENCE healthstudio.public.objectidentity_objid_seq OWNED BY healthstudio.public.objectidentity.objid;

CREATE SEQUENCE healthstudio.public.person_id_seq;

CREATE TABLE healthstudio.public.person (
                id BIGINT NOT NULL DEFAULT nextval('healthstudio.public.person_id_seq'),
                name VARCHAR(120) NOT NULL,
                created TIMESTAMP NOT NULL,
                objid BIGINT NOT NULL,
                CONSTRAINT person_pk PRIMARY KEY (id)
);
COMMENT ON TABLE healthstudio.public.person IS 'The Person (customer, client, vendor, fabricant, employe, student, user) basic data.
It''s tight related to user table';


ALTER SEQUENCE healthstudio.public.person_id_seq OWNED BY healthstudio.public.person.id;

CREATE TABLE healthstudio.public.person_media (
                person_id BIGINT NOT NULL,
                media_id BIGINT NOT NULL,
                CONSTRAINT person_media_pk PRIMARY KEY (person_id, media_id)
);


CREATE SEQUENCE healthstudio.public.user_id_seq;

CREATE TABLE healthstudio.public.user (
                id INTEGER NOT NULL DEFAULT nextval('healthstudio.public.user_id_seq'),
                name VARCHAR(64) NOT NULL,
                email VARCHAR(255) NOT NULL,
                pwd CHAR(32) NOT NULL,
                created TIMESTAMP NOT NULL,
                last_login TIMESTAMP NOT NULL,
                status SMALLINT NOT NULL,
                rnd_salt VARCHAR(32) NOT NULL,
                person_id BIGINT NOT NULL,
                appaccount_id BIGINT NOT NULL,
                objid BIGINT NOT NULL,
                CONSTRAINT user_pk PRIMARY KEY (id)
);
COMMENT ON TABLE healthstudio.public.user IS 'User of the system';
COMMENT ON COLUMN healthstudio.public.user.status IS 'Status of the user account. 

-1 	= Blocked
0 	= Not yet activated
1	= Active';
COMMENT ON COLUMN healthstudio.public.user.rnd_salt IS 'Randomic salt to generate the encripted password with MD5';


ALTER SEQUENCE healthstudio.public.user_id_seq OWNED BY healthstudio.public.user.id;

CREATE INDEX obj_idx_table
 ON healthstudio.public.objectidentity
 ( tablename );


CREATE UNIQUE INDEX user_idx_email
 ON healthstudio.public.user
 ( email );

CREATE UNIQUE INDEX appaccount_idx_name
 ON healthstudio.public.appaccount
 ( name ASC );

CREATE UNIQUE INDEX user_idx_objid
 ON healthstudio.public.user
 ( objid );

ALTER TABLE healthstudio.public.user ADD CONSTRAINT appaccount_user_fk
FOREIGN KEY (appaccount_id)
REFERENCES healthstudio.public.appaccount (id)
ON DELETE RESTRICT
ON UPDATE NO ACTION
NOT DEFERRABLE;


ALTER TABLE healthstudio.public.person_media ADD CONSTRAINT media_person_media_fk
FOREIGN KEY (media_id)
REFERENCES healthstudio.public.media (id)
ON DELETE RESTRICT
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE healthstudio.public.person_media ADD CONSTRAINT person_person_media_fk
FOREIGN KEY (person_id)
REFERENCES healthstudio.public.person (id)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE healthstudio.public.user ADD CONSTRAINT person_user_fk
FOREIGN KEY (person_id)
REFERENCES healthstudio.public.person (id)
ON DELETE RESTRICT
ON UPDATE NO ACTION
NOT DEFERRABLE;

