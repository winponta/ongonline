/************ Update: Tables ***************/

/******************** Add Table: fingerprint ************************/

/* Build Table Structure */
CREATE TABLE fingerprint
(
	person_id BIGINT NOT NULL,
	finger_number SMALLINT DEFAULT 1 NOT NULL,
	text_hash TEXT NOT NULL
);

/* Add Primary Key */
ALTER TABLE fingerprint ADD CONSTRAINT pkfingerprint
	PRIMARY KEY (person_id, finger_number);

/* Add Comments */
COMMENT ON COLUMN fingerprint.finger_number IS 'Mão direita a partir do polegar 1=pol, 2=indicador, etc ... segue mão esquerda 6=pol, etc';

COMMENT ON COLUMN fingerprint.text_hash IS 'Hash em texto gerado pelo leitor';


/************ Add Foreign Keys ***************/

/* Add Foreign Key: fk_fingerprint_person */
ALTER TABLE fingerprint ADD CONSTRAINT fk_fingerprint_person
	FOREIGN KEY (person_id) REFERENCES person (id)
	ON UPDATE CASCADE ON DELETE CASCADE;