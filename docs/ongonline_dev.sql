--
-- PostgreSQL database dump
--

-- Started on 2014-10-14 07:56:04 BRT

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

--
-- TOC entry 210 (class 1255 OID 78389)
-- Dependencies: 6
-- Name: normalize_utf8(character varying); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION normalize_utf8(texto character varying) RETURNS character varying
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$select to_ascii(convert_to($1, 'latin1'), 'latin1')$_$;


--
-- TOC entry 208 (class 1255 OID 50197)
-- Dependencies: 6
-- Name: to_ascii(bytea, name); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION to_ascii(bytea, name) RETURNS text
    LANGUAGE internal STRICT
    AS $$to_ascii_encname$$;


--
-- TOC entry 209 (class 1255 OID 49766)
-- Dependencies: 6
-- Name: unaccented(text); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION unaccented(text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
    SELECT translate($1,'ÀÁÂÃÄÅĀĂĄÈÉÊËĒĔĖĘĚÌÍÎÏĨĪĮİÒÓÔÕÖØŌŎŐÙÚÛÜŨŪŬŮŰŲàáâãäåāăąèéêëēĕėęěìíîïĩīĭįòóôõöøōŏőùúûüũūŭůųÇçÑñÝýÿĆćĈĉĊċČčĎďĐđĜĝĞğĠġĢģĤĥĦħ',
'AAAAAAAAAEEEEEEEEEIIIIIIIIOOOOOOOOOUUUUUUUUUUaaaaaaaaaeeeeeeeeeiiiiiiiiooooooooouuuuuuuuuCcNnYyyCcCcCcCcDdDdGgGgGgGgHhHh');
$_$;


SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 140 (class 1259 OID 49767)
-- Dependencies: 6
-- Name: acl_role; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE acl_role (
    id integer NOT NULL,
    name character varying(50) NOT NULL,
    appaccount_id bigint NOT NULL
);


--
-- TOC entry 141 (class 1259 OID 49770)
-- Dependencies: 6 140
-- Name: acl_role_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE acl_role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2152 (class 0 OID 0)
-- Dependencies: 141
-- Name: acl_role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE acl_role_id_seq OWNED BY acl_role.id;


--
-- TOC entry 2153 (class 0 OID 0)
-- Dependencies: 141
-- Name: acl_role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('acl_role_id_seq', 4, true);


--
-- TOC entry 142 (class 1259 OID 49772)
-- Dependencies: 6
-- Name: acl_role_permission; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE acl_role_permission (
    id bigint NOT NULL,
    resource character varying(30) NOT NULL,
    privilege character varying(30) NOT NULL,
    acl_role_id integer NOT NULL
);


--
-- TOC entry 143 (class 1259 OID 49775)
-- Dependencies: 142 6
-- Name: acl_role_permission_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE acl_role_permission_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2154 (class 0 OID 0)
-- Dependencies: 143
-- Name: acl_role_permission_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE acl_role_permission_id_seq OWNED BY acl_role_permission.id;


--
-- TOC entry 2155 (class 0 OID 0)
-- Dependencies: 143
-- Name: acl_role_permission_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('acl_role_permission_id_seq', 88, true);


--
-- TOC entry 144 (class 1259 OID 49777)
-- Dependencies: 6
-- Name: appaccount; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE appaccount (
    id bigint NOT NULL,
    name character varying(120) NOT NULL,
    email character varying(255) NOT NULL,
    created timestamp without time zone NOT NULL
);


--
-- TOC entry 2156 (class 0 OID 0)
-- Dependencies: 144
-- Name: TABLE appaccount; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE appaccount IS 'The owners of accounts in the system';


--
-- TOC entry 145 (class 1259 OID 49780)
-- Dependencies: 144 6
-- Name: appaccount_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE appaccount_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2157 (class 0 OID 0)
-- Dependencies: 145
-- Name: appaccount_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE appaccount_id_seq OWNED BY appaccount.id;


--
-- TOC entry 2158 (class 0 OID 0)
-- Dependencies: 145
-- Name: appaccount_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('appaccount_id_seq', 1, true);


--
-- TOC entry 185 (class 1259 OID 50147)
-- Dependencies: 6
-- Name: appaccount_media; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE appaccount_media (
    appaccount_id bigint NOT NULL,
    media_id bigint NOT NULL
);


--
-- TOC entry 184 (class 1259 OID 50145)
-- Dependencies: 6
-- Name: atividade_assistencia_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE atividade_assistencia_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2159 (class 0 OID 0)
-- Dependencies: 184
-- Name: atividade_assistencia_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('atividade_assistencia_id_seq', 23, true);


--
-- TOC entry 186 (class 1259 OID 50152)
-- Dependencies: 1986 1987 6
-- Name: atividade_assistencia; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE atividade_assistencia (
    id bigint DEFAULT nextval('atividade_assistencia_id_seq'::regclass) NOT NULL,
    person_helped_id bigint NOT NULL,
    person_performed_id bigint NOT NULL,
    task_type_id integer NOT NULL,
    project_id bigint,
    assistance_date date NOT NULL,
    assistance_time time without time zone NOT NULL,
    person_recorded_id bigint NOT NULL,
    description text,
    event_id bigint,
    id_by_finger_key boolean DEFAULT false NOT NULL,
    appaccount_id bigint NOT NULL
);


--
-- TOC entry 2160 (class 0 OID 0)
-- Dependencies: 186
-- Name: TABLE atividade_assistencia; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE atividade_assistencia IS 'Atvidades de assistências realizadas, podendo ou não estar ligadas à um projeto, porém sempre ligadas à um Task Type (Tipo de Atividade)';


--
-- TOC entry 2161 (class 0 OID 0)
-- Dependencies: 186
-- Name: COLUMN atividade_assistencia.person_recorded_id; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN atividade_assistencia.person_recorded_id IS 'Pessoa que realizou o lançamento do r';


--
-- TOC entry 146 (class 1259 OID 49782)
-- Dependencies: 1969 6
-- Name: audit_trail; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE audit_trail (
    id bigint NOT NULL,
    record_id bigint,
    tablename character varying(60) NOT NULL,
    fieldname character varying(60) NOT NULL,
    eventdate timestamp without time zone NOT NULL,
    eventtype character(3) NOT NULL,
    user_id bigint NOT NULL,
    fieldtexttype character(1) DEFAULT false NOT NULL,
    appaccount_id bigint NOT NULL,
    value character varying(260) NOT NULL
);


--
-- TOC entry 2162 (class 0 OID 0)
-- Dependencies: 146
-- Name: COLUMN audit_trail.eventtype; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN audit_trail.eventtype IS 'INS, UPD, DEL';


--
-- TOC entry 2163 (class 0 OID 0)
-- Dependencies: 146
-- Name: COLUMN audit_trail.fieldtexttype; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN audit_trail.fieldtexttype IS 'Y or N';


--
-- TOC entry 147 (class 1259 OID 49786)
-- Dependencies: 6 146
-- Name: audit_trail_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE audit_trail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2164 (class 0 OID 0)
-- Dependencies: 147
-- Name: audit_trail_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE audit_trail_id_seq OWNED BY audit_trail.id;


--
-- TOC entry 2165 (class 0 OID 0)
-- Dependencies: 147
-- Name: audit_trail_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('audit_trail_id_seq', 11, true);


--
-- TOC entry 148 (class 1259 OID 49788)
-- Dependencies: 1971 6
-- Name: busunit; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE busunit (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    tradename character varying(100),
    doctaxnumber character varying(20),
    phone character varying(16),
    address character varying(150),
    addressnumber character varying(6),
    addressdetails character varying(150),
    postalcode character varying(9),
    website character varying(255),
    city_id integer,
    appaccount_id bigint NOT NULL,
    head smallint DEFAULT 0 NOT NULL,
    district character varying(50)
);


--
-- TOC entry 2166 (class 0 OID 0)
-- Dependencies: 148
-- Name: TABLE busunit; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE busunit IS 'Headquarter / Branch / Head Office
Only one "main" unit may exist, this will have a relation with appaccount, all other will be child of it';


--
-- TOC entry 2167 (class 0 OID 0)
-- Dependencies: 148
-- Name: COLUMN busunit.doctaxnumber; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN busunit.doctaxnumber IS 'This is the document id - Tax Number (USA), CNPJ (Brasil), CPF (Brasil Pessoa Física)';


--
-- TOC entry 2168 (class 0 OID 0)
-- Dependencies: 148
-- Name: COLUMN busunit.website; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN busunit.website IS 'This is the main url to access in web';


--
-- TOC entry 2169 (class 0 OID 0)
-- Dependencies: 148
-- Name: COLUMN busunit.head; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN busunit.head IS 'Indicates the Headquarter or Head office unit of the app account. Only one is allowed for app account';


--
-- TOC entry 149 (class 1259 OID 49795)
-- Dependencies: 148 6
-- Name: busunit_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE busunit_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2170 (class 0 OID 0)
-- Dependencies: 149
-- Name: busunit_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE busunit_id_seq OWNED BY busunit.id;


--
-- TOC entry 2171 (class 0 OID 0)
-- Dependencies: 149
-- Name: busunit_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('busunit_id_seq', 4, true);


--
-- TOC entry 187 (class 1259 OID 50162)
-- Dependencies: 6
-- Name: category; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE category (
    id integer NOT NULL,
    parent_id integer,
    name character varying(80) NOT NULL,
    category_group_id smallint NOT NULL
);


--
-- TOC entry 2172 (class 0 OID 0)
-- Dependencies: 187
-- Name: TABLE category; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE category IS 'Terms in a taxonomy, category group';


--
-- TOC entry 188 (class 1259 OID 50167)
-- Dependencies: 6
-- Name: category_group; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE category_group (
    id smallint NOT NULL,
    name character varying(60) NOT NULL
);


--
-- TOC entry 2173 (class 0 OID 0)
-- Dependencies: 188
-- Name: TABLE category_group; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE category_group IS 'Name of categories groups or vacabularies or taxonomies';


--
-- TOC entry 150 (class 1259 OID 49797)
-- Dependencies: 6
-- Name: city; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE city (
    id integer NOT NULL,
    name character varying(70) NOT NULL,
    state_id integer NOT NULL
);


--
-- TOC entry 151 (class 1259 OID 49800)
-- Dependencies: 6
-- Name: city_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE city_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2174 (class 0 OID 0)
-- Dependencies: 151
-- Name: city_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('city_id_seq', 38, true);


--
-- TOC entry 152 (class 1259 OID 49802)
-- Dependencies: 6
-- Name: city_region_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE city_region_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2175 (class 0 OID 0)
-- Dependencies: 152
-- Name: city_region_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('city_region_id_seq', 45, true);


--
-- TOC entry 153 (class 1259 OID 49804)
-- Dependencies: 1973 6
-- Name: city_region; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE city_region (
    id bigint DEFAULT nextval('city_region_id_seq'::regclass) NOT NULL,
    name character varying(50) NOT NULL,
    city_id integer NOT NULL,
    parent_id bigint
);


--
-- TOC entry 154 (class 1259 OID 49808)
-- Dependencies: 6
-- Name: country; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE country (
    id smallint NOT NULL,
    name character varying(50) NOT NULL
);


--
-- TOC entry 155 (class 1259 OID 49811)
-- Dependencies: 6 154
-- Name: country_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE country_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2176 (class 0 OID 0)
-- Dependencies: 155
-- Name: country_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE country_id_seq OWNED BY country.id;


--
-- TOC entry 2177 (class 0 OID 0)
-- Dependencies: 155
-- Name: country_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('country_id_seq', 4, true);


--
-- TOC entry 156 (class 1259 OID 49813)
-- Dependencies: 6
-- Name: employee; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE employee (
    id bigint NOT NULL,
    registration_number character varying(20),
    busunit_id integer NOT NULL,
    job_function_id smallint NOT NULL
);


--
-- TOC entry 191 (class 1259 OID 78400)
-- Dependencies: 6
-- Name: evento_assistencia_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE evento_assistencia_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2178 (class 0 OID 0)
-- Dependencies: 191
-- Name: evento_assistencia_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('evento_assistencia_id_seq', 16, true);


--
-- TOC entry 189 (class 1259 OID 50172)
-- Dependencies: 1988 6
-- Name: evento_assistencia; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE evento_assistencia (
    id bigint DEFAULT nextval('evento_assistencia_id_seq'::regclass) NOT NULL,
    event_date date NOT NULL,
    task_type_id integer NOT NULL,
    project_id bigint,
    appaccount_id bigint NOT NULL
);


--
-- TOC entry 2179 (class 0 OID 0)
-- Dependencies: 189
-- Name: TABLE evento_assistencia; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE evento_assistencia IS 'Agrupador de atividades de assistencia';


--
-- TOC entry 157 (class 1259 OID 49816)
-- Dependencies: 6
-- Name: expertise_area; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE expertise_area (
    id integer NOT NULL,
    name character varying(50) NOT NULL,
    description character varying(400) NOT NULL,
    appaccount_id bigint NOT NULL
);


--
-- TOC entry 2180 (class 0 OID 0)
-- Dependencies: 157
-- Name: TABLE expertise_area; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE expertise_area IS 'Expertise, knowledge, specialization area';


--
-- TOC entry 158 (class 1259 OID 49819)
-- Dependencies: 157 6
-- Name: expertise_area_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE expertise_area_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2181 (class 0 OID 0)
-- Dependencies: 158
-- Name: expertise_area_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE expertise_area_id_seq OWNED BY expertise_area.id;


--
-- TOC entry 2182 (class 0 OID 0)
-- Dependencies: 158
-- Name: expertise_area_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('expertise_area_id_seq', 6, true);


--
-- TOC entry 192 (class 1259 OID 94758)
-- Dependencies: 1989 6
-- Name: fingerprint; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE fingerprint (
    person_id bigint NOT NULL,
    finger_number smallint DEFAULT 1 NOT NULL,
    text_hash text NOT NULL
);


--
-- TOC entry 2183 (class 0 OID 0)
-- Dependencies: 192
-- Name: COLUMN fingerprint.finger_number; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN fingerprint.finger_number IS 'Mão direita a partir do polegar 1=pol, 2=indicador, etc ... segue mão esquerda 6=pol, etc';


--
-- TOC entry 2184 (class 0 OID 0)
-- Dependencies: 192
-- Name: COLUMN fingerprint.text_hash; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN fingerprint.text_hash IS 'Hash em texto gerado pelo leitor';


--
-- TOC entry 159 (class 1259 OID 49821)
-- Dependencies: 6
-- Name: job_function; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE job_function (
    id smallint NOT NULL,
    name character varying(50) NOT NULL,
    description character varying(400),
    appaccount_id bigint NOT NULL
);


--
-- TOC entry 2185 (class 0 OID 0)
-- Dependencies: 159
-- Name: TABLE job_function; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE job_function IS 'Describe the job function in a company for persons';


--
-- TOC entry 160 (class 1259 OID 49824)
-- Dependencies: 6 159
-- Name: job_function_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE job_function_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2186 (class 0 OID 0)
-- Dependencies: 160
-- Name: job_function_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE job_function_id_seq OWNED BY job_function.id;


--
-- TOC entry 2187 (class 0 OID 0)
-- Dependencies: 160
-- Name: job_function_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('job_function_id_seq', 16, true);


--
-- TOC entry 161 (class 1259 OID 49826)
-- Dependencies: 1977 6
-- Name: media; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE media (
    id bigint NOT NULL,
    title character varying(140) DEFAULT 'No title specified'::character varying NOT NULL,
    file character varying(140) NOT NULL,
    filesize bigint NOT NULL,
    mimetype character varying(50) NOT NULL
);


--
-- TOC entry 2188 (class 0 OID 0)
-- Dependencies: 161
-- Name: COLUMN media.file; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN media.file IS 'The name and extension of the file: user-1.png';


--
-- TOC entry 2189 (class 0 OID 0)
-- Dependencies: 161
-- Name: COLUMN media.filesize; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN media.filesize IS 'The size in bytes of the file';


--
-- TOC entry 162 (class 1259 OID 49830)
-- Dependencies: 161 6
-- Name: media_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE media_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2190 (class 0 OID 0)
-- Dependencies: 162
-- Name: media_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE media_id_seq OWNED BY media.id;


--
-- TOC entry 2191 (class 0 OID 0)
-- Dependencies: 162
-- Name: media_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('media_id_seq', 40, true);


--
-- TOC entry 163 (class 1259 OID 49832)
-- Dependencies: 6
-- Name: person; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE person (
    id bigint NOT NULL,
    name character varying(120) NOT NULL,
    created timestamp without time zone NOT NULL,
    appaccount_id bigint NOT NULL,
    address character varying(150),
    addressdetails character varying(150),
    addressnumber character(6),
    city_id integer,
    mobilephone character(16),
    phone character(16),
    postalcode character(9),
    website character varying(255),
    email character varying(255),
    gender character(1) NOT NULL,
    birthdate date,
    city_region_id bigint,
    marital_status character varying(12)
);


--
-- TOC entry 2192 (class 0 OID 0)
-- Dependencies: 163
-- Name: TABLE person; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE person IS 'The Person (customer, client, vendor, fabricant, employe, student, user) basic data.
It''s tight related to user table';


--
-- TOC entry 2193 (class 0 OID 0)
-- Dependencies: 163
-- Name: COLUMN person.marital_status; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person.marital_status IS 'single, married, widow(er), separeted, stable union';


--
-- TOC entry 164 (class 1259 OID 49838)
-- Dependencies: 6
-- Name: person_docs; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE person_docs (
    id bigint NOT NULL,
    identitycard character varying(20),
    individualdoctaxnumber character varying(20),
    birthcertificate character varying(30),
    professionalcard character varying(20),
    driverslicense character varying(20),
    voterregistration character varying(20),
    militaryregistration character varying(30),
    healthsystemcard character varying(20)
);


--
-- TOC entry 2194 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN person_docs.identitycard; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person_docs.identitycard IS 'RG - Brasil';


--
-- TOC entry 2195 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN person_docs.individualdoctaxnumber; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person_docs.individualdoctaxnumber IS 'CPF - Brasil';


--
-- TOC entry 2196 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN person_docs.birthcertificate; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person_docs.birthcertificate IS 'Certificado de Nascimento - Brasil';


--
-- TOC entry 2197 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN person_docs.professionalcard; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person_docs.professionalcard IS 'Carteira Profissional - Brasil';


--
-- TOC entry 2198 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN person_docs.driverslicense; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person_docs.driverslicense IS 'Carteira de Motorista - Brasil';


--
-- TOC entry 2199 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN person_docs.voterregistration; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person_docs.voterregistration IS 'Título de Eleitor - Brasil';


--
-- TOC entry 2200 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN person_docs.militaryregistration; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person_docs.militaryregistration IS 'Carteira de Reservista - Brasil';


--
-- TOC entry 2201 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN person_docs.healthsystemcard; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person_docs.healthsystemcard IS 'Cartão do SUS - Brasil';


--
-- TOC entry 165 (class 1259 OID 49841)
-- Dependencies: 6
-- Name: person_helped; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE person_helped (
    id bigint NOT NULL,
    religion character varying(100),
    professional_occupation character varying(100) NOT NULL,
    professional_experience character varying(400) NOT NULL,
    live_with_family boolean NOT NULL,
    home_situation character varying(50) NOT NULL,
    home_since date NOT NULL,
    born_city_id integer NOT NULL,
    born_state_id integer NOT NULL,
    home_area character varying(50) NOT NULL,
    home_type character varying(50) NOT NULL,
    home_pieces_number smallint NOT NULL,
    rent_value numeric(10,2),
    first_help_date date
);


--
-- TOC entry 2202 (class 0 OID 0)
-- Dependencies: 165
-- Name: TABLE person_helped; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE person_helped IS 'Data of person helped by non profit org';


--
-- TOC entry 2203 (class 0 OID 0)
-- Dependencies: 165
-- Name: COLUMN person_helped.id; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person_helped.id IS 'Person id';


--
-- TOC entry 2204 (class 0 OID 0)
-- Dependencies: 165
-- Name: COLUMN person_helped.professional_occupation; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person_helped.professional_occupation IS 'Seted by app as: Retired, Rural Worker, Unemployed, City Worker, Another (described)';


--
-- TOC entry 2205 (class 0 OID 0)
-- Dependencies: 165
-- Name: COLUMN person_helped.home_situation; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person_helped.home_situation IS 'Specified in app as: Owner, Rent, Mortgage, Present, Invasion, Other(describe)';


--
-- TOC entry 2206 (class 0 OID 0)
-- Dependencies: 165
-- Name: COLUMN person_helped.home_area; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person_helped.home_area IS 'Described in app as: Urban, Rural, Island, Quilombo, Indian';


--
-- TOC entry 2207 (class 0 OID 0)
-- Dependencies: 165
-- Name: COLUMN person_helped.home_type; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person_helped.home_type IS 'Spcifeid in app as: Brick, Adobe, Wood, Another(describe)';


--
-- TOC entry 166 (class 1259 OID 49847)
-- Dependencies: 6
-- Name: person_helped_project; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE person_helped_project (
    project_id bigint NOT NULL,
    person_id bigint NOT NULL,
    date_in date NOT NULL,
    date_out date
);


--
-- TOC entry 2208 (class 0 OID 0)
-- Dependencies: 166
-- Name: TABLE person_helped_project; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE person_helped_project IS 'Persons helped on projects';


--
-- TOC entry 2209 (class 0 OID 0)
-- Dependencies: 166
-- Name: COLUMN person_helped_project.date_in; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person_helped_project.date_in IS 'Date that the person got in the project';


--
-- TOC entry 2210 (class 0 OID 0)
-- Dependencies: 166
-- Name: COLUMN person_helped_project.date_out; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN person_helped_project.date_out IS 'Date the person got out';


--
-- TOC entry 167 (class 1259 OID 49850)
-- Dependencies: 163 6
-- Name: person_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE person_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2211 (class 0 OID 0)
-- Dependencies: 167
-- Name: person_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE person_id_seq OWNED BY person.id;


--
-- TOC entry 2212 (class 0 OID 0)
-- Dependencies: 167
-- Name: person_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('person_id_seq', 1433, true);


--
-- TOC entry 168 (class 1259 OID 49852)
-- Dependencies: 6
-- Name: person_media; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE person_media (
    person_id bigint NOT NULL,
    media_id bigint NOT NULL
);


--
-- TOC entry 169 (class 1259 OID 49855)
-- Dependencies: 6
-- Name: person_programa_federal_social; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE person_programa_federal_social (
    person_id bigint NOT NULL,
    pfs_id integer NOT NULL,
    numero character varying(20) NOT NULL
);


--
-- TOC entry 170 (class 1259 OID 49858)
-- Dependencies: 6
-- Name: programa_federal_social_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE programa_federal_social_id_seq
    START WITH 16
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2213 (class 0 OID 0)
-- Dependencies: 170
-- Name: programa_federal_social_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('programa_federal_social_id_seq', 16, false);


--
-- TOC entry 171 (class 1259 OID 49860)
-- Dependencies: 1980 6
-- Name: programa_federal_social; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE programa_federal_social (
    id integer DEFAULT nextval('programa_federal_social_id_seq'::regclass) NOT NULL,
    nome character varying(40) NOT NULL,
    sigla character(5) NOT NULL
);


--
-- TOC entry 2214 (class 0 OID 0)
-- Dependencies: 171
-- Name: TABLE programa_federal_social; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE programa_federal_social IS 'Programas federais sociais como Bolsa Família, Pró-jovem, NIS, NIT, PASEP, PIS, etc';


--
-- TOC entry 172 (class 1259 OID 49864)
-- Dependencies: 1981 6
-- Name: project; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE project (
    id bigint NOT NULL,
    name character varying(60) NOT NULL,
    startdateexpected date,
    abstract character varying(1200) NOT NULL,
    fulldescription text,
    appaccount_id bigint NOT NULL,
    startdatereal date,
    finishdatereal date,
    finishdateexpected date,
    status smallint DEFAULT 0 NOT NULL
);


--
-- TOC entry 2215 (class 0 OID 0)
-- Dependencies: 172
-- Name: COLUMN project.status; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN project.status IS '0 = Draft; 1 = Active; 2 = Paused; 3 = Finished; 4 = Closed';


--
-- TOC entry 173 (class 1259 OID 49871)
-- Dependencies: 6 172
-- Name: project_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE project_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2216 (class 0 OID 0)
-- Dependencies: 173
-- Name: project_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE project_id_seq OWNED BY project.id;


--
-- TOC entry 2217 (class 0 OID 0)
-- Dependencies: 173
-- Name: project_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('project_id_seq', 14, true);


--
-- TOC entry 190 (class 1259 OID 50177)
-- Dependencies: 6
-- Name: project_media; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE project_media (
    project_id bigint NOT NULL,
    media_id bigint NOT NULL
);


--
-- TOC entry 174 (class 1259 OID 49873)
-- Dependencies: 6
-- Name: state; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE state (
    id integer NOT NULL,
    name character varying(50) NOT NULL,
    country_id smallint NOT NULL,
    abbreviation character(2) NOT NULL
);


--
-- TOC entry 2218 (class 0 OID 0)
-- Dependencies: 174
-- Name: TABLE state; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE state IS 'State of a Country';


--
-- TOC entry 175 (class 1259 OID 49876)
-- Dependencies: 6 174
-- Name: state_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE state_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2219 (class 0 OID 0)
-- Dependencies: 175
-- Name: state_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE state_id_seq OWNED BY state.id;


--
-- TOC entry 2220 (class 0 OID 0)
-- Dependencies: 175
-- Name: state_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('state_id_seq', 29, true);


--
-- TOC entry 176 (class 1259 OID 49878)
-- Dependencies: 6
-- Name: task_type; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE task_type (
    id integer NOT NULL,
    name character varying(120) NOT NULL,
    description character varying(1200),
    parent_id integer,
    appaccount_id bigint NOT NULL
);


--
-- TOC entry 177 (class 1259 OID 49884)
-- Dependencies: 176 6
-- Name: task_type_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE task_type_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2221 (class 0 OID 0)
-- Dependencies: 177
-- Name: task_type_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE task_type_id_seq OWNED BY task_type.id;


--
-- TOC entry 2222 (class 0 OID 0)
-- Dependencies: 177
-- Name: task_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('task_type_id_seq', 58, true);


--
-- TOC entry 178 (class 1259 OID 49886)
-- Dependencies: 6
-- Name: user; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE "user" (
    id integer NOT NULL,
    name character varying(64) NOT NULL,
    email character varying(255) NOT NULL,
    pwd character(32) NOT NULL,
    created timestamp without time zone NOT NULL,
    last_login timestamp without time zone,
    status smallint NOT NULL,
    rnd_salt character varying(32) NOT NULL,
    person_id bigint NOT NULL,
    appaccount_id bigint NOT NULL,
    acl_role_id integer
);


--
-- TOC entry 2223 (class 0 OID 0)
-- Dependencies: 178
-- Name: TABLE "user"; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE "user" IS 'User of the system';


--
-- TOC entry 2224 (class 0 OID 0)
-- Dependencies: 178
-- Name: COLUMN "user".status; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN "user".status IS 'Status of the user account. 

-1 	= Blocked
0 	= Not yet activated
1	= Active';


--
-- TOC entry 2225 (class 0 OID 0)
-- Dependencies: 178
-- Name: COLUMN "user".rnd_salt; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN "user".rnd_salt IS 'Randomic salt to generate the encripted password with MD5';


--
-- TOC entry 179 (class 1259 OID 49889)
-- Dependencies: 6 178
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 2226 (class 0 OID 0)
-- Dependencies: 179
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE user_id_seq OWNED BY "user".id;


--
-- TOC entry 2227 (class 0 OID 0)
-- Dependencies: 179
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('user_id_seq', 8, true);


--
-- TOC entry 180 (class 1259 OID 49891)
-- Dependencies: 1770 6
-- Name: v_Employee; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW "v_Employee" AS
    SELECT p.id, p.name, p.created, p.appaccount_id, p.address, p.addressdetails, p.addressnumber, p.city_id, p.mobilephone, p.phone, p.postalcode, p.website, p.email, p.gender, p.birthdate, p.city_region_id, e.busunit_id, e.registration_number, e.job_function_id FROM (person p JOIN employee e ON ((p.id = e.id)));


--
-- TOC entry 181 (class 1259 OID 49896)
-- Dependencies: 6
-- Name: volunteer; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE volunteer (
    id bigint NOT NULL
);


--
-- TOC entry 182 (class 1259 OID 49899)
-- Dependencies: 1771 6
-- Name: v_Volunteer; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW "v_Volunteer" AS
    SELECT p.id, p.name, p.created, p.appaccount_id, p.address, p.addressdetails, p.addressnumber, p.city_id, p.mobilephone, p.phone, p.postalcode, p.website, p.email, p.gender, p.birthdate, p.city_region_id FROM (person p JOIN volunteer v ON ((p.id = v.id)));


--
-- TOC entry 193 (class 1259 OID 94767)
-- Dependencies: 1772 6
-- Name: v_person_helped; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW v_person_helped AS
    SELECT p.id, p.name, p.created, p.appaccount_id, p.address, p.addressdetails, p.addressnumber, p.city_id, p.mobilephone, p.phone, p.postalcode, p.website, p.email, p.gender, p.birthdate, p.city_region_id, p.marital_status, ph.religion, ph.professional_occupation, ph.professional_experience, ph.live_with_family, ph.home_situation, ph.home_since, ph.born_city_id, ph.born_state_id, ph.home_area, ph.home_type, ph.home_pieces_number, ph.rent_value, ph.first_help_date FROM (person p JOIN person_helped ph ON ((p.id = ph.id)));


--
-- TOC entry 194 (class 1259 OID 94772)
-- Dependencies: 1773 6
-- Name: v_person_helped_by_project; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW v_person_helped_by_project AS
    SELECT prj.name AS project_name, php.project_id, php.person_id, php.date_in, php.date_out, p.name AS person_name FROM ((project prj LEFT JOIN person_helped_project php ON ((prj.id = php.project_id))) LEFT JOIN person p ON ((php.person_id = p.id))) ORDER BY prj.name, p.name;


--
-- TOC entry 195 (class 1259 OID 94777)
-- Dependencies: 1774 6
-- Name: v_person_helped_programa_federal_social; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW v_person_helped_programa_federal_social AS
    SELECT ph.id AS person_id, pfs.id AS pfs_id, pfs.nome AS pfs_nome, pfs.sigla AS pgs_sigla FROM ((person_helped ph JOIN person_programa_federal_social ppfs ON ((ph.id = ppfs.person_id))) JOIN programa_federal_social pfs ON ((ppfs.pfs_id = pfs.id)));


--
-- TOC entry 183 (class 1259 OID 49908)
-- Dependencies: 6
-- Name: volunteer_expertise_area; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE volunteer_expertise_area (
    volunteer_id bigint NOT NULL,
    expertise_area_id integer NOT NULL
);


--
-- TOC entry 1966 (class 2604 OID 49911)
-- Dependencies: 141 140
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_role ALTER COLUMN id SET DEFAULT nextval('acl_role_id_seq'::regclass);


--
-- TOC entry 1967 (class 2604 OID 49912)
-- Dependencies: 143 142
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_role_permission ALTER COLUMN id SET DEFAULT nextval('acl_role_permission_id_seq'::regclass);


--
-- TOC entry 1968 (class 2604 OID 49913)
-- Dependencies: 145 144
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY appaccount ALTER COLUMN id SET DEFAULT nextval('appaccount_id_seq'::regclass);


--
-- TOC entry 1970 (class 2604 OID 49914)
-- Dependencies: 147 146
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY audit_trail ALTER COLUMN id SET DEFAULT nextval('audit_trail_id_seq'::regclass);


--
-- TOC entry 1972 (class 2604 OID 49915)
-- Dependencies: 149 148
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY busunit ALTER COLUMN id SET DEFAULT nextval('busunit_id_seq'::regclass);


--
-- TOC entry 1974 (class 2604 OID 49916)
-- Dependencies: 155 154
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY country ALTER COLUMN id SET DEFAULT nextval('country_id_seq'::regclass);


--
-- TOC entry 1975 (class 2604 OID 49917)
-- Dependencies: 158 157
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY expertise_area ALTER COLUMN id SET DEFAULT nextval('expertise_area_id_seq'::regclass);


--
-- TOC entry 1976 (class 2604 OID 49918)
-- Dependencies: 160 159
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY job_function ALTER COLUMN id SET DEFAULT nextval('job_function_id_seq'::regclass);


--
-- TOC entry 1978 (class 2604 OID 49919)
-- Dependencies: 162 161
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY media ALTER COLUMN id SET DEFAULT nextval('media_id_seq'::regclass);


--
-- TOC entry 1979 (class 2604 OID 49920)
-- Dependencies: 167 163
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY person ALTER COLUMN id SET DEFAULT nextval('person_id_seq'::regclass);


--
-- TOC entry 1982 (class 2604 OID 49921)
-- Dependencies: 173 172
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY project ALTER COLUMN id SET DEFAULT nextval('project_id_seq'::regclass);


--
-- TOC entry 1983 (class 2604 OID 49922)
-- Dependencies: 175 174
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY state ALTER COLUMN id SET DEFAULT nextval('state_id_seq'::regclass);


--
-- TOC entry 1984 (class 2604 OID 49923)
-- Dependencies: 177 176
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY task_type ALTER COLUMN id SET DEFAULT nextval('task_type_id_seq'::regclass);


--
-- TOC entry 1985 (class 2604 OID 49924)
-- Dependencies: 179 178
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY "user" ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


--
-- TOC entry 2116 (class 0 OID 49767)
-- Dependencies: 140
-- Data for Name: acl_role; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO acl_role VALUES (1, 'Super Administradores', 1);
INSERT INTO acl_role VALUES (2, 'Administrador', 1);
INSERT INTO acl_role VALUES (3, 'Gerente', 1);
INSERT INTO acl_role VALUES (4, 'Lançar Cadastros', 1);


--
-- TOC entry 2117 (class 0 OID 49772)
-- Dependencies: 142
-- Data for Name: acl_role_permission; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO acl_role_permission VALUES (43, 'User', 'view', 1);
INSERT INTO acl_role_permission VALUES (44, 'User', 'list', 1);
INSERT INTO acl_role_permission VALUES (45, 'User', 'create', 1);
INSERT INTO acl_role_permission VALUES (46, 'User', 'update', 1);
INSERT INTO acl_role_permission VALUES (47, 'User', 'update-pwd', 1);
INSERT INTO acl_role_permission VALUES (48, 'User', 'delete', 1);
INSERT INTO acl_role_permission VALUES (49, 'UserRole', 'view', 1);
INSERT INTO acl_role_permission VALUES (50, 'UserRole', 'list', 1);
INSERT INTO acl_role_permission VALUES (51, 'UserRole', 'create', 1);
INSERT INTO acl_role_permission VALUES (52, 'UserRole', 'update', 1);
INSERT INTO acl_role_permission VALUES (53, 'UserRole', 'delete', 1);
INSERT INTO acl_role_permission VALUES (54, 'BusinessUnitHeadquarters', 'view', 1);
INSERT INTO acl_role_permission VALUES (55, 'BusinessUnitHeadquarters', 'update', 1);
INSERT INTO acl_role_permission VALUES (56, 'BusinessUnitBranchs', 'view', 1);
INSERT INTO acl_role_permission VALUES (57, 'BusinessUnitBranchs', 'list', 1);
INSERT INTO acl_role_permission VALUES (58, 'BusinessUnitBranchs', 'create', 1);
INSERT INTO acl_role_permission VALUES (59, 'BusinessUnitBranchs', 'update', 1);
INSERT INTO acl_role_permission VALUES (60, 'BusinessUnitBranchs', 'delete', 1);
INSERT INTO acl_role_permission VALUES (61, 'AppAccount', 'view', 1);
INSERT INTO acl_role_permission VALUES (62, 'AppAccount', 'update', 1);
INSERT INTO acl_role_permission VALUES (63, 'User', 'view', 2);
INSERT INTO acl_role_permission VALUES (64, 'User', 'list', 2);
INSERT INTO acl_role_permission VALUES (65, 'UserRole', 'view', 2);
INSERT INTO acl_role_permission VALUES (66, 'UserRole', 'list', 2);
INSERT INTO acl_role_permission VALUES (67, 'BusinessUnitHeadquarters', 'view', 2);
INSERT INTO acl_role_permission VALUES (68, 'BusinessUnitHeadquarters', 'update', 2);
INSERT INTO acl_role_permission VALUES (69, 'BusinessUnitBranchs', 'view', 2);
INSERT INTO acl_role_permission VALUES (70, 'BusinessUnitBranchs', 'list', 2);
INSERT INTO acl_role_permission VALUES (71, 'BusinessUnitBranchs', 'create', 2);
INSERT INTO acl_role_permission VALUES (72, 'BusinessUnitBranchs', 'update', 2);
INSERT INTO acl_role_permission VALUES (73, 'BusinessUnitBranchs', 'delete', 2);
INSERT INTO acl_role_permission VALUES (74, 'AppAccount', 'view', 2);
INSERT INTO acl_role_permission VALUES (75, 'User', 'view', 3);
INSERT INTO acl_role_permission VALUES (76, 'User', 'list', 3);
INSERT INTO acl_role_permission VALUES (77, 'UserRole', 'view', 3);
INSERT INTO acl_role_permission VALUES (78, 'UserRole', 'list', 3);
INSERT INTO acl_role_permission VALUES (79, 'BusinessUnitHeadquarters', 'view', 3);
INSERT INTO acl_role_permission VALUES (80, 'BusinessUnitHeadquarters', 'update', 3);
INSERT INTO acl_role_permission VALUES (81, 'BusinessUnitBranchs', 'view', 3);
INSERT INTO acl_role_permission VALUES (82, 'BusinessUnitBranchs', 'list', 3);
INSERT INTO acl_role_permission VALUES (83, 'BusinessUnitBranchs', 'create', 3);
INSERT INTO acl_role_permission VALUES (84, 'BusinessUnitBranchs', 'update', 3);
INSERT INTO acl_role_permission VALUES (85, 'AppAccount', 'view', 3);
INSERT INTO acl_role_permission VALUES (86, 'BusinessUnitHeadquarters', 'view', 4);
INSERT INTO acl_role_permission VALUES (87, 'BusinessUnitBranchs', 'view', 4);
INSERT INTO acl_role_permission VALUES (88, 'BusinessUnitBranchs', 'list', 4);


--
-- TOC entry 2118 (class 0 OID 49777)
-- Dependencies: 144
-- Data for Name: appaccount; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO appaccount VALUES (1, 'Ministério Melhor Viver', 'jeliseumontes@hotmail.com', '2012-12-18 16:12:04');


--
-- TOC entry 2141 (class 0 OID 50147)
-- Dependencies: 185
-- Data for Name: appaccount_media; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2142 (class 0 OID 50152)
-- Dependencies: 186
-- Data for Name: atividade_assistencia; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO atividade_assistencia VALUES (5, 1212, 1, 16, 4, '2014-07-12', '17:34:00', 1, 'Teste teste teste', NULL, false, 1);
INSERT INTO atividade_assistencia VALUES (6, 62, 1, 3, NULL, '2014-07-12', '00:43:00', 1, 'slkdfjkl dl', NULL, false, 1);
INSERT INTO atividade_assistencia VALUES (7, 62, 1, 3, NULL, '2014-07-12', '00:47:00', 1, 'Vamo la', NULL, false, 1);
INSERT INTO atividade_assistencia VALUES (8, 62, 1, 3, NULL, '2014-07-12', '00:52:00', 1, 'Mais um, 
falta arrumar o erro ao tentar carregar a imagem', NULL, false, 1);
INSERT INTO atividade_assistencia VALUES (9, 1341, 1, 3, NULL, '2014-07-12', '00:53:00', 1, '', NULL, false, 1);
INSERT INTO atividade_assistencia VALUES (10, 218, 1, 3, NULL, '2014-07-12', '00:54:00', 1, '', NULL, false, 1);
INSERT INTO atividade_assistencia VALUES (11, 373, 1, 3, NULL, '2014-07-12', '00:55:00', 1, '', NULL, false, 1);
INSERT INTO atividade_assistencia VALUES (12, 682, 1, 3, NULL, '2014-07-12', '00:56:00', 1, '', 7, false, 1);
INSERT INTO atividade_assistencia VALUES (13, 62, 1, 3, NULL, '2014-07-12', '01:06:00', 1, 'Cooolll', 7, false, 1);
INSERT INTO atividade_assistencia VALUES (14, 83, 1, 3, NULL, '2014-07-12', '20:23:00', 1, 'Mais um lançamento neste evento', 7, false, 1);
INSERT INTO atividade_assistencia VALUES (15, 14, 1, 3, NULL, '2014-07-12', '20:27:00', 1, '', 7, false, 1);
INSERT INTO atividade_assistencia VALUES (16, 1289, 1, 3, NULL, '2014-07-12', '20:28:00', 1, '', 7, false, 1);
INSERT INTO atividade_assistencia VALUES (17, 574, 1, 3, NULL, '2014-07-12', '20:44:00', 1, '', 7, false, 1);
INSERT INTO atividade_assistencia VALUES (18, 728, 1, 3, NULL, '2014-07-12', '23:11:00', 1, 'ddd', 7, false, 1);
INSERT INTO atividade_assistencia VALUES (19, 1177, 1, 19, 6, '2014-07-16', '20:46:00', 1, 'Para resolver o problema da data', NULL, false, 1);
INSERT INTO atividade_assistencia VALUES (20, 697, 1, 3, NULL, '2014-07-12', '20:56:00', 1, 'Acho que resolveu a hora ', 7, false, 1);
INSERT INTO atividade_assistencia VALUES (21, 689, 1, 22, 13, '2014-07-16', '21:13:00', 1, '', 10, false, 1);
INSERT INTO atividade_assistencia VALUES (22, 479, 1, 22, 13, '2014-07-16', '21:13:00', 1, '', 10, false, 1);
INSERT INTO atividade_assistencia VALUES (23, 167, 1, 15, 10, '2014-07-16', '22:50:00', 1, 'sçlkdjld', 14, false, 1);


--
-- TOC entry 2119 (class 0 OID 49782)
-- Dependencies: 146
-- Data for Name: audit_trail; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO audit_trail VALUES (1, 1, 'appaccount', 'name', '2012-12-18 18:32:31', 'UPD', 1, ' ', 1, 'Winponta Software');
INSERT INTO audit_trail VALUES (2, 1, 'appaccount', 'email', '2012-12-18 18:32:31', 'UPD', 1, ' ', 1, 'admin@winponta.com.br');
INSERT INTO audit_trail VALUES (3, 1, 'appaccount', 'email', '2012-12-18 18:33:06', 'UPD', 1, ' ', 1, 'pastorjoao@gmail.com');
INSERT INTO audit_trail VALUES (4, 2, 'user', 'name', '2012-12-19 13:56:00', 'UPD', 1, ' ', 1, 'joao2');
INSERT INTO audit_trail VALUES (5, 3, 'user', 'name', '2012-12-19 13:59:07', 'UPD', 1, ' ', 1, 'silvana3');
INSERT INTO audit_trail VALUES (6, 4, 'user', 'name', '2012-12-19 14:01:17', 'UPD', 1, ' ', 1, 'ana4');
INSERT INTO audit_trail VALUES (7, 5, 'user', 'name', '2012-12-19 14:03:02', 'UPD', 1, ' ', 1, 'carolina5');
INSERT INTO audit_trail VALUES (8, 6, 'user', 'name', '2012-12-19 14:04:49', 'UPD', 1, ' ', 1, 'emanuely6');
INSERT INTO audit_trail VALUES (9, 7, 'user', 'name', '2013-08-30 16:33:05', 'UPD', 1, ' ', 1, 'john97');
INSERT INTO audit_trail VALUES (10, 7, 'user', 'email', '2013-08-30 16:33:05', 'UPD', 1, ' ', 1, 'john97@no.validemail.com');
INSERT INTO audit_trail VALUES (11, 7, 'user', 'name', '2014-04-24 13:46:53', 'UPD', 7, ' ', 1, 'john');


--
-- TOC entry 2120 (class 0 OID 49788)
-- Dependencies: 148
-- Data for Name: busunit; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO busunit VALUES (1, 'Ministério Melhor Viver', 'Ministério Melhor Viver', '07.223.960/0001-60', '(42) 3223-9414', 'R. Herculano de Freitas', '751', '', '84015-105', 'http://www.ministeriomelhorviver.com.br', 1, 1, 1, 'Jd Carvalho');
INSERT INTO busunit VALUES (2, 'Comunidade Terapêutica Melhor Viver', '', '07.223.960/0001-60', '(42) 3243-0139', 'Rua Neci Nunes Ferreira', 's/n', '', '', '', 1, 1, 0, 'Lagoa Dourada');
INSERT INTO busunit VALUES (3, 'Chacara Cidade dos santos', '', '07.223.960/0001-60', 'não possui', 'Rua Florestópulis', 's/n', '', '', '', 1, 1, 0, 'Cipa');
INSERT INTO busunit VALUES (4, 'Republica de Apoio', 'Republica de Apoio', '07.223.960/0001-60', 'não possui', 'Rua Daily Luiz Wambier', '2560', '', '84015010', '', 1, 1, 0, 'Jardim Carvalho');


--
-- TOC entry 2143 (class 0 OID 50162)
-- Dependencies: 187
-- Data for Name: category; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2144 (class 0 OID 50167)
-- Dependencies: 188
-- Data for Name: category_group; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2121 (class 0 OID 49797)
-- Dependencies: 150
-- Data for Name: city; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO city VALUES (1, 'Ponta Grossa', 17);
INSERT INTO city VALUES (2, 'Castro', 17);
INSERT INTO city VALUES (3, 'Curitiba', 17);
INSERT INTO city VALUES (4, 'Carambeí', 17);
INSERT INTO city VALUES (5, 'Palmeira', 17);
INSERT INTO city VALUES (7, 'Cocos', 5);
INSERT INTO city VALUES (8, 'Bauru', 26);
INSERT INTO city VALUES (9, 'tibagi', 17);
INSERT INTO city VALUES (10, 'telemaco borba', 17);
INSERT INTO city VALUES (11, 'sao paulo', 26);
INSERT INTO city VALUES (12, 'Jaguariaiva', 17);
INSERT INTO city VALUES (13, 'Ortigueira', 17);
INSERT INTO city VALUES (14, 'Uruguaiana', 22);
INSERT INTO city VALUES (15, 'Londrina', 17);
INSERT INTO city VALUES (16, 'Prudentopulis', 17);
INSERT INTO city VALUES (17, 'Ipirang', 17);
INSERT INTO city VALUES (18, 'Marechal Candido Rondom', 17);
INSERT INTO city VALUES (19, 'Joinville', 25);
INSERT INTO city VALUES (20, 'Guarapuava', 17);
INSERT INTO city VALUES (21, 'São João do Ivai', 17);
INSERT INTO city VALUES (22, 'São José dos Pinhais', 16);
INSERT INTO city VALUES (23, 'Bairro Alto', 9);
INSERT INTO city VALUES (24, 'Jacarezinho', 22);
INSERT INTO city VALUES (25, 'Pato Branco', 17);
INSERT INTO city VALUES (26, 'Araguari', 29);
INSERT INTO city VALUES (27, 'Itapetininga', 26);
INSERT INTO city VALUES (28, 'Sorocaba', 26);
INSERT INTO city VALUES (29, 'Ivaiporã', 17);
INSERT INTO city VALUES (30, 'Wenceslau Braz', 17);
INSERT INTO city VALUES (31, 'Turvo', 17);
INSERT INTO city VALUES (32, 'Foz do Iguaçu', 17);
INSERT INTO city VALUES (33, 'Arappostgresas', 17);
INSERT INTO city VALUES (34, 'Araras', 26);
INSERT INTO city VALUES (35, 'Lençois Paulista', 26);
INSERT INTO city VALUES (36, 'Santo Antonio da Platina', 17);
INSERT INTO city VALUES (37, 'Laranjeiras do sul', 17);
INSERT INTO city VALUES (6, 'Paranavai', 17);
INSERT INTO city VALUES (38, 'Mandaguari', 10);


--
-- TOC entry 2122 (class 0 OID 49804)
-- Dependencies: 153
-- Data for Name: city_region; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO city_region VALUES (1, 'Centro', 1, NULL);
INSERT INTO city_region VALUES (2, 'Parque Ambiental', 1, 1);
INSERT INTO city_region VALUES (3, 'Cipa', 1, NULL);
INSERT INTO city_region VALUES (4, 'Jardim Carvalho', 1, NULL);
INSERT INTO city_region VALUES (5, 'Uvaranas', 1, NULL);
INSERT INTO city_region VALUES (6, 'Lagoa Dourada', 1, 5);
INSERT INTO city_region VALUES (7, 'Boa Vista', 1, NULL);
INSERT INTO city_region VALUES (8, 'Nova Russia', 4, NULL);
INSERT INTO city_region VALUES (9, 'Oficinas', 1, NULL);
INSERT INTO city_region VALUES (10, 'Praça dos Polacos', 1, 1);
INSERT INTO city_region VALUES (11, '31 de março', 1, 5);
INSERT INTO city_region VALUES (12, 'Vila estrela', 1, 9);
INSERT INTO city_region VALUES (13, 'Cel.Claudio', 1, 5);
INSERT INTO city_region VALUES (15, 'Sta Terezinha', 5, NULL);
INSERT INTO city_region VALUES (16, 'sabara', 1, 7);
INSERT INTO city_region VALUES (17, 'pimentel', 1, 5);
INSERT INTO city_region VALUES (18, 'lelila maria', 1, 7);
INSERT INTO city_region VALUES (19, 'loteamento cachoeira', 1, 6);
INSERT INTO city_region VALUES (20, 'Ronda', 1, 1);
INSERT INTO city_region VALUES (21, 'Santa paula', 1, 1);
INSERT INTO city_region VALUES (23, 'Vilela', 1, 1);
INSERT INTO city_region VALUES (24, 'Vila Liane', 1, NULL);
INSERT INTO city_region VALUES (25, 'Rio Verde', 1, NULL);
INSERT INTO city_region VALUES (26, 'Nossa Senhora dgss', 8, NULL);
INSERT INTO city_region VALUES (27, 'Sao jose', 1, NULL);
INSERT INTO city_region VALUES (28, 'Estrela do Lago', 1, NULL);
INSERT INTO city_region VALUES (29, 'Vila Rio Branco', 1, NULL);
INSERT INTO city_region VALUES (30, 'Baronesa', 1, NULL);
INSERT INTO city_region VALUES (22, 'Nova rusia', 1, 8);
INSERT INTO city_region VALUES (31, 'Palmeirinha', 1, 7);
INSERT INTO city_region VALUES (32, 'Santo Antonio', 1, NULL);
INSERT INTO city_region VALUES (33, 'Olarias', 1, 9);
INSERT INTO city_region VALUES (34, 'Jardim Cachoeira', 1, NULL);
INSERT INTO city_region VALUES (35, 'Vila Margarida', 1, NULL);
INSERT INTO city_region VALUES (36, 'Santa Maria', 1, NULL);
INSERT INTO city_region VALUES (37, 'Cpostgresonhas', 1, NULL);
INSERT INTO city_region VALUES (38, 'Cloris', 1, NULL);
INSERT INTO city_region VALUES (39, 'Recanto Verde', 1, NULL);
INSERT INTO city_region VALUES (40, 'Vila rio Branco', 1, 9);
INSERT INTO city_region VALUES (41, 'Cara-Cara', 1, 1);
INSERT INTO city_region VALUES (42, 'Mariana', 1, NULL);
INSERT INTO city_region VALUES (43, 'Bela Vista', 1, NULL);
INSERT INTO city_region VALUES (44, 'núcleo Gralha Azul', 1, 1);
INSERT INTO city_region VALUES (14, 'Nossa Senhora das Graças', 1, 7);
INSERT INTO city_region VALUES (45, 'Gralha Azul', 1, 21);


--
-- TOC entry 2123 (class 0 OID 49808)
-- Dependencies: 154
-- Data for Name: country; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO country VALUES (1, 'Brasil');
INSERT INTO country VALUES (2, 'Paraguai');
INSERT INTO country VALUES (3, 'Argentina');
INSERT INTO country VALUES (4, 'Chile');


--
-- TOC entry 2124 (class 0 OID 49813)
-- Dependencies: 156
-- Data for Name: employee; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO employee VALUES (6, '', 1, 2);
INSERT INTO employee VALUES (3, '7', 1, 1);
INSERT INTO employee VALUES (5, '2', 1, 1);
INSERT INTO employee VALUES (2, '00', 1, 3);
INSERT INTO employee VALUES (13, '1', 1, 9);
INSERT INTO employee VALUES (14, '2', 2, 10);
INSERT INTO employee VALUES (15, '3', 1, 11);
INSERT INTO employee VALUES (16, '4', 2, 12);
INSERT INTO employee VALUES (17, '5', 1, 12);
INSERT INTO employee VALUES (18, '6', 2, 12);
INSERT INTO employee VALUES (22, '8', 2, 6);
INSERT INTO employee VALUES (23, '9', 2, 4);
INSERT INTO employee VALUES (24, '10', 2, 13);
INSERT INTO employee VALUES (26, '12', 2, 12);
INSERT INTO employee VALUES (27, '13', 2, 12);
INSERT INTO employee VALUES (28, '14', 2, 12);
INSERT INTO employee VALUES (29, '15', 2, 14);
INSERT INTO employee VALUES (30, '16', 2, 1);
INSERT INTO employee VALUES (31, '17', 2, 11);
INSERT INTO employee VALUES (32, '18', 2, 11);
INSERT INTO employee VALUES (33, '19', 2, 15);
INSERT INTO employee VALUES (34, '20', 2, 16);
INSERT INTO employee VALUES (35, '21', 1, 12);
INSERT INTO employee VALUES (36, '22', 1, 8);
INSERT INTO employee VALUES (37, '23', 1, 6);
INSERT INTO employee VALUES (38, '24', 1, 6);
INSERT INTO employee VALUES (39, '25', 3, 12);
INSERT INTO employee VALUES (40, '26', 1, 4);
INSERT INTO employee VALUES (41, '27', 1, 8);
INSERT INTO employee VALUES (42, '28', 1, 7);
INSERT INTO employee VALUES (43, '29', 1, 10);
INSERT INTO employee VALUES (1338, '20', 1, 1);


--
-- TOC entry 2145 (class 0 OID 50172)
-- Dependencies: 189
-- Data for Name: evento_assistencia; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO evento_assistencia VALUES (7, '2014-07-12', 3, NULL, 1);
INSERT INTO evento_assistencia VALUES (8, '2014-07-12', 6, NULL, 1);
INSERT INTO evento_assistencia VALUES (10, '2014-07-16', 22, 13, 1);
INSERT INTO evento_assistencia VALUES (11, '2014-07-16', 3, 13, 1);
INSERT INTO evento_assistencia VALUES (12, '2014-07-16', 11, NULL, 1);
INSERT INTO evento_assistencia VALUES (13, '2014-07-16', 4, NULL, 1);
INSERT INTO evento_assistencia VALUES (14, '2014-07-16', 15, 10, 1);
INSERT INTO evento_assistencia VALUES (15, '2014-07-16', 13, 5, 1);
INSERT INTO evento_assistencia VALUES (16, '2014-07-15', 14, NULL, 1);


--
-- TOC entry 2125 (class 0 OID 49816)
-- Dependencies: 157
-- Data for Name: expertise_area; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO expertise_area VALUES (1, 'Professor de Informática', 'Aulas de Informática básica', 1);
INSERT INTO expertise_area VALUES (2, 'Professor de Alfabetizaçao', '', 1);
INSERT INTO expertise_area VALUES (3, 'Cozinheiro', '', 1);
INSERT INTO expertise_area VALUES (4, 'Professora de Artesanato', '', 1);
INSERT INTO expertise_area VALUES (5, 'Assistente Social', '', 1);
INSERT INTO expertise_area VALUES (6, 'Administrador de Informática', 'Lança cadastros e administra o programa de informática.', 1);


--
-- TOC entry 2147 (class 0 OID 94758)
-- Dependencies: 192
-- Data for Name: fingerprint; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO fingerprint VALUES (1312, 3, 'wdwsdwsdd');
INSERT INTO fingerprint VALUES (1312, 9, 'snldf ksld fjlskdfjld ');
INSERT INTO fingerprint VALUES (1384, 5, 'ESTE ÉUM TESTE POR ISSO A CHAVE NÃO É REAL E SIM SOMENTE ESTA FRASE, DEVE SER EXCLUIDO');
INSERT INTO fingerprint VALUES (1384, 7, 'ESTE ÉUM TESTE POR ISSO A CHAVE NÃO É REAL E SIM SOMENTE ESTA FRASE, DEVE SER EXCLUIDO');
INSERT INTO fingerprint VALUES (1384, 6, 'ESTE ÉUM TESTE POR ISSO A CHAVE NÃO É REAL E SIM SOMENTE ESTA FRASE, DEVE SER EXCLUIDO');
INSERT INTO fingerprint VALUES (1384, 1, 'ESTE ÉUM TESTE POR ISSO A CHAVE NÃO É REAL E SIM SOMENTE ESTA FRASE, DEVE SER EXCLUIDO');
INSERT INTO fingerprint VALUES (1384, 9, 'ESTE ÉUM TESTE POR ISSO A CHAVE NÃO É REAL E SIM SOMENTE ESTA FRASE, DEVE SER EXCLUIDO');
INSERT INTO fingerprint VALUES (272, 1, 'ESTE ÉUM TESTE POR ISSO A CHAVE NÃO É REAL E SIM SOMENTE ESTA FRASE, DEVE SER EXCLUIDO');
INSERT INTO fingerprint VALUES (272, 7, 'ESTE ÉUM TESTE POR ISSO A CHAVE NÃO É REAL E SIM SOMENTE ESTA FRASE, DEVE SER EXCLUIDO');
INSERT INTO fingerprint VALUES (272, 4, 'ESTE ÉUM TESTE POR ISSO A CHAVE NÃO É REAL E SIM SOMENTE ESTA FRASE, DEVE SER EXCLUIDO');
INSERT INTO fingerprint VALUES (272, 5, 'ESTE ÉUM TESTE POR ISSO A CHAVE NÃO É REAL E SIM SOMENTE ESTA FRASE, DEVE SER EXCLUIDO');
INSERT INTO fingerprint VALUES (272, 2, 'ESTE ÉUM TESTE POR ISSO A CHAVE NÃO É REAL E SIM SOMENTE ESTA FRASE, DEVE SER EXCLUIDO');
INSERT INTO fingerprint VALUES (272, 3, 'ESTE ÉUM TESTE POR ISSO A CHAVE NÃO É REAL E SIM SOMENTE ESTA FRASE, DEVE SER EXCLUIDO');
INSERT INTO fingerprint VALUES (272, 8, 'ESTE ÉUM TESTE POR ISSO A CHAVE NÃO É REAL E SIM SOMENTE ESTA FRASE, DEVE SER EXCLUIDO');


--
-- TOC entry 2126 (class 0 OID 49821)
-- Dependencies: 159
-- Data for Name: job_function; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO job_function VALUES (1, 'Assistente Social', '', 1);
INSERT INTO job_function VALUES (3, 'Presidente', '', 1);
INSERT INTO job_function VALUES (2, 'Estagiário(a) - Auxiliar Administrativo', '', 1);
INSERT INTO job_function VALUES (4, 'Motorista', '', 1);
INSERT INTO job_function VALUES (5, 'Atendente Social', '', 1);
INSERT INTO job_function VALUES (6, 'Coordenador de Unidade', '', 1);
INSERT INTO job_function VALUES (7, 'Pedreiro', '', 1);
INSERT INTO job_function VALUES (8, 'Agente de abordagem', '', 1);
INSERT INTO job_function VALUES (9, 'Diretor (a) de unidade', '', 1);
INSERT INTO job_function VALUES (10, 'Psicólogo (a)', '', 1);
INSERT INTO job_function VALUES (11, 'Cozinheira', '', 1);
INSERT INTO job_function VALUES (12, 'Educador Social', '', 1);
INSERT INTO job_function VALUES (13, 'Prof. Ed. Física', '', 1);
INSERT INTO job_function VALUES (14, 'Auxiliar Administrativo', '', 1);
INSERT INTO job_function VALUES (15, 'Gestor Financeiro', '', 1);
INSERT INTO job_function VALUES (16, 'Zeladora', '', 1);


--
-- TOC entry 2127 (class 0 OID 49826)
-- Dependencies: 161
-- Data for Name: media; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO media VALUES (2, 'person_20', '7de4490b8998d6957f133a7d082a4bc0.jpg', 42940, 'application/octet-stream');
INSERT INTO media VALUES (3, 'person_25', 'b784fa7d9d17aca3061dd0a4fa5fc4bc.jpg', 160698, 'application/octet-stream');
INSERT INTO media VALUES (4, 'person_5', '4b770bc6ec98eb43edb3203b19550b47.jpg', 150725, 'application/octet-stream');
INSERT INTO media VALUES (5, 'person_13', 'caaff667d661320df7721397c5870e51.jpg', 73915, 'application/octet-stream');
INSERT INTO media VALUES (6, 'person_14', 'dc443a09b4909bd4ea1e2c41cdd62179.jpg', 164015, 'application/octet-stream');
INSERT INTO media VALUES (7, 'person_15', '7cd5a5c090f2eb02784bbb27621ac0c2.jpg', 22939, 'application/octet-stream');
INSERT INTO media VALUES (8, 'person_17', '5dd512bef04a99f0f6cf8ed560b93325.jpg', 44558, 'application/octet-stream');
INSERT INTO media VALUES (9, 'person_3', '758acc90eb6d8cc9d2d9a5f795ea3432.jpg', 119533, 'application/octet-stream');
INSERT INTO media VALUES (10, 'person_37', 'c10b1716c0e48ac2d312a89604452824.jpg', 96171, 'application/octet-stream');
INSERT INTO media VALUES (11, 'person_38', 'dd6a5ed90d2c081bb7a8f1d33a370590.jpg', 21008, 'application/octet-stream');
INSERT INTO media VALUES (13, 'person_48', '333138af2224b8d6fef6830bd8b3653e.png', 127999, 'application/octet-stream');
INSERT INTO media VALUES (12, 'person_97', '2a70518eaaf44d81aabb6302c7542d22.jpg', 23067, 'application/octet-stream');
INSERT INTO media VALUES (14, 'person_115', '5e74b98383d1620605d866abebcff78a.png', 143329, 'application/octet-stream');
INSERT INTO media VALUES (15, 'person_109', 'c71903fb3d9ef81a69c62b280c09b38f.png', 123745, 'application/octet-stream');
INSERT INTO media VALUES (16, 'person_70', '16bbd35dc4c4e2ee546cb0e7fd68c880.png', 139953, 'application/octet-stream');
INSERT INTO media VALUES (17, 'person_67', '5d3151772c2558dede2789946bc2621a.png', 117959, 'application/octet-stream');
INSERT INTO media VALUES (19, 'person_71', '15f342e0fc14ae164cbc18c0ce8d751b.png', 106454, 'application/octet-stream');
INSERT INTO media VALUES (20, 'person_54', '3a07cbcd264f4b1fcbbd93cd13ecb461.png', 131523, 'application/octet-stream');
INSERT INTO media VALUES (21, 'person_128', '6822b93e786c625b062e8f85c5ecc081.png', 121359, 'application/octet-stream');
INSERT INTO media VALUES (22, 'person_127', 'e0132ea418d4e5faa406bc472d5d054a.png', 122842, 'application/octet-stream');
INSERT INTO media VALUES (23, 'person_574', '9d7f4ece29a0dd213ba6937cbe915089.png', 111232, 'application/octet-stream');
INSERT INTO media VALUES (24, 'person_103', '39623218e04957adfb59d5bf4cc6c31d.png', 125467, 'application/octet-stream');
INSERT INTO media VALUES (18, 'person_974', '93885fb86a6eede7bc666deaf54328e4.png', 123905, 'application/octet-stream');
INSERT INTO media VALUES (25, 'person_117', 'ee7e798769b1404d1ddf62542f4dbc14.png', 118336, 'application/octet-stream');
INSERT INTO media VALUES (26, 'person_98', 'bd8425318c62f515b7d70e7976f21b05.png', 118787, 'application/octet-stream');
INSERT INTO media VALUES (27, 'person_72', '1389de81c144d0e90a6408bf3d33fd91.png', 116002, 'application/octet-stream');
INSERT INTO media VALUES (28, 'person_753', '951624a605e7aa348c31491cfcbafd04.png', 138790, 'application/octet-stream');
INSERT INTO media VALUES (29, 'person_118', '370eb7462c9da2deb33b990ed649d857.png', 116114, 'application/octet-stream');
INSERT INTO media VALUES (30, 'person_978', 'c4077ed3293579a50779b12e482e986e.png', 128364, 'application/octet-stream');
INSERT INTO media VALUES (31, 'person_60', '7b05c1e7935e291f4c1eb45231a7f64b.png', 130701, 'application/octet-stream');
INSERT INTO media VALUES (32, 'person_122', '2bbe9e6c79ea2002f77e9cfed72143d7.png', 131713, 'application/octet-stream');
INSERT INTO media VALUES (33, 'person_126', '74ac57267c18cfe109cf05b1cdf25e60.png', 121708, 'application/octet-stream');
INSERT INTO media VALUES (34, 'person_124', '8b66916214585fd21ce824a0ca8e9671.png', 127091, 'application/octet-stream');
INSERT INTO media VALUES (35, 'person_132', '0903ad92488e86f33a320cdbcfe2d104.png', 132733, 'application/octet-stream');
INSERT INTO media VALUES (36, 'person_1047', '333138af2224b8d6fef6830bd8b3653e.png', 127999, 'application/octet-stream');
INSERT INTO media VALUES (37, 'person_46', 'c71903fb3d9ef81a69c62b280c09b38f.png', 123745, 'application/octet-stream');
INSERT INTO media VALUES (1, 'person_6', 'ca81d6c753cdf4b14b969601660b042e.jpg', 160472, 'application/octet-stream');
INSERT INTO media VALUES (38, 'person_1337', '9cdfcff8339289838bf301815c6b5ec2.jpg', 116309, 'application/octet-stream');
INSERT INTO media VALUES (39, 'person_1338', '79a497f04c66847cbf0b3b8f134d45b4.jpg', 26866, 'application/octet-stream');
INSERT INTO media VALUES (40, 'person_62', '20c5a1816544cd57cdc2b564999246c1.jpg', 124171, 'image/jpeg');


--
-- TOC entry 2128 (class 0 OID 49832)
-- Dependencies: 163
-- Data for Name: person; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO person VALUES (2, 'João Eliseu Montes', '2012-12-19 13:12:22', 1, '', '', '      ', 1, '                ', '                ', '         ', '', 'jeliseumontes@hotmail.com', 'm', NULL, NULL, NULL);
INSERT INTO person VALUES (3, 'Silvana Mayer Moro', '2012-12-19 13:12:23', 1, '', '', '      ', 1, '                ', '                ', '         ', '', 'silvanammoro@hotmail.com', 'm', NULL, NULL, NULL);
INSERT INTO person VALUES (41, 'Patrick Fernando Osga', '2013-05-22 16:05:11', 1, 'Rua Herculano de Freitas', '', '743   ', 1, '                ', '                ', '84015105 ', '', '', 'm', NULL, 4, 'married');
INSERT INTO person VALUES (5, 'Carolina Ribeiro Saraiva Muniz', '2012-12-19 14:12:32', 1, '', '', '      ', 1, '                ', '                ', '         ', '', 'carolruiva21@hotmail.com', 'f', NULL, NULL, NULL);
INSERT INTO person VALUES (7, 'Teste', '2012-12-19 14:12:39', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', NULL, NULL, NULL);
INSERT INTO person VALUES (1, 'Ademir Mazer Jr', '2012-12-18 16:12:04', 1, '', '', '      ', 1, '42 - 9135.5005  ', '                ', '         ', '', 'ademir@winponta.com.br', 'm', '1974-07-17', NULL, 'married');
INSERT INTO person VALUES (12, 'Francelis Garcia', '2013-05-10 17:05:42', 1, 'Rua Francisco Ribas', '', '1194  ', 1, '(42)99617284    ', '(42) 33235188   ', '84015000 ', '', 'francelis-garcia@hotmail.com', 'f', '1977-10-04', 1, 'single');
INSERT INTO person VALUES (13, 'Ana Flavia Von Heimburg', '2013-05-15 16:05:11', 1, '', '', '      ', 1, '                ', '(42) 3028-8817  ', '         ', '', 'flaviaheimburg@hotmail.com', 'f', '1978-12-29', NULL, 'married');
INSERT INTO person VALUES (14, 'Ana Paula de Souza Pereira', '2013-05-15 16:05:02', 1, '', '', '      ', 1, '                ', '                ', '         ', '', 'anapauladream@yahoo.com.br', 'f', '1987-03-15', NULL, 'married');
INSERT INTO person VALUES (15, 'Carla Andressa de Lara', '2013-05-15 16:05:26', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1981-10-17', NULL, 'married');
INSERT INTO person VALUES (16, 'Sidnei Roberto scherer', '2013-05-15 16:05:35', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1964-05-30', NULL, 'separated');
INSERT INTO person VALUES (17, 'Cristiano dos Santos souza', '2013-05-15 16:05:01', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1981-11-24', NULL, 'married');
INSERT INTO person VALUES (18, 'Eder Otoni do Nascimento', '2013-05-15 16:05:15', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1975-05-31', NULL, 'married');
INSERT INTO person VALUES (20, 'Amadeu Rosa', '2013-05-15 17:05:40', 1, 'Rua Florestópulis', '', 's/n   ', 1, '                ', 'não possui      ', '         ', '', '', 'm', '1954-05-28', 3, 'single');
INSERT INTO person VALUES (21, 'Felipe Augusto Scarpim Cruz', '2013-05-22 14:05:07', 1, '', '', '      ', 1, '(42)            ', '(42)3243-0139   ', '         ', '', 'felipemelhorviver@gmail.com', 'm', '1983-06-24', NULL, 'married');
INSERT INTO person VALUES (22, 'Felipe Augusto Scarpim Cruz', '2013-05-22 14:05:10', 1, '', '', '      ', 1, '(42)            ', '(42)3243-0139   ', '         ', '', 'felipemelhorviver@gmail.com', 'm', '1983-06-24', NULL, 'married');
INSERT INTO person VALUES (23, 'Jairo Gaia', '2013-05-22 14:05:13', 1, '', '', '      ', 1, '(42)            ', '(42) 3243-0139  ', '         ', '', '', 'm', '1950-12-14', NULL, 'married');
INSERT INTO person VALUES (24, 'Jardel Aleixo', '2013-05-22 14:05:31', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', NULL, NULL, '');
INSERT INTO person VALUES (25, 'Jhonatan dos Santos Marques', '2013-05-22 14:05:06', 1, '', '', '      ', 1, '(42)            ', '(42) 3243-0139  ', '         ', '', '', 'm', '1989-11-06', NULL, 'married');
INSERT INTO person VALUES (26, 'Luiz Carlos araujo', '2013-05-22 14:05:21', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1979-09-01', NULL, '');
INSERT INTO person VALUES (27, 'Luiz Carlos Scudlarek', '2013-05-22 14:05:17', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1960-02-08', NULL, '');
INSERT INTO person VALUES (28, 'Luiz Fernando de Oliveira', '2013-05-22 15:05:42', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1988-05-27', NULL, '');
INSERT INTO person VALUES (29, 'Patrick de Lara Correia', '2013-05-22 15:05:15', 1, 'Rua Herculano de Freitads', '', '      ', 1, '(420 8839-0599  ', '(42) 3243-0139  ', '84015105 ', '', 'admcomunidadeterapeutica@hotmail.com', 'm', '1983-09-13', 4, 'single');
INSERT INTO person VALUES (30, 'Valéria Ferreira correia', '2013-05-22 15:05:03', 1, '', '', '      ', 1, '(42) 9919-9195  ', '(42)3243-0139   ', '         ', '', 'servicosocial_valeriaferreira@hotmail.com', 'f', '1989-08-26', NULL, 'single');
INSERT INTO person VALUES (31, 'Vanderleia de Oliveira', '2013-05-22 15:05:28', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1970-04-18', NULL, '');
INSERT INTO person VALUES (32, 'Cristiane Gomes dos Santos', '2013-05-22 15:05:05', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', NULL, NULL, '');
INSERT INTO person VALUES (33, 'Odino Moro Neto', '2013-05-22 15:05:57', 1, 'Rua Green Halg', '', '      ', 1, '(42) 9972-1952  ', '(42) 3223-9414  ', '         ', '', 'odinomoro@hotmail.com', 'm', '1967-10-19', NULL, 'married');
INSERT INTO person VALUES (34, 'Silvana da Silveira', '2013-05-22 15:05:08', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', NULL, NULL, '');
INSERT INTO person VALUES (35, 'Juliano Leitner', '2013-05-22 15:05:43', 1, 'Rua Herculano de Freitas', '', '751   ', 1, '                ', '                ', '84015105 ', '', '', 'm', '1985-11-06', 4, 'single');
INSERT INTO person VALUES (36, 'Ladyani Pereira Rodrigues da Costa', '2013-05-22 15:05:05', 1, 'Rua Herculano de Freitas', '', '743   ', 1, '(42)9905-6270   ', '                ', '84015105 ', '', 'ladydedeus@hotamil.com', 'f', '1985-10-31', 4, 'married');
INSERT INTO person VALUES (37, 'Marcel de Geus', '2013-05-22 15:05:41', 1, 'Rua Prefeito José Hofman', '', '207   ', 1, '(42) 9135-7027  ', '(42) 3236-4038  ', '         ', '', 'mdegeus13@hotmail.com', 'm', '1977-06-10', NULL, 'married');
INSERT INTO person VALUES (39, 'Osmar Carneiro da Silva', '2013-05-22 16:05:35', 1, 'Rua florestópulis', '', 's/n   ', 1, 'não possui      ', 'não possui      ', '         ', '', 'não possui', 'm', '1952-12-23', 3, 'single');
INSERT INTO person VALUES (40, 'Manoel Bittencourt', '2013-05-22 16:05:46', 1, '', '', '      ', 1, '(42) 9971-7002  ', '                ', '         ', '', '', 'm', NULL, NULL, 'married');
INSERT INTO person VALUES (6, 'Emanuely Pitome', '2012-12-19 14:12:30', 1, 'Rua Alzemiro Lopes', '', '100   ', 1, '(42)9999-5857   ', '(42)3223-9414   ', '         ', '', 'emanuelypitome@hotmail.com', 'f', '1996-07-16', NULL, 'single');
INSERT INTO person VALUES (44, 'Anderson Machado dos Santos', '2013-05-23 14:05:14', 1, 'Rua Herculano de Freitas', '', '743   ', 1, '                ', '                ', '84015105 ', '', '', 'm', '1979-11-19', 4, 'single');
INSERT INTO person VALUES (45, 'Anderson Monteiro Bernardo', '2013-05-23 14:05:03', 1, 'Rua Herculano de Freitas', '', '743   ', 1, '                ', '                ', '84015105 ', '', '', 'm', '1988-10-28', 4, 'single');
INSERT INTO person VALUES (46, 'André Domingues Pinhove', '2013-05-23 14:05:14', 1, 'Rua Herculano de Freitas', '', '743   ', 1, '                ', '                ', '84015105 ', '', '', 'm', '1974-10-23', 4, 'separated');
INSERT INTO person VALUES (47, 'Karina Caroline Rodrigues Fiorin', '2013-05-23 14:05:09', 1, 'Rua Herculano de Freitas', '', '751   ', 1, '                ', '                ', '84015105 ', '', '', 'f', '1985-06-16', 4, 'single');
INSERT INTO person VALUES (48, 'Anderson Machado dos Santos', '2013-06-17 15:06:31', 1, 'rua Herculano de Freitas', 'Jd Carvalho', '751   ', 1, 'não possui      ', 'não possui      ', '84015105 ', '', 'não possui', 'm', '1979-11-19', 4, 'single');
INSERT INTO person VALUES (49, 'Ari Marcos do Nascimento', '2013-06-17 16:06:17', 1, 'Rua Herculano de Freitas', '', '751   ', 1, '                ', '                ', '84015105 ', '', '', 'm', '1976-11-06', 4, 'single');
INSERT INTO person VALUES (50, 'Dirceu José Pires', '2013-06-17 16:06:22', 1, 'Rua Herculano de Freitas', '', '751   ', 1, '                ', '                ', '84015105 ', '', '', 'm', '1970-05-03', 4, 'single');
INSERT INTO person VALUES (51, 'Eliakim Ramos Pires', '2013-06-17 16:06:10', 1, 'rua Herculano de Freitas', '', '751   ', 1, '                ', '                ', '84015105 ', '', '', 'm', '1984-07-07', 4, 'married');
INSERT INTO person VALUES (52, 'Gileard Rafael Lacoski', '2013-06-19 11:06:51', 1, 'Rua Herculano de Freitas', '', '751   ', 1, 'não possui      ', '42 32239414     ', '840151005', 'não possui', 'não possui', 'm', '1981-08-09', 4, 'single');
INSERT INTO person VALUES (42, 'Sebastião Henrique Carneiro', '2013-05-22 16:05:17', 1, 'Rua Florestópolis', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '1967-01-21', 3, 'single');
INSERT INTO person VALUES (43, 'Lais Crissiane Rodrigues da Luz', '2013-05-22 16:05:28', 1, '', '', '      ', 1, '42 99320420     ', '                ', '         ', '', '', 'f', '2014-04-14', 1, 'single');
INSERT INTO person VALUES (53, 'Josué de Almeida', '2013-06-19 11:06:11', 1, 'Rua Herculano de Freitas', '', '751   ', 1, 'não possui      ', '42 32239414     ', '84015105 ', '', 'não possui', 'm', '1981-07-22', 4, 'single');
INSERT INTO person VALUES (54, 'Juliano Leitner', '2013-06-19 11:06:51', 1, 'Rua Herculano de Freitas', '', '751   ', 1, '42 99153864     ', '42 32239414     ', '84015105 ', '', 'não possui', 'm', '1985-11-06', 4, 'single');
INSERT INTO person VALUES (55, 'Ladyani Rodrigues Pereira Osga', '2013-06-19 11:06:25', 1, 'Rua Herculano de Freitas', '', '751   ', 1, '42 99056270     ', '42 32239414     ', '84015105 ', '', 'ladydedeus@hotmail.com', 'm', '1985-10-31', 4, 'married');
INSERT INTO person VALUES (57, 'Milton de Oliveira', '2013-06-19 11:06:36', 1, 'Rua Herculano de Freitas', '', '751   ', 1, '                ', '42 32239414     ', '84015105 ', '', 'não possui', 'm', '1957-02-01', 4, 'single');
INSERT INTO person VALUES (58, 'Nelson José Moraes', '2013-06-19 11:06:00', 1, 'Rua Herculano de Freitas', '', '751   ', 1, '98281726        ', '42 32239414     ', '84015105 ', '', 'não possui', 'm', '1966-08-31', 4, 'separated');
INSERT INTO person VALUES (59, 'Rafael Martins Maciel', '2013-06-19 11:06:44', 1, 'Rua Herculano de Freitas', '', '751   ', 1, '42 98226426     ', '                ', '84015105 ', '', 'r.a.f.amaciel@hotmail.com', 'm', '1983-09-21', 4, 'single');
INSERT INTO person VALUES (60, 'Valdecir Antunes Roth', '2013-06-19 11:06:48', 1, 'Rua Herculano de Freitas', '', '751   ', 1, 'não possui      ', '42 32239414     ', '84015105 ', '', 'não possui', 'm', '1974-07-17', 4, 'single');
INSERT INTO person VALUES (61, 'Valdomiro Lopes', '2013-06-19 11:06:13', 1, 'Rua Herculano de Freitas', '', '751   ', 1, '42 99897915     ', '42 32239414     ', '84015105 ', '', 'não possui', 'm', '1976-05-15', 4, 'single');
INSERT INTO person VALUES (62, 'João Antonio Ramos', '2013-07-02 14:07:43', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015105 ', '', '', 'm', '1951-04-22', 4, 'widow(er)');
INSERT INTO person VALUES (38, 'Mauro Eduardo Hilgemberg', '2013-05-22 16:05:08', 1, 'rua Odino Moro', 'EM frente ao Espazio verde', 's/n   ', 1, '(42) 9146-0033  ', '(42) 3223-9414  ', '         ', '', 'eduhilgemberg@hotmail.com', 'm', '1984-02-07', NULL, 'married');
INSERT INTO person VALUES (63, 'Alecsandro Ponciano da Rocha', '2013-07-02 16:07:38', 1, 'Rua Herculano de Freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1978-12-13', 4, 'single');
INSERT INTO person VALUES (64, 'Eduardo Eloy', '2013-07-02 16:07:41', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1986-06-02', 4, 'single');
INSERT INTO person VALUES (65, 'Everaldo Vinicius da Silva', '2013-07-02 16:07:22', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1973-07-28', 4, 'single');
INSERT INTO person VALUES (66, 'Jeferson Luiz Dummer', '2013-07-02 16:07:59', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1977-03-05', 4, 'separated');
INSERT INTO person VALUES (67, 'Israel Caldas Fortunato', '2013-07-02 16:07:30', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1972-07-05', 4, 'single');
INSERT INTO person VALUES (68, 'Valdomiro de Oliveira', '2013-07-02 16:07:31', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1960-09-20', 4, 'single');
INSERT INTO person VALUES (69, 'Marcos de Moraes', '2013-07-02 16:07:36', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1981-07-30', 4, 'separated');
INSERT INTO person VALUES (70, 'Delton Luiz Maciel', '2013-07-02 16:07:38', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1982-09-03', 4, 'single');
INSERT INTO person VALUES (71, 'Jorge Luiz Madureira', '2013-07-02 16:07:49', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1969-07-04', 4, 'single');
INSERT INTO person VALUES (73, 'Rodrigo Ramos de Lara', '2013-07-02 16:07:31', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1987-11-24', 4, 'single');
INSERT INTO person VALUES (74, 'Cliceu Faria', '2013-07-02 16:07:24', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1981-03-08', 4, 'single');
INSERT INTO person VALUES (75, 'Daniel Pereira', '2013-07-02 16:07:41', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1983-01-14', 4, 'single');
INSERT INTO person VALUES (76, 'Rodrigo José Martins', '2013-07-02 16:07:26', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1985-01-15', 4, 'single');
INSERT INTO person VALUES (77, 'Luiz Fernando Coimbra Alves', '2013-07-02 16:07:24', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1974-11-17', 4, 'single');
INSERT INTO person VALUES (78, 'Orlando Maia Steudel', '2013-07-02 17:07:29', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1968-02-15', 4, 'single');
INSERT INTO person VALUES (79, 'Robson Luiz Almeida Penteado', '2013-07-02 17:07:20', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1989-01-04', 4, 'single');
INSERT INTO person VALUES (80, 'Roberto Carlos Dias', '2013-07-02 17:07:58', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1970-03-29', 4, 'single');
INSERT INTO person VALUES (81, 'Jailson Elvis da Silva', '2013-07-02 17:07:15', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1983-07-29', 4, 'separated');
INSERT INTO person VALUES (82, 'Valdinei Xavier da Silva', '2013-07-02 17:07:59', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1962-10-09', 4, 'single');
INSERT INTO person VALUES (83, 'Adilson de Freitas Miranda', '2013-07-02 17:07:21', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1967-07-29', 4, 'separated');
INSERT INTO person VALUES (84, 'Bruno Elisandro dos Santos', '2013-07-02 17:07:05', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1992-07-03', 4, 'single');
INSERT INTO person VALUES (85, 'João Pedro Ricetti', '2013-07-02 17:07:53', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1993-06-17', 4, 'single');
INSERT INTO person VALUES (86, 'Luiz Vanderlei Fernandes Belon', '2013-07-02 17:07:46', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1973-04-02', 4, 'single');
INSERT INTO person VALUES (87, 'Marcos Aurélio Oliveira dos Santos', '2013-07-02 17:07:42', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1994-09-15', 4, 'single');
INSERT INTO person VALUES (88, 'Mauro Sergio Fernandes', '2013-07-02 17:07:24', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1971-03-08', 4, 'single');
INSERT INTO person VALUES (89, 'Leandro Leite', '2013-07-02 17:07:49', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1989-05-06', 4, 'single');
INSERT INTO person VALUES (90, 'Cleverton Andreata', '2013-07-02 17:07:52', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1981-02-08', 4, 'single');
INSERT INTO person VALUES (91, 'Juarez Martins Fedex', '2013-07-02 17:07:52', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1956-01-30', 4, 'separated');
INSERT INTO person VALUES (92, 'Jorge Lopes de Paula', '2013-07-02 17:07:32', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1981-08-12', 4, 'single');
INSERT INTO person VALUES (93, 'Franciel Rodrigues Dias', '2013-07-02 17:07:58', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1993-01-08', 4, 'single');
INSERT INTO person VALUES (94, 'Edilson da Rocha', '2013-07-02 17:07:20', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1966-12-27', 4, 'single');
INSERT INTO person VALUES (72, 'Tiago Rodrigo Treder dos Santos', '2013-07-02 16:07:42', 1, 'rua herculano de freitas', '', '751   ', 1, '                ', '4232239414      ', '84015-105', '', '', 'm', '1983-05-25', 4, 'married');
INSERT INTO person VALUES (95, 'Elinton Opata', '2013-07-18 09:07:51', 1, 'Rua Marcelino Nogueira', '', '59    ', 1, '99908216        ', '                ', '         ', '', '', 'm', '1986-10-06', NULL, 'single');
INSERT INTO person VALUES (96, 'Mayson Mattos de Oliveira', '2013-07-18 09:07:44', 1, 'Rua Herculano de Freitas', '', '751   ', 1, '                ', '4232239414      ', '84015105 ', '', '', 'm', '1993-07-16', 4, 'single');
INSERT INTO person VALUES (19, 'Adela Garcia Lopez', '2013-05-15 17:05:57', 1, '', '', '      ', 1, '                ', '                ', '         ', '', 'princesa_9300@hotmail.com', 'f', '2013-01-20', NULL, 'married');
INSERT INTO person VALUES (98, 'Rober Andersom Severino', '2013-08-20 14:08:13', 1, 'Citrino', '', '77    ', 1, '                ', '                ', '         ', '', '', 'm', '1977-12-13', 11, 'single');
INSERT INTO person VALUES (99, 'Juliano da Siva', '2013-08-20 15:08:23', 1, 'Ebano Ferreira', '', '57    ', 6, '                ', '                ', '         ', '', '', 'm', '1978-11-09', NULL, 'single');
INSERT INTO person VALUES (100, 'Hamilkar Jose Gasparello', '2013-08-20 15:08:47', 1, 'Joao Marcelino Madaloso', '', '183   ', 1, '99883742        ', '32258162        ', '         ', '', '', 'm', '2013-01-20', 12, 'separated');
INSERT INTO person VALUES (101, 'Luiz Fernando Coinbra Alves', '2013-08-20 15:08:29', 1, 'Herculano de Freitas', '', '751   ', 1, '99735704        ', '                ', '8415105  ', '', '', 'm', '1974-11-17', 4, 'single');
INSERT INTO person VALUES (102, 'Luciano das Graças Silva', '2013-08-20 15:08:07', 1, 'Helculano de Freitas', '', '751   ', 1, '                ', '32239414        ', '         ', '', '', 'm', '1980-04-20', 4, 'single');
INSERT INTO person VALUES (103, 'Lucas da Silva Nascimento', '2013-08-20 15:08:55', 1, 'Herculano de Freitas', '', '751   ', 1, '                ', '32239414        ', '         ', '', '', 'm', '1992-06-06', 4, 'single');
INSERT INTO person VALUES (104, 'Juarez Martins Fedex', '2013-08-20 15:08:18', 1, 'Hereculano de Freitas', '', '751   ', 1, '98099045        ', '                ', '84015105 ', '', '', 'm', '1956-01-31', 4, 'separated');
INSERT INTO person VALUES (105, 'Jorge Lopes de Paula', '2013-08-20 16:08:02', 1, 'Herculano de Freitaas', '', '751   ', 1, '                ', '32239414        ', '         ', '', '', 'm', '1981-08-12', 7, 'single');
INSERT INTO person VALUES (106, 'Joao Antonio Ramos', '2013-08-20 16:08:39', 1, 'Herculano  Freitas', '', '751   ', 5, '                ', '3223 9414       ', '84015105 ', '', '', 'm', '1951-04-22', 15, 'widow(er)');
INSERT INTO person VALUES (107, 'Franciel Rodrigues Silva', '2013-08-20 16:08:01', 1, 'Herculano De Freitas', '', '751   ', 1, '                ', '32239414        ', '         ', '', '', 'm', '1993-01-08', 4, 'single');
INSERT INTO person VALUES (108, 'Cleversom Silva Moura', '2013-08-20 16:08:02', 1, 'Herculano de Freitas', '', '751   ', 7, '                ', '32239414        ', '         ', '', '', 'm', '1992-04-23', 1, 'single');
INSERT INTO person VALUES (109, 'Andre Domingues Pinhove', '2013-08-20 16:08:06', 1, 'Herculano de Freitas', '', '751   ', 8, '(14)98382601    ', '(14)32030989    ', '8405105  ', '', '', 'm', '1974-10-23', NULL, 'separated');
INSERT INTO person VALUES (116, 'Albari Ferreira de Andrade', '2013-08-21 09:08:00', 1, 'Herculano de Freitas', '', '751   ', 1, '                ', '32239414        ', '8405105  ', '', '', 'm', '1961-12-01', 4, 'separated');
INSERT INTO person VALUES (117, 'Miguel  Angelo da Silva', '2013-08-21 09:08:28', 1, '15 DE Novenbro', '', '1062  ', 1, '(42)99090584    ', '                ', '         ', '', '', 'm', '1969-01-06', 1, 'single');
INSERT INTO person VALUES (56, 'Marcelo Lima dos Santos', '2013-06-19 11:06:28', 1, 'Rua Herculano de Freitas', '', '751   ', 1, '98056308        ', '42 32239414     ', '84015105 ', '', 'marcelotheryla@gmail.com', 'm', '1989-11-13', 4, 'stable union');
INSERT INTO person VALUES (121, 'Tiago Abreu Silva', '2013-08-21 10:08:42', 1, 'Isaque', '', '0     ', 1, '                ', '32239414        ', '         ', '', '', 'm', '1985-12-06', 17, 'separated');
INSERT INTO person VALUES (122, 'Valderly Costa Ferreira', '2013-08-21 10:08:56', 1, 'Herculano Freitas', '', '751   ', 1, '                ', '32239414        ', '84015105 ', '', '', 'm', '1989-12-22', 4, 'separated');
INSERT INTO person VALUES (123, 'Weslley Weldisom da Silva da Rossa', '2013-08-21 10:08:36', 1, 'Herculano de Freitas', '', '751   ', 1, '                ', '32239414        ', '84015105 ', '', '', 'm', '2002-02-05', 4, 'single');
INSERT INTO person VALUES (124, 'Vitoria da SIlva Rosa', '2013-08-21 10:08:28', 1, 'Herculano de Freitas', '', '751   ', 1, '                ', '32239414        ', '8405105  ', '', '', 'f', '2007-03-09', 4, 'single');
INSERT INTO person VALUES (126, 'Vinicius da Silva da Rosa', '2013-08-21 10:08:51', 1, 'Heculano de Freitas', '', '751   ', 1, '                ', '32239414        ', '84015105 ', '', '', 'm', '2005-12-05', 4, 'single');
INSERT INTO person VALUES (130, 'Luiz Guilerme Sanpaio Lopes', '2013-08-21 10:08:21', 1, 'Herculano de Freitas', '', '751   ', 1, '                ', '32239414        ', '84015105 ', '', '', 'm', '2010-11-08', 4, 'single');
INSERT INTO person VALUES (131, 'Samoel Borges', '2013-08-21 10:08:31', 1, 'Herculano de Freitas', '', '751   ', 1, '                ', '32239414        ', '84015105 ', '', '', 'm', '2003-11-12', 4, 'single');
INSERT INTO person VALUES (133, 'Karina Cardine .R. Fiorin', '2013-08-21 11:08:34', 1, 'Herculano de Freitas', '', '751   ', 1, '(14)33731497    ', '(14)97637650    ', '84015105 ', '', '', 'f', '2013-01-21', 4, 'married');
INSERT INTO person VALUES (134, 'Alam Jair Correia da Luz', '2013-08-21 11:08:09', 1, 'Antonio Saad', '', '61    ', 1, '(42)88208414    ', '(42)32382855    ', '         ', '', '', 'm', '1990-05-12', 7, 'single');
INSERT INTO person VALUES (135, 'Antonio  Demeter Tianakef', '2013-08-21 11:08:56', 1, 'pepeita', '', '      ', 10, '                ', '                ', '         ', '', '', 'm', '1968-04-05', 3, 'single');
INSERT INTO person VALUES (136, 'Andersom Luiz Dutka', '2013-08-21 11:08:24', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1978-01-19', 1, 'single');
INSERT INTO person VALUES (137, 'Acir da Silva Soares', '2013-08-21 11:08:41', 1, 'rua 13(luiz pereira barreto)', '', '213   ', 1, '                ', '                ', '         ', '', '', 'm', '1994-12-20', 7, 'single');
INSERT INTO person VALUES (138, 'Adriano Rocha de Oliveira', '2013-08-21 13:08:18', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1989-11-12', 1, 'single');
INSERT INTO person VALUES (139, 'Orimarcos do Nascimento', '2013-08-21 13:08:00', 1, 'Nova Londrina', '', '361   ', 1, '(42)99406034    ', '(42)99945423    ', '         ', '', '', 'm', '1976-11-06', NULL, 'single');
INSERT INTO person VALUES (140, 'Ademar Eichellbaum', '2013-08-21 13:08:04', 1, 'Domingos Ferreira Pinto', '', '386   ', 5, '                ', '                ', '         ', '', '', 'm', '1969-05-17', 7, 'married');
INSERT INTO person VALUES (143, 'Alexandre Godoi', '2013-08-21 14:08:11', 1, 'gnl Barros Falcao', '', '500   ', 1, '                ', '                ', '         ', '', '', 'm', '1983-10-10', 7, 'single');
INSERT INTO person VALUES (147, 'Alexandre  dos Santos Galvao', '2013-08-21 15:08:23', 1, 'Julio Castanho', '', '78    ', 1, '                ', '                ', '         ', '', '', 'm', '1989-06-26', 7, 'single');
INSERT INTO person VALUES (128, 'Karen Naomi de Moraes', '2013-08-21 10:08:05', 1, 'Heculano de Freitas', '', '751   ', 1, '                ', '32239414        ', '84015105 ', '', '', 'f', '2001-08-22', 4, 'single');
INSERT INTO person VALUES (127, 'Kevelin de Fatima Borges dos Santos', '2013-08-21 10:08:14', 1, 'Herculano de Freitas', '', '751   ', 1, '                ', '32239414        ', '         ', '', '', 'f', '2000-03-30', 4, 'single');
INSERT INTO person VALUES (125, 'Stefany Anelize Silva da Rosa', '2013-08-21 10:08:29', 1, 'Herculano de Freitas', '', '751   ', 1, '                ', '32239414        ', '8405105  ', '', '', 'f', '1998-02-06', 4, 'single');
INSERT INTO person VALUES (118, 'Tharcilo Sergio Kirchener Correia', '2013-08-21 09:08:29', 1, 'Heculano de Freitas', '', '751   ', 1, '                ', '32239414        ', '84015105 ', '', '', 'm', '1976-12-05', 4, 'single');
INSERT INTO person VALUES (132, 'Wesley Gabriel Sanpaio Gomes', '2013-08-21 11:08:29', 1, 'Herculano de Freitas', '', '751   ', 1, '                ', '32239414        ', '84015105 ', '', '', 'm', '2008-01-29', 4, 'single');
INSERT INTO person VALUES (144, 'Alfredo Borck', '2013-08-21 15:08:53', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1978-01-16', 5, 'single');
INSERT INTO person VALUES (129, 'Maria Eduarda Sampaio Lopes', '2013-08-21 10:08:47', 1, 'Heculano de Freitas', '', '751   ', 1, '                ', '32239414        ', '8405105  ', '', '', 'f', '2009-04-16', 4, 'single');
INSERT INTO person VALUES (141, 'Alaf Nazario', '2013-08-21 13:08:55', 1, 'republica do peru', '', 's/n   ', 1, '(42)99091387    ', '(42)91068217    ', '         ', '', '', 'm', '1993-07-08', 1, 'single');
INSERT INTO person VALUES (115, 'Andersom Schneider', '2013-08-21 08:08:46', 1, 'Herculano de Freitas', '', '751   ', 1, '(41)88015682    ', '32239414        ', '84015105 ', '', '', 'm', '1981-06-26', 4, 'separated');
INSERT INTO person VALUES (148, 'Alencar Jose da Silva', '2013-08-21 15:08:13', 1, 'jaguapita', '', '71    ', 5, '                ', '                ', '         ', '', '', 'm', '1991-02-17', NULL, 'single');
INSERT INTO person VALUES (149, 'Andersom Rogerio de Oliveira', '2013-08-21 15:08:49', 1, 'augusto severino', '', '1870  ', 5, '                ', '                ', '         ', '', '', 'm', '1970-10-05', NULL, 'single');
INSERT INTO person VALUES (150, 'Adolfo Geve Junior', '2013-08-21 15:08:51', 1, 'Jaguapita', '', '41    ', 1, '                ', '                ', '         ', '', '', 'm', '1981-07-11', 7, 'single');
INSERT INTO person VALUES (151, 'Adolfo Geve Junior', '2013-08-21 15:08:10', 1, 'jaguapita', '', '41    ', 1, '                ', '                ', '         ', '', '', 'm', '1981-07-11', 7, 'single');
INSERT INTO person VALUES (152, 'Alex  Sandro Ribeiro dos Santos', '2013-08-21 15:08:36', 1, 'vicente machado', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1981-09-09', 1, 'single');
INSERT INTO person VALUES (153, 'Andersom Tizom dos Santos', '2013-08-21 15:08:56', 1, 'Sao Jose fat', '', '1524  ', 1, '                ', '                ', '         ', '', '', 'm', '1986-02-21', 9, 'single');
INSERT INTO person VALUES (154, 'Albam Santos de Souza', '2013-08-21 16:08:24', 1, 'operarios', '', '1267  ', 1, '                ', '(42)99652919    ', '         ', '', '', 'm', '1992-04-24', 9, 'single');
INSERT INTO person VALUES (155, 'Antonio de Oliveira', '2013-08-21 16:08:06', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1942-09-10', NULL, 'single');
INSERT INTO person VALUES (156, 'Odair Fernandes Machado', '2013-08-21 16:08:36', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1991-03-03', 7, 'single');
INSERT INTO person VALUES (157, 'Alisom de Freitas Miranda', '2013-08-21 16:08:04', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1967-07-29', 1, 'single');
INSERT INTO person VALUES (159, 'andersom Monteiro Bernardo', '2013-08-21 16:08:04', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1988-10-28', 1, 'single');
INSERT INTO person VALUES (161, 'Andersom Mehret', '2013-08-22 08:08:03', 1, 'modarta', '', '3     ', 5, '                ', '                ', '         ', '', '', 'm', '1984-08-25', 11, 'single');
INSERT INTO person VALUES (162, 'Alam Tomas de Souza dos Anjos', '2013-08-22 08:08:33', 1, 'Cesar Alves', '', '198   ', 1, '                ', '                ', '         ', '', '', 'm', '1997-09-06', 9, '');
INSERT INTO person VALUES (163, 'Andre Hardt da Rocha', '2013-08-22 08:08:11', 1, 'primula', '', '90    ', 1, '                ', '(42)32161656    ', '         ', '', '', 'm', '1974-06-08', 7, 'single');
INSERT INTO person VALUES (164, 'Adinilsom Borges de Oliveira', '2013-08-22 09:08:41', 1, 'Lidia Scheidt Curi', '', '16    ', 1, '(42)99085934    ', '(42)            ', '         ', '', '', 'm', '1979-08-07', 7, 'single');
INSERT INTO person VALUES (165, 'Alisom Santos Rodrigues', '2013-08-22 09:08:31', 1, 'Garoupa', '', '601   ', 1, '                ', '                ', '         ', '', '', 'm', '1993-07-18', 9, 'single');
INSERT INTO person VALUES (166, 'Andersom Aparecido Assunçao', '2013-08-22 09:08:42', 1, '', '', '      ', 12, '                ', '                ', '         ', '', '', 'm', '1985-05-24', NULL, '');
INSERT INTO person VALUES (167, 'Alexandro Porciano da Rocha', '2013-08-22 09:08:20', 1, 'Gralha Azul', '', '124   ', 1, '(42)98815273    ', '(42)99368358    ', '         ', '', '', 'm', '1978-12-03', 9, 'married');
INSERT INTO person VALUES (168, 'Antonio Andrade dos Santos', '2013-08-22 09:08:46', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1971-01-26', NULL, 'single');
INSERT INTO person VALUES (169, 'Ademir Luiz  Gorchoski', '2013-08-22 09:08:24', 1, 'Haiti', 'Haiti', '123   ', 1, '                ', '                ', '         ', '', '', 'm', '1972-10-13', NULL, '');
INSERT INTO person VALUES (170, 'Artur Adriano de Freitas Miranda', '2013-08-22 09:08:51', 1, 'Frei Leandro de Sacramento', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1974-11-09', 7, 'married');
INSERT INTO person VALUES (171, 'Alexandre Lopes', '2013-08-22 09:08:28', 1, 'Bahia', '', '245   ', 1, '                ', '(43)84082875    ', '         ', '', '', 'm', '1986-12-26', 1, 'single');
INSERT INTO person VALUES (173, 'Antonio do Rocio Santos', '2013-08-22 10:08:56', 1, '', '', '      ', 11, '(14)81098212    ', '(14)96015820    ', '         ', '', '', 'm', '1963-09-29', NULL, 'married');
INSERT INTO person VALUES (174, 'Angelo Michel  Pereira', '2013-08-22 10:08:46', 1, 'Dario Velozo', '', '78    ', 1, '                ', '                ', '         ', '', '', 'm', '1986-11-26', NULL, '');
INSERT INTO person VALUES (175, 'Alisom Carvalho Pereira de Almeida', '2013-08-22 10:08:38', 1, 'Alfredo Santana', '', '2     ', 1, '                ', '                ', '         ', '', '', 'm', '2009-03-15', 4, 'single');
INSERT INTO person VALUES (176, 'Alexandro Gonsalves', '2013-08-22 10:08:42', 1, 'garoupa', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-22', 7, 'single');
INSERT INTO person VALUES (177, 'Bruno Elizandro dos Santos', '2013-08-22 10:08:37', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1992-07-03', NULL, 'single');
INSERT INTO person VALUES (178, 'Benedetito Carlos Munhoz', '2013-08-22 10:08:54', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1948-11-04', NULL, 'married');
INSERT INTO person VALUES (179, 'Bruno Jakinzo Tomas', '2013-08-22 10:08:43', 1, 'espedicionario', '', '224   ', 1, '                ', '                ', '         ', '', '', 'm', '1994-03-21', 1, 'single');
INSERT INTO person VALUES (180, 'Bruno Leal do Valle', '2013-08-22 10:08:38', 1, 'lopes nogueira', '', '31    ', 1, '                ', '                ', '         ', '', '', 'm', '1992-09-04', NULL, 'single');
INSERT INTO person VALUES (181, 'Antonio Nascimento', '2013-08-22 10:08:50', 1, 'rua 4', '', '267   ', 1, '(42)91477218    ', '                ', '         ', '', '', 'm', '1948-04-02', 11, 'widow(er)');
INSERT INTO person VALUES (182, 'Airtom Borges', '2013-08-22 10:08:35', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1977-01-05', NULL, 'married');
INSERT INTO person VALUES (183, 'Aline Matiozi Macudo', '2013-08-22 10:08:16', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'f', '2013-01-22', NULL, 'married');
INSERT INTO person VALUES (184, 'Antonio de Oliveira', '2013-08-22 10:08:39', 1, 'Fernando Sacrammento', '', '      ', 5, '                ', '                ', '         ', '', '', 'm', '1942-09-10', 20, 'married');
INSERT INTO person VALUES (185, 'Andersom Junior Marques da Rosa', '2013-08-22 10:08:39', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1974-04-03', NULL, 'widow(er)');
INSERT INTO person VALUES (186, 'Alex Sandro Alabi Ulaile', '2013-08-22 10:08:23', 1, 'Nicolau Clupel Neto', '', '955   ', 1, '                ', '                ', '         ', '', '', 'm', '1987-06-02', 21, 'single');
INSERT INTO person VALUES (187, 'Amauri de Almeida Leal', '2013-08-22 10:08:22', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1970-11-06', NULL, 'single');
INSERT INTO person VALUES (189, 'Andre Luiz Rodriguez', '2013-08-22 11:08:06', 1, 'CORONEL Vivido', '', '712   ', 1, '(42)98039565    ', '                ', '84036310 ', '', '', 'm', '1986-07-21', 3, 'single');
INSERT INTO person VALUES (190, 'Antonio Santos Costa', '2013-08-22 11:08:34', 1, 'Monte Alvene', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-22', 12, 'single');
INSERT INTO person VALUES (195, 'Alceu Rodrigues', '2013-08-22 11:08:37', 1, '', '', '      ', 1, '                ', '(42)36240238    ', '         ', '', '', 'm', '1986-08-25', NULL, 'single');
INSERT INTO person VALUES (196, 'Antonio Donizete da Silva', '2013-08-22 11:08:49', 1, 'Santo Mauro', '', '329   ', 1, '                ', '                ', '         ', '', '', 'm', '1956-11-12', NULL, 'single');
INSERT INTO person VALUES (197, 'Alessandro Marques Cordeiro', '2013-08-22 11:08:42', 1, 'Alvaro Albim', '', '664   ', 1, '                ', '                ', '         ', '', '', 'm', '1988-08-23', 4, 'single');
INSERT INTO person VALUES (198, 'Adriano da Silva', '2013-08-22 11:08:23', 1, 'Puciliano Negrao', '', '      ', 1, '(42)98070844    ', '                ', '         ', '', '', 'm', '1989-12-22', 21, 'single');
INSERT INTO person VALUES (199, 'Andri Henrique P Bueno', '2013-08-22 13:08:13', 1, 'Jose Pereira Silveira', '', '632   ', 1, '                ', '                ', '         ', '', '', 'm', '1995-01-06', 1, 'single');
INSERT INTO person VALUES (160, 'Aldair Pereira Batista', '2013-08-21 16:08:08', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1983-07-09', NULL, 'single');
INSERT INTO person VALUES (172, 'Adriano josé Lara', '2013-08-22 09:08:16', 1, 'Guartemala', '', '445   ', 1, '                ', '                ', '         ', '', '', 'm', '1986-03-29', 9, 'single');
INSERT INTO person VALUES (158, 'Adilson Carlos Banisky', '2013-08-21 16:08:31', 1, 'CONDOR', '', '96    ', 1, '(42)91141102    ', '(42)32298117    ', '         ', '', '', 'm', '1981-10-24', 1, 'single');
INSERT INTO person VALUES (201, 'Antonio Amiltom do Nascimento', '2013-08-22 14:08:06', 1, '', '', '      ', 1, '(42)99830528    ', '                ', '         ', '', '', 'm', '1953-01-21', 7, 'single');
INSERT INTO person VALUES (202, 'Alissom da silva', '2013-08-22 14:08:37', 1, 'Jaguapita', '', '541   ', 6, '                ', '                ', '         ', '', '', 'm', '1978-08-15', 7, 'single');
INSERT INTO person VALUES (203, 'Alisom de Oliveira', '2013-08-22 14:08:21', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1989-11-19', 1, 'single');
INSERT INTO person VALUES (204, 'Almir Pinheiro Machado', '2013-08-22 15:08:08', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1983-04-14', NULL, 'single');
INSERT INTO person VALUES (205, 'Adir Tizom', '2013-08-22 15:08:21', 1, 'Sao Jose Fate', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '1969-05-18', 9, 'single');
INSERT INTO person VALUES (206, 'Alisom Jose Veiga', '2013-08-22 15:08:08', 1, 'Espedicionario Miltom', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1999-02-12', NULL, 'single');
INSERT INTO person VALUES (207, 'Antonio Josnei dos Santos', '2013-08-22 15:08:43', 1, 'Sentenario do sul', '', '726   ', 1, '                ', '                ', '         ', '', '', 'm', '1968-06-12', 7, 'single');
INSERT INTO person VALUES (210, 'Alexadre Meira', '2013-08-22 15:08:31', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1982-08-02', NULL, '');
INSERT INTO person VALUES (211, 'Allam Dionei Marques', '2013-08-22 15:08:52', 1, 'Jaime A dos Santos', '', '      ', 5, '                ', '(42)32244938    ', '         ', '', '', 'm', '1981-10-28', 7, 'single');
INSERT INTO person VALUES (212, 'Amauri de Almeida Leal', '2013-08-22 16:08:57', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1970-11-06', NULL, 'single');
INSERT INTO person VALUES (213, 'Adolfo Gehr', '2013-08-22 16:08:13', 1, 'RUA 3', '', '62    ', 1, '                ', '                ', '         ', '', '', 'm', '1981-07-11', NULL, 'single');
INSERT INTO person VALUES (214, 'Adilsom da Silva Pinheiro', '2013-08-22 16:08:52', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-22', NULL, '');
INSERT INTO person VALUES (215, 'Antonio Andrade dos Santos', '2013-08-22 16:08:46', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1961-01-26', NULL, '');
INSERT INTO person VALUES (216, 'Antonio Antunes de Paula', '2013-08-22 16:08:54', 1, 'Izaias de Luz', '', '27    ', 1, '                ', '                ', '         ', '', '', 'm', '1952-02-14', NULL, 'married');
INSERT INTO person VALUES (217, 'Antonio de Teixeira d Paula', '2013-08-22 16:08:04', 1, 'Joao Ditzel', '', '396   ', 1, '                ', '                ', '         ', '', '', 'm', '1974-01-01', NULL, 'married');
INSERT INTO person VALUES (219, 'Adriano Ribas', '2013-08-23 08:08:06', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1981-11-03', NULL, 'single');
INSERT INTO person VALUES (220, 'rli Francisco de Lara', '2013-08-23 09:08:50', 1, 'saboudia', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1967-02-21', 7, 'single');
INSERT INTO person VALUES (222, 'Altair de Oliveira', '2013-08-23 09:08:03', 1, 'Nelsom Narciso Centenario', '', '12    ', 1, '                ', '                ', '         ', '', '', 'm', '1953-08-27', 5, 'married');
INSERT INTO person VALUES (223, 'Agnaldo de Sousa', '2013-08-23 09:08:43', 1, 'Julio Perneta', '', '299   ', 1, '                ', '                ', '         ', '', '', 'm', '1969-07-25', 12, 'single');
INSERT INTO person VALUES (224, 'Adalberto Machado Siqueira', '2013-08-23 09:08:48', 1, 'Dralicio Correia', '', '316   ', 1, '                ', '                ', '         ', '', '', 'm', '1968-06-28', 5, 'single');
INSERT INTO person VALUES (225, 'Andersom Maira da Silva', '2013-08-23 09:08:56', 1, 'joao', '', '113   ', 1, '                ', '                ', '         ', '', '', 'm', '1976-06-04', 7, 'single');
INSERT INTO person VALUES (226, 'Alex dos Santos', '2013-08-23 09:08:08', 1, 'agnaldo Guimarens da Cunha', 'Prox ao ginasio de esportes', '199   ', 5, '                ', '                ', '         ', '', '', 'm', '1985-11-23', 7, 'single');
INSERT INTO person VALUES (227, 'Luiz Ricardo de Arruda', '2013-08-23 10:08:07', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1992-12-31', NULL, 'single');
INSERT INTO person VALUES (228, 'Luciano Algusto da Silva', '2013-08-23 10:08:40', 1, 'woshingtom luiz', '', '24    ', 1, '                ', '(42)32266534    ', '         ', '', '', 'm', '1975-09-24', 23, 'single');
INSERT INTO person VALUES (229, 'Luizimar Costa da Silva', '2013-08-23 10:08:25', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1980-06-18', NULL, 'single');
INSERT INTO person VALUES (230, 'Lucas R Krik', '2013-08-23 10:08:03', 1, 'Orlindo Miranda', '', '74    ', 1, '(42)99776595    ', '                ', '         ', '', '', 'm', '1985-03-14', NULL, 'single');
INSERT INTO person VALUES (231, 'Luiz Fernando Novak', '2013-08-23 10:08:45', 1, 'Alfredo Pedro Ribas', '', '11    ', 1, '                ', '                ', '         ', '', '', 'm', '1961-09-26', 9, 'single');
INSERT INTO person VALUES (232, 'Luciano Abrreu Soares', '2013-08-23 10:08:38', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1979-10-28', NULL, 'single');
INSERT INTO person VALUES (233, 'Leandro de Souza Zanbom', '2013-08-23 10:08:48', 1, 'Rosmar Denis Escobnar', '', '756   ', 1, '                ', '                ', '         ', '', '', 'm', '1992-07-30', 22, 'single');
INSERT INTO person VALUES (234, 'Luciano de Jesus Camargo', '2013-08-23 10:08:51', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1975-04-22', NULL, 'single');
INSERT INTO person VALUES (235, 'Maysom Matoso de Oliveira', '2013-08-23 10:08:15', 1, 'Habilio Hosmam', '', '2270  ', 1, '                ', '                ', '         ', '', '', 'm', '1993-07-16', 11, 'single');
INSERT INTO person VALUES (236, 'Leandro José Justino', '2013-08-23 11:08:39', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-07-31', NULL, 'single');
INSERT INTO person VALUES (237, 'Luciano de Jesus Gonçalves', '2013-08-23 11:08:45', 1, 'Anita Garibaldi', 'Apfrrox ponte de pedra', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1982-03-06', NULL, 'single');
INSERT INTO person VALUES (238, 'Luam Patrik de Almeida', '2013-08-23 11:08:25', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1993-07-29', NULL, 'single');
INSERT INTO person VALUES (239, 'Luiz Ednilsom Padilha', '2013-08-23 11:08:13', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1974-09-27', NULL, 'married');
INSERT INTO person VALUES (240, 'Luiz Teofilo Alvez', '2013-08-23 11:08:32', 1, '', '', '      ', 1, '(42)  99195008  ', '                ', '         ', '', '', 'm', '1973-11-17', NULL, 'single');
INSERT INTO person VALUES (241, 'Luiz Vanderlei Fernandes Belon', '2013-08-23 13:08:44', 1, 'Quadra 1 lote 19', 'Prox ao mercado Estrela', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '19973-04-02', 1, 'single');
INSERT INTO person VALUES (242, 'Luiz Carlos Cordeiro', '2013-08-23 13:08:28', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1976-04-30', NULL, 'married');
INSERT INTO person VALUES (243, 'Luiz Teofilo Alves', '2013-08-23 13:08:50', 1, 'Mateus Soudam', '', '56    ', 1, '(42)91562267    ', '(42)32268934    ', '         ', '', '', 'm', '1973-11-17', NULL, 'separated');
INSERT INTO person VALUES (244, 'Leandro Leite', '2013-08-23 13:08:43', 1, '', '', '      ', 14, '                ', '                ', '         ', '', '', 'm', '1989-05-06', NULL, 'single');
INSERT INTO person VALUES (247, 'Luiz Carlos Rosa dos Santos', '2013-08-23 13:08:02', 1, '', '', '      ', 1, '(13)87582351    ', '                ', '         ', '', '', 'm', '1980-06-05', NULL, 'single');
INSERT INTO person VALUES (248, 'Luiz Edgar Carvalho', '2013-08-23 14:08:31', 1, 'Beijamim Franklim', '', '727   ', 1, '                ', '                ', '         ', '', '', 'm', '1971-05-05', 9, 'single');
INSERT INTO person VALUES (249, 'Marcos Antonio Martins', '2013-08-23 14:08:59', 1, 'Renato Menarim', '', '275   ', 1, '                ', '                ', '         ', '', '', 'm', '1961-06-08', 9, 'married');
INSERT INTO person VALUES (250, 'Miltom de Oliveira', '2013-08-23 14:08:42', 1, 'DR Rubens Gomes de Souza', '', '61    ', 1, '                ', '                ', '         ', '', '', 'm', '1957-02-01', 14, 'separated');
INSERT INTO person VALUES (251, 'Manoel Antonio dos Santos', '2013-08-23 14:08:30', 1, 'Vidal de negreiros', '', '174   ', 1, '                ', '                ', '         ', '', '', 'm', '1964-12-08', 9, 'single');
INSERT INTO person VALUES (209, 'Adilson Martins', '2013-08-22 15:08:22', 1, 'Alberto Campos', '', '575   ', 1, '                ', '                ', '         ', '', '', 'm', '1980-12-22', 13, 'single');
INSERT INTO person VALUES (221, 'Adilson  da  Rocha', '2013-08-23 09:08:25', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1966-12-27', NULL, 'single');
INSERT INTO person VALUES (252, 'Luiz Fabiano Oliveira dos Santos', '2013-08-23 15:08:54', 1, 'Beta', '', '277   ', 1, '                ', '                ', '         ', '', '', 'm', '1989-10-27', NULL, 'single');
INSERT INTO person VALUES (253, 'Luiz Carlos Pires', '2013-08-23 15:08:04', 1, 'rua dos pardais', '', '23    ', 1, '                ', '                ', '         ', '', '', 'm', '1962-11-15', NULL, 'single');
INSERT INTO person VALUES (254, 'Luiz Tiago Ferreira', '2013-08-23 15:08:57', 1, 'Serra do mar', '', 's/n   ', 5, '                ', '                ', '         ', '', '', 'm', '1987-12-14', NULL, 'single');
INSERT INTO person VALUES (255, 'Lourenço Alves', '2013-08-23 15:08:59', 1, 'General Rondom', '', '750   ', 1, '                ', '                ', '         ', '', '', 'm', '1987-03-25', 22, 'separated');
INSERT INTO person VALUES (256, 'Luiz Carlos de Oliveira', '2013-08-23 15:08:57', 1, 'amortila', '', '131   ', 1, '                ', '                ', '         ', '', '', 'm', '1965-08-06', NULL, 'single');
INSERT INTO person VALUES (257, 'Luiz Rodrigo Carneiro', '2013-08-23 15:08:19', 1, 'Ecilio Arnaldino', '', '632   ', 1, '                ', '                ', '         ', '', '', 'm', '1989-12-20', 17, 'single');
INSERT INTO person VALUES (258, 'Luiz Ednilsom Padilha', '2013-08-23 15:08:32', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1984-09-27', NULL, 'single');
INSERT INTO person VALUES (261, 'Luiz de Souza Junior', '2013-08-23 15:08:03', 1, '7 de Setenbro', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1967-10-23', 1, 'single');
INSERT INTO person VALUES (262, 'Luiz  Fernando Pires Cordeiro', '2013-08-23 15:08:05', 1, 'Ico  Risental', '', '325   ', 1, '                ', '                ', '         ', '', '', 'm', '1983-01-03', 1, 'single');
INSERT INTO person VALUES (263, 'Paulo Ricardo Sousa Araujo', '2013-08-23 15:08:07', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1991-03-11', NULL, 'single');
INSERT INTO person VALUES (264, 'Luiz Gustavo J Pereira', '2013-08-23 15:08:22', 1, 'Paulo  de nadal', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2009-05-23', NULL, '');
INSERT INTO person VALUES (265, 'Jjoao Ferreia Lemes', '2013-08-26 09:08:30', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1956-02-28', NULL, 'single');
INSERT INTO person VALUES (267, 'Joao Alcis Pricval', '2013-08-26 09:08:36', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-26', NULL, '');
INSERT INTO person VALUES (268, 'Joe Joreira', '2013-08-26 09:08:07', 1, 'Julia Pernet', '', '290   ', 1, '                ', '                ', '         ', '', '', 'm', '1964-11-07', 23, 'single');
INSERT INTO person VALUES (269, 'Leoner Soares de Sou', '2013-08-26 09:08:39', 1, 'Ervo Helio Chacvej', '', '150   ', 1, '                ', '                ', '         ', '', '', 'm', '1950-11-16', 5, 'single');
INSERT INTO person VALUES (270, 'Jan Condor  Jegesk', '2013-08-26 10:08:53', 1, 'ana rita', '', '284   ', 1, '                ', '                ', '         ', '', '', 'm', '1983-05-17', NULL, 'single');
INSERT INTO person VALUES (271, 'Jefersom Luiz a dos Santos', '2013-08-26 10:08:44', 1, 'Carlos Cahagas', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1993-11-23', 23, 'single');
INSERT INTO person VALUES (272, 'Joao dos Santos Filho', '2013-08-26 10:08:26', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1972-08-17', 21, 'single');
INSERT INTO person VALUES (273, 'Joao Marcelo meira dos Santos', '2013-08-26 10:08:55', 1, 'Barbosa lima', '', '355   ', 1, '                ', '                ', '         ', '', '', 'm', '1976-09-04', NULL, 'single');
INSERT INTO person VALUES (274, 'Jose Valdemir Ribeiro Borges', '2013-08-26 10:08:19', 1, 'joao cheidt', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '1967-09-09', NULL, '');
INSERT INTO person VALUES (275, 'Joao Ponijalski', '2013-08-26 13:08:24', 1, 'Chafic Curi', '', '44    ', 5, '(42)84027469    ', '(42)32381449    ', '         ', '', '', 'm', '1960-11-02', NULL, 'married');
INSERT INTO person VALUES (276, 'Juliano Ferreira', '2013-08-26 13:08:48', 1, 'Marcilio Mias', '', '1889  ', 1, '(42)99892414    ', '                ', '         ', '', '', 'm', '1978-08-09', NULL, 'single');
INSERT INTO person VALUES (277, 'Joao Ribeiro de Jesus', '2013-08-26 13:08:49', 1, 'Marcilio dias', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1986-12-25', NULL, 'single');
INSERT INTO person VALUES (278, 'Jorge Luiz Madureira', '2013-08-26 13:08:20', 1, 'Carlos chagas', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1967-07-04', 23, 'single');
INSERT INTO person VALUES (279, 'Jose Milrtom Gorchacosk', '2013-08-26 13:08:05', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1956-10-14', NULL, 'single');
INSERT INTO person VALUES (280, 'Jose Fernandes de Lima', '2013-08-26 13:08:22', 1, 'Alfredo Trentini', '', '250   ', 1, '                ', '                ', '         ', '', '', 'm', '1979-05-27', NULL, 'single');
INSERT INTO person VALUES (281, 'Joel Fernandes de Lima', '2013-08-26 13:08:19', 1, 'Alfredo trentim', '', '250   ', 1, '                ', '                ', '         ', '', '', 'm', '0179-05-27', 7, 'single');
INSERT INTO person VALUES (282, 'Jacsom Jonas Cardoso', '2013-08-26 13:08:49', 1, 'R Londrina', '', '486   ', 1, '                ', '                ', '         ', '', '', 'm', '1969-11-13', 21, 'single');
INSERT INTO person VALUES (283, 'Joao Ogarencho', '2013-08-26 13:08:43', 1, '', '', '      ', 1, '                ', '(42)32250568    ', '         ', '', '', 'm', '1955-07-14', NULL, 'single');
INSERT INTO person VALUES (284, 'Joao Batista de Melo', '2013-08-26 13:08:11', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1962-05-07', NULL, '');
INSERT INTO person VALUES (285, 'Jaroslau Kroim', '2013-08-26 13:08:26', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1956-03-30', NULL, 'single');
INSERT INTO person VALUES (286, 'Marcos Antonio Kobinski', '2013-08-26 14:08:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1975-07-23', 2, 'single');
INSERT INTO person VALUES (287, 'Luiz Claudio Samiuk', '2013-08-26 14:08:38', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-12-09', NULL, 'single');
INSERT INTO person VALUES (288, 'Lucas Cortes  Borges', '2013-08-26 14:08:59', 1, 'Pedro Francisco', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1994-04-11', 4, 'single');
INSERT INTO person VALUES (289, 'Luiz Carlos de Andrade da Rocha', '2013-08-26 14:08:49', 1, 'Aroa Brock', '', '      ', 1, '                ', '(42)32279006    ', '         ', '', '', 'm', '1983-09-09', NULL, 'single');
INSERT INTO person VALUES (290, 'Luiz Fernando Maldonado', '2013-08-26 14:08:59', 1, 'Maringa', '', '698   ', 1, '(42)99362177    ', '(42)32367633    ', '         ', '', '', 'm', '1991-04-27', 7, 'single');
INSERT INTO person VALUES (291, 'Leandro Souza Zamem', '2013-08-26 14:08:49', 1, 'Rosmar Diniz', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1992-07-30', 21, 'single');
INSERT INTO person VALUES (292, 'Kaique Carvalho Pereira de Almeida', '2013-08-26 14:08:00', 1, 'Alfredo Santana', '', '1     ', 1, '                ', '                ', '         ', '', '', 'm', '2006-12-17', 4, 'single');
INSERT INTO person VALUES (293, 'Jose Mauro Antunes', '2013-08-26 14:08:34', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1967-07-11', NULL, 'married');
INSERT INTO person VALUES (294, 'Jailsom Elvis Da Silva', '2013-08-26 14:08:34', 1, 'engenheiro virgilho milask', '', '99    ', 1, '                ', '                ', '         ', '', '', 'm', '1983-07-29', 17, 'separated');
INSERT INTO person VALUES (295, 'Jefersom Tomas De Jesus', '2013-08-26 14:08:09', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1988-05-20', NULL, 'single');
INSERT INTO person VALUES (296, 'Jair Ferreira', '2013-08-26 14:08:10', 1, 'Haiti', '', '232   ', 1, '                ', '                ', '         ', '', '', 'm', '1958-05-02', 23, 'single');
INSERT INTO person VALUES (297, 'Jonatam Jakinso Tomas', '2013-08-26 15:08:11', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1995-11-13', NULL, '');
INSERT INTO person VALUES (298, 'Jose Renam Gonsalves', '2013-08-26 15:08:35', 1, 'Aristopolis', '', '302   ', 1, '                ', '                ', '         ', '', '', 'm', '2000-09-16', NULL, 'single');
INSERT INTO person VALUES (299, 'Jose Padilha', '2013-08-26 15:08:46', 1, 'santa paula2', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1066-01-26', 21, 'single');
INSERT INTO person VALUES (300, 'Jorge Ramiro Marinho', '2013-08-26 15:08:47', 1, 'Cascavel', '', '38    ', 1, '                ', '                ', '         ', '', '', 'm', '1980-10-14', 16, 'married');
INSERT INTO person VALUES (494, 'Petersom Figueredo', '2013-08-30 15:08:12', 1, 'Mirim', '', '44    ', 1, '                ', '                ', '         ', '', '', 'm', '1984-03-19', 14, 'single');
INSERT INTO person VALUES (301, 'Jocemar Michel dos Santos', '2013-08-26 15:08:08', 1, 'Enfermeiro Paulino', '', '2916  ', 1, '                ', '                ', '         ', '', '', 'm', '1994-06-12', 13, 'single');
INSERT INTO person VALUES (266, 'João Carlos Mileski', '2013-08-26 09:08:29', 1, 'Osvado Cruz', '', '357   ', 1, '                ', '                ', '         ', '', '', 'm', '1977-05-16', 12, 'single');
INSERT INTO person VALUES (302, 'Jonathan dos Santos Marques', '2013-08-26 15:08:29', 1, 'Joao Dietzel', '', '396   ', 1, '                ', '                ', '         ', '', '', 'm', '1989-11-06', 7, 'single');
INSERT INTO person VALUES (303, 'Josley Junior Fernandes de Paula', '2013-08-26 16:08:43', 1, 'Emelino de Leao', '', '915   ', 1, '                ', '                ', '         ', '', '', 'm', '1982-05-25', 1, 'single');
INSERT INTO person VALUES (304, 'Jose Mario Vicente de Lima', '2013-08-26 16:08:16', 1, 'Carlos Chagas', '', '370   ', 1, '                ', '                ', '         ', '', '', 'm', '1963-11-04', 23, 'single');
INSERT INTO person VALUES (305, 'Jose Lucio Dos Santos', '2013-08-26 16:08:42', 1, 'lira', '', '81    ', 1, '(42)99664911    ', '                ', '         ', '', '', 'm', '1973-07-06', 16, 'single');
INSERT INTO person VALUES (309, 'Jose Carlos Soaresn', '2013-08-26 16:08:27', 1, 'Dai Luiz Wanber', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1976-05-02', 1, 'single');
INSERT INTO person VALUES (310, 'Jair de Jesus', '2013-08-26 16:08:42', 1, 'Lucio Alves da Silva', '', '156   ', 1, '                ', '                ', '         ', '', '', 'm', '1960-12-28', 9, 'single');
INSERT INTO person VALUES (311, 'Jose Demetrio Walhoviccz', '2013-08-26 16:08:59', 1, 'br 280', '', 'km 232', 1, '                ', '                ', '85520000 ', '', '', 'm', '1982-09-16', NULL, 'single');
INSERT INTO person VALUES (312, 'Joel Mendes', '2013-08-26 16:08:59', 1, 'Xavier da Silva', '', '227   ', 1, '(42)91276071    ', '                ', '         ', '', '', 'm', '1949-06-20', 1, 'single');
INSERT INTO person VALUES (313, 'Jucinar garcia da Silva', '2013-08-26 16:08:23', 1, 'Alcel de Jamar Guimaraens', '', '288   ', 1, '                ', '                ', '         ', '', '', 'm', '1969-06-30', 20, 'single');
INSERT INTO person VALUES (314, 'Jose roberto Domingos', '2013-08-26 16:08:21', 1, 'Salvador de Mendonça', '', '1     ', 1, '(42)99038504    ', '                ', '         ', '', '', 'm', '1972-01-06', 22, 'single');
INSERT INTO person VALUES (315, 'Jonatam da Cunha Passos', '2013-08-26 17:08:05', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-04-10', NULL, 'single');
INSERT INTO person VALUES (316, 'Janaina dos Santos', '2013-08-27 09:08:31', 1, 'cachoeirinha', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1994-04-24', NULL, 'married');
INSERT INTO person VALUES (317, 'Jaqueline Zavoski', '2013-08-27 09:08:31', 1, 'Carlos Chagas', '', '612   ', 1, '                ', '                ', '         ', '', '', 'm', '1997-10-06', 23, 'single');
INSERT INTO person VALUES (318, 'Janaina Chamo', '2013-08-27 09:08:17', 1, '7 setenbro', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '2007-07-29', 1, 'single');
INSERT INTO person VALUES (319, 'Jocelia de oliveira', '2013-08-27 09:08:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2013-01-27', NULL, 'single');
INSERT INTO person VALUES (320, 'Juvelina A Rodrigues', '2013-08-27 09:08:10', 1, 'Expedicicionario Joao Maetins', '', '95    ', 1, '                ', '                ', '         ', '', '', 'f', '1941-12-13', 5, 'single');
INSERT INTO person VALUES (321, 'Josiane Aparecida Alves dos Santos', '2013-08-27 09:08:03', 1, 'Carlos Chagas', '', '370   ', 1, '                ', '                ', '         ', '', '', 'f', '1984-04-02', 23, 'single');
INSERT INTO person VALUES (322, 'Josine Santos Nascimento', '2013-08-27 09:08:25', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2005-07-20', NULL, 'separated');
INSERT INTO person VALUES (323, 'Jessica Oliveira Rodrigues', '2013-08-27 09:08:45', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2009-12-12', NULL, 'single');
INSERT INTO person VALUES (324, 'Jeinefer Tainara Mendes de Oliveira', '2013-08-27 09:08:41', 1, 'Abelardo de Brito', '', '15    ', 1, '                ', '                ', '         ', '', '', 'f', '2007-03-08', 5, 'single');
INSERT INTO person VALUES (325, 'Jeisebel Pires de Moraes', '2013-08-27 09:08:58', 1, 'Antonio Carlos', '', '224   ', 1, '                ', '                ', '         ', '', '', 'f', '2013-01-27', 12, 'single');
INSERT INTO person VALUES (326, 'Juliana Debora Barbosa da Silva', '2013-08-27 09:08:16', 1, 'Evaristo da Veiga', '', '97    ', 1, '(42)99012287    ', '(42)32250512    ', '         ', '', '', 'f', '1995-06-26', 4, 'married');
INSERT INTO person VALUES (327, 'Josiane Borges', '2013-08-27 10:08:28', 1, 'Garoupa 601', '', '601   ', 1, '                ', '                ', '         ', '', '', 'f', '1973-03-14', 5, 'single');
INSERT INTO person VALUES (328, 'Ingreid de Paula', '2013-08-27 10:08:04', 1, 'Carlos Chagas', '', '56    ', 1, '                ', '                ', '         ', '', '', 'f', '1999-11-25', 23, 'single');
INSERT INTO person VALUES (329, 'Isabel Dias Galvao', '2013-08-27 10:08:56', 1, '', '', '      ', 1, '(42)99093074    ', '                ', '         ', '', '', 'f', '1990-11-09', NULL, 'married');
INSERT INTO person VALUES (330, 'Geisebel Rodrigues', '2013-08-27 10:08:02', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1982-03-25', NULL, 'single');
INSERT INTO person VALUES (331, 'Geova Araujo', '2013-08-27 10:08:30', 1, 'Radialsta Nelsom', '12', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1997-12-31', 7, 'single');
INSERT INTO person VALUES (332, 'Gilva Domingues da Silva', '2013-08-27 10:08:21', 1, 'Souza Franco', '', '420   ', 1, '                ', '                ', '         ', '', '', 'f', '2006-10-07', 23, 'single');
INSERT INTO person VALUES (333, 'Gabriele Ribeiro Santos', '2013-08-27 10:08:12', 1, 'Aide Oliveira Madureira', '', '42    ', 1, '                ', '                ', '         ', '', '', 'f', '2004-04-17', 7, 'single');
INSERT INTO person VALUES (334, 'Gisele Aparecida Rodrigues', '2013-08-27 10:08:20', 1, 'Julio Perneta', '', '299   ', 1, '                ', '                ', '         ', '', '', 'f', '1998-04-22', 23, 'single');
INSERT INTO person VALUES (335, 'Franciele Santos Marques', '2013-08-27 10:08:22', 1, 'Paulo Nadal', '', '197   ', 1, '                ', '                ', '         ', '', '', 'f', '1990-12-30', NULL, '');
INSERT INTO person VALUES (336, 'Franciele Pedroso', '2013-08-27 10:08:11', 1, 'Carlos Chagas', '', '1     ', 1, '                ', '                ', '         ', '', '', 'f', '1999-02-14', 23, 'single');
INSERT INTO person VALUES (337, 'Fabiola Gabriele Sanpaio Gomes', '2013-08-27 10:08:38', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1999-08-14', 9, 'single');
INSERT INTO person VALUES (338, 'Franciele Krevei de Almeida', '2013-08-27 11:08:05', 1, 'Ercilio  Eslavieiro', '', '13    ', 1, '                ', '                ', '         ', '', '', 'f', '1995-05-29', 7, 'single');
INSERT INTO person VALUES (339, 'Franciele Aparrecida de Paula', '2013-08-27 13:08:08', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1988-10-01', NULL, 'single');
INSERT INTO person VALUES (340, 'Franciele Franciene Lemes', '2013-08-27 13:08:24', 1, 'Evaristo da Veiga', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'f', '1989-04-16', 23, 'single');
INSERT INTO person VALUES (341, 'Eclair Buher', '2013-08-27 13:08:38', 1, '', '', '      ', 1, '(42)98111698    ', '                ', '         ', '', '', 'm', '1976-05-29', NULL, 'single');
INSERT INTO person VALUES (342, 'Ediane Miquel da Silva', '2013-08-27 13:08:24', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1990-08-23', NULL, 'single');
INSERT INTO person VALUES (343, 'Elisangela Bueno de Almeida', '2013-08-27 13:08:12', 1, 'Eleni Aparecida', '', '1     ', 1, '                ', '                ', '         ', '', '', 'f', '1994-11-11', NULL, 'single');
INSERT INTO person VALUES (344, 'Emanueli de Oliveira Feraz', '2013-08-27 13:08:47', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2005-06-20', NULL, 'single');
INSERT INTO person VALUES (345, 'Emanuela Aparecida Oliveira Barbosa', '2013-08-27 13:08:30', 1, 'nelsom Narciso Vitiato', '', '12    ', 1, '                ', '                ', '         ', '', '', 'f', '2000-04-10', 21, 'single');
INSERT INTO person VALUES (346, 'Elvira Gonçalves', '2013-08-27 13:08:59', 1, 'Garoupa', '1', '60    ', 1, '                ', '                ', '         ', '', '', 'f', '1947-02-22', NULL, '');
INSERT INTO person VALUES (347, 'Denise Jaquinzo', '2013-08-27 13:08:33', 1, 'expedicionario  iltom', '', '224   ', 1, '                ', '                ', '         ', '', '', 'f', '1974-03-03', NULL, '');
INSERT INTO person VALUES (348, 'Derzina de Fatima Santana', '2013-08-27 13:08:38', 1, 'Jose Azevedo de Macedo', '', '14    ', 1, '(42)88226212    ', '(42)32227381    ', '         ', '', '', 'f', '1976-02-27', 13, 'single');
INSERT INTO person VALUES (349, 'Daiane Caroline Maciel Oliveira', '2013-08-27 13:08:41', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1996-05-05', NULL, 'single');
INSERT INTO person VALUES (350, 'Daniela Launa Lourenço', '2013-08-27 13:08:08', 1, 'Aroldo Snenberg', '', '6     ', 1, '                ', '                ', '         ', '', '', 'f', '1988-05-11', 7, '');
INSERT INTO person VALUES (351, 'Daiane Raiane Gonçalves Lemes', '2013-08-27 13:08:14', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2004-05-13', NULL, '');
INSERT INTO person VALUES (352, 'Debora Maiara Gonçalves Lemes', '2013-08-27 13:08:27', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2002-01-01', NULL, 'single');
INSERT INTO person VALUES (353, 'Carla Regiane da Silva', '2013-08-27 14:08:24', 1, 'Haiti', '', '6     ', 1, '                ', '                ', '         ', '', '', 'f', '1982-07-16', 23, 'married');
INSERT INTO person VALUES (354, 'Celia Aparecida Camargo', '2013-08-27 14:08:15', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1974-09-10', NULL, 'married');
INSERT INTO person VALUES (355, 'Cauna Zarosk', '2013-08-27 14:08:53', 1, 'Vanderlei Martins', '', '2     ', 1, '                ', '                ', '         ', '', '', 'f', '2001-08-01', 23, '');
INSERT INTO person VALUES (356, 'Claudia Cristiana Glass', '2013-08-27 14:08:02', 1, 'Alvares de Azevedo', '', '4     ', 1, '                ', '                ', '         ', '', '', 'f', '1977-02-22', 20, 'single');
INSERT INTO person VALUES (357, 'carlos mendes de Oliveira', '2013-08-27 14:08:23', 1, 'Ribeiro de Canpos', '', '761   ', 1, '                ', '                ', '         ', '', '', 'f', '1990-11-09', 13, 'single');
INSERT INTO person VALUES (358, 'Clausiane de Souza Mota', '2013-08-27 14:08:19', 1, 'Carlos Chagas', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1985-06-01', 23, 'single');
INSERT INTO person VALUES (359, 'Carla Miranda de Paula Rocha', '2013-08-27 14:08:12', 1, 'Julio Perneta', '', '3     ', 1, '                ', '                ', '         ', '', '', 'f', '2000-07-10', 9, 'single');
INSERT INTO person VALUES (360, 'Claudineia Pontes', '2013-08-27 14:08:57', 1, '', '', '      ', 3, '                ', '                ', '         ', '', '', 'f', '1900-01-09', NULL, 'single');
INSERT INTO person VALUES (361, 'Caroline reinaldo', '2013-08-27 14:08:19', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'f', '1993-06-18', NULL, 'single');
INSERT INTO person VALUES (362, 'Celia Rodrigues Hanke', '2013-08-27 15:08:24', 1, 'Anita Garibaldi', '', '1674  ', 1, '                ', '                ', '         ', '', '', 'f', '1980-01-20', 7, 'single');
INSERT INTO person VALUES (363, 'Cristiane Moraes Franco', '2013-08-27 15:08:54', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1987-05-07', NULL, 'single');
INSERT INTO person VALUES (364, 'Claudete de Fatima Viana', '2013-08-27 15:08:53', 1, 'Barros Falcao', '', '48    ', 1, '                ', '                ', '         ', '', '', 'f', '1977-04-18', 7, 'single');
INSERT INTO person VALUES (366, 'Bruna Jakinzo Thomas', '2013-08-27 15:08:23', 1, 'Bonifacio ribas', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1998-10-07', 13, 'single');
INSERT INTO person VALUES (367, 'Ariane Aparecida Gonçalves', '2013-08-27 15:08:58', 1, 'Garça Braca', '', '8     ', 1, '                ', '                ', '         ', '', '', 'f', '1993-05-19', 7, 'single');
INSERT INTO person VALUES (368, 'Andreia de Fatima dos Santos', '2013-08-27 15:08:04', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1975-10-28', NULL, 'single');
INSERT INTO person VALUES (369, 'Adriane de Fatima Melo Gonçalves', '2013-08-27 16:08:46', 1, 'Jaci Monteiro', '', '89    ', 1, '                ', '                ', '         ', '', '', 'f', '1996-09-02', 7, 'single');
INSERT INTO person VALUES (370, 'Ana Caroline Ferreira Santos', '2013-08-27 16:08:42', 1, 'ana de lima', '', '7     ', 1, '                ', '                ', '         ', '', '', 'f', '1996-11-22', 4, 'widow(er)');
INSERT INTO person VALUES (371, 'Alexandra Aparecida Roberto', '2013-08-28 08:08:32', 1, '', '', '      ', 2, '                ', '(42)32231551    ', '         ', '', '', 'f', '1982-07-08', NULL, 'married');
INSERT INTO person VALUES (373, 'Amanda Caroline Mendes', '2013-08-28 09:08:42', 1, 'Reni Gomes  Lopes', '', '52    ', 1, '                ', '                ', '         ', '', '', 'f', '1998-11-06', 7, 'single');
INSERT INTO person VALUES (374, 'Adriele Aparecida Mendes', '2013-08-28 09:08:24', 1, 'Reni Gomes Lopes', '', '52    ', 1, '                ', '                ', '         ', '', '', 'f', '2013-01-28', NULL, 'single');
INSERT INTO person VALUES (375, 'Adriele dos Anjos Shultz', '2013-08-28 09:08:38', 1, 'Alfrredo Trentim', '', '83 fds', 1, '(42)99063009    ', '                ', '         ', '', '', 'f', '1992-12-18', 7, 'married');
INSERT INTO person VALUES (376, 'Adriele Genu', '2013-08-28 09:08:13', 1, 'Marcilo Dias', '', '1378  ', 1, '(42)99951563    ', '                ', '         ', '', '', 'f', '2013-01-28', 7, 'single');
INSERT INTO person VALUES (377, 'Adriana Bonim Cunha', '2013-08-28 09:08:16', 1, 'Haiti', '', '123   ', 1, '                ', '                ', '         ', '', '', 'f', '1979-10-12', 23, 'married');
INSERT INTO person VALUES (378, 'Line Molinari', '2013-08-28 09:08:09', 1, 'Argemiro de bula', '', '1140  ', 1, '                ', '                ', '         ', '', '', 'f', '1995-01-19', 1, 'single');
INSERT INTO person VALUES (379, 'Angelica Kimarra Jakinjo', '2013-08-28 09:08:03', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2006-03-17', NULL, 'single');
INSERT INTO person VALUES (380, 'Ana Rosa Ribeiro', '2013-08-28 10:08:22', 1, 'Jaguapita', '', '41    ', 1, '                ', '                ', '         ', '', '', 'f', '1976-03-04', NULL, 'married');
INSERT INTO person VALUES (381, 'Ana luiza De Oliveira', '2013-08-28 10:08:13', 1, 'Nelsom narciso', '', '12    ', 1, '                ', '                ', '         ', '', '', 'f', '1954-07-22', NULL, 'single');
INSERT INTO person VALUES (382, 'Ana Maria de Lima', '2013-08-28 10:08:35', 1, 'Carlos Chagas', '', '370   ', 1, '                ', '                ', '         ', '', '', 'f', '1959-07-26', 23, 'single');
INSERT INTO person VALUES (383, 'Ana Paula Dezetenik', '2013-08-28 10:08:33', 1, 'Carlos Chagas', '', '556   ', 1, '                ', '                ', '         ', '', '', 'f', '1990-01-28', 24, 'single');
INSERT INTO person VALUES (384, 'Andressa de Paula Lima', '2013-08-28 10:08:06', 1, 'Raider de Oliveira', '', '76    ', 1, '                ', '                ', '         ', '', '', 'f', '2008-06-05', 14, 'single');
INSERT INTO person VALUES (385, 'Angela Maria Fagundes', '2013-08-28 10:08:30', 1, '', '', '      ', 5, '                ', '                ', '         ', '', '', 'f', '1979-04-22', NULL, 'single');
INSERT INTO person VALUES (386, 'Andressa Jonak Gonçalves', '2013-08-28 10:08:47', 1, 'Anita Garibaldi', '', '3001  ', 1, '                ', '                ', '         ', '', '', 'f', '1996-03-16', 24, 'single');
INSERT INTO person VALUES (387, 'Adriana da Silva Bueno de Matos', '2013-08-28 10:08:05', 1, 'sebastiao', '', '93    ', 1, '                ', '                ', '         ', '', '', 'f', '1973-05-21', 14, 'single');
INSERT INTO person VALUES (388, 'Adriana Carvalho Muniz', '2013-08-28 10:08:56', 1, 'Pricila Negrao', '', '      ', 1, '99339943        ', '                ', '         ', '', '', 'f', '1988-05-02', NULL, 'single');
INSERT INTO person VALUES (390, 'Alessandra Amaciel de Oliveira', '2013-08-28 10:08:56', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1990-09-02', NULL, 'married');
INSERT INTO person VALUES (391, 'Fabio Garcia Moreira', '2013-08-28 11:08:53', 1, 'Mocidade Alegre', '', '366   ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-28', NULL, 'single');
INSERT INTO person VALUES (392, 'Fabio Guimaraens  dos Santos', '2013-08-28 11:08:42', 1, 'Antonio Chagas', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-28', NULL, 'married');
INSERT INTO person VALUES (393, 'Fernando Ilenek', '2013-08-28 11:08:45', 1, 'Marques de Oliveira', '', '1162  ', 1, '                ', '                ', '         ', '', '', 'm', '1983-05-14', NULL, 'single');
INSERT INTO person VALUES (394, 'Felipe Lucas de LIma', '2013-08-28 11:08:36', 1, 'Maestro Bento Mossorunga', '', '195   ', 1, '                ', '                ', '         ', '', '', 'm', '1990-08-21', 16, 'single');
INSERT INTO person VALUES (395, 'Erivelto da Veiga', '2013-08-29 08:08:28', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'm', '1951-06-25', NULL, 'married');
INSERT INTO person VALUES (396, 'Erotilde Xavier da Silva', '2013-08-29 09:08:58', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1947-10-08', NULL, 'single');
INSERT INTO person VALUES (397, 'Erom Junior Rodrigues', '2013-08-29 09:08:44', 1, 'Rosicler Oliveira Madureira', '', '76    ', 1, '                ', '                ', '         ', '', '', 'm', '1994-08-06', 14, 'single');
INSERT INTO person VALUES (398, 'Everaldo Vinicius da Silva', '2013-08-29 09:08:37', 1, 'Radialista Nelsom', '', '122   ', 1, '(42)99173912    ', '(42)32361582    ', '84073460 ', '', '', 'm', '1973-07-28', 14, 'single');
INSERT INTO person VALUES (399, 'Eli Fernades Lima', '2013-08-29 09:08:43', 1, 'Alvaro Alvim', '', '6     ', 1, '                ', '                ', '         ', '', '', 'm', '1943-11-23', NULL, 'widow(er)');
INSERT INTO person VALUES (400, 'Edsom Rodrigues', '2013-08-29 09:08:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1972-04-22', NULL, 'single');
INSERT INTO person VALUES (365, 'Bianca Sampaio Rocha', '2013-08-27 15:08:51', 1, 'Evaristo de Moraes', '', '30    ', 1, '                ', '                ', '         ', '', '', 'f', '1981-01-13', 9, 'single');
INSERT INTO person VALUES (372, 'Amelia Maria da Luz', '2013-08-28 08:08:58', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1960-04-25', NULL, 'single');
INSERT INTO person VALUES (401, 'Emersom Jean Vrieber', '2013-08-29 09:08:38', 1, 'Miguel Couto', '', '1306  ', 1, '                ', '                ', '         ', '', '', 'm', '1975-12-19', 25, 'separated');
INSERT INTO person VALUES (402, 'Ericsom Horacio Delezuk', '2013-08-29 09:08:25', 1, 'palmeira', '', '      ', 1, '(42)91092787    ', '(42)30271749    ', '         ', '', '', 'm', '1967-03-12', 21, 'married');
INSERT INTO person VALUES (403, 'Enio Clementino Rodrigues Farias', '2013-08-29 09:08:32', 1, 'Manoel Margues', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1975-02-02', 13, 'single');
INSERT INTO person VALUES (404, 'Everaldo Jaildo de Almeida', '2013-08-29 09:08:24', 1, 'Alfredo Valentim', '', '22    ', 1, '                ', '                ', '         ', '', '', 'm', '1992-02-12', 24, 'single');
INSERT INTO person VALUES (405, 'Elisandro dos Santos Jaques Coelho', '2013-08-29 09:08:18', 1, 'Marcilio Dias', '', '1378  ', 1, '                ', '                ', '         ', '', '', 'm', '1983-08-10', 7, 'single');
INSERT INTO person VALUES (406, 'Fabio Jose dos Santos', '2013-08-29 09:08:14', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1994-11-06', NULL, 'single');
INSERT INTO person VALUES (407, 'Erico Andrade Diniz', '2013-08-29 10:08:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1981-09-30', NULL, 'married');
INSERT INTO person VALUES (408, 'Eliseu Gonsalves Santos', '2013-08-29 10:08:52', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1993-08-27', NULL, 'single');
INSERT INTO person VALUES (409, 'Edso da Silva Marinho', '2013-08-29 10:08:08', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-02-22', NULL, '');
INSERT INTO person VALUES (410, 'Ezequiel Mathias da Penha', '2013-08-29 10:08:47', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1984-05-25', NULL, 'single');
INSERT INTO person VALUES (411, 'Edivaldo Jose Carneiro', '2013-08-29 10:08:08', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1962-10-04', NULL, '');
INSERT INTO person VALUES (413, 'Edsom Oliveira dos Santos', '2013-08-29 10:08:22', 1, 'Aristids Simoens', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1971-09-28', 1, 'single');
INSERT INTO person VALUES (414, 'Eduardo Eloi', '2013-08-29 10:08:30', 1, '', '', '      ', 3, '                ', '                ', '         ', '', '', 'm', '1986-06-02', NULL, 'single');
INSERT INTO person VALUES (415, 'Elitom Opata', '2013-08-29 10:08:12', 1, 'Maercelino Nogueira', '', '      ', 1, '942)99908216    ', '                ', '         ', '', '', 'm', '1983-10-06', 2, 'single');
INSERT INTO person VALUES (416, 'Eliakim Ramos Pires', '2013-08-29 10:08:52', 1, 'Cornelio', '', '37    ', 1, '(42)99551242    ', '(42)32395468    ', '         ', '', '', 'm', '1984-07-07', 21, 'single');
INSERT INTO person VALUES (417, 'Emersom Luiz Coelho', '2013-08-29 10:08:21', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1975-07-14', NULL, 'single');
INSERT INTO person VALUES (419, 'Evertom Jonaque Gonsalves', '2013-08-29 11:08:20', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-11-09', NULL, 'single');
INSERT INTO person VALUES (420, 'Eraldo Mendes', '2013-08-29 11:08:13', 1, 'Carlos Chagas', '', '551   ', 1, '                ', '                ', '         ', '', '', 'm', '1957-11-03', 23, 'married');
INSERT INTO person VALUES (421, 'Claudinei Severo Da Silva', '2013-08-29 11:08:16', 1, 'Marques Guimarens', '', '287   ', 1, '                ', '                ', '         ', '', '', 'm', '1975-04-04', 20, 'single');
INSERT INTO person VALUES (422, 'Clevertom Andreata', '2013-08-29 11:08:13', 1, 'Paulo Frontim', '', '768   ', 1, '                ', '                ', '         ', '', '', 'm', '1981-02-08', 27, 'single');
INSERT INTO person VALUES (423, 'Edsom Termosk Lemes', '2013-08-29 11:08:20', 1, 'Expeddicionario Adao Buss', '', '3     ', 1, '                ', '                ', '         ', '', '', 'm', '1977-07-02', 23, 'single');
INSERT INTO person VALUES (424, 'Edsom Leteca', '2013-08-29 11:08:20', 1, 'Xavantes', '', '228   ', 1, '                ', '                ', '84035500 ', '', '', 'm', '1974-08-30', 9, 'married');
INSERT INTO person VALUES (425, 'Eduardo Fernandes', '2013-08-29 11:08:43', 1, 'Leandro Saxramento', '', '156   ', 1, '                ', '                ', '         ', '', '', 'm', '1994-10-18', 20, 'single');
INSERT INTO person VALUES (427, 'Juliano Albino dos Santos', '2013-08-29 11:08:21', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1991-09-10', NULL, 'single');
INSERT INTO person VALUES (428, 'Everaldo c Chavez', '2013-08-29 11:08:11', 1, 'Teixeira de Macedo', '', '985   ', 1, '                ', '                ', '         ', '', '', 'm', '1979-02-19', 13, 'single');
INSERT INTO person VALUES (429, 'Ericssom Blanc Gonçalves', '2013-08-29 11:08:10', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1993-12-07', NULL, 'single');
INSERT INTO person VALUES (430, 'Eduado Braga', '2013-08-29 11:08:28', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1983-09-08', NULL, 'single');
INSERT INTO person VALUES (431, 'Ericsom Barbosa dos Santos', '2013-08-29 11:08:47', 1, '', '', '      ', 3, '                ', '                ', '         ', '', '', 'm', '1885-09-20', NULL, 'single');
INSERT INTO person VALUES (432, 'Eltom Cenci', '2013-08-29 11:08:06', 1, 'Constantino Borsato', '', '48    ', 6, '                ', '                ', '         ', '', '', 'm', '1981-11-30', 5, 'single');
INSERT INTO person VALUES (433, 'Edivaldo Bispo Dos Santos', '2013-08-29 11:08:32', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1977-12-02', NULL, 'single');
INSERT INTO person VALUES (434, 'Eversom Jose Santana Pereira', '2013-08-29 11:08:22', 1, 'Wenseslau Braz', '', '54    ', 1, '                ', '                ', '         ', '', '', 'm', '1995-06-16', 13, 'single');
INSERT INTO person VALUES (435, 'Emersom Giovane de Lima Bueno', '2013-08-29 11:08:07', 1, 'Eliseu', '', '80    ', 1, '                ', '                ', '         ', '', '', 'm', '1983-01-27', 17, 'single');
INSERT INTO person VALUES (436, 'Dirceu Pereira de Almeida', '2013-08-29 13:08:53', 1, 'Alfredo Santana', '', '2     ', 1, '                ', '                ', '         ', '', '', 'm', '1975-10-14', 4, 'married');
INSERT INTO person VALUES (437, 'Diego Nazario', '2013-08-29 13:08:03', 1, '', '', '      ', 1, '(42)99091387    ', '(42)91068217    ', '         ', '', '', 'm', '1991-05-01', NULL, 'single');
INSERT INTO person VALUES (438, 'Lairde Lucas Dominques', '2013-08-29 13:08:41', 1, 'Visconde Porto Alegre', '', '1265  ', 1, '(42)99385155    ', '(42)30282751    ', '         ', '', '', 'm', '1988-12-28', 7, 'single');
INSERT INTO person VALUES (440, 'Douglas Nogare', '2013-08-29 14:08:56', 1, '7 de Setenbro', '', '466   ', 1, '                ', '                ', '         ', '', '', 'm', '1985-09-04', 1, 'single');
INSERT INTO person VALUES (441, 'Danilo da Silva Marques', '2013-08-29 14:08:32', 1, 'Joao Ditzel', '', '396   ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-29', 14, 'single');
INSERT INTO person VALUES (442, 'Daniel do Nascimento', '2013-08-29 14:08:51', 1, 'Visconde de Barauna', '', '1604  ', 1, '                ', '                ', '         ', '', '', 'm', '1991-10-25', 7, 'single');
INSERT INTO person VALUES (443, 'Dirceu Farias Ferraz', '2013-08-29 14:08:43', 1, 'Tira dentes', '', '112   ', 9, '                ', '                ', '         ', '', '', 'm', '1988-07-24', NULL, 'single');
INSERT INTO person VALUES (444, 'Daniel dos Santos Marques', '2013-08-29 14:08:09', 1, 'Joao Ditzeel', '', '396   ', 1, '                ', '                ', '         ', '', '', 'm', '1968-09-14', 14, 'single');
INSERT INTO person VALUES (445, 'Divonsir Martins de Oliveira', '2013-08-29 14:08:31', 1, 'Canpo Largo', '', '119   ', 1, '                ', '                ', '         ', '', '', 'm', '1969-11-26', 3, 'single');
INSERT INTO person VALUES (446, 'Daltom Madureira Cordal', '2013-08-29 14:08:53', 1, 'Carvalho Pereira Ramos', '', '74    ', 1, '                ', '                ', '         ', '', '', 'm', '1969-10-31', 4, 'single');
INSERT INTO person VALUES (447, 'Davi Teixeira Pinto', '2013-08-29 14:08:10', 1, 'Visconde de Araguaia', '', '601   ', 1, '                ', '                ', '         ', '', '', 'm', '1964-01-09', 27, 'married');
INSERT INTO person VALUES (448, 'Douglas Ferreira Eleotério', '2013-08-29 14:08:28', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-11-09', NULL, '');
INSERT INTO person VALUES (449, 'Daniel Arnesto Ribeiro', '2013-08-29 14:08:44', 1, 'Ivo Alvim', '', '6     ', 1, '                ', '                ', '         ', '', '', 'm', '1982-06-23', 23, 'single');
INSERT INTO person VALUES (439, 'Danilo Cesar Machado', '2013-08-29 14:08:59', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1947-12-08', NULL, 'widow(er)');
INSERT INTO person VALUES (418, 'Elizeu Campos de Paula', '2013-08-29 10:08:44', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1995-12-17', NULL, 'single');
INSERT INTO person VALUES (412, 'Emersom Gonçalves', '2013-08-29 10:08:14', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-01-12', 2, '');
INSERT INTO person VALUES (450, 'Drio das Neves Aleida', '2013-08-29 14:08:17', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1988-10-21', 2, 'single');
INSERT INTO person VALUES (451, 'Celson Borges da SILVA', '2013-08-29 14:08:15', 1, 'Jaguapita', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1974-07-03', NULL, '');
INSERT INTO person VALUES (452, 'Cleosio Neri de Oliveira', '2013-08-29 14:08:53', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1976-03-05', NULL, 'single');
INSERT INTO person VALUES (454, 'Cleversom Aramis Paes', '2013-08-29 15:08:49', 1, 'Almirante c', '', '120   ', 1, '(42)99558955    ', '                ', '         ', '', '', 'm', '1990-08-03', 9, 'single');
INSERT INTO person VALUES (455, 'Clevrsom Gonçalves', '2013-08-29 16:08:32', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1976-05-07', NULL, 'single');
INSERT INTO person VALUES (456, 'Daivid Gonçalves Da Rocha', '2013-08-29 16:08:34', 1, 'General Joao', '', '197   ', 1, '                ', '                ', '         ', '', '', 'm', '1977-12-15', 23, 'single');
INSERT INTO person VALUES (457, 'Carlos Eduardo da Cruz Pirez', '2013-08-30 09:08:57', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1980-08-15', NULL, 'single');
INSERT INTO person VALUES (458, 'Cleversom Luiz Ferreira', '2013-08-30 09:08:50', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1989-10-17', NULL, 'single');
INSERT INTO person VALUES (459, 'Claudio Conrrado Junior', '2013-08-30 09:08:54', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1973-01-03', NULL, 'single');
INSERT INTO person VALUES (460, 'Carlos Jamil Vaigas', '2013-08-30 09:08:59', 1, 'Colobia', '', '211   ', 1, '                ', '                ', '         ', '', '', 'm', '1969-05-21', 20, 'single');
INSERT INTO person VALUES (461, 'Cristiano Moreira', '2013-08-30 09:08:48', 1, 'Haiti', '', 'sn    ', 1, '                ', '                ', '         ', '', '', 'm', '1965-08-16', 23, 'single');
INSERT INTO person VALUES (462, 'Cristiam Rodrigo Gorchinski', '2013-08-30 09:08:45', 1, 'Enrique Suber', '', '61    ', 1, '                ', '                ', '         ', '', '', 'm', '1980-07-26', 12, 'single');
INSERT INTO person VALUES (463, 'Carlos Alexandre Pedroso', '2013-08-30 09:08:14', 1, 'Carlos Chagas', '', '370   ', 1, '                ', '                ', '         ', '', '', 'm', '1996-09-17', 23, 'single');
INSERT INTO person VALUES (464, 'Cleversom Tomas de Jesus', '2013-08-30 09:08:05', 1, 'Alfredo Elgenio', '', '235   ', 1, '                ', '                ', '         ', '', '', 'm', '1982-01-21', 24, 'married');
INSERT INTO person VALUES (465, 'Cleversom Silva Tecnoski', '2013-08-30 09:08:26', 1, 'lagoa dourada', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1994-11-27', 6, 'single');
INSERT INTO person VALUES (466, 'Clebertom dos Santos Santana', '2013-08-30 09:08:52', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-30', NULL, '');
INSERT INTO person VALUES (467, 'Deivid Gonçalves da Rocha', '2013-08-30 10:08:44', 1, 'General joao', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-30', NULL, 'single');
INSERT INTO person VALUES (468, 'Daivd de Almeida', '2013-08-30 10:08:06', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-30', NULL, 'single');
INSERT INTO person VALUES (469, 'Domingues Sidnei Pedroso', '2013-08-30 10:08:44', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1964-12-31', NULL, 'single');
INSERT INTO person VALUES (470, 'Emersom Sebastiao Gonssalves da Rosa', '2013-08-30 10:08:41', 1, 'Bartolomeu Bueno', '', '16    ', 1, '                ', '                ', '         ', '', '', 'm', '1985-01-02', NULL, 'single');
INSERT INTO person VALUES (471, 'Evandro Weslei Pires da Silva', '2013-08-30 10:08:36', 1, 'presidente kenedy', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1986-09-25', 21, 'single');
INSERT INTO person VALUES (472, 'Cleitom Nando dos Santos', '2013-08-30 11:08:01', 1, 'Maestro Bento', '', '118   ', 1, '                ', '                ', '         ', '', '', 'm', '1977-05-19', 16, 'single');
INSERT INTO person VALUES (473, 'Carlos Alexandre Cidral Fernandes', '2013-08-30 11:08:39', 1, 'Perdro Sercundino Pelisale', '', '7     ', 1, '                ', '                ', '         ', '', '', 'm', '1980-02-26', 4, 'single');
INSERT INTO person VALUES (474, 'Celso de Moura Matos', '2013-08-30 11:08:15', 1, 'Lenon Silva', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1963-08-15', 1, 'separated');
INSERT INTO person VALUES (475, 'Cleisom Daivd de paula Rosa', '2013-08-30 11:08:20', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-30', NULL, 'single');
INSERT INTO person VALUES (477, 'Cleber Luiz Monteiro', '2013-08-30 11:08:44', 1, 'Raul Pinheiro Machado', '', '2     ', 1, '(42)99182970    ', '(42) 32385256   ', '         ', '', '', 'm', '1982-11-17', 4, 'single');
INSERT INTO person VALUES (478, 'Clever Sandro Menon', '2013-08-30 11:08:26', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1979-07-31', NULL, 'separated');
INSERT INTO person VALUES (479, 'Carlos Beker Neto', '2013-08-30 11:08:47', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1992-10-17', NULL, 'single');
INSERT INTO person VALUES (480, 'Cleversom Pires De Oliveira', '2013-08-30 11:08:04', 1, 'Brasil Para Cristo', '', '9     ', 1, '                ', '                ', '         ', '', '', 'm', '1981-11-06', 16, 'married');
INSERT INTO person VALUES (481, 'Rodrigo Ramos de Lara', '2013-08-30 13:08:37', 1, 'Dario Veloso', '', '885   ', 1, '                ', '                ', '         ', '', '', 'm', '1987-11-24', 13, 'single');
INSERT INTO person VALUES (482, 'Paulo Sergio Machado', '2013-08-30 14:08:43', 1, 'Teotonio Jorge', '', '37    ', 1, '                ', '                ', '         ', '', '', 'm', '1991-06-10', 22, 'married');
INSERT INTO person VALUES (483, 'Paulo Sergio de Lima', '2013-08-30 14:08:39', 1, 'Alvares de Azevedo', '', '4     ', 1, '                ', '                ', '         ', '', '', 'm', '1992-04-05', 20, 'separated');
INSERT INTO person VALUES (484, 'Pedro Stevam de Camargo', '2013-08-30 14:08:53', 1, 'Paulo Grorte', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '1954-06-28', 15, 'single');
INSERT INTO person VALUES (485, 'Peter Salmom de Jesus', '2013-08-30 14:08:02', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1968-04-25', NULL, 'separated');
INSERT INTO person VALUES (486, 'Pedro Raimundo Antero', '2013-08-30 14:08:44', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1976-06-05', NULL, 'single');
INSERT INTO person VALUES (487, 'Patrik DE Almeida', '2013-08-30 14:08:26', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-30', NULL, 'single');
INSERT INTO person VALUES (488, 'Paulo Rodriques Pexinho', '2013-08-30 14:08:32', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-30', NULL, 'single');
INSERT INTO person VALUES (489, 'Pedro Carlos Iablosk Filho', '2013-08-30 14:08:32', 1, 'Emilio de Menezes', '', '1025  ', 1, '                ', '                ', '         ', '', '', 'm', '1974-05-23', 9, 'single');
INSERT INTO person VALUES (490, 'Pedro Alexandre Andrade', '2013-08-30 14:08:46', 1, 'Visconde de Porto Alegre', '', '733   ', 1, '                ', '                ', '         ', '', '', 'm', '1980-06-29', 7, 'married');
INSERT INTO person VALUES (491, 'Paulo Egidio Darante', '2013-08-30 14:08:50', 1, 'Otavio de Carvalho', '', '469   ', 1, '                ', '                ', '         ', '', '', 'm', '1980-01-07', 4, 'single');
INSERT INTO person VALUES (492, 'Paulo Cesar Gomes', '2013-08-30 14:08:33', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-30', NULL, '');
INSERT INTO person VALUES (495, 'Paulo Cesar da Cruz', '2013-08-30 15:08:17', 1, 'Brasil Para Cristo', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1979-09-06', 16, 'single');
INSERT INTO person VALUES (496, 'Percio Bronoski', '2013-08-30 15:08:05', 1, 'Dom Geraldo Pelanda', '', '412   ', 1, '                ', '                ', '         ', '', '', 'm', '1977-11-25', 5, 'single');
INSERT INTO person VALUES (497, 'Paulo Vanderlei Pereira', '2013-08-30 15:08:56', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1966-01-26', NULL, 'single');
INSERT INTO person VALUES (498, 'Paulo Cesar Tomas', '2013-08-30 15:08:28', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1970-07-07', NULL, 'single');
INSERT INTO person VALUES (453, 'Carlos Santos Sampaio', '2013-08-29 15:08:17', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1979-08-15', 25, 'single');
INSERT INTO person VALUES (499, 'Pulo Pires da Silva', '2013-08-30 15:08:58', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1980-11-09', NULL, 'single');
INSERT INTO person VALUES (500, 'Pedro Luiz Cruz', '2013-08-30 15:08:59', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1971-06-05', NULL, 'single');
INSERT INTO person VALUES (501, 'Paulo Robuto Fernandes dos Santos', '2013-08-30 15:08:44', 1, 'Melo Moraes', '', '437   ', 1, '                ', '                ', '         ', '', '', 'm', '1967-07-16', 23, 'single');
INSERT INTO person VALUES (502, 'Paulo Cesar Rocha de Camargo', '2013-08-30 15:08:34', 1, 'Lira,', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1963-05-15', 21, 'single');
INSERT INTO person VALUES (503, 'Pedro Igor Gomes', '2013-08-30 16:08:31', 1, 'Maranhao Sobrinho', '', '1445  ', 8, '                ', '                ', '         ', '', '', 'm', '1994-09-05', NULL, 'single');
INSERT INTO person VALUES (504, 'Patrik Jose Santana Pereira', '2013-08-30 16:08:24', 1, '', '', '      ', 1, '(42)88226212    ', '                ', '         ', '', '', 'm', '1993-07-04', NULL, 'single');
INSERT INTO person VALUES (505, 'Petersom de Lima', '2013-08-30 16:08:56', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1984-11-23', NULL, '');
INSERT INTO person VALUES (506, 'Paulo Sebastiao  Gonsalves da Rosa', '2013-08-30 16:08:54', 1, 'Vila margarida', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1973-08-09', NULL, 'single');
INSERT INTO person VALUES (507, 'Osvaldo Wagner', '2013-08-30 16:08:57', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1960-10-10', NULL, 'separated');
INSERT INTO person VALUES (508, 'Oto Peplom DA Cunha', '2013-08-30 16:08:57', 1, '', '', '      ', 9, '                ', '                ', '         ', '', '', 'm', '1966-01-14', NULL, 'single');
INSERT INTO person VALUES (509, 'Niltom Cesar Preir', '2013-09-02 09:09:11', 1, '', '', '      ', 3, '                ', '                ', '         ', '', '', 'm', '1974-04-28', NULL, 'single');
INSERT INTO person VALUES (510, 'Nisom dos Santo', '2013-09-02 09:09:31', 1, 'Carlos Cagas', '', '37    ', 1, '                ', '                ', '         ', '', '', 'm', '0194-11-05', 23, '');
INSERT INTO person VALUES (511, 'Nilsom Rosa dos Santos', '2013-09-02 09:09:52', 1, 'Egeheiro Shanber', '', 'sn    ', 1, '                ', '                ', '         ', '', '', 'm', '1969-04-25', 1, 'single');
INSERT INTO person VALUES (512, 'Nelsom Jose Mrtins de Canpos', '2013-09-02 10:09:25', 1, '', '', '      ', 17, '                ', '                ', '         ', '', '', 'm', '1955-03-25', NULL, 'widow(er)');
INSERT INTO person VALUES (513, 'Nelsom Santana', '2013-09-02 10:09:03', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1980-02-02', NULL, 'single');
INSERT INTO person VALUES (514, 'Natham JakinzoTomas', '2013-09-02 10:09:22', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2003-04-05', NULL, 'single');
INSERT INTO person VALUES (515, 'Nivaldo Aparecid dos Satos Rigo', '2013-09-02 10:09:22', 1, '', '', '      ', 3, '                ', '                ', '         ', '', '', 'm', '1959-03-13', NULL, 'single');
INSERT INTO person VALUES (516, 'Orland Bhandth Guimaraens', '2013-09-02 10:09:54', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1958-11-20', NULL, 'single');
INSERT INTO person VALUES (517, 'Omar de Oliveira', '2013-09-02 10:09:28', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1958-01-16', NULL, 'single');
INSERT INTO person VALUES (518, 'Odair Jose Comin', '2013-09-02 10:09:37', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1988-07-20', NULL, 'single');
INSERT INTO person VALUES (519, 'Odenilsom jose de Franca', '2013-09-02 10:09:42', 1, '', '', '      ', 5, '                ', '                ', '         ', '', '', 'm', '1980-02-07', NULL, 'single');
INSERT INTO person VALUES (520, 'Osni de Oliveira', '2013-09-02 11:09:42', 1, 'josuino de liveira', '', '09    ', 1, '                ', '                ', '         ', '', '', 'm', '1976-02-15', 14, 'single');
INSERT INTO person VALUES (521, 'Odar de Carvalho Oliveira', '2013-09-02 11:09:30', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1979-05-15', NULL, 'single');
INSERT INTO person VALUES (522, 'Orlando Gonçalves dos Sants', '2013-09-02 11:09:01', 1, '', '', '      ', 3, '                ', '(42)36772511    ', '         ', '', '', 'm', '1993-01-08', NULL, 'single');
INSERT INTO person VALUES (523, 'Oelei  r Batista', '2013-09-03 09:09:52', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1960-02-17', NULL, 'single');
INSERT INTO person VALUES (524, 'Noel Soares de Oliveira', '2013-09-03 09:09:53', 1, 'Centenario do sul', '', '60    ', 1, '                ', '                ', '         ', '', '', 'm', '1984-05-08', 7, 'single');
INSERT INTO person VALUES (525, 'Nailor Ribas', '2013-09-03 09:09:09', 1, 'Av Ana Rita', '', '1230  ', 1, '                ', '                ', '         ', '', '', 'm', '1969-03-19', NULL, 'single');
INSERT INTO person VALUES (527, 'Oracio Roberto Da Silva', '2013-09-03 09:09:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1973-05-22', NULL, 'single');
INSERT INTO person VALUES (529, 'Osmar Clein', '2013-09-03 09:09:29', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1975-12-24', NULL, 'single');
INSERT INTO person VALUES (530, 'Niltom Ferreira de Moraes', '2013-09-03 09:09:44', 1, '', '', '      ', 1, '                ', '(42)32251733    ', '         ', '', '', 'm', '2006-03-13', NULL, 'single');
INSERT INTO person VALUES (531, 'Marcos Aurelio dos Santos', '2013-09-03 09:09:16', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'm', '1994-09-15', NULL, 'single');
INSERT INTO person VALUES (532, 'Maicom Luam de Andrade de Pintos', '2013-09-03 10:09:03', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1985-01-03', NULL, 'single');
INSERT INTO person VALUES (533, 'Marcio Jose De Oliveira', '2013-09-03 10:09:58', 1, 'Bela Vista', '', '880   ', 1, '                ', '                ', '         ', '', '', 'm', '1977-07-22', 16, 'single');
INSERT INTO person VALUES (534, 'Marcos Vinicius Santos', '2013-09-03 10:09:06', 1, 'Alvaro Alvim', '', '93    ', 1, '                ', '                ', '         ', '', '', 'm', '1976-03-03', 23, 'single');
INSERT INTO person VALUES (535, 'Maurico Dias de Moraes', '2013-09-03 10:09:25', 1, 'Aroldo Eschenberg', '', '18    ', 1, '                ', '                ', '         ', '', '', 'm', '1979-01-30', 17, 'single');
INSERT INTO person VALUES (536, 'Magno Ricardo  de Moraes', '2013-09-03 10:09:52', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1991-09-09', NULL, 'single');
INSERT INTO person VALUES (537, 'Marcio Adriano de Andrade', '2013-09-03 10:09:35', 1, 'Valério', '', '90    ', 1, '                ', '                ', '84030320 ', '', '', 'm', '1976-01-10', 9, 'single');
INSERT INTO person VALUES (538, 'Marcelo de Siqueira Maciel', '2013-09-03 10:09:59', 1, 'Afonço Celso', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-03', 1, '');
INSERT INTO person VALUES (539, 'Mario de Oliveira', '2013-09-03 10:09:03', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-03', NULL, '');
INSERT INTO person VALUES (540, 'Marcos Leandro Ribeiro', '2013-09-03 10:09:30', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1978-09-15', NULL, 'married');
INSERT INTO person VALUES (541, 'Michael Aparecido  de Sousa', '2013-09-03 10:09:23', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1987-01-10', NULL, '');
INSERT INTO person VALUES (542, 'Marcos Ramos de Carvalho', '2013-09-03 11:09:18', 1, '7 setenbro', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1988-05-21', 1, 'single');
INSERT INTO person VALUES (543, 'Marcos Antonio Rosa', '2013-09-03 11:09:10', 1, 'Daily luioz Wanber', '', '2     ', 1, '                ', '                ', '         ', '', '', 'm', '1974-08-01', 4, 'single');
INSERT INTO person VALUES (544, 'Marcelo Pupo Teixeira', '2013-09-03 11:09:44', 1, 'Jose Antonio Mendes', '', '1544  ', 1, '                ', '                ', '         ', '', '', 'm', '1988-02-11', 27, 'single');
INSERT INTO person VALUES (545, 'Marcio Gonçalves', '2013-09-03 11:09:36', 1, 'Luiz Oliveira e Silva', '', '42    ', 1, '                ', '                ', '         ', '', '', 'm', '1976-07-16', 12, 'single');
INSERT INTO person VALUES (546, 'Marcio Jose Ravalhete', '2013-09-03 11:09:39', 1, 'Barbara Setim', '', '591   ', 1, '(42)91183065    ', '(42)32228049    ', '         ', '', '', 'm', '1965-05-01', 5, 'single');
INSERT INTO person VALUES (547, 'Mateus Andre Mendes', '2013-09-03 11:09:40', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2003-09-28', NULL, 'single');
INSERT INTO person VALUES (548, 'Moacir de Pulo Ingles Filho', '2013-09-03 11:09:19', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1969-06-27', NULL, '');
INSERT INTO person VALUES (528, 'Osvaldo Martins Daeski', '2013-09-03 09:09:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1973-10-10', NULL, 'single');
INSERT INTO person VALUES (549, 'Maicom Rodrigo Lemes Gonçalvez', '2013-09-03 11:09:27', 1, 'Porto Amazonas', '', 'sn    ', 1, '                ', '                ', '         ', '', '', 'm', '1993-09-29', 3, 'single');
INSERT INTO person VALUES (550, 'Marcio Angelico', '2013-09-03 11:09:37', 1, 'Doutor Luiz Oliveita', '', '233   ', 1, '                ', '                ', '         ', '', '', 'm', '1951-12-15', NULL, 'single');
INSERT INTO person VALUES (551, 'Mario Sergio Vaz Simeão', '2013-09-03 11:09:23', 1, '', '', '      ', 3, '                ', '                ', '         ', '', '', 'm', '1988-01-09', NULL, 'single');
INSERT INTO person VALUES (552, 'Muner Ferreira da Silva', '2013-09-03 11:09:24', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1986-10-10', NULL, 'single');
INSERT INTO person VALUES (553, 'Marco Antonio Rosa', '2013-09-03 11:09:54', 1, 'Laily Luiz', '', '1     ', 1, '                ', '                ', '         ', '', '', 'm', '1974-08-01', 4, 'married');
INSERT INTO person VALUES (554, 'Marcos Fernandes', '2013-09-03 11:09:01', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1967-10-04', NULL, 'separated');
INSERT INTO person VALUES (555, 'Marcos Aurelio Da Cunha', '2013-09-03 11:09:21', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1976-12-30', NULL, 'single');
INSERT INTO person VALUES (556, 'Mateus Rafael de Oliveira', '2013-09-04 09:09:24', 1, '', '', '      ', 1, '                ', '(42)30281008    ', '         ', '', '', 'm', '1991-06-19', NULL, 'single');
INSERT INTO person VALUES (557, 'Marcos Rocha', '2013-09-04 09:09:46', 1, 'Ermelino Teixeira', '', '47    ', 1, '                ', '                ', '         ', '', '', 'm', '1973-05-02', 7, 'separated');
INSERT INTO person VALUES (558, 'Marcio Chaves', '2013-09-04 09:09:42', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1976-06-14', NULL, 'single');
INSERT INTO person VALUES (559, 'Rafel da Costa Silva', '2013-09-05 09:09:32', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1987-03-30', NULL, 'single');
INSERT INTO person VALUES (560, 'Jhonathan da Cunhas Passos', '2013-09-05 09:09:42', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-04-10', NULL, 'single');
INSERT INTO person VALUES (561, 'Cristiam Orencio de Andrade', '2013-09-05 09:09:52', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1983-12-12', 14, 'single');
INSERT INTO person VALUES (562, 'Marlene Lizardo Madeira', '2013-09-05 10:09:49', 1, 'Manoel Soares dos Santos', '', '585   ', 1, '                ', '                ', '84015330 ', '', '', 'm', '1998-02-12', 24, 'single');
INSERT INTO person VALUES (563, 'Paulo Cesar Reis', '2013-09-05 10:09:53', 1, 'Jose Branco Ribas', '', '84    ', 1, '(42)98013601    ', '                ', '         ', '', '', 'm', '1991-08-30', 5, 'single');
INSERT INTO person VALUES (564, 'Fernado Estefaniak', '2013-09-05 10:09:50', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1979-06-13', NULL, 'single');
INSERT INTO person VALUES (565, 'Fabio Rodrigues de Oliveira', '2013-09-05 10:09:46', 1, 'Sousa Mendes', '', '15    ', 1, '(42)91095812    ', '                ', '         ', '', '', 'm', '1989-12-09', 7, 'single');
INSERT INTO person VALUES (567, 'Alex Sandro dos Santos', '2013-09-05 10:09:32', 1, 'Silas Sales', '', '556   ', 1, '                ', '(42)32271275    ', '         ', '', '', 'm', '1979-01-01', 7, 'single');
INSERT INTO person VALUES (568, 'Emersom Jose Araujo Canpos', '2013-09-05 11:09:15', 1, 'Frei Caneca', '', '23    ', 1, '                ', '(42)32235907    ', '         ', '', '', 'm', '1975-02-22', 1, 'single');
INSERT INTO person VALUES (569, 'Luiz Carlos Rodrigues', '2013-09-05 11:09:50', 1, 'av Noroeste', '', '38    ', 1, '                ', '(42)99148622    ', '         ', '', '', 'm', '1979-12-17', 16, 'married');
INSERT INTO person VALUES (570, 'Gustavo Felipe  Martinho de Oliveira', '2013-09-05 11:09:45', 1, 'Antonio Rodrigues Santana', '', '15151 ', 1, '(67)91015750    ', '                ', '         ', '', '', 'm', '1993-12-16', 7, 'single');
INSERT INTO person VALUES (571, 'Crislaine Andrade Cardoso', '2013-09-05 11:09:25', 1, 'Eugenio José', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1993-10-29', 7, 'single');
INSERT INTO person VALUES (572, 'Andre Felipe Ferreira', '2013-09-05 11:09:04', 1, 'Algusto Canto', '', '346   ', 1, '(42)99462750    ', '                ', '         ', '', '', 'm', '1990-07-31', 4, 'single');
INSERT INTO person VALUES (573, 'Leandro Gomes de Paula', '2013-09-05 11:09:38', 1, 'Francisco Frajad', '', '8     ', 1, '                ', '                ', '         ', '', '', 'm', '1995-06-26', 9, 'single');
INSERT INTO person VALUES (574, 'Leonel Ferreira de Lima', '2013-09-05 15:09:41', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1959-07-22', NULL, 'single');
INSERT INTO person VALUES (575, 'Josiane Dias Gonçalves', '2013-09-05 15:09:14', 1, 'Francisco Piercosk', '', '33    ', 1, '(42)99706130    ', '                ', '         ', '', '', 'f', '1992-08-11', NULL, 'single');
INSERT INTO person VALUES (576, 'Ana Claudia dos Santos', '2013-09-05 15:09:03', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1976-07-19', NULL, 'single');
INSERT INTO person VALUES (577, 'Amiltom Antunes de Proença', '2013-09-05 15:09:59', 1, 'Jeremias', '', '34    ', 1, '942)98367883    ', '                ', '         ', '', '', 'm', '1966-10-25', 16, 'single');
INSERT INTO person VALUES (578, 'Tainá de Freitas', '2013-09-05 16:09:17', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1998-01-28', NULL, 'single');
INSERT INTO person VALUES (579, 'Thainara Domingues Da Silva', '2013-09-06 09:09:47', 1, 'Sousa Dantes', '', '420   ', 1, '                ', '                ', '         ', '', '', 'f', '1999-11-10', 23, 'single');
INSERT INTO person VALUES (580, 'Tatiana Aparecida Alves Dos antos', '2013-09-06 09:09:14', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2000-08-08', NULL, 'single');
INSERT INTO person VALUES (581, 'Samanta Gonçalves Soares', '2013-09-06 09:09:51', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2001-05-24', NULL, 'single');
INSERT INTO person VALUES (582, 'Tatiane Aparecida de Paula', '2013-09-06 09:09:55', 1, 'Vitzel Joao', '', '396   ', 1, '                ', '                ', '         ', '', '', 'f', '1999-07-19', 14, 'single');
INSERT INTO person VALUES (583, 'Teresinha Aparecia Martins', '2013-09-06 09:09:15', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1954-06-14', NULL, 'single');
INSERT INTO person VALUES (584, 'Sandra Mara Xavier Batista', '2013-09-06 09:09:35', 1, 'Teodora Klupel Neto', '', '26    ', 1, '                ', '                ', '         ', '', '', 'f', '1961-12-03', 7, '');
INSERT INTO person VALUES (585, 'Sirlei Gonçalves de Deus', '2013-09-06 09:09:27', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1969-05-16', NULL, 'married');
INSERT INTO person VALUES (586, 'Sonia Boniti dos Santos', '2013-09-06 09:09:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1969-02-04', NULL, 'single');
INSERT INTO person VALUES (587, 'Stefani de Paula Ribeiro de  Jesus', '2013-09-06 09:09:48', 1, 'Aide Oliveira', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2004-04-30', 14, 'single');
INSERT INTO person VALUES (588, 'Suelem Viana dos Santos', '2013-09-06 09:09:00', 1, 'General Boinos Falcao', '', '48    ', 1, '                ', '                ', '         ', '', '', 'f', '1993-01-25', 14, 'single');
INSERT INTO person VALUES (589, 'Silmara dos Santos', '2013-09-06 09:09:58', 1, 'Teixeir de macedo', '', '935   ', 1, '                ', '                ', '         ', '', '', 'f', '19979-07-21', 9, 'married');
INSERT INTO person VALUES (590, 'Rosiana Aparecida dos Santos', '2013-09-06 10:09:41', 1, 'Teixeira de Macedo', '', '935   ', 1, '                ', '                ', '         ', '', '', 'f', '1968-07-29', 9, 'single');
INSERT INTO person VALUES (591, 'Raquel Garret dos Santos', '2013-09-06 10:09:16', 1, 'Alexandre Lejanbre', '', '544   ', 1, '                ', '                ', '84062694 ', '', '', 'f', '1973-11-03', NULL, 'married');
INSERT INTO person VALUES (592, 'Lucimeri do Rocio Gonçalves', '2013-09-06 10:09:04', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1973-08-23', NULL, 'single');
INSERT INTO person VALUES (593, 'Rosalina Martins da Silva', '2013-09-06 10:09:45', 1, 'Sertanopolis', '', '17    ', 1, '                ', '(42)32228089    ', '         ', '', '', 'f', '1932-01-20', 25, 'married');
INSERT INTO person VALUES (594, 'Rosangela Gonçalves', '2013-09-06 10:09:37', 1, 'Pedro Francisco', '', '10    ', 1, '                ', '                ', '         ', '', '', 'f', '1983-01-01', NULL, 'married');
INSERT INTO person VALUES (595, 'Rosiane Aparecida Bueno', '2013-09-06 10:09:01', 1, 'Barbosa Lima', '', '208   ', 1, '                ', '                ', '         ', '', '', 'f', '1982-02-14', 23, 'married');
INSERT INTO person VALUES (596, 'Rosana Aparecida Machado', '2013-09-06 11:09:02', 1, 'Alberto de Oliveira', '', '141   ', 1, '                ', '                ', '         ', '', '', 'f', '1966-03-16', 7, 'single');
INSERT INTO person VALUES (597, 'Roseli Teresinha C da Luz', '2013-09-06 11:09:08', 1, 'Antonio Saad', '', '65    ', 1, '                ', '                ', '         ', '', '', 'f', '1962-10-27', 7, 'single');
INSERT INTO person VALUES (598, 'Rosana Aparecida Aráujo', '2013-09-06 11:09:24', 1, '', '', '      ', 1, '(42)98054815    ', '                ', '         ', '', '', 'f', '1975-08-26', 3, 'single');
INSERT INTO person VALUES (599, 'Raeli de Paula Rosa', '2013-09-06 11:09:29', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1990-11-09', NULL, 'single');
INSERT INTO person VALUES (600, 'Roseli de Fatima Paes', '2013-09-06 11:09:12', 1, 'Almirante', '', '122   ', 1, '(42)99011886    ', '                ', '284036230', '', '', 'f', '1957-02-11', NULL, 'single');
INSERT INTO person VALUES (601, 'Rosiane de Oliveira', '2013-09-06 11:09:50', 1, 'Nelsom Narciso', '', '12    ', 1, '                ', '                ', '         ', '', '', 'f', '1976-07-06', 25, 'separated');
INSERT INTO person VALUES (602, 'Solange de Fatima', '2013-09-06 11:09:36', 1, 'rua o ,31', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1980-02-13', 11, 'married');
INSERT INTO person VALUES (603, 'Solange Cardoso', '2013-09-06 11:09:58', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1980-08-06', 23, 'single');
INSERT INTO person VALUES (604, 'Sirlene Ferreira Catarina', '2013-09-06 11:09:11', 1, 'Farias de Brito', '', '392   ', 1, '                ', '                ', '84016050 ', '', '', 'f', '1972-06-27', 23, 'single');
INSERT INTO person VALUES (605, 'Sarita Fatima Braz', '2013-09-06 11:09:03', 1, 'Jucelino Kubcheck', '', '371   ', 1, '                ', '                ', '         ', '', '', 'f', '1975-12-02', 5, 'single');
INSERT INTO person VALUES (606, 'Roselia Maria Lukasiervicz', '2013-09-09 09:09:45', 1, 'Sabaudia', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'f', '1953-05-24', 7, 'widow(er)');
INSERT INTO person VALUES (607, 'Renata Aparecida Pedroso Ribas', '2013-09-09 09:09:23', 1, 'Bonifaci Ribas', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1998-07-15', 13, 'single');
INSERT INTO person VALUES (608, 'Regiliane da Costa de Almeida', '2013-09-09 09:09:53', 1, 'Santo Antonio da Platina', '', '28    ', 1, '(42)9935765     ', '                ', '         ', '', '', 'f', '1977-11-18', 21, 'married');
INSERT INTO person VALUES (609, 'Pamela Vitorino Rodrigues', '2013-09-09 09:09:30', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2010-08-14', NULL, 'single');
INSERT INTO person VALUES (610, 'Paulina Pires Debas', '2013-09-09 09:09:34', 1, 'Espirito Santo', '', '174   ', 1, '                ', '                ', '         ', '', '', 'f', '1965-06-28', NULL, 'married');
INSERT INTO person VALUES (611, 'Priciele de Paula', '2013-09-09 09:09:59', 1, 'Bonifacio Ribas', '', '1321  ', 1, '                ', '                ', '         ', '', '', 'f', '1993-08-18', 11, 'single');
INSERT INTO person VALUES (612, 'Ovanda Gonçalvez da Silva', '2013-09-09 09:09:11', 1, 'Prof. Jogurte de Oliveira', '', '367   ', 1, '                ', '                ', '         ', '', '', 'f', '1953-09-15', 21, 'separated');
INSERT INTO person VALUES (613, 'Noemi dos Santos Marques', '2013-09-09 09:09:34', 1, 'Silva Sales', '', '185   ', 1, '                ', '                ', '         ', '', '', 'f', '1982-11-27', 7, 'married');
INSERT INTO person VALUES (614, 'Nilcéia da Silva', '2013-09-09 09:09:07', 1, 'rua 11', '', '291   ', 1, '                ', '                ', '         ', '', '', 'f', '1974-03-12', 16, 'single');
INSERT INTO person VALUES (615, 'Mareza Ramos Carvalho', '2013-09-09 09:09:25', 1, 'Alfredo Santana', '', '2     ', 1, '                ', '                ', '         ', '', '', 'f', '2004-06-18', 4, 'single');
INSERT INTO person VALUES (616, 'Marina Carvalho Pereira de Almeida', '2013-09-09 10:09:34', 1, 'Alfredo Santana', '', '2     ', 1, '                ', '                ', '         ', '', '', 'f', '2011-09-20', 4, 'single');
INSERT INTO person VALUES (617, 'Micaelly de Oliveira', '2013-09-09 10:09:54', 1, 'Nielsom Narciso Vitiato', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'f', '2003-11-14', 20, 'single');
INSERT INTO person VALUES (618, 'Maria Regina Alves Santos', '2013-09-09 10:09:05', 1, 'Carlos Chagas', '', '370   ', 1, '                ', '                ', '         ', '', '', 'f', '1991-06-03', 23, 'single');
INSERT INTO person VALUES (619, 'Mayara Livina Ramos', '2013-09-09 10:09:17', 1, 'Expedicionario Dom Bosco', '', '1     ', 1, '                ', '                ', '         ', '', '', 'f', '1998-01-02', 16, 'single');
INSERT INTO person VALUES (620, 'Maria Aparecida Menezes de Lara', '2013-09-09 10:09:07', 1, '', '', '      ', 1, '(42)91420105    ', '                ', '         ', '', '', 'f', '1980-03-20', NULL, 'married');
INSERT INTO person VALUES (621, 'Maria Gabriela Martins do Nascimento', '2013-09-09 10:09:44', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1985-03-09', NULL, 'single');
INSERT INTO person VALUES (622, 'Maria Daniele Grosevic', '2013-09-09 10:09:23', 1, 'Raimundo Correia', '', '21    ', 1, '(42)91444439    ', '(42)32298730    ', '         ', '', '', 'f', '1977-07-27', 28, 'single');
INSERT INTO person VALUES (623, 'Mariana Rosilda Rodrigues', '2013-09-09 10:09:33', 1, 'Raider Oliveira Madureira', '', '71    ', 1, '                ', '                ', '         ', '', '', 'f', '1972-06-24', 14, 'single');
INSERT INTO person VALUES (624, 'Maria de Lurdes Pinheiro', '2013-09-09 10:09:31', 1, 'Bonifacio Ribas', '', '567   ', 1, '                ', '                ', '         ', '', '', 'f', '1948-12-08', 20, 'widow(er)');
INSERT INTO person VALUES (625, 'Mayara Francine Pereira', '2013-09-09 10:09:08', 1, 'Antonio Carlos', '', '100   ', 1, '                ', '                ', '         ', '', '', 'f', '1991-10-06', 27, 'single');
INSERT INTO person VALUES (626, 'Marcia Regina Ramos Carvalho', '2013-09-09 10:09:54', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1973-06-05', NULL, 'married');
INSERT INTO person VALUES (627, 'Marcia Regina Ramos Carvalho', '2013-09-09 10:09:07', 1, 'Alfredo Santana', '', '2     ', 1, '                ', '                ', '         ', '', '', 'f', '1973-06-05', 4, 'single');
INSERT INTO person VALUES (628, 'Margarete da Rosa Carneiro', '2013-09-09 10:09:33', 1, 'Teodoro Pinheiro Machado', '', '4     ', 1, '                ', '                ', '         ', '', '', 'f', '1982-08-05', 30, 'single');
INSERT INTO person VALUES (629, 'Maria das Graças de Melo', '2013-09-09 11:09:18', 1, 'Jaci Monteiro', '', '89    ', 1, '                ', '                ', '         ', '', '', 'f', '1957-12-01', 14, 'widow(er)');
INSERT INTO person VALUES (630, 'Karina Aparecida Viana', '2013-09-10 09:09:18', 1, 'Rio Grande do Sul', '', '418   ', 1, '                ', '                ', '         ', '', '', 'f', '1979-04-27', 4, 'single');
INSERT INTO person VALUES (631, 'Karem Kaoine dos Santos Marques', '2013-09-10 09:09:10', 1, 'Silas Sales', '', '185   ', 1, '                ', '                ', '         ', '', '', 'f', '2001-07-01', 7, 'single');
INSERT INTO person VALUES (632, 'Leticia Gilu', '2013-09-10 09:09:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1990-11-09', NULL, '');
INSERT INTO person VALUES (633, 'Marta de Oliveira Vitorino', '2013-09-10 09:09:49', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1985-04-14', NULL, 'single');
INSERT INTO person VALUES (634, 'Kinberli Matani Rodrigues', '2013-09-10 09:09:44', 1, 'Prof. Raider Oliveira Madureira', '', '76    ', 1, '                ', '                ', '         ', '', '', 'f', '2001-08-18', 7, 'single');
INSERT INTO person VALUES (635, 'Ketlyn Kauane Jakinso Machado', '2013-09-10 09:09:10', 1, 'Xisto', '', '149   ', 1, '                ', '                ', '         ', '', '', 'f', '2001-02-23', 15, 'single');
INSERT INTO person VALUES (636, 'Kelly Rodrigues Shut', '2013-09-10 10:09:10', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1994-10-10', 14, 'single');
INSERT INTO person VALUES (637, 'Kethelen Camargo', '2013-09-10 10:09:54', 1, 'Abelardo de Brito', '', '15    ', 1, '                ', '                ', '         ', '', '', 'f', '2002-11-24', NULL, 'single');
INSERT INTO person VALUES (638, 'Karoline Rodrigues Ferreira', '2013-09-10 10:09:58', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1997-11-07', NULL, 'single');
INSERT INTO person VALUES (639, 'Lauri Rodrigues da Silva', '2013-09-10 11:09:48', 1, 'Julio Perneta', '', '299   ', 1, '                ', '                ', '         ', '', '', 'f', '2002-10-26', NULL, 'single');
INSERT INTO person VALUES (640, 'Lucinéia Mendes Gonçalves', '2013-09-10 11:09:18', 1, 'Carlos Chagas', '', '15    ', 1, '                ', '                ', '         ', '', '', 'f', '1984-08-18', 17, 'single');
INSERT INTO person VALUES (641, 'Luciane Mendes Gonçalves', '2013-09-10 11:09:41', 1, 'Leocena', '', '249   ', 1, '(42)91187963    ', '                ', '         ', '', '', 'f', '1982-11-04', 13, 'single');
INSERT INTO person VALUES (642, 'Luiza Lopes de Paula', '2013-09-10 11:09:52', 1, '', '', '      ', 5, '                ', '                ', '         ', '', '', 'f', '1986-12-25', NULL, 'married');
INSERT INTO person VALUES (643, 'Luciane Aparecida Pasturcsak', '2013-09-10 11:09:35', 1, 'Cesinha Matos', '', '04    ', 1, '                ', '                ', '         ', '', '', 'f', '1962-06-15', 12, 'married');
INSERT INTO person VALUES (644, 'Lucimara Aparecida Silva', '2013-09-10 11:09:50', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1975-04-05', 2, 'single');
INSERT INTO person VALUES (645, 'Maria Luciana do nascimento', '2013-09-12 09:09:38', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1969-03-15', NULL, 'single');
INSERT INTO person VALUES (646, 'Margaret Luiz', '2013-09-12 09:09:14', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1979-08-13', NULL, 'single');
INSERT INTO person VALUES (647, 'Margarete Rosa Machado', '2013-09-12 09:09:28', 1, 'Estrada rio Verde', '', '21    ', 1, '                ', '                ', '         ', '', '', 'f', '1965-09-09', 25, 'single');
INSERT INTO person VALUES (648, 'Maria Clarice Cardoso de Paula', '2013-09-12 09:09:01', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1992-12-12', NULL, 'single');
INSERT INTO person VALUES (649, 'Maira Domingues', '2013-09-12 09:09:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1998-05-31', NULL, '');
INSERT INTO person VALUES (650, 'Miriam Rodrigues de Paula', '2013-09-12 09:09:49', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1971-05-24', NULL, 'widow(er)');
INSERT INTO person VALUES (651, 'Marinalva Lima Padilha', '2013-09-12 09:09:08', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1980-10-10', 7, 'married');
INSERT INTO person VALUES (652, 'Maria Rosa de Jesus', '2013-09-12 09:09:13', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1977-03-02', NULL, 'single');
INSERT INTO person VALUES (653, 'Marina de Brito', '2013-09-12 09:09:14', 1, 'Maecilio Dias', '', '1889  ', 1, '(42)99892414    ', '                ', '         ', '', '', 'f', '1974-07-28', 7, 'single');
INSERT INTO person VALUES (654, 'Marcia Teixeira De Paula', '2013-09-12 09:09:46', 1, 'Roicler Oliveira', '', '76    ', 1, '                ', '                ', '         ', '', '', 'f', '1974-07-28', 14, 'single');
INSERT INTO person VALUES (655, 'Maria Luciane do nascimento', '2013-09-12 09:09:38', 1, 'Prof  Alzira Braga.', '', '1000  ', 1, '                ', '                ', '         ', '', '', 'f', '1969-03-15', 22, 'single');
INSERT INTO person VALUES (656, 'Miram Teresinha Ribeiro dos Santos', '2013-09-12 10:09:34', 1, 'Prof Aide de Oliveira', '', '42    ', 1, '                ', '                ', '         ', '', '', 'f', '2013-01-12', 7, '');
INSERT INTO person VALUES (657, 'Maria Rosa Correa Soares', '2013-09-12 10:09:11', 1, 'Alex Feloix Alvares', '', '141   ', 1, '                ', '                ', '         ', '', '', 'f', '1949-10-08', NULL, 'married');
INSERT INTO person VALUES (658, 'Jair de Jesus', '2013-09-12 11:09:49', 1, 'Ermelino de Leao', '', '1161  ', 1, '                ', '                ', '         ', '', '', 'm', '1960-12-28', 9, 'single');
INSERT INTO person VALUES (659, 'Jair de Jesus', '2013-09-13 10:09:00', 1, 'Ermelino de Leao', '', '1161  ', 1, '                ', '                ', '         ', '', '', 'm', '1960-12-28', 1, 'separated');
INSERT INTO person VALUES (660, 'João Ribeiro de Jesus', '2013-09-13 10:09:15', 1, 'João Ditzel', '396', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1977-02-08', 14, 'married');
INSERT INTO person VALUES (661, 'Jonathan Aihom Vieira', '2013-09-13 10:09:36', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1991-04-01', NULL, 'single');
INSERT INTO person VALUES (662, 'João Maria Cardozo de Lima', '2013-09-13 10:09:03', 1, 'rua a jd Atlanta', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1951-01-02', NULL, 'widow(er)');
INSERT INTO person VALUES (663, 'José Roberto', '2013-09-13 10:09:33', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1991-02-28', NULL, 'single');
INSERT INTO person VALUES (664, 'Jose Eduardo Chagas da Silva', '2013-09-13 10:09:12', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-11-09', NULL, 'single');
INSERT INTO person VALUES (665, 'Joao Miguel das Neves', '2013-09-13 10:09:56', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1976-02-25', NULL, 'single');
INSERT INTO person VALUES (666, 'Joao Miguel das Neves', '2013-09-16 09:09:23', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1976-02-25', NULL, 'single');
INSERT INTO person VALUES (667, 'Julio Cesar De Camargo', '2013-09-16 09:09:27', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1983-02-11', NULL, 'single');
INSERT INTO person VALUES (668, 'João Vitor Borges dos Santos', '2013-09-16 09:09:40', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2007-09-26', NULL, 'single');
INSERT INTO person VALUES (669, 'Jerfersom Luiz de Souza Lima', '2013-09-16 09:09:38', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1987-06-25', NULL, 'single');
INSERT INTO person VALUES (670, 'José Enrique Barbosa', '2013-09-16 09:09:06', 1, 'Evaristo d Veiga', '', '97    ', 1, '                ', '                ', '         ', '', '', 'm', '1987-01-20', 23, 'single');
INSERT INTO person VALUES (671, 'Junior Lucas de Lima', '2013-09-16 09:09:40', 1, 'Francisco Mateus', '', '11    ', 1, '                ', '                ', '         ', '', '', 'm', '1990-11-17', 3, 'single');
INSERT INTO person VALUES (672, 'Jeniffer Luana Borges dos Santos', '2013-09-16 09:09:49', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1996-08-02', NULL, '');
INSERT INTO person VALUES (673, 'Izael Rodrigues dos Santos', '2013-09-16 09:09:41', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1983-07-20', NULL, 'single');
INSERT INTO person VALUES (674, 'João Waltrick', '2013-09-16 09:09:17', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1957-10-09', NULL, 'single');
INSERT INTO person VALUES (675, 'Izael Romoaldo da Cruz', '2013-09-16 09:09:22', 1, '', '', '      ', 1, '                ', '(42)32268918    ', '         ', '', '', 'm', '1954-03-01', NULL, 'married');
INSERT INTO person VALUES (676, 'Ivanil Martins da Silva', '2013-09-16 09:09:56', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1974-07-10', NULL, 'single');
INSERT INTO person VALUES (677, 'José Cruz dias', '2013-09-16 09:09:01', 1, 'Cavernoso', '', '526   ', 1, '(42)99818692    ', '(42)30255257    ', '84020510 ', '', '', 'm', '2013-01-16', 11, 'single');
INSERT INTO person VALUES (678, 'João Pedro Ricetti', '2013-09-16 09:09:20', 1, 'Antonio Saad', '', '595   ', 1, '(42)99497515    ', '(42)32381753    ', '         ', '', '', 'm', '1993-06-17', 14, 'single');
INSERT INTO person VALUES (679, 'João Mario Rodrigues', '2013-09-16 09:09:09', 1, 'Joao Passiniak Filho', '', '48    ', 1, '(42)99334705    ', '(42)99128552    ', '         ', '', '', 'm', '1995-06-01', 5, 'single');
INSERT INTO person VALUES (680, 'Julino da Silva Lemes', '2013-09-16 09:09:59', 1, 'Arenitos', '', '111   ', 1, '(42)99294138    ', '                ', '         ', '', '', 'm', '1976-05-03', 21, 'single');
INSERT INTO person VALUES (681, 'Igor dos Santos', '2013-09-16 09:09:10', 1, 'Izaias da Luz', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '1956-10-19', 14, 'separated');
INSERT INTO person VALUES (682, 'João Marcos Orloski', '2013-09-16 10:09:54', 1, 'Fabio de Mello Binilha', '', '142   ', 1, '                ', '                ', '         ', '', '', 'm', '1973-06-23', 14, 'single');
INSERT INTO person VALUES (683, 'Josmar José Kalenoski', '2013-09-16 10:09:57', 1, 'Ana Elesabeth', '', '275   ', 1, '                ', '(42)32392575    ', '         ', '', '', 'm', '2012-04-02', 16, 'single');
INSERT INTO person VALUES (684, 'José Ediardo Chagas da Silva', '2013-09-16 10:09:08', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1972-06-07', NULL, 'single');
INSERT INTO person VALUES (685, 'José Agusto Ribas', '2013-09-16 10:09:09', 1, 'Anita Garibaldi', '', '3002  ', 1, '                ', '                ', '         ', '', '', 'm', '1959-02-08', 24, '');
INSERT INTO person VALUES (686, 'José Vanderlei Vaz', '2013-09-16 10:09:34', 1, 'Agostinho Jorge', '', '20    ', 1, '                ', '                ', '         ', '', '', 'm', '1983-06-20', NULL, 'single');
INSERT INTO person VALUES (687, 'Juliano dos Santos Gonçalves', '2013-09-16 10:09:47', 1, 'São José Fate', '', '1369  ', 1, '(42)_99856402   ', '                ', '         ', '', '', 'm', '1988-05-02', 22, 'single');
INSERT INTO person VALUES (688, 'Jefersom Antonio de Lima', '2013-09-16 10:09:18', 1, '', '', '      ', 1, '                ', '(42)_32364770   ', '         ', '', '', 'm', '1981-06-14', NULL, 'single');
INSERT INTO person VALUES (689, 'João Carlos Nunes da Silva', '2013-09-16 10:09:27', 1, 'Francisco Resental', '', '23    ', 1, '                ', '                ', '         ', '', '', 'm', '1968-07-09', 14, 'single');
INSERT INTO person VALUES (690, 'José Aldo Nascimento', '2013-09-16 10:09:05', 1, 'Helena Silas', '', '178   ', 1, '                ', '                ', '         ', '', '', 'm', '1967-03-01', 7, 'single');
INSERT INTO person VALUES (691, 'Francisco Vilmar dos Santos Marques', '2013-09-16 10:09:28', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1965-10-22', NULL, 'single');
INSERT INTO person VALUES (692, 'Felipe de Paula Oliveira', '2013-09-16 10:09:42', 1, 'Luciano Alves da Silva', '', '31    ', 1, '                ', '                ', '         ', '', '', 'm', '1999-03-18', 9, 'single');
INSERT INTO person VALUES (693, 'Fabine Soares dos Santos', '2013-09-16 10:09:52', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1982-11-27', NULL, 'single');
INSERT INTO person VALUES (694, 'Franco Simõens Dias Lencine Junior', '2013-09-16 10:09:05', 1, 'Colonos', '', '302   ', 1, '(42)98233746    ', '(42)_32250481   ', '         ', '', '', 'm', '1990-04-24', 21, 'single');
INSERT INTO person VALUES (695, 'Fabio José dos Santos', '2013-09-16 10:09:29', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1994-11-06', NULL, 'single');
INSERT INTO person VALUES (696, 'Fabio do Rocio', '2013-09-16 10:09:10', 1, 'Padre antonio', '', '75    ', 1, '                ', '                ', '         ', '', '', 'm', '1985-10-25', 4, 'single');
INSERT INTO person VALUES (697, 'Francisco Ricieri Carneiro', '2013-09-16 11:09:42', 1, 'Cornélio gomes', '', '112   ', 1, '                ', '                ', '         ', '', '', 'm', '1968-09-26', 13, 'married');
INSERT INTO person VALUES (698, 'José Antono Matos', '2013-09-16 11:09:39', 1, 'Certanopolis', '', '61    ', 1, '                ', '                ', '         ', '', '', 'm', '1961-08-19', 6, 'married');
INSERT INTO person VALUES (699, 'José Romulo dos Santos', '2013-09-16 11:09:09', 1, 'Césinha Matos de Souza', '', '04    ', 1, '                ', '                ', '         ', '', '', 'm', '1949-05-25', 29, 'married');
INSERT INTO person VALUES (700, 'João José Evangelista Silva', '2013-09-16 11:09:20', 1, '', '', '      ', 1, '                ', '(33)91403464    ', '         ', '', '', 'm', '1966-09-30', NULL, 'single');
INSERT INTO person VALUES (701, 'Juares Rodrigues', '2013-09-16 11:09:22', 1, '', '', '      ', 2, '                ', '                ', '         ', '', '', 'm', '1963-05-12', NULL, 'single');
INSERT INTO person VALUES (702, 'José Carlos Marques', '2013-09-16 11:09:55', 1, 'Rodrigo Otavio', '', '135   ', 1, '                ', '                ', '         ', '', '', 'm', '1957-03-02', NULL, 'single');
INSERT INTO person VALUES (703, 'João Maria Venancio', '2013-09-16 11:09:29', 1, 'Alfredo Trentim', '', '20    ', 1, '                ', '                ', '         ', '', '', 'm', '1973-09-13', 24, 'single');
INSERT INTO person VALUES (704, 'Jurandir José da Rosa', '2013-09-16 11:09:45', 1, 'Arararuana', '', '8     ', 1, '                ', '                ', '         ', '', '', 'm', '1943-12-22', 3, 'single');
INSERT INTO person VALUES (705, 'José Altair Elias', '2013-09-16 11:09:57', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1976-11-29', NULL, 'married');
INSERT INTO person VALUES (706, 'José Osvaldo Viana do Carmo', '2013-09-16 11:09:23', 1, 'Teodoro Sanpaio', '', '595   ', 1, '(42)99906688    ', '(42)32237556    ', '         ', '', '', 'm', '1975-01-31', 3, 'married');
INSERT INTO person VALUES (707, 'Joao Santos de Lacerda', '2013-09-16 11:09:23', 1, 'Francisco Ribas', '', '1125  ', 1, '                ', '                ', '         ', '', '', 'm', '1961-08-12', 1, 'separated');
INSERT INTO person VALUES (708, 'João Maria de Oliveira', '2013-09-16 11:09:18', 1, '', '', '      ', 12, '                ', '                ', '         ', '', '', 'm', '1964-10-11', NULL, 'separated');
INSERT INTO person VALUES (710, 'Gersom Kelly', '2013-09-16 11:09:18', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'm', '1978-09-15', NULL, 'single');
INSERT INTO person VALUES (711, 'Gustavo Henrique Alves', '2013-09-16 11:09:23', 1, '', '', '      ', 12, '                ', '                ', '         ', '', '', 'm', '1992-04-14', NULL, 'single');
INSERT INTO person VALUES (712, 'Herlysom Bamdeira Maia', '2013-09-17 09:09:47', 1, '12 quadra 8', '', '18    ', 1, '(98)82049229    ', '(98)32323007    ', '         ', '', '', 'm', '1988-08-18', NULL, 'single');
INSERT INTO person VALUES (713, 'Hudsom Nunes da Cruz', '2013-09-17 09:09:45', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1982-01-20', NULL, 'single');
INSERT INTO person VALUES (714, 'Hamilton Soares Sutil', '2013-09-17 09:09:51', 1, 'Sao Jeronimo', '', '55    ', 1, '                ', '                ', '         ', '', '', 'm', '1948-03-14', 19, 'single');
INSERT INTO person VALUES (715, 'Isaias Dopmingos da Silva', '2013-09-17 09:09:44', 1, 'Sousa Dantas', '', '      ', 1, '                ', '                ', '         ', '', '420', 'm', '1995-10-16', 23, 'single');
INSERT INTO person VALUES (716, 'Gustavo Pinheiro da Silva', '2013-09-17 09:09:49', 1, 'Nicolau Frotinjano', '', 'sn    ', 1, '                ', '                ', '         ', '', '', 'm', '1989-01-15', 5, 'single');
INSERT INTO person VALUES (717, 'Gilberto Reis da Silva', '2013-09-17 09:09:18', 1, 'Paes de Andrade', '', '320   ', 1, '                ', '                ', '         ', '', '', 'm', '1973-02-04', 22, 'single');
INSERT INTO person VALUES (718, 'Gersom Soarres da Costa Junior', '2013-09-17 09:09:27', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1988-07-30', NULL, 'married');
INSERT INTO person VALUES (719, 'Gabriel Angelo Pereira Alves', '2013-09-17 09:09:34', 1, 'Lagoa do Bonfim', '', '25    ', 1, '                ', '                ', '         ', '', '', 'm', '1995-02-21', 28, 'single');
INSERT INTO person VALUES (720, 'Gibram Talfic Camargo Elakkari', '2013-09-17 09:09:58', 1, 'Julia Vanderlei', '', '576   ', 1, '(42099035839    ', '                ', '         ', '', '', 'm', '1995-08-02', 1, 'single');
INSERT INTO person VALUES (721, 'Gabriel Wilhian da Silva', '2013-09-17 10:09:05', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2007-04-30', NULL, '');
INSERT INTO person VALUES (722, 'Gaspar Caetano', '2013-09-17 10:09:46', 1, 'Serra da Saudade', '', '32    ', 1, '                ', '                ', '         ', '', '', 'm', '1966-10-02', 15, 'single');
INSERT INTO person VALUES (723, 'Gregorio Fustenbeg Kressom', '2013-09-17 10:09:03', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1973-11-23', NULL, 'separated');
INSERT INTO person VALUES (724, 'Gilsom Nunes Carraro', '2013-09-17 10:09:16', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'm', '1980-12-05', NULL, 'single');
INSERT INTO person VALUES (725, 'Gersom Kelly', '2013-09-17 10:09:31', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1978-07-15', NULL, 'married');
INSERT INTO person VALUES (726, 'Francisco de Jesus Venancio', '2013-09-17 10:09:13', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-17', NULL, '');
INSERT INTO person VALUES (727, 'Fabricio Donizete Nunes', '2013-09-17 10:09:51', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'm', '1979-02-17', NULL, 'single');
INSERT INTO person VALUES (728, 'Francisco dos Reis Filho', '2013-09-17 10:09:34', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-17', NULL, '');
INSERT INTO person VALUES (729, 'Florinal Junir Bueno', '2013-09-17 10:09:41', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-11-09', NULL, '');
INSERT INTO person VALUES (730, 'Iago Junior Schroeder', '2013-09-17 10:09:17', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1992-12-10', 1, 'single');
INSERT INTO person VALUES (731, 'Ivo Sutil Almeida', '2013-09-17 10:09:38', 1, 'Brigadeiro Machado Oliveira', '', '136   ', 1, '                ', '                ', '         ', '', '', 'm', '1982-07-06', 14, 'married');
INSERT INTO person VALUES (732, 'Ismael Roberto Jacky', '2013-09-17 10:09:05', 1, 'Antonio de sá Camargo', '', '11    ', 5, '                ', '                ', '         ', '', '', 'm', '1987-05-18', NULL, 'single');
INSERT INTO person VALUES (733, 'Ivam Fernandes de Almeida', '2013-09-17 10:09:53', 1, 'Julio Perneta', '', '279   ', 1, '                ', '                ', '         ', '', '', 'm', '1990-12-20', 4, 'single');
INSERT INTO person VALUES (734, 'Ivo Cordeiro de Miranda', '2013-09-17 10:09:48', 1, 'Teixeira Mendes', '1834', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1941-07-20', 5, 'widow(er)');
INSERT INTO person VALUES (736, 'Valdemir Ferraz', '2013-09-17 11:09:12', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-10-07', NULL, 'single');
INSERT INTO person VALUES (737, 'Valdir Pinheiro', '2013-09-17 11:09:28', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1982-08-13', NULL, 'single');
INSERT INTO person VALUES (738, 'Valdeir Borges', '2013-09-17 11:09:46', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1977-02-07', NULL, 'single');
INSERT INTO person VALUES (739, 'Vanderlei Aparecidop', '2013-09-17 11:09:00', 1, 'Enfermeiro Paulino', '', '331   ', 1, '                ', '                ', '         ', '', '', 'm', '1982-09-15', 1, 'single');
INSERT INTO person VALUES (740, 'Vandir Soares dos Santos', '2013-09-17 11:09:09', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '0979-01-23', NULL, 'single');
INSERT INTO person VALUES (741, 'Victor Matheu Picolé de Soua', '2013-09-17 11:09:04', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1993-12-12', NULL, 'single');
INSERT INTO person VALUES (742, 'Vitor Jairo de Rosa Lemes', '2013-09-17 11:09:25', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1978-10-16', NULL, 'single');
INSERT INTO person VALUES (743, 'Vicente Luiz Pereira', '2013-09-17 11:09:19', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '19667-11-17', NULL, 'married');
INSERT INTO person VALUES (744, 'Valdecir Lemes Pereira', '2013-09-17 11:09:47', 1, '', '', '      ', 1, '(42)99423710    ', '                ', '         ', '', '', 'm', '1975-08-11', NULL, 'single');
INSERT INTO person VALUES (745, 'Valdeci Antonio de Moraes', '2013-09-17 11:09:46', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1970-06-28', NULL, 'single');
INSERT INTO person VALUES (746, 'Vitor Leo Vitorino Rodrigues', '2013-09-17 11:09:38', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2009-02-15', NULL, 'single');
INSERT INTO person VALUES (747, 'Valdomiro dos Santos Cruz', '2013-09-17 11:09:30', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-17', NULL, 'single');
INSERT INTO person VALUES (748, 'Valdinei Xavier da Silva', '2013-09-17 11:09:33', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1962-10-09', NULL, 'single');
INSERT INTO person VALUES (749, 'Sergio Diego Oliveira', '2013-09-18 09:09:13', 1, '', '', '      ', 12, '                ', '                ', '         ', '', '', 'm', '1986-08-18', NULL, 'single');
INSERT INTO person VALUES (750, 'Tadeu Ribeiro de Lima', '2013-09-18 09:09:02', 1, 'C''canpos Melo', '', '35    ', 1, '                ', '(42)32701115    ', '         ', '', '', 'm', '1980-08-02', 7, 'married');
INSERT INTO person VALUES (751, 'Thiago Barbosa', '2013-09-18 09:09:30', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'm', '1988-11-27', NULL, 'single');
INSERT INTO person VALUES (752, 'Thiago Hannch Muller', '2013-09-18 09:09:20', 1, 'Bento Ribeiro', '', '140   ', 1, '                ', '                ', '         ', '', '', 'm', '1989-07-18', NULL, 'single');
INSERT INTO person VALUES (753, 'Thiago Abreu Silva', '2013-09-18 09:09:55', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1985-12-06', NULL, 'single');
INSERT INTO person VALUES (754, 'Thiago do Carmo', '2013-09-18 09:09:12', 1, 'Vereador Raul', '', '3     ', 1, '                ', '                ', '         ', '', '', 'm', '1991-09-02', 24, 'single');
INSERT INTO person VALUES (755, 'Leandro MartinsFerreira', '2013-09-18 09:09:45', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1982-04-12', NULL, 'single');
INSERT INTO person VALUES (756, 'Thiago Hemrique Gonçalves de Lima', '2013-09-18 09:09:12', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1989-11-06', NULL, 'single');
INSERT INTO person VALUES (757, 'Valdir Dias Rodrigues', '2013-09-18 09:09:16', 1, '', '', '      ', 5, '                ', '                ', '         ', '', '', 'm', '1978-01-12', NULL, 'married');
INSERT INTO person VALUES (758, 'Victor Mtheus Ribeiro da Silva', '2013-09-18 09:09:43', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1994-05-26', NULL, 'single');
INSERT INTO person VALUES (759, 'Valdemar Ribeiro Meira', '2013-09-18 09:09:39', 1, 'Luiz Noveski', '', '74    ', 1, '                ', '                ', '         ', '', '', 'm', '1981-07-22', 16, 'single');
INSERT INTO person VALUES (760, 'Valdinei de Oliveira Leiria', '2013-09-18 09:09:16', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1982-01-22', NULL, 'single');
INSERT INTO person VALUES (761, 'Vanderlei Moreira', '2013-09-18 09:09:51', 1, 'Julio Perneta', '', '3     ', 1, '                ', '                ', '         ', '', '', 'm', '1985-09-10', 23, 'single');
INSERT INTO person VALUES (762, 'Vicente Luiz Pereira', '2013-09-18 09:09:42', 1, '', '', '      ', 1, '(42)99933146    ', '                ', '         ', '', '', 'm', '1967-11-17', NULL, 'separated');
INSERT INTO person VALUES (763, 'Valmir Marques dos Santos', '2013-09-18 09:09:00', 1, 'Jacobe Michel', '', '164   ', 1, '                ', '                ', '         ', '', '', 'm', '1960-08-28', 14, 'single');
INSERT INTO person VALUES (764, 'Sandro Gonçalves de Paula', '2013-09-18 10:09:21', 1, 'Plinio Cesaroti', '', '338   ', 1, '(42)91121091    ', '                ', '         ', '', '', 'm', '1977-04-03', 14, 'stable union');
INSERT INTO person VALUES (765, 'Samuel Salatiel  da Costa', '2013-09-18 10:09:31', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'm', '1967-11-14', NULL, 'single');
INSERT INTO person VALUES (766, 'Saulo Nogueira', '2013-09-18 10:09:25', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1953-10-19', NULL, 'married');
INSERT INTO person VALUES (767, 'Sidnei Batista de Oliveira', '2013-09-18 10:09:31', 1, '', '', '      ', 1, '(42)99875977    ', '                ', '         ', '', '', 'm', '1977-07-17', NULL, 'single');
INSERT INTO person VALUES (768, 'Sergio Vilar  Jacintho', '2013-09-18 10:09:14', 1, 'Euzébio de Gueiroz', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1965-02-02', 5, 'separated');
INSERT INTO person VALUES (769, 'Sebastião Pontes Pereira', '2013-09-18 10:09:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1988-09-26', NULL, 'single');
INSERT INTO person VALUES (770, 'Sergio Moreira', '2013-09-18 10:09:55', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1982-05-13', NULL, '');
INSERT INTO person VALUES (771, 'Sideval Barbosa da Rosa', '2013-09-18 10:09:11', 1, 'Visconde Araguaia', '', '1151  ', 1, '                ', '                ', '         ', '', '', 'm', '1990-12-12', 27, 'single');
INSERT INTO person VALUES (772, 'Saint-Clair de Lima', '2013-09-18 10:09:29', 1, 'rua 11', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '1979-09-07', 4, 'single');
INSERT INTO person VALUES (773, 'Sandro Luiz Lemes Teixeira', '2013-09-18 10:09:59', 1, 'Marcilio Mezomo', '', '4     ', 1, '                ', '                ', '         ', '', '', 'm', '1978-05-09', 7, 'single');
INSERT INTO person VALUES (774, 'Sidnei AndreTA', '2013-09-18 10:09:41', 1, 'Sila Sales', '', '366   ', 1, '                ', '                ', '         ', '', '', 'm', '1975-07-03', 7, 'single');
INSERT INTO person VALUES (775, 'Silmar Ferreira', '2013-09-18 10:09:44', 1, 'Paulo Nadal', '', '197   ', 1, '                ', '                ', '         ', '', '', 'm', '1991-01-23', 17, 'stable union');
INSERT INTO person VALUES (776, 'Sidnei do Nascimento', '2013-09-18 11:09:32', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-09-04', NULL, 'single');
INSERT INTO person VALUES (777, 'Segio Rodrigues Batista', '2013-09-18 11:09:38', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1967-12-14', NULL, 'widow(er)');
INSERT INTO person VALUES (778, 'Santiago Blanc Gonçalves', '2013-09-18 11:09:42', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1996-05-12', NULL, 'single');
INSERT INTO person VALUES (779, 'Robsom Machado Olinek', '2013-09-18 11:09:00', 1, 'Raul Alberto de Oliveira', '', '1441  ', 1, '                ', '                ', '         ', '', '', 'm', '1991-10-04', 7, 'single');
INSERT INTO person VALUES (780, 'Rene Carneiro', '2013-09-18 11:09:30', 1, 'Julio Perneta', '', '557   ', 1, '                ', '                ', '         ', '', '', 'm', '1965-12-22', 4, 'single');
INSERT INTO person VALUES (781, 'Renato Ribeiro dos Santos', '2013-09-18 11:09:46', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1993-11-09', NULL, 'single');
INSERT INTO person VALUES (782, 'Rogerio Camargo', '2013-09-18 11:09:21', 1, 'Bitencout Sanpaio', '', '346   ', 1, '                ', '                ', '         ', '', '', 'm', '1985-01-11', 22, 'single');
INSERT INTO person VALUES (783, 'Rafael Maciel Martins', '2013-09-18 11:09:34', 1, '', '', '      ', 1, '(42)88439198    ', '                ', '         ', '', '', 'm', '1983-09-21', NULL, 'single');
INSERT INTO person VALUES (784, 'Robsom de Oliveira Santiago', '2013-09-18 11:09:42', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1987-02-02', NULL, 'single');
INSERT INTO person VALUES (785, 'Rodrigo Mendes Oliveira Silva', '2013-09-18 11:09:57', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1986-05-13', NULL, 'single');
INSERT INTO person VALUES (786, 'Reinaldo Glusczka', '2013-09-18 11:09:53', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1981-07-14', NULL, 'single');
INSERT INTO person VALUES (787, 'Rafael Machado Olinek', '2013-09-18 11:09:50', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1993-08-16', NULL, 'single');
INSERT INTO person VALUES (788, 'Sergio Olinek', '2013-09-18 11:09:50', 1, 'Apucarana', '', '88    ', 1, '                ', '                ', '         ', '', '', 'm', '1968-01-30', 7, 'single');
INSERT INTO person VALUES (789, 'Saulo Vinicius Martins', '2013-09-18 11:09:37', 1, 'Algusto Faria da Rocha', '', '202   ', 1, '                ', '                ', '         ', '', '', 'm', '1981-07-11', 4, 'married');
INSERT INTO person VALUES (790, 'Sebastião Xavier do Prado', '2013-09-18 11:09:37', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1961-04-24', NULL, 'married');
INSERT INTO person VALUES (791, 'Ronaldo dos Santos Marques', '2013-09-18 13:09:09', 1, 'Aide Madureira', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1998-03-22', 14, 'single');
INSERT INTO person VALUES (792, 'Reginaldo Fogaça dos  Santos', '2013-09-18 13:09:32', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-18', NULL, 'single');
INSERT INTO person VALUES (793, 'Robsom Geraldo Guilay', '2013-09-18 13:09:22', 1, '', '', '      ', 1, '                ', '(42)322241162   ', '         ', '', '', 'm', '1970-08-28', NULL, 'single');
INSERT INTO person VALUES (794, 'Roberto César Pinheiro', '2013-09-18 13:09:55', 1, 'Arero Romam Batista', '', '2     ', 1, '                ', '                ', '         ', '', '', 'm', '1980-07-02', 21, 'single');
INSERT INTO person VALUES (795, 'Raul Dias Nogueira', '2013-09-18 13:09:08', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1994-10-05', NULL, 'single');
INSERT INTO person VALUES (796, 'Rodrigo Apafecido Machado Cruz', '2013-09-18 13:09:04', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'm', '1983-12-26', NULL, 'single');
INSERT INTO person VALUES (797, 'Reinaldo Aparecido de Lima', '2013-09-18 13:09:36', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1969-09-23', 9, 'single');
INSERT INTO person VALUES (798, 'Rodrigo dos Santos Marques', '2013-09-18 13:09:49', 1, 'Isaias da Luz', '', '26    ', 1, '                ', '                ', '         ', '', '', 'm', '1994-11-06', 14, 'single');
INSERT INTO person VALUES (799, 'Rogério Rodrigues', '2013-09-18 14:09:52', 1, 'Cesario Alves', '', '500   ', 1, '                ', '                ', '         ', '', '', 'm', '1962-09-07', 9, 'separated');
INSERT INTO person VALUES (800, 'Ronaldo da Anunciação simõens', '2013-09-19 09:09:34', 1, 'Riachao', '', '1452  ', 1, '(79)91317502    ', '(79)92221411    ', '         ', '', '', 'm', '1973-11-15', NULL, 'single');
INSERT INTO person VALUES (801, 'Rubens Marcio Soares Pinheiro', '2013-09-19 09:09:50', 1, '', '', '      ', 9, '                ', '                ', '         ', '', '', 'm', '1968-10-15', NULL, 'separated');
INSERT INTO person VALUES (802, 'Rodrigo Diogo de Almeida Martins', '2013-09-19 09:09:02', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-11-09', 25, 'single');
INSERT INTO person VALUES (803, 'Rodrigo Aparecido Machado', '2013-09-19 09:09:47', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'm', '1983-12-26', NULL, 'single');
INSERT INTO person VALUES (804, 'Reinaldo Duarte', '2013-09-19 09:09:31', 1, 'Felipe Karam', '', '415   ', 1, '                ', '                ', '         ', '', '', 'm', '1978-09-03', 7, 'single');
INSERT INTO person VALUES (806, 'Roberto Savicski', '2013-09-19 09:09:48', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1965-10-26', NULL, 'single');
INSERT INTO person VALUES (807, 'Rodrigo Machado Alves', '2013-09-19 09:09:16', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'm', '1981-07-18', NULL, 'single');
INSERT INTO person VALUES (808, 'Rodrigo Santos Marques', '2013-09-19 09:09:59', 1, 'João Ditzzel', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1994-01-06', 14, 'single');
INSERT INTO person VALUES (810, 'Rudilei Miguel de Oliveira Fereira', '2013-09-19 09:09:08', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'm', '1985-06-08', NULL, 'single');
INSERT INTO person VALUES (811, 'Renato Eliel Ribeiro da Silva', '2013-09-19 09:09:45', 1, 'Antonio Saade', '', '65    ', 1, '                ', '                ', '         ', '', '', 'm', '1984-12-09', 14, 'single');
INSERT INTO person VALUES (812, 'Rubens Bahls de Almeida', '2013-09-19 09:09:35', 1, 'Acacio Negro', '', '305   ', 1, '                ', '                ', '         ', '', '', 'm', '1989-05-07', 22, 'single');
INSERT INTO person VALUES (814, 'Ruamn Domingues da Silva', '2013-09-19 09:09:27', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-11-09', NULL, 'single');
INSERT INTO person VALUES (815, 'Fabiano Santos Valdarski', '2013-09-19 09:09:29', 1, 'rua 4', '', '      ', 1, '(42)99420197    ', '(42)99986620    ', '         ', '', '', 'm', '1981-12-17', 29, 'single');
INSERT INTO person VALUES (816, 'Ubiratam Morais', '2013-09-19 09:09:04', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1968-03-01', NULL, 'single');
INSERT INTO person VALUES (817, 'Rodrigo Ramos De Lara', '2013-09-19 10:09:20', 1, 'Dario Velozo', '', '885   ', 1, '                ', '                ', '         ', '', '', 'm', '1987-11-24', 13, 'single');
INSERT INTO person VALUES (818, 'Marcos Ubirajara da Silva', '2013-09-19 10:09:22', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1978-11-26', NULL, 'separated');
INSERT INTO person VALUES (819, 'Marcio Roberto Meira Santos', '2013-09-19 10:09:17', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1975-05-02', NULL, 'single');
INSERT INTO person VALUES (820, 'Marcelo Gabriel de Oliveira Andrade', '2013-09-19 10:09:57', 1, '', '', '      ', 1, '                ', '(42)322269168   ', '         ', '', '', 'm', '1966-12-25', NULL, 'single');
INSERT INTO person VALUES (821, 'Marcio Cristiano Teixeira', '2013-09-19 10:09:49', 1, 'Sousa Dantas', '', '309   ', 1, '                ', '                ', '         ', '', '', 'm', '1975-06-01', 24, '');
INSERT INTO person VALUES (822, 'Marcos Alexandre Schultz Mendes', '2013-09-19 10:09:29', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1993-08-19', NULL, 'single');
INSERT INTO person VALUES (823, 'Moises Leonel Pedroso', '2013-09-19 10:09:52', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1982-07-05', NULL, 'single');
INSERT INTO person VALUES (824, 'Marta de Oliveira Torino', '2013-09-27 09:09:00', 1, 'Garoupa', '', '316   ', 1, '                ', '                ', '         ', '', '', 'f', '1985-04-14', 19, 'married');
INSERT INTO person VALUES (825, 'Micaele de Oliveira', '2013-09-27 09:09:13', 1, 'Nelsom Narciso Ritiato', '', '12    ', 1, '                ', '                ', '         ', '', '', 'f', '2004-11-14', 5, 'single');
INSERT INTO person VALUES (826, 'Monalisa Jenifer Nascimento', '2013-09-27 09:09:34', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1994-11-11', NULL, 'single');
INSERT INTO person VALUES (827, 'Monaliza Nogueira Pereira', '2013-09-27 09:09:47', 1, 'Penteado de  Almeida', '', '9     ', 2, '                ', '                ', '         ', '', '', 'm', '1988-12-30', NULL, 'single');
INSERT INTO person VALUES (828, 'Nancy Aparecida de  Meira', '2013-09-27 09:09:29', 1, 'Rua 21', '', '1     ', 1, '                ', '                ', '         ', '', '', 'f', '1970-01-03', 5, 'single');
INSERT INTO person VALUES (829, 'Valdeniro Sebastiao Ribeiro', '2013-09-27 09:09:03', 1, 'Bela vista do Paraiso', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-27', NULL, 'single');
INSERT INTO person VALUES (830, 'Tiago dos Sants', '2013-09-30 09:09:56', 1, '', '', '      ', 10, '                ', '                ', '         ', '', '', 'm', '1994-12-02', NULL, 'single');
INSERT INTO person VALUES (831, 'Thiago de Freitas de Sa', '2013-09-30 09:09:06', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1997-08-11', NULL, 'single');
INSERT INTO person VALUES (832, 'Sérgio Olinek', '2013-09-30 09:09:41', 1, 'Rua Apucarana', '', '44    ', 1, '                ', '                ', '         ', '', '', 'm', '1968-01-30', 31, 'single');
INSERT INTO person VALUES (833, 'Renato Ramires Ribeiro', '2013-09-30 09:09:57', 1, '', '', '      ', 19, '                ', '                ', '         ', '', '', 'm', '1988-01-01', NULL, 'single');
INSERT INTO person VALUES (834, 'Marilaine da Silva Motel', '2013-09-30 09:09:57', 1, 'Madureira', '', '76    ', 1, '                ', '                ', '         ', '', '', 'm', '1993-02-15', 14, 'single');
INSERT INTO person VALUES (835, 'Ricardo Gomes de freitas', '2013-09-30 09:09:09', 1, 'Pirai do Sul', '', '121   ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-30', 32, 'single');
INSERT INTO person VALUES (836, 'Romario Vaz', '2013-09-30 09:09:52', 1, 'Lucélio Alves da Silva', '', '33    ', 1, '                ', '                ', '         ', '', '', 'm', '1995-04-18', 33, 'single');
INSERT INTO person VALUES (837, 'Vitor de Oliveira', '2013-09-30 09:09:38', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2009-04-22', 34, 'single');
INSERT INTO person VALUES (838, 'Virmonde Adriano Cordeiro', '2013-09-30 09:09:15', 1, 'Alvaro Alvim', '', '664   ', 1, '                ', '                ', '         ', '', '', 'm', '1945-09-17', 4, 'married');
INSERT INTO person VALUES (839, 'Vinicius Silva Rosa', '2013-09-30 09:09:45', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-11-09', 35, 'single');
INSERT INTO person VALUES (840, 'Victrer Manoel M,Souza', '2013-09-30 09:09:16', 1, 'Kliper', '', '410   ', 1, '                ', '                ', '         ', '', '', 'm', '2004-01-12', 33, 'single');
INSERT INTO person VALUES (813, 'Rogério Rosa de Paula', '2013-09-19 09:09:03', 1, '', '', '      ', 2, '                ', '                ', '         ', '', '', 'm', '1981-02-27', NULL, 'single');
INSERT INTO person VALUES (809, 'Rogério Marconatti', '2013-09-19 09:09:42', 1, 'Esteve Martins', '', '      ', 1, '                ', '(42)36753071    ', '         ', '', '', 'm', '1983-03-19', 1, 'single');
INSERT INTO person VALUES (841, 'Valdinei da Silva Borges', '2013-09-30 09:09:09', 1, 'Marcilo Luiz Mezomo', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1994-11-30', 7, 'single');
INSERT INTO person VALUES (842, 'Valdinei Moreira', '2013-09-30 09:09:51', 1, 'Julio Perneta', '', '299   ', 1, '                ', '                ', '         ', '', '', 'm', '1987-10-19', 23, 'single');
INSERT INTO person VALUES (843, 'Rosaldo Ribas', '2013-09-30 10:09:59', 1, 'Lucio Alves Da Silva', '', '31    ', 1, '                ', '                ', '         ', '', '', 'm', '1970-08-10', 33, 'single');
INSERT INTO person VALUES (844, 'Sandro Luiz M. Teixeira', '2013-09-30 10:09:31', 1, '', '', '      ', 1, '                ', '(42)32362931    ', '         ', '', '', 'm', '2013-01-30', 7, 'single');
INSERT INTO person VALUES (846, 'Roseval De Andrade', '2013-09-30 10:09:06', 1, 'Rep. do Panama', '', '771   ', 1, '                ', '                ', '         ', '', '', 'm', '1968-07-15', 20, 'single');
INSERT INTO person VALUES (847, 'Andressa De Lima de Paula', '2013-09-30 10:09:54', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2013-01-30', NULL, '');
INSERT INTO person VALUES (848, 'Caroline dos Santos', '2013-09-30 10:09:34', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2013-01-30', NULL, '');
INSERT INTO person VALUES (849, 'Ygor de Andrade Vaz', '2013-09-30 10:09:31', 1, 'Lucio Alves da Silva', '', '33    ', 1, '                ', '                ', '         ', '', '', 'm', '1998-12-26', 33, 'single');
INSERT INTO person VALUES (850, 'Wilsom Grziebeluka', '2013-09-30 10:09:53', 1, 'Francisco Ribas', '', '1125  ', 1, '                ', '                ', '         ', '', '', 'm', '1960-07-30', 1, 'separated');
INSERT INTO person VALUES (851, 'Wilsom Geraldo Ferreira Santos', '2013-09-30 10:09:19', 1, 'Afonço Sriros', '', '52    ', 1, '                ', '                ', '         ', '', '', 'm', '1972-03-23', 1, 'single');
INSERT INTO person VALUES (852, 'Wiliam A.M', '2013-09-30 10:09:17', 1, 'Manoel Marques', '', '809   ', 1, '                ', '                ', '         ', '', '', 'm', '2007-05-26', 13, 'single');
INSERT INTO person VALUES (853, 'Weslei Vicente Barbosa', '2013-09-30 10:09:53', 1, 'Artilho Gardinal', '', '444   ', 1, '                ', '                ', '         ', '', '', 'm', '1987-12-24', 35, 'single');
INSERT INTO person VALUES (854, 'Wesley Luam Jakinso Machado', '2013-09-30 10:09:39', 1, 'Rua do Xisto', '', '149   ', 1, '                ', '                ', '         ', '', '', 'm', '1998-11-28', 36, 'single');
INSERT INTO person VALUES (855, 'Welintom Padilha da Silva', '2013-09-30 10:09:52', 1, 'Jaguapita/ Fundos', '', '41    ', 1, '                ', '                ', '         ', '', '', 'm', '2003-07-06', 31, 'single');
INSERT INTO person VALUES (856, 'Wendel Aleff Margenstein', '2013-09-30 10:09:07', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-30', NULL, 'single');
INSERT INTO person VALUES (857, 'Walber Douglas A Ripardo', '2013-09-30 10:09:44', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '19986-05-05', NULL, 'single');
INSERT INTO person VALUES (858, 'Viviliana Padilha da Silva', '2013-09-30 10:09:01', 1, 'João Pereira de Oliveira', '', '197   ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-30', 35, 'single');
INSERT INTO person VALUES (859, 'Maria Tereza Amaro', '2013-09-30 10:09:22', 1, 'Alfredo Justus', '', '67    ', 1, '                ', '                ', '         ', '', '', 'm', '1944-12-06', 21, 'married');
INSERT INTO person VALUES (860, 'Noemi dos Santos', '2013-09-30 10:09:46', 1, 'Cleber Justus', '', '414   ', 1, '                ', '                ', '         ', '', '', 'f', '1948-08-13', 20, 'married');
INSERT INTO person VALUES (861, 'Pamela Karine de Lima', '2013-09-30 10:09:41', 1, 'Madureira', '', '76    ', 1, '                ', '                ', '         ', '', '', 'f', '1984-08-07', 14, 'stable union');
INSERT INTO person VALUES (862, 'Paola Maiara de Jesus', '2013-09-30 10:09:52', 1, 'Brasil pARA Cristo', '', '168   ', 1, '                ', '                ', '         ', '', '', 'm', '2001-04-26', 16, '');
INSERT INTO person VALUES (863, 'Patriocia Aparecida de Jesus', '2013-09-30 11:09:15', 1, 'Brasil Para Cristo', '', '168   ', 1, '                ', '                ', '         ', '', '', 'f', '1984-10-22', 37, 'married');
INSERT INTO person VALUES (864, 'Ramayane Xavier B Porto', '2013-09-30 11:09:48', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1992-10-02', NULL, 'single');
INSERT INTO person VALUES (865, 'Raiane Maiara Bruno dos Santos', '2013-09-30 11:09:48', 1, 'Barbosa Lima', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2004-04-11', 23, 'single');
INSERT INTO person VALUES (866, 'Guilerme William Lacerda', '2013-09-30 11:09:39', 1, 'Barboza Lima', '', '97    ', 1, '                ', '                ', '         ', '', '', 'm', '1993-07-07', 19, 'single');
INSERT INTO person VALUES (867, 'Guilerme Lourenço De Souza', '2013-09-30 11:09:32', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1982-12-10', NULL, '');
INSERT INTO person VALUES (868, 'Geraldo Amaro', '2013-09-30 11:09:08', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-30', NULL, '');
INSERT INTO person VALUES (869, 'Geovane Martins', '2013-09-30 11:09:38', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1993-08-30', 24, '');
INSERT INTO person VALUES (870, 'Evertom Luiz Ferreira', '2013-10-01 09:10:23', 1, 'Dona rita', '', '913   ', 1, '                ', '                ', '         ', '', '', 'm', '1984-05-05', 35, 'single');
INSERT INTO person VALUES (871, 'Fabiano Santos V. Uvar', '2013-10-01 09:10:50', 1, 'rua 7', '', '143   ', 1, '                ', '                ', '         ', '', '', 'm', '1961-04-07', 29, 'single');
INSERT INTO person VALUES (872, 'Felipe Gabriel Francisco', '2013-10-01 09:10:47', 1, 'Lucio Alves da Silva', '', '31    ', 1, '                ', '                ', '         ', '', '', 'm', '1970-08-10', 33, 'single');
INSERT INTO person VALUES (873, 'Fagner Barbosa', '2013-10-01 09:10:55', 1, 'Evaristo da Veiga', '', '97    ', 1, '                ', '                ', '         ', '', '', 'm', '1991-07-20', 23, 'single');
INSERT INTO person VALUES (874, 'Felisbino Jansem', '2013-10-01 09:10:23', 1, 'Teixeira de Freitas', '', '1     ', 1, '                ', '                ', '         ', '', '', 'm', '1950-03-28', 29, 'single');
INSERT INTO person VALUES (875, 'Fernando Vargas', '2013-10-01 09:10:31', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1976-03-17', 23, 'single');
INSERT INTO person VALUES (876, 'Isaque Cristiano', '2013-10-01 09:10:12', 1, '', '', '      ', 3, '                ', '                ', '         ', '', '', 'm', '1978-08-18', NULL, 'single');
INSERT INTO person VALUES (877, 'Israel Fernandes Dos Santos', '2013-10-01 09:10:38', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1963-06-26', NULL, 'married');
INSERT INTO person VALUES (878, 'Isaias de Jesus borges', '2013-10-01 10:10:26', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-01', NULL, '');
INSERT INTO person VALUES (879, 'Igor Rosa', '2013-10-01 10:10:52', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1971-12-27', NULL, 'married');
INSERT INTO person VALUES (880, 'Hendersom Linhares de Abreu', '2013-10-01 10:10:37', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-01', NULL, '');
INSERT INTO person VALUES (881, 'Helintom Isaque Gomes', '2013-10-01 10:10:30', 1, 'Teodoro Kippel', '', '40    ', 1, '                ', '                ', '         ', '', '', 'm', '1993-08-07', 33, 'single');
INSERT INTO person VALUES (882, 'Joao Carlos Pereira', '2013-10-01 10:10:24', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1982-10-09', NULL, 'single');
INSERT INTO person VALUES (883, 'Jefersom Silvério', '2013-10-01 10:10:47', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1977-05-05', NULL, 'single');
INSERT INTO person VALUES (884, 'Jefersom Torquato', '2013-10-01 10:10:46', 1, 'Duarte Ronda', '', '510   ', 1, '                ', '                ', '         ', '', '', 'm', '1961-10-16', 20, 'widow(er)');
INSERT INTO person VALUES (885, 'Jefersom Osni de Souza', '2013-10-01 10:10:14', 1, 'rua 7 de setenbro', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1981-05-20', 1, 'single');
INSERT INTO person VALUES (886, 'josé  Ranuldo dos Santos', '2013-10-01 10:10:07', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1949-05-27', NULL, 'single');
INSERT INTO person VALUES (887, 'Luciano Gonsalves', '2013-10-01 10:10:35', 1, 'Senador Afonso Camargo', '', '5     ', 1, '                ', '                ', '         ', '', '', 'f', '1983-08-21', 13, 'single');
INSERT INTO person VALUES (888, 'Luciane Aparecida Pasturzak', '2013-10-01 10:10:42', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1962-06-15', NULL, 'married');
INSERT INTO person VALUES (889, 'Ivaldo dos Santos', '2013-10-01 10:10:12', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1976-06-16', NULL, 'single');
INSERT INTO person VALUES (890, 'Vilmara Mazedika', '2013-10-01 10:10:28', 1, 'Manoel Marques', '', '809   ', 1, '                ', '                ', '         ', '', '', 'f', '1990-07-16', 13, 'single');
INSERT INTO person VALUES (891, 'Wagner Pires de Andrade', '2013-10-01 10:10:06', 1, 'Carvalho', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '1988-11-09', 21, 'separated');
INSERT INTO person VALUES (892, 'Wilsom Rafael de Araujo Ferreira', '2013-10-01 11:10:59', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-07-26', NULL, 'single');
INSERT INTO person VALUES (893, 'Pedro Reinaldo Pires', '2013-10-01 11:10:31', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1966-06-29', NULL, 'married');
INSERT INTO person VALUES (894, 'Patricia de Jesus Rodriquues', '2013-10-01 11:10:47', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1983-06-02', NULL, 'married');
INSERT INTO person VALUES (895, 'Osni Mendes', '2013-10-01 11:10:43', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1963-09-29', 24, 'single');
INSERT INTO person VALUES (896, 'Osni Martins de oliveira', '2013-10-01 11:10:39', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1982-12-19', NULL, 'single');
INSERT INTO person VALUES (897, 'Eversom Luiz Becher', '2013-10-02 08:10:41', 1, 'rua 6', '', '136   ', 1, '                ', '                ', '         ', '', '', 'm', '1969-09-24', 11, 'single');
INSERT INTO person VALUES (898, 'Eversom Marks de Oliveira', '2013-10-02 09:10:43', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1977-03-13', NULL, 'married');
INSERT INTO person VALUES (899, 'Hamltom F. Rodrigues', '2013-10-02 09:10:33', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-02', NULL, 'single');
INSERT INTO person VALUES (900, 'Hamiltom Soares Sutil', '2013-10-02 09:10:23', 1, 'rua 5', '', '6     ', 1, '                ', '                ', '         ', '', '', 'm', '1948-03-14', 23, 'single');
INSERT INTO person VALUES (901, 'Joao Lucas Leandro', '2013-10-02 09:10:48', 1, 'Julio Perneta', '', '290   ', 1, '                ', '                ', '         ', '', '', 'm', '1997-06-16', 23, 'single');
INSERT INTO person VALUES (902, 'Hamiltom Sezar Barbosa', '2013-10-02 09:10:07', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1976-11-11', NULL, 'single');
INSERT INTO person VALUES (903, 'Joao Maria de Sousa', '2013-10-02 09:10:49', 1, 'R. Castro', '', '321   ', 1, '                ', '                ', '         ', '', '', 'm', '1967-10-11', 32, '');
INSERT INTO person VALUES (904, 'João Dos Santos', '2013-10-02 09:10:30', 1, 'Rua 5', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1937-04-05', 28, 'married');
INSERT INTO person VALUES (905, 'Joel Silva Rauche', '2013-10-02 09:10:45', 1, 'Jaguapita', '', '42    ', 1, '                ', '                ', '         ', '', '', 'm', '1997-12-10', 31, 'single');
INSERT INTO person VALUES (906, 'Jonathan Taques Mansani', '2013-10-02 09:10:40', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1999-05-25', NULL, 'single');
INSERT INTO person VALUES (907, 'Jonatham Luiz Nascimento', '2013-10-02 09:10:39', 1, 'Teodoro Klupel', '', '408   ', 1, '                ', '                ', '         ', '', '', 'm', '1997-02-11', 33, 'single');
INSERT INTO person VALUES (908, 'Jonas Pefreira', '2013-10-02 09:10:21', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1989-07-02', NULL, 'single');
INSERT INTO person VALUES (909, 'Joao Lucio Alves Da Silva', '2013-10-02 10:10:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1954-05-16', NULL, 'single');
INSERT INTO person VALUES (910, 'Jose Ailsom de Oliveira', '2013-10-02 10:10:53', 1, 'Cascavel', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1979-06-24', 16, 'single');
INSERT INTO person VALUES (911, 'José Dirceu Pires', '2013-10-02 10:10:59', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-02', NULL, 'single');
INSERT INTO person VALUES (912, 'José Eduardo Chagas da Silva', '2013-10-02 10:10:02', 1, '', '', '      ', 12, '                ', '                ', '         ', '', '', 'm', '1972-06-07', NULL, 'single');
INSERT INTO person VALUES (913, 'Jose Valdevino Rodriques', '2013-10-02 10:10:42', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1969-10-27', NULL, 'single');
INSERT INTO person VALUES (914, 'Jose Padilha', '2013-10-02 11:10:24', 1, 'Cornelio de Geus', '', '9     ', 1, '                ', '                ', '         ', '', '', 'm', '1966-01-26', 29, 'single');
INSERT INTO person VALUES (915, 'Juliano Manoel Moreira', '2013-10-02 11:10:36', 1, 'Julio Perneta', '', '4     ', 1, '                ', '                ', '         ', '', '', 'm', '1994-05-16', 23, 'single');
INSERT INTO person VALUES (916, 'Julio Carlos Vian do Carmo', '2013-10-02 11:10:36', 1, 'Rua Pará', '', '365   ', 1, '                ', '                ', '         ', '', '', 'm', '1960-06-02', 33, 'married');
INSERT INTO person VALUES (917, 'Julio Sesar da Silva', '2013-10-02 13:10:30', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1985-07-15', NULL, 'single');
INSERT INTO person VALUES (918, 'Leandro Alam Sheiffer', '2013-10-02 13:10:57', 1, 'Beijamim Franklim', '', '81    ', 1, '                ', '                ', '         ', '', '', 'm', '1994-12-27', 33, 'single');
INSERT INTO person VALUES (919, 'Leandro Kauê de Oliveira', '2013-10-02 14:10:38', 1, 'Julio Perneta', '', '250   ', 1, '                ', '                ', '         ', '', '', 'm', '2000-05-22', 23, 'single');
INSERT INTO person VALUES (920, 'Leandro Gomes de Paula', '2013-10-02 14:10:13', 1, 'Teodoro kluppel', '', '8     ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-02', 33, 'single');
INSERT INTO person VALUES (921, 'Liberato de Oliveira', '2013-10-02 14:10:12', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-02', NULL, 'single');
INSERT INTO person VALUES (922, 'Lourival de Jesus Rodrigues', '2013-10-02 14:10:00', 1, 'Bela vista do Paraiso', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-02', 16, 'single');
INSERT INTO person VALUES (923, 'Lourival Martins', '2013-10-02 14:10:15', 1, '', '', '      ', 3, '                ', '                ', '         ', '', '', 'm', '1964-12-26', NULL, 'single');
INSERT INTO person VALUES (924, 'Luciano Emidio Vieria', '2013-10-02 14:10:56', 1, 'Cristino Justus', '', 'S/N   ', 1, '                ', '                ', '         ', '', '', 'm', '1980-09-20', 7, 'single');
INSERT INTO person VALUES (925, 'Luiz  Gabriel Gonçalves Lemes', '2013-10-02 14:10:23', 1, 'Pedro francisco', '', '10    ', 1, '                ', '                ', '         ', '', '', 'm', '2006-02-07', 35, 'single');
INSERT INTO person VALUES (926, 'Luiz Algusto da Silva', '2013-10-02 14:10:02', 1, 'Haiti', '', 'fd/123', 1, '                ', '                ', '         ', '', '', 'm', '1975-05-09', 5, 'single');
INSERT INTO person VALUES (927, 'Luiz Fernades Munosk', '2013-10-02 14:10:29', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1961-07-29', NULL, 'married');
INSERT INTO person VALUES (928, 'Maicom Rodrigo Lemes', '2013-10-02 14:10:15', 1, 'Vila Margarida', '', '8     ', 1, '                ', '                ', '         ', '', '', 'm', '1993-09-29', 35, 'single');
INSERT INTO person VALUES (929, 'Manrcelo Ferreira', '2013-10-02 14:10:31', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1979-06-18', NULL, 'single');
INSERT INTO person VALUES (930, 'Marcelo Rodrigues dos Santos', '2013-10-02 15:10:40', 1, 'Paz de Andrade', '', '540   ', 1, '                ', '                ', '         ', '', '', 'm', '1987-07-28', 20, 'single');
INSERT INTO person VALUES (931, 'Marcelo da Luz Pinto', '2013-10-02 15:10:37', 1, 'Paulo Grote', '', '19    ', 1, '                ', '                ', '         ', '', '', 'm', '1980-02-22', 7, 'single');
INSERT INTO person VALUES (932, 'Maicom Rodrigo Mendes Gonçalves', '2013-10-02 15:10:46', 1, 'Anita Garibaldi s/n', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '1993-09-29', 35, 'single');
INSERT INTO person VALUES (933, 'Mario Adriano Maciel Lourenço', '2013-10-02 15:10:06', 1, 'Haiti', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '1981-05-11', 23, 'single');
INSERT INTO person VALUES (934, 'Luiz Antonio Barbosa', '2013-10-02 15:10:34', 1, '', '', '      ', 17, '                ', '                ', '         ', '', '', 'm', '1968-06-10', NULL, 'single');
INSERT INTO person VALUES (935, 'Adriano Castro', '2013-10-02 15:10:04', 1, 'Alfredo Kepper', '', '70    ', 1, '                ', '                ', '         ', '', '', 'm', '1975-05-13', 4, 'single');
INSERT INTO person VALUES (936, 'Ari Jakelim', '2013-10-02 15:10:13', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1968-06-13', NULL, 'single');
INSERT INTO person VALUES (937, 'Algostinho Sebastião Ferreira da Silva', '2013-10-02 15:10:09', 1, 'Navegador Ernani', '', '31    ', 1, '                ', '                ', '         ', '', '', 'm', '1960-02-14', 4, 'single');
INSERT INTO person VALUES (938, 'Antonio Roberto Rodrigues', '2013-10-02 15:10:58', 1, 'César Alvim', '', '137   ', 1, '                ', '                ', '         ', '', '', 'm', '1960-04-14', 33, 'single');
INSERT INTO person VALUES (939, 'Amanda Ribeiro', '2013-10-02 15:10:21', 1, 'Haity', '', '147   ', 1, '                ', '                ', '         ', '', '', 'f', '2007-07-28', 23, 'single');
INSERT INTO person VALUES (940, 'André Luiz Nascimento', '2013-10-02 15:10:42', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-02', NULL, 'single');
INSERT INTO person VALUES (941, 'Alessandro Pereira Antunes', '2013-10-02 15:10:07', 1, '', '', '      ', 10, '                ', '                ', '         ', '', '', 'm', '1981-03-02', NULL, 'married');
INSERT INTO person VALUES (942, 'Andersom W da Silva de Oliveira', '2013-10-02 15:10:19', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1979-08-13', NULL, 'married');
INSERT INTO person VALUES (943, 'Alexandro de Goes', '2013-10-02 15:10:13', 1, 'Francisco Risental', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1974-05-28', 14, 'separated');
INSERT INTO person VALUES (944, 'Edsom Luiz de Lima', '2013-10-02 15:10:19', 1, 'Ernande Batista Rosa', '', '141   ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-02', 4, 'single');
INSERT INTO person VALUES (945, 'Elias Padilha de Castro', '2013-10-02 15:10:25', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1983-07-28', NULL, 'single');
INSERT INTO person VALUES (946, 'Evertom Luiz Ferreira', '2013-10-02 15:10:54', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1984-04-05', NULL, 'single');
INSERT INTO person VALUES (947, 'Enerstina  Bueno', '2013-10-02 15:10:06', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-02', NULL, 'single');
INSERT INTO person VALUES (948, 'Emile Parecida Bueno de Oliveira', '2013-10-02 16:10:51', 1, 'Barbosa Lima', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '2002-02-02', 23, 'single');
INSERT INTO person VALUES (949, 'Emanuele Aparecida Oliveira Barbosa', '2013-10-02 16:10:08', 1, 'Nelso Narciso Vitiato', '', '12    ', 1, '                ', '                ', '         ', '', '', 'm', '2000-04-10', 25, 'single');
INSERT INTO person VALUES (950, 'Fabio Cauam H.Q da Silva', '2013-10-02 16:10:59', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2006-04-08', 33, 'single');
INSERT INTO person VALUES (951, 'Felipe Sebastião Junio', '2013-10-02 16:10:29', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-05-28', NULL, '');
INSERT INTO person VALUES (952, 'Francisco Camargo Junior', '2013-10-02 16:10:47', 1, 'Rua Ivai', '', '555   ', 1, '                ', '                ', '         ', '', '', 'm', '1963-03-03', NULL, 'single');
INSERT INTO person VALUES (953, 'Fabricio Pereira', '2013-10-02 16:10:56', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'm', '1975-03-06', NULL, 'single');
INSERT INTO person VALUES (954, 'Florisvaldo Cordeiro', '2013-10-02 16:10:41', 1, 'Jardim Meneleu', '', '7     ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-02', 33, 'married');
INSERT INTO person VALUES (955, 'Francisco Cruz Dos Santos', '2013-10-02 16:10:18', 1, 'Salvador Mendonça', '', '386   ', 1, '                ', '                ', '         ', '', '', 'm', '1964-03-25', 20, 'single');
INSERT INTO person VALUES (956, 'Francisco dos Reis Filho', '2013-10-02 16:10:17', 1, 'Cornélio de Geus', '', '9     ', 1, '                ', '                ', '         ', '', '', 'm', '1959-07-03', 12, 'single');
INSERT INTO person VALUES (957, 'Guilerme Luiz da Silva', '2013-10-02 16:10:18', 1, 'bartolomeu Gusmão', '', '280   ', 1, '                ', '                ', '         ', '', '', 'm', '1995-01-13', 36, 'single');
INSERT INTO person VALUES (958, 'Gisele Aparecida Rodrigues', '2013-10-02 16:10:00', 1, 'Julio Perneta', '', '990   ', 1, '                ', '                ', '         ', '', '', 'm', '1998-04-17', 23, 'single');
INSERT INTO person VALUES (959, 'Julio Manoel Moreira', '2013-10-02 16:10:58', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-02', NULL, 'single');
INSERT INTO person VALUES (960, 'José Ivonei de Brito Nascimento', '2013-10-02 16:10:43', 1, 'RUA B', '', '15    ', 1, '                ', '                ', '         ', '', '', 'm', '1992-05-18', 38, 'single');
INSERT INTO person VALUES (961, 'Josiel Andrei de Lima', '2013-10-02 16:10:17', 1, 'Bitencurt Sanpaio', '', '398   ', 1, '                ', '                ', '         ', '', '', 'm', '1997-09-17', 22, 'single');
INSERT INTO person VALUES (962, 'Jaciara Alves Santos', '2013-10-02 16:10:24', 1, 'Bitencurt ASnpaio', '', '398   ', 1, '                ', '                ', '         ', '', '', 'm', '2001-10-18', 22, 'single');
INSERT INTO person VALUES (845, 'teste', '2013-09-30 10:09:28', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-30', NULL, '');
INSERT INTO person VALUES (963, 'Jeam Carlos S Ferreira', '2013-10-02 16:10:07', 1, 'Visconde de Nacar', '', '129   ', 1, '                ', '                ', '         ', '', '', 'm', '1977-06-23', 1, 'single');
INSERT INTO person VALUES (964, 'Jaime Rodriques Matins', '2013-10-02 16:10:44', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1964-11-02', NULL, 'single');
INSERT INTO person VALUES (965, 'Juarez De Jesus Oliveira', '2013-10-03 10:10:50', 1, 'Lucio Alvez da Silva', '', '32    ', 1, '                ', '                ', '         ', '', '', 'm', '1967-08-24', 33, 'single');
INSERT INTO person VALUES (966, 'Mauro Ribeiro da Cruz', '2013-10-03 11:10:47', 1, 'Teixeir de Freitas', '', '502   ', 1, '                ', '                ', '         ', '', '', 'm', '1967-04-15', 35, 'single');
INSERT INTO person VALUES (967, 'Osmar de Oliveira', '2013-10-03 11:10:41', 1, 'Evaristo Moraes', '', '20    ', 1, '                ', '                ', '         ', '', '', 'm', '1967-08-23', 33, 'single');
INSERT INTO person VALUES (968, 'Naiara Karine Ferri', '2013-10-03 11:10:57', 1, 'Teodoro Kluppel', '', '422   ', 1, '                ', '                ', '         ', '', '', 'm', '2001-06-21', 33, 'single');
INSERT INTO person VALUES (969, 'Orlando Maia Steudel', '2013-10-03 11:10:19', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1968-02-15', NULL, 'single');
INSERT INTO person VALUES (970, 'Jocelito Alves Meira', '2013-10-03 11:10:40', 1, 'Tobias Moscoso', '', '14    ', 1, '                ', '                ', '         ', '', '', 'm', '1969-05-04', 20, 'single');
INSERT INTO person VALUES (971, 'Marcio dos Santos Silva', '2013-10-04 09:10:40', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1983-11-15', NULL, 'single');
INSERT INTO person VALUES (972, 'Arlindo Cezar de Oliveira', '2013-10-04 09:10:05', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1970-08-21', NULL, 'single');
INSERT INTO person VALUES (973, 'Luiz Roberto do Prado', '2013-10-04 09:10:43', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1972-11-30', NULL, 'single');
INSERT INTO person VALUES (974, 'Luciano de Bastos', '2013-10-04 10:10:03', 1, 'Foz do Iguaçu', '', '119   ', 1, '                ', '                ', '         ', '', '', 'm', '1980-06-11', 16, 'single');
INSERT INTO person VALUES (975, 'Edsom Felipe Ribeiro', '2013-10-04 10:10:22', 1, 'Antonio Victor Burgmam', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1985-11-28', 4, 'single');
INSERT INTO person VALUES (976, 'Jose Adriano Ramos', '2013-10-04 13:10:40', 1, 'Eugenio José Bochi', '', '8     ', 1, '                ', '                ', '         ', '', '', 'm', '1986-01-01', 7, 'single');
INSERT INTO person VALUES (978, 'Valdecir Antonio de Moraes', '2013-10-04 15:10:24', 1, '', '', '      ', 1, '                ', '32267710        ', '         ', '', '', 'm', '1970-06-28', NULL, '');
INSERT INTO person VALUES (979, 'Jhony da Silva Nunes', '2013-10-04 15:10:38', 1, '', '', '      ', 1, '(42)99112844    ', '                ', '         ', '', '', 'm', '1995-03-22', NULL, 'single');
INSERT INTO person VALUES (980, 'Luciano dos Anjos de Oliveira', '2013-10-04 16:10:25', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-04', NULL, '');
INSERT INTO person VALUES (981, 'Jose Ricardo Main Forno', '2013-10-04 16:10:53', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1966-12-07', NULL, 'single');
INSERT INTO person VALUES (982, 'Rauam Mizael da Silca', '2013-10-07 08:10:01', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2013-01-07', 25, '');
INSERT INTO person VALUES (983, 'Leonardo Gomes da Silva', '2013-10-07 09:10:31', 1, 'Francisco Frajaido', '', '8     ', 1, '                ', '                ', '         ', '', '', 'm', '1995-06-15', 33, 'single');
INSERT INTO person VALUES (984, 'Crislaine Arruda Cardoso', '2013-10-07 09:10:41', 1, 'Dr Eugenio José', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1993-10-29', 7, '');
INSERT INTO person VALUES (985, 'José Eduardo Santana da Luz', '2013-10-07 09:10:45', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-07', NULL, 'single');
INSERT INTO person VALUES (1035, 'Marcelo Arcenio Gregorio', '2013-10-08 10:10:32', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1980-01-01', NULL, 'single');
INSERT INTO person VALUES (986, 'Renato dos Ajos de Oliveira', '2013-10-07 09:10:40', 1, 'Quadra 6 lote 120', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-07', 39, 'single');
INSERT INTO person VALUES (987, 'Jonathan Santana da Luz', '2013-10-07 09:10:39', 1, 'Quadra 9 lote 189', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-07', 39, '');
INSERT INTO person VALUES (988, 'Francisco Allberto da Silva', '2013-10-07 09:10:31', 1, 'Cornelio de Geus', '', '66    ', 1, '(42)98131861    ', '                ', '         ', '', '', 'm', '1986-05-16', 12, 'single');
INSERT INTO person VALUES (989, 'Alissom Aparecido Barreto de Paula', '2013-10-07 09:10:56', 1, 'Visconde de Jaguari', '', '103   ', 1, '                ', '(42)32277009    ', '         ', '', '', 'm', '1990-03-23', 14, 'single');
INSERT INTO person VALUES (990, 'Glênio Muller', '2013-10-07 09:10:24', 1, 'Teodoro Sanpaio', '', '763   ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-07', NULL, 'single');
INSERT INTO person VALUES (991, 'José Dair Ribeiro', '2013-10-07 09:10:01', 1, 'Fransico Beltrao', '', '51    ', 1, '                ', '                ', '         ', '', '', 'm', '1977-08-28', 16, 'single');
INSERT INTO person VALUES (992, 'Jamile Ribeiro Batista', '2013-10-07 09:10:34', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2013-01-07', NULL, '');
INSERT INTO person VALUES (993, 'Marcelo Soares', '2013-10-07 09:10:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1984-07-02', NULL, 'single');
INSERT INTO person VALUES (994, 'João Rocha dos Santos', '2013-10-07 09:10:03', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1967-04-05', NULL, '');
INSERT INTO person VALUES (995, 'Valeria de Almeida F Bertoletti', '2013-10-07 09:10:33', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1974-10-11', 20, 'single');
INSERT INTO person VALUES (996, 'Thaline G Leandro Monteiro', '2013-10-07 09:10:01', 1, 'Julio Perneta', '', '290   ', 1, '                ', '                ', '         ', '', '', 'm', '1999-02-18', 23, 'single');
INSERT INTO person VALUES (997, 'Jassiane de Freitas', '2013-10-07 09:10:54', 1, 'Marcilio Luiz', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1996-12-02', 7, 'single');
INSERT INTO person VALUES (998, 'Solange de Fatima', '2013-10-07 09:10:42', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1986-02-13', NULL, 'single');
INSERT INTO person VALUES (999, 'Sheila Francine Trugillo', '2013-10-07 09:10:17', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2013-01-07', NULL, '');
INSERT INTO person VALUES (1000, 'Santana E Ribeiro', '2013-10-07 09:10:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1992-03-25', NULL, 'single');
INSERT INTO person VALUES (1001, 'Rosimery Aparecido Bueno', '2013-10-07 09:10:32', 1, 'Baarbosa Lima', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1982-02-14', 23, 'single');
INSERT INTO person VALUES (1002, 'Rosimeri Aparecida dos  Santos', '2013-10-07 09:10:14', 1, 'Teixeira de macedo', '', '935   ', 1, '                ', '                ', '         ', '', '', 'f', '1968-07-29', 33, 'single');
INSERT INTO person VALUES (1003, 'Rosangela Maria Bueno', '2013-10-07 10:10:11', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1985-11-27', NULL, 'single');
INSERT INTO person VALUES (1004, 'Rosenette Banderley', '2013-10-07 10:10:12', 1, 'Bento de Amaral', '', '137   ', 1, '                ', '                ', '         ', '', '', 'm', '1975-12-24', 29, 'married');
INSERT INTO person VALUES (1005, 'Rosana Aprecida Gonçalves', '2013-10-07 10:10:23', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1982-01-16', 13, 'single');
INSERT INTO person VALUES (1006, 'Reginaldo Cardoso Carlos de Asis', '2013-10-07 10:10:37', 1, '', '', '      ', 8, '                ', '                ', '         ', '', '', 'm', '1969-06-12', NULL, 'single');
INSERT INTO person VALUES (1007, 'Andersom Maciel Alves', '2013-10-07 10:10:17', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-10-10', NULL, 'single');
INSERT INTO person VALUES (1008, 'Alceu Alves França', '2013-10-07 10:10:21', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1994-11-01', NULL, 'single');
INSERT INTO person VALUES (1009, 'Ana Maria Moreira de Lima', '2013-10-07 10:10:31', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1972-03-06', NULL, 'single');
INSERT INTO person VALUES (1010, 'Antonio Claudio de Oliveira', '2013-10-07 10:10:27', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1965-09-25', NULL, 'single');
INSERT INTO person VALUES (1011, 'Arlindo da Luz Paulista', '2013-10-07 10:10:35', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1951-09-29', 31, 'single');
INSERT INTO person VALUES (1012, 'Miltom Ribeiro', '2013-10-07 11:10:20', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-07', NULL, '');
INSERT INTO person VALUES (1013, 'Vandir Soares dos Santos', '2013-10-07 11:10:56', 1, 'Barao de Peneda', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1979-01-23', NULL, 'single');
INSERT INTO person VALUES (1014, 'Vera Lucia Capiatez', '2013-10-07 11:10:38', 1, 'Raul Quil Cordeiro', '', '13    ', 1, '                ', '                ', '         ', '', '', 'f', '1969-08-01', 3, 'single');
INSERT INTO person VALUES (1015, 'Daiane Oliveira Ferrera', '2013-10-08 09:10:20', 1, 'Abelardo de Brito', '', '15    ', 1, '                ', '                ', '         ', '', '', 'f', '1994-03-18', 20, 'single');
INSERT INTO person VALUES (1016, 'Delmira Gomes Drose', '2013-10-08 09:10:18', 1, 'Avidor Gastao  Soares', '68', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1949-04-15', 4, 'widow(er)');
INSERT INTO person VALUES (1017, 'Elaine Vieira dos Santos', '2013-10-08 09:10:02', 1, 'Theodoro Kluppel', '', '402   ', 1, '                ', '                ', '         ', '', '', 'f', '1982-03-25', 33, 'single');
INSERT INTO person VALUES (1018, 'Emanuele Aparecida Oliveira Barbosa', '2013-10-08 09:10:15', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2000-04-10', NULL, 'single');
INSERT INTO person VALUES (1019, 'Emile dos Santos', '2013-10-08 09:10:22', 1, 'Nestor Victor', '', '100   ', 1, '                ', '                ', '         ', '', '', 'f', '2013-01-08', NULL, '');
INSERT INTO person VALUES (1020, 'Erica Pedroso Pekado', '2013-10-08 09:10:07', 1, 'Carlos Chagas', '', '400   ', 1, '                ', '                ', '         ', '', '', 'f', '1996-11-22', 23, 'single');
INSERT INTO person VALUES (1021, 'Eunice Ferreira', '2013-10-08 09:10:42', 1, 'José Face', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1976-09-15', 20, 'single');
INSERT INTO person VALUES (1022, 'Evelym Jeniffer Nascimento', '2013-10-08 10:10:53', 1, 'Theodoro Cluppel', '', '408   ', 1, '                ', '                ', '         ', '', '', 'f', '1996-03-07', 33, 'single');
INSERT INTO person VALUES (1023, 'Helena de Lara Cardoso', '2013-10-08 10:10:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1955-08-21', NULL, 'separated');
INSERT INTO person VALUES (1024, 'Giovana dos Santos', '2013-10-08 10:10:06', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2013-01-08', NULL, '');
INSERT INTO person VALUES (1025, 'Irene de Fatima Ribeiro', '2013-10-08 10:10:36', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1954-03-16', NULL, 'single');
INSERT INTO person VALUES (1026, 'Josiane Alves Ferreira', '2013-10-08 10:10:52', 1, 'Serra da Canastra', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'f', '1986-07-23', 27, 'single');
INSERT INTO person VALUES (1027, 'Katia Rose do Nacimento', '2013-10-08 10:10:38', 1, 'Haitin fds 122', '', '122   ', 1, '                ', '                ', '         ', '', '', 'f', '1986-04-11', 23, 'single');
INSERT INTO person VALUES (1028, 'Kauane Isabele da Silva', '2013-10-08 10:10:14', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2003-07-14', NULL, 'single');
INSERT INTO person VALUES (1029, 'Kauane Meira Amaral', '2013-10-08 10:10:57', 1, 'Tobias Moscoso', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2013-01-08', 20, 'single');
INSERT INTO person VALUES (1030, 'Larissa Tamires Duarte', '2013-10-08 10:10:55', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2013-01-08', NULL, 'single');
INSERT INTO person VALUES (1031, 'Lauriemely Rodrigues Silva', '2013-10-08 10:10:14', 1, 'Julio Perneta', '', '299   ', 1, '                ', '                ', '         ', '', '', 'm', '2002-10-26', 23, 'single');
INSERT INTO person VALUES (1032, 'Luana Karoline Francisco', '2013-10-08 10:10:57', 1, 'Ademar Horn', '', '116   ', 1, '                ', '                ', '         ', '', '', 'f', '1995-08-12', 24, 'single');
INSERT INTO person VALUES (1033, 'Maiara Loriane Desentenike', '2013-10-08 10:10:58', 1, 'Haiti', '', '123   ', 1, '                ', '                ', '         ', '', '', 'f', '2006-02-13', 23, 'single');
INSERT INTO person VALUES (1034, 'Joao Maria  Almeida', '2013-10-08 10:10:37', 1, 'Brigadeiro Machado', '', '136   ', 1, '                ', '                ', '         ', '', '', 'f', '1955-01-23', 14, 'single');
INSERT INTO person VALUES (1036, 'Leonardo Gomes de Paula', '2013-10-08 10:10:49', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-08', NULL, 'single');
INSERT INTO person VALUES (1037, 'Luciano Ferreira', '2013-10-08 10:10:56', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1975-02-18', NULL, 'single');
INSERT INTO person VALUES (1038, 'Luiz Carlos dos Santos', '2013-10-08 10:10:50', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1960-03-02', NULL, 'single');
INSERT INTO person VALUES (1039, 'Luiz de Sousa Junior', '2013-10-08 10:10:04', 1, 'Curitiba', '', '87    ', 1, '                ', '                ', '         ', '', '', 'm', '1967-10-23', 33, 'single');
INSERT INTO person VALUES (1040, 'Luiz Claudio Romeira', '2013-10-08 10:10:19', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'm', '1974-04-28', NULL, 'single');
INSERT INTO person VALUES (1041, 'Leandro de Oliveira', '2013-10-08 10:10:22', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1994-10-06', NULL, 'single');
INSERT INTO person VALUES (1042, 'Laudenis Serzovski dos Santos', '2013-10-08 11:10:41', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1966-03-05', NULL, 'single');
INSERT INTO person VALUES (1043, 'Lauri Bueno de Camargo', '2013-10-08 11:10:37', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1965-03-21', NULL, 'single');
INSERT INTO person VALUES (1044, 'Luiz Rega', '2013-10-08 11:10:52', 1, 'Braulina Carneiro', '', '416   ', 1, '                ', '                ', '         ', '', '', 'm', '1969-07-30', 20, 'single');
INSERT INTO person VALUES (1045, 'Caroline Leticia  dos Santos', '2013-10-08 11:10:37', 1, 'Fraias de Brito', '', '65    ', 1, '                ', '                ', '         ', '', '', 'f', '2004-01-22', 23, 'single');
INSERT INTO person VALUES (1046, 'Kevilim Vitoria', '2013-10-08 11:10:33', 1, 'Senador Afonso Camargo', '', '5     ', 1, '                ', '                ', '         ', '', '', 'f', '2006-06-08', 13, 'single');
INSERT INTO person VALUES (97, 'John Lenon Costa sagais', '2013-08-20 14:08:51', 1, 'Rua Herculano de Freitas', '', '751   ', 1, '                ', '32239414        ', '84015105 ', '', '', 'm', '1990-11-09', 4, 'single');
INSERT INTO person VALUES (1047, 'Andersom Machado dos Santos', '2013-10-09 11:10:03', 1, 'Herculano de Freitas', '', '751   ', 1, '4232239414      ', '32239414        ', '84015105 ', '', '', 'm', '1979-11-19', 4, 'single');
INSERT INTO person VALUES (1048, 'Maicom Luiz Rodrigo Lermes', '2013-10-09 13:10:55', 1, 'Evaristo da Veiga', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1993-09-29', NULL, 'single');
INSERT INTO person VALUES (1049, 'Maiara Carvalho Barbosa', '2013-10-09 13:10:29', 1, 'Bonifacio Ribas', '', '557   ', 1, '                ', '                ', '         ', '', '', 'm', '2009-01-03', 13, 'single');
INSERT INTO person VALUES (1050, 'Michael Leandro dos Santos', '2013-10-09 13:10:57', 1, 'Teixeira de Macedo', '', '435   ', 1, '                ', '                ', '         ', '', '', 'm', '1995-01-23', 33, 'single');
INSERT INTO person VALUES (1051, 'Maria Helena C Barbosa', '2013-10-09 13:10:08', 1, 'Alfredo Pedro Dias', '', '665   ', 1, '                ', '                ', '         ', '', '', 'm', '2004-04-16', 25, 'single');
INSERT INTO person VALUES (1052, 'Vilsom Ferreira Pinto', '2013-10-09 13:10:28', 1, '', '', '      ', 3, '                ', '                ', '         ', '', '', 'm', '1985-05-28', NULL, 'single');
INSERT INTO person VALUES (1053, 'Noel Barbosa', '2013-10-09 13:10:46', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1958-07-17', NULL, '');
INSERT INTO person VALUES (1054, 'Jaqueline Lavoski', '2013-10-09 14:10:01', 1, 'Carlos Chagas', '', '612   ', 1, '                ', '                ', '         ', '', '', 'f', '1990-10-09', 23, 'single');
INSERT INTO person VALUES (1055, 'Nilsom Aparecido Amaral Fereira', '2013-10-09 14:10:33', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1968-05-23', NULL, 'single');
INSERT INTO person VALUES (1056, 'Emanuela Aparecida Oliveira Barbosa', '2013-10-09 14:10:23', 1, 'Nelsom Narciso Hatro', '', '12    ', 1, '                ', '                ', '         ', '', '', 'f', '2000-04-10', 25, 'single');
INSERT INTO person VALUES (1057, 'Atlio Feereira da Silva Filho', '2013-10-09 14:10:29', 1, 'Engen Chanber', '', '287   ', 1, '                ', '                ', '         ', '', '', 'm', '1971-06-08', 1, 'single');
INSERT INTO person VALUES (1058, 'Adilsom dos Santos', '2013-10-09 14:10:09', 1, 'Sebastiao Parana', '', '678   ', 1, '                ', '                ', '         ', '', '', 'm', '1954-07-24', 20, 'single');
INSERT INTO person VALUES (1059, 'Antonio Carlos Miranda', '2013-10-09 14:10:38', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1968-11-07', NULL, 'single');
INSERT INTO person VALUES (1060, 'Brendo de Andrade Vaz', '2013-10-09 14:10:01', 1, 'Lucio alves da Silva', '', '33    ', 1, '                ', '                ', '         ', '', '', 'm', '1997-05-05', 33, 'single');
INSERT INTO person VALUES (1061, 'Antonio Carlos da Silva', '2013-10-09 14:10:49', 1, 'Azaléia', '', '63    ', 1, '                ', '                ', '         ', '', '', 'm', '1986-08-15', 21, 'single');
INSERT INTO person VALUES (1062, 'Bento Severino Soares', '2013-10-09 14:10:09', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1935-07-21', 27, '');
INSERT INTO person VALUES (1063, 'Bruno Ferreira', '2013-10-09 14:10:42', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-09', NULL, '');
INSERT INTO person VALUES (1064, 'Bener Schember', '2013-10-09 14:10:53', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1978-08-11', NULL, '');
INSERT INTO person VALUES (1065, 'Julio Mendes', '2013-10-10 09:10:30', 1, 'rua 3', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2000-07-30', 7, 'married');
INSERT INTO person VALUES (1066, 'José Sebastião Pinto', '2013-10-10 09:10:08', 1, 'Carlos Chagas', '', '370   ', 1, '                ', '                ', '         ', '', '', 'm', '1972-10-10', 23, 'single');
INSERT INTO person VALUES (1067, 'Janaira Alves Santos', '2013-10-10 09:10:27', 1, 'Bitencurt Sanpaio', '', '398   ', 1, '                ', '                ', '         ', '', '', 'f', '1992-09-29', 22, 'single');
INSERT INTO person VALUES (1068, 'Jocemeri Ferreira Alves Santos', '2013-10-10 09:10:58', 1, 'Bitencurt Sanpaio', '', '398   ', 1, '                ', '                ', '         ', '', '', 'f', '1974-11-27', 22, 'married');
INSERT INTO person VALUES (1069, 'Jerri Rodrigo Nalifico', '2013-10-10 09:10:22', 1, '', '', '      ', 3, '                ', '                ', '         ', '', '', 'm', '1988-09-27', NULL, 'single');
INSERT INTO person VALUES (1070, 'José Evandro dos Santos', '2013-10-10 09:10:39', 1, 'Teodoro Cluppel', '', '408   ', 1, '                ', '                ', '         ', '', '', 'm', '1983-12-02', 33, 'single');
INSERT INTO person VALUES (1071, 'Josnei dos Santos', '2013-10-10 10:10:06', 1, 'rui Barbosa', '', '71    ', 1, '                ', '                ', '         ', '', '', 'm', '1978-03-10', 1, 'single');
INSERT INTO person VALUES (1072, 'Junior Lucas de Lima', '2013-10-10 10:10:14', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-11-16', NULL, 'single');
INSERT INTO person VALUES (1073, 'José Lels', '2013-10-10 10:10:54', 1, 'londrina', '', '15    ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-10', 32, '');
INSERT INTO person VALUES (1074, 'Joao Laves de Brito', '2013-10-10 10:10:11', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1961-03-09', NULL, '');
INSERT INTO person VALUES (1075, 'Luiz Carlos de Oliveira', '2013-10-10 10:10:54', 1, 'Marques de Sapucai', '', '2     ', 1, '                ', '                ', '         ', '', '', 'm', '1979-05-06', NULL, 'married');
INSERT INTO person VALUES (1076, 'Luiz Antonio de Oliveira', '2013-10-10 10:10:42', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1983-06-15', NULL, 'single');
INSERT INTO person VALUES (1077, 'Luiz Carlos de Freitas', '2013-10-10 10:10:13', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1952-03-25', NULL, 'widow(er)');
INSERT INTO person VALUES (1078, 'Luiz Carlos Nascimento', '2013-10-10 10:10:19', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1975-05-14', NULL, 'single');
INSERT INTO person VALUES (1079, 'Luiz Antonio Ribeiro Gomes', '2013-10-10 10:10:49', 1, 'Barao de serro Azul', '', '147   ', 1, '                ', '                ', '         ', '', '', 'm', '1960-07-28', 1, 'separated');
INSERT INTO person VALUES (1080, 'Loriane Kleye', '2013-10-10 11:10:36', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1964-05-16', NULL, '');
INSERT INTO person VALUES (1081, 'Luana Ramos', '2013-10-10 11:10:28', 1, 'Nestor Victor', '', '100   ', 1, '                ', '                ', '         ', '', '', 'f', '2013-01-10', 32, 'single');
INSERT INTO person VALUES (1082, 'Luiz Carlos Macedo', '2013-10-14 08:10:20', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1957-02-10', NULL, 'single');
INSERT INTO person VALUES (1083, 'Laudelino Gomes Veta', '2013-10-14 08:10:46', 1, 'Marechal Hermes', '', '731   ', 1, '                ', '                ', '         ', '', '', 'm', '1963-12-23', 20, 'single');
INSERT INTO person VALUES (1084, 'Luiz Albero da Silva', '2013-10-14 09:10:20', 1, 'Maria Ursula de Abreu', '', '13    ', 1, '                ', '                ', '         ', '', '', 'm', '1979-08-01', 34, 'single');
INSERT INTO person VALUES (1085, 'Ketlim Fabiane Iurk', '2013-10-14 09:10:48', 1, 'Dominicio da Gama', '', '980   ', 1, '                ', '                ', '         ', '', '', 'f', '1993-06-03', 33, '');
INSERT INTO person VALUES (1086, 'Ketly Maiara C Barbosa', '2013-10-14 09:10:20', 1, 'Alfredo Pedro Ribas', '', '665   ', 1, '                ', '                ', '         ', '', '', 'f', '1995-10-07', 40, 'single');
INSERT INTO person VALUES (1087, 'Kauane Gonçalves Ribeiro', '2013-10-14 09:10:53', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2003-03-12', NULL, 'single');
INSERT INTO person VALUES (1088, 'Diana Aparecida Rodrigues', '2013-10-14 09:10:51', 1, 'Julio Perneta', '', '299   ', 1, '                ', '                ', '         ', '', '', 'm', '1995-10-17', 23, 'single');
INSERT INTO person VALUES (1089, 'Cristiane Martins Moritz', '2013-10-14 09:10:43', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2007-05-16', NULL, 'single');
INSERT INTO person VALUES (1090, 'Clara Pereira', '2013-10-14 09:10:42', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1961-08-12', 13, 'single');
INSERT INTO person VALUES (1091, 'bida Patricia Preme', '2013-10-14 09:10:06', 1, 'rua 3', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '0183-11-16', 7, 'single');
INSERT INTO person VALUES (1092, 'Jaqueline Bueno Mendes', '2013-10-14 09:10:19', 1, '', '', '      ', 5, '                ', '                ', '         ', '', '', 'f', '1987-09-22', NULL, 'single');
INSERT INTO person VALUES (1093, 'Adriano Carvalho Chaves', '2013-10-14 10:10:03', 1, 'Alfredo Pereira Ribas', '', '665   ', 1, '                ', '                ', '         ', '', '', 'm', '1970-07-29', 5, 'single');
INSERT INTO person VALUES (1094, 'Paulo Sergio Pinheiro', '2013-10-14 10:10:37', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'm', '1972-06-25', NULL, 'single');
INSERT INTO person VALUES (1095, 'Paulo Sergio Rodrigues', '2013-10-14 10:10:40', 1, 'Visconde de Araguaia', '', '10    ', 1, '                ', '                ', '         ', '', '', 'm', '1967-06-27', 32, 'single');
INSERT INTO person VALUES (1096, 'Pedro Correia', '2013-10-14 10:10:29', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1971-04-03', NULL, 'single');
INSERT INTO person VALUES (1097, 'Pedro Liz da Cruz', '2013-10-14 10:10:24', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1971-06-05', NULL, 'single');
INSERT INTO person VALUES (1098, 'Paulo Sergio M de Oliveira', '2013-10-14 10:10:01', 1, 'Maria Veling Braga', '', '34    ', 1, '                ', '                ', '         ', '', '', 'm', '1988-12-30', 36, 'single');
INSERT INTO person VALUES (1099, 'Petersom Jeam Gonsalves dos Santos', '2013-10-14 10:10:07', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1994-05-18', 32, 'single');
INSERT INTO person VALUES (1100, 'Roberto de Oliveira', '2013-10-14 10:10:04', 1, 'Chacara bom Jesus', '', '      ', 17, '                ', '                ', '         ', '', '', 'm', '1966-04-05', NULL, 'single');
INSERT INTO person VALUES (1101, 'Ronaldo Gomes Leopoldino', '2013-10-14 10:10:20', 1, '', '', '      ', 3, '                ', '                ', '         ', '', '', 'm', '1977-05-17', NULL, 'single');
INSERT INTO person VALUES (1102, 'Rene Carneiro', '2013-10-14 10:10:05', 1, 'Julio Perneta', '', '557   ', 1, '                ', '                ', '         ', '', '', 'm', '1965-12-23', 4, 'single');
INSERT INTO person VALUES (1103, 'Israel Ferreira Da Silva', '2013-10-14 10:10:37', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1959-09-24', NULL, 'single');
INSERT INTO person VALUES (1104, 'Rossana Fatima Gomes', '2013-10-14 10:10:50', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1970-01-23', NULL, 'single');
INSERT INTO person VALUES (1105, 'Rogerio Gomes dos Santos', '2013-10-14 10:10:26', 1, 'Pedro Gador', '', '608   ', 1, '                ', '                ', '         ', '', '', 'm', '1995-09-15', 14, 'single');
INSERT INTO person VALUES (1106, 'Roberto Jesus Cunha', '2013-10-14 10:10:57', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1966-08-24', NULL, 'single');
INSERT INTO person VALUES (1107, 'Rafael Preinotti de Rmaos', '2013-10-14 10:10:26', 1, 'Bento do Amaral', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '1985-10-18', 40, 'single');
INSERT INTO person VALUES (1109, 'Reinolde Ferreira', '2013-10-14 10:10:50', 1, 'rua Londrina', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '1978-11-20', 32, 'single');
INSERT INTO person VALUES (1110, 'Renato Balduino ereira', '2013-10-14 10:10:23', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1978-01-06', NULL, 'single');
INSERT INTO person VALUES (1111, 'Ricardo Ramom Fagundes', '2013-10-14 10:10:38', 1, 'teofilo Otoni', '', '282   ', 1, '                ', '                ', '         ', '', '', 'm', '1996-05-03', 23, 'single');
INSERT INTO person VALUES (1112, 'Rauan Misael da Silva', '2013-10-14 10:10:47', 1, 'final da Barbosa Lima', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1999-10-29', 23, 'single');
INSERT INTO person VALUES (1113, 'Sebastião Sesar Alves Prestes', '2013-10-14 10:10:37', 1, 'Alcebiades Miranda', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1975-10-21', 14, 'single');
INSERT INTO person VALUES (1114, 'Sergio Rodrigues Batista', '2013-10-14 10:10:12', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1967-12-14', NULL, 'single');
INSERT INTO person VALUES (1115, 'Solange Aparecida Ferri', '2013-10-14 10:10:02', 1, 'Todoro kluppel', '', '422   ', 1, '                ', '                ', '         ', '', '', 'm', '1968-05-15', 33, 'single');
INSERT INTO person VALUES (1116, 'Samuel correia Leite', '2013-10-14 10:10:21', 1, 'Corunpias', '', '122   ', 1, '                ', '                ', '         ', '', '', 'm', '1977-12-09', 36, 'single');
INSERT INTO person VALUES (1117, 'sidnei Valentim', '2013-10-14 10:10:34', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1969-12-05', NULL, 'single');
INSERT INTO person VALUES (1118, 'Sheldan Werda', '2013-10-14 11:10:21', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1992-01-17', 25, 'single');
INSERT INTO person VALUES (1119, 'Teresa Rodrigues', '2013-10-14 11:10:13', 1, 'Julio Perneta', '', '230   ', 1, '                ', '                ', '         ', '', '', 'm', '1978-05-14', 23, 'single');
INSERT INTO person VALUES (1120, 'Thais Rodrigues da Silva', '2013-10-14 11:10:36', 1, 'São Josafate', '', '81    ', 1, '                ', '                ', '         ', '', '', 'f', '1985-07-15', 7, 'married');
INSERT INTO person VALUES (1121, 'Thais Jaqueline de Moraes', '2013-10-14 11:10:40', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1991-08-29', NULL, '');
INSERT INTO person VALUES (1122, 'Thiago José dos Santos', '2013-10-14 11:10:48', 1, 'Theodoro Klupell', '', '410   ', 1, '                ', '                ', '         ', '', '', 'm', '1988-03-08', 33, 'single');
INSERT INTO person VALUES (1123, 'Valdomiro Alves', '2013-10-14 11:10:35', 1, 'Bitencurt Sanpaio', '', '398   ', 1, '                ', '                ', '         ', '', '', 'm', '1973-05-03', 22, 'single');
INSERT INTO person VALUES (1124, 'Vicente de Paula Freitas', '2013-10-14 11:10:11', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1965-12-24', NULL, 'married');
INSERT INTO person VALUES (1125, 'Vivaldo Rodriques dos Santos', '2013-10-14 11:10:46', 1, 'Nossa Senhora da Luz', '', '59    ', 1, '                ', '                ', '         ', '', '', 'm', '1959-11-16', 8, 'single');
INSERT INTO person VALUES (1126, 'Vitor Manoel M Souza', '2013-10-14 11:10:25', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2004-03-30', NULL, 'single');
INSERT INTO person VALUES (1127, 'Valdinéia da Silva', '2013-10-14 11:10:27', 1, 'Praia Bpm Jesus', '', '14    ', 1, '                ', '                ', '         ', '', '', 'f', '1980-01-11', 21, '');
INSERT INTO person VALUES (1128, 'Aline Gabriel S de Oliveira', '2013-10-14 14:10:40', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '2000-07-13', NULL, 'single');
INSERT INTO person VALUES (1129, 'Alaor  Gonçalves Vieira', '2013-10-14 14:10:47', 1, 'Brigadeiro Machado', '', '67    ', 1, '                ', '                ', '         ', '', '', 'm', '1967-01-08', 14, 'single');
INSERT INTO person VALUES (1130, 'Andrei Souza Dias', '2013-10-14 14:10:34', 1, 'rua 13 de Março', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-03-13', 27, 'single');
INSERT INTO person VALUES (1131, 'Anderson Wilian Silva Oliveira', '2013-10-14 14:10:07', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1979-08-13', NULL, 'single');
INSERT INTO person VALUES (389, 'Ana Paula de Lima', '2013-08-28 10:08:46', 1, 'Nelsom Vitor', '', '77    ', 1, '                ', '                ', '         ', '', '', 'f', '1983-06-05', 20, 'married');
INSERT INTO person VALUES (1132, 'Evaldo Maciel Alves', '2013-10-14 14:10:24', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1968-08-11', NULL, 'single');
INSERT INTO person VALUES (1133, 'Eva de Lima', '2013-10-14 14:10:42', 1, 'Bitencourt Sanpaio', '', '398   ', 1, '                ', '                ', '         ', '', '', 'm', '1953-07-18', 22, '');
INSERT INTO person VALUES (1134, 'Eloir Pereira', '2013-10-14 14:10:28', 1, 'Ernandes Batista rosa', '', '141   ', 1, '                ', '                ', '         ', '', '', 'm', '1971-01-02', 4, 'single');
INSERT INTO person VALUES (1135, 'Eli Alexandrina Gomes', '2013-10-14 14:10:40', 1, '', '', '      ', 3, '                ', '                ', '         ', '', '', 'm', '1977-09-18', NULL, 'single');
INSERT INTO person VALUES (1136, 'Diego Silva de Mello', '2013-10-14 15:10:37', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1987-10-15', NULL, 'single');
INSERT INTO person VALUES (1137, 'Daiana Aparecida Rodrigues', '2013-10-14 15:10:49', 1, '', '', '      ', 16, '                ', '                ', '         ', '', '', 'f', '2013-01-14', 31, '');
INSERT INTO person VALUES (1138, 'iDavid Leandro Ferri', '2013-10-14 15:10:22', 1, 'Teodoro Kluppel 422', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1998-10-07', 33, 'single');
INSERT INTO person VALUES (1139, 'Davi Blank', '2013-10-14 15:10:02', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1963-11-04', NULL, 'single');
INSERT INTO person VALUES (1140, 'Deniam Roberto Popik', '2013-10-14 15:10:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1968-01-10', NULL, 'single');
INSERT INTO person VALUES (1141, 'Dirso Ivasyssym', '2013-10-14 15:10:22', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1960-12-26', NULL, 'single');
INSERT INTO person VALUES (1142, 'Daniel Carneiro', '2013-10-14 15:10:34', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-14', NULL, 'single');
INSERT INTO person VALUES (1143, 'David de Jesus Gonçalves Silva', '2013-10-14 15:10:28', 1, 'Alfreedo Eugenio Battista RosA', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1992-03-12', 24, 'single');
INSERT INTO person VALUES (1144, 'Dirceu de Freita Junior', '2013-10-14 15:10:58', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1986-12-14', NULL, 'single');
INSERT INTO person VALUES (1145, 'Darci Juares Santos', '2013-10-14 15:10:25', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1964-01-01', NULL, '');
INSERT INTO person VALUES (1146, 'Dirceu de Freitas', '2013-10-14 15:10:37', 1, 'Pr Cida de Oliveira', '', '36    ', 1, '                ', '                ', '         ', '', '', 'm', '1969-03-28', 14, 'single');
INSERT INTO person VALUES (1147, 'Dilacir Antunes de Proença', '2013-10-14 15:10:09', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1963-11-05', NULL, 'single');
INSERT INTO person VALUES (1148, 'Daniele dos Santos', '2013-10-14 15:10:55', 1, 'Bitencurt Sanpaio', '', '398   ', 1, '                ', '                ', '         ', '', '', 'm', '1989-01-13', 22, 'single');
INSERT INTO person VALUES (1149, 'Daniel Correia Leite', '2013-10-14 15:10:06', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1984-08-27', NULL, 'single');
INSERT INTO person VALUES (1150, 'Daniel Correia Leite', '2013-10-14 15:10:18', 1, 'Corrupião Leite', '', '122   ', 1, '                ', '                ', '         ', '', '', 'm', '1984-08-27', 36, 'single');
INSERT INTO person VALUES (1151, 'Camila Veriane Nascimento da Silva', '2013-10-14 16:10:30', 1, 'haiti', '', '123   ', 1, '                ', '                ', '         ', '', '', 'm', '2004-08-03', 23, 'single');
INSERT INTO person VALUES (1152, 'Carla dos SaNTOS', '2013-10-14 16:10:57', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1989-09-15', NULL, 'single');
INSERT INTO person VALUES (1153, 'Cristiane Rocha Guedes', '2013-10-14 16:10:11', 1, 'Teodoro Kluppel', '', '410   ', 1, '                ', '                ', '         ', '', '', 'm', '1983-04-24', 33, 'single');
INSERT INTO person VALUES (1154, 'Cintia Lavoski Maartins', '2013-10-14 16:10:39', 1, 'Carlos Chagas', '', '612   ', 1, '                ', '                ', '         ', '', '', 'm', '1994-08-07', 23, 'single');
INSERT INTO person VALUES (1155, 'Claudio Braz', '2013-10-14 16:10:10', 1, 'Alzira Braga Ribas', '', '364   ', 1, '                ', '                ', '         ', '', '', 'm', '1964-11-28', 35, 'single');
INSERT INTO person VALUES (1156, 'Carlos Edenilsom Pacheco', '2013-10-14 16:10:16', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1966-10-01', NULL, 'single');
INSERT INTO person VALUES (1157, 'Claudinei Jesus Teixeira', '2013-10-14 16:10:26', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1973-04-18', NULL, 'single');
INSERT INTO person VALUES (1158, 'Claudio Pereira de Almeida', '2013-10-14 16:10:59', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1974-03-04', NULL, 'single');
INSERT INTO person VALUES (1160, 'Claudinei Alves dos Santos', '2013-10-14 16:10:13', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1967-08-15', NULL, 'single');
INSERT INTO person VALUES (1161, 'Claudete Aparecida Santos Costa', '2013-10-14 16:10:44', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1968-12-01', NULL, 'single');
INSERT INTO person VALUES (1162, 'Alisom José Baals', '2013-10-14 16:10:40', 1, 'Teodoro doro Kluppel', '', '408   ', 1, '                ', '                ', '         ', '', '', 'm', '1999-08-07', 33, '');
INSERT INTO person VALUES (1163, 'Adriana de Jesus de Cavalho', '2013-10-14 16:10:11', 1, 'Alfredo Pedro', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1975-04-11', 40, 'single');
INSERT INTO person VALUES (1169, 'Andreia de OliveiraFerreia', '2013-10-14 17:10:41', 1, 'Abelardo de Brito', '', '15    ', 1, '                ', '                ', '         ', '', '', 'f', '1988-12-12', 20, 'single');
INSERT INTO person VALUES (1170, 'Adriane Aparecida Santos', '2013-10-14 17:10:27', 1, '13', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1994-03-11', 3, '');
INSERT INTO person VALUES (1171, 'Aline Monalisa Santos', '2013-10-16 09:10:12', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1993-11-26', NULL, '');
INSERT INTO person VALUES (1172, 'Andressa Godeski', '2013-10-16 09:10:36', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1900-12-26', NULL, '');
INSERT INTO person VALUES (1173, 'Alessandro Gonçalves dos Santos', '2013-10-16 09:10:14', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1998-01-01', 32, 'single');
INSERT INTO person VALUES (1174, 'Antonio de Oliveira', '2013-10-16 09:10:33', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1950-04-01', NULL, 'single');
INSERT INTO person VALUES (1175, 'Adilsom do Rocio de Freitas', '2013-10-16 09:10:01', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1977-07-10', 7, '');
INSERT INTO person VALUES (1176, 'Adir Gomes', '2013-10-16 09:10:04', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1948-09-07', NULL, 'single');
INSERT INTO person VALUES (1177, 'Cristiane Pedroso', '2013-10-16 09:10:47', 1, 'Manoel Margues', '', '84    ', 1, '                ', '                ', '         ', '', '', 'f', '1985-11-09', 13, '');
INSERT INTO person VALUES (1178, 'Almiraci Antonio  Alves', '2013-10-16 09:10:49', 1, 'Ataide Ferreira Menezes', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1975-09-09', 7, 'single');
INSERT INTO person VALUES (1179, 'Carlos Adriano Mendes', '2013-10-16 09:10:04', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-16', NULL, '');
INSERT INTO person VALUES (1180, 'Claudia Regina Ferreira', '2013-10-16 09:10:37', 1, 'Enfermeiro Paulino', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1976-11-04', NULL, 'single');
INSERT INTO person VALUES (1181, 'Claudia Veiga', '2013-10-16 09:10:13', 1, 'Padre Anacleto', '', '1234  ', 1, '                ', '                ', '         ', '', '', 'f', '1970-09-21', 1, '');
INSERT INTO person VALUES (1182, 'Airtom dos Santos', '2013-10-16 09:10:49', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-16', NULL, 'single');
INSERT INTO person VALUES (1183, 'Jaquelina Aparecida do Nascimento', '2013-10-16 10:10:03', 1, 'Farias de Brito', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1987-10-23', 23, 'single');
INSERT INTO person VALUES (1184, 'José Juares Hibilski', '2013-10-16 10:10:37', 1, 'Martins Pena', '', '515   ', 1, '                ', '                ', '         ', '', '', 'm', '1945-12-21', 22, 'single');
INSERT INTO person VALUES (1185, 'Joao Maria Pedroso Ribas', '2013-10-16 10:10:00', 1, 'Pedro Lisboa Gonçalves', '', '288   ', 1, '                ', '                ', '         ', '', '', 'm', '1962-03-04', 5, '');
INSERT INTO person VALUES (1186, 'Jonatha,m Teixeira', '2013-10-16 10:10:47', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1977-10-01', NULL, 'single');
INSERT INTO person VALUES (1187, 'Jose Carlos Santiago de Oliveira', '2013-10-16 10:10:20', 1, 'Teodoro Rosas', '', '118   ', 1, '                ', '                ', '         ', '', '', 'm', '1966-10-31', 1, '');
INSERT INTO person VALUES (1188, 'Jose Claudio dos Santos', '2013-10-16 10:10:18', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-16', NULL, '');
INSERT INTO person VALUES (1189, 'Jorge Luiz Teixeira', '2013-10-16 10:10:44', 1, 'Prof Braulino', '', '387   ', 1, '                ', '                ', '         ', '', '', 'm', '1955-09-27', 20, 'single');
INSERT INTO person VALUES (1190, 'Jeam Henrique Ramos', '2013-10-16 10:10:59', 1, 'Sao Jose Fate', '', '81    ', 1, '                ', '                ', '         ', '', '', 'm', '2006-03-15', 32, 'single');
INSERT INTO person VALUES (1191, 'Jefersom  Luiz Soares', '2013-10-16 10:10:01', 1, '', '', '      ', 11, '                ', '                ', '         ', '', '', 'm', '1976-06-12', NULL, 'single');
INSERT INTO person VALUES (1192, 'Junior Ribsom da Silva', '2013-10-16 10:10:38', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1988-10-25', NULL, 'single');
INSERT INTO person VALUES (1193, 'Jose Ricardo Vidal', '2013-10-16 10:10:48', 1, 'Rio Iapo', '', '558   ', 1, '                ', '                ', '         ', '', '', 'm', '1978-10-31', 25, 'single');
INSERT INTO person VALUES (1194, 'Joao Ribeirop de Lima', '2013-10-16 10:10:48', 1, 'SURUQUA', '', '153   ', 1, '                ', '                ', '         ', '', '', 'm', '1956-09-11', 36, 'widow(er)');
INSERT INTO person VALUES (1195, 'Jonatham Deangui', '2013-10-16 10:10:04', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1986-06-13', NULL, '');
INSERT INTO person VALUES (1196, 'Josnei de Freitas', '2013-10-16 10:10:51', 1, 'Visconde de Macaé', 'i', '323   ', 1, '                ', '                ', '         ', '', '', 'm', '1979-04-30', 22, 'single');
INSERT INTO person VALUES (1197, 'Marcos Roberto Machado', '2013-10-16 11:10:00', 1, 'Israel de Barbosa Lima', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '1977-08-20', 23, 'married');
INSERT INTO person VALUES (1199, 'Marcio Roberto Meira dos Santos', '2013-10-16 11:10:24', 1, 'Barbosa Lima', '', '355   ', 1, '                ', '                ', '         ', '', '', 'm', '1975-05-02', 13, 'married');
INSERT INTO person VALUES (1200, 'Armando Oscar Alexandre', '2013-10-16 11:10:31', 1, 'Guaracy', '', '164   ', 1, '                ', '                ', '         ', '', '', 'm', '1981-09-01', 14, 'single');
INSERT INTO person VALUES (1202, 'Antonio Josnei dos Santos', '2013-10-16 11:10:13', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-16', NULL, '');
INSERT INTO person VALUES (1203, 'Antonio de Oliveira', '2013-10-16 11:10:17', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1952-04-01', NULL, 'single');
INSERT INTO person VALUES (1204, 'Alvaro Partricio Camargo', '2013-10-16 11:10:55', 1, 'Rincao da Cruz', '', '299   ', 1, '                ', '                ', '         ', '', '', 'm', '1977-03-13', 1, 'single');
INSERT INTO person VALUES (1205, 'Alisom Santos Rodriques', '2013-10-16 11:10:22', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1992-07-18', NULL, 'single');
INSERT INTO person VALUES (1206, 'Alisom Vinicius Schechtel', '2013-10-16 11:10:48', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1988-07-18', NULL, 'single');
INSERT INTO person VALUES (1207, 'Alexandro dos Santos', '2013-10-16 11:10:14', 1, 'Rua 7', '', '143   ', 1, '                ', '                ', '         ', '', '', 'm', '1978-05-18', 12, 'single');
INSERT INTO person VALUES (1208, 'Alercio Machado dos Santos', '2013-10-16 11:10:51', 1, 'Bela vista do Paraiso', '', '4     ', 1, '                ', '                ', '         ', '', '', 'm', '1968-08-10', 16, 'single');
INSERT INTO person VALUES (1209, 'Alam Wiliam Notel Vieira', '2013-10-16 11:10:59', 1, 'Madureira', '', '76    ', 1, '                ', '                ', '         ', '', '', 'm', '2008-02-26', 14, 'single');
INSERT INTO person VALUES (1211, 'Adriano Gustavo Vieira', '2013-10-16 11:10:18', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1981-03-01', NULL, '');
INSERT INTO person VALUES (1212, 'Adriano Damas da Silva', '2013-10-16 15:10:22', 1, 'Teofilo Otoni', '', '282   ', 1, '                ', '                ', '         ', '', '', 'm', '1990-12-18', 4, 'single');
INSERT INTO person VALUES (1214, 'Adilsom de Almeida', '2013-10-16 16:10:27', 1, 'Minas Gerais', '', '1825  ', 18, '                ', '                ', '         ', '', '', 'm', '1984-09-25', NULL, 'single');
INSERT INTO person VALUES (1215, 'vanessa anielle de Moraes', '2013-10-16 16:10:48', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1995-02-21', NULL, 'single');
INSERT INTO person VALUES (1216, 'Pedro Machado Martins', '2013-10-16 16:10:21', 1, 'Jose Pedro Godoi Gomes', '', '522   ', 1, '                ', '                ', '         ', '', '', 'm', '1993-10-18', 14, 'single');
INSERT INTO person VALUES (1217, 'Petersom Perinoti de Ramos', '2013-10-16 16:10:43', 1, 'bento do amarl', '', '421   ', 1, '                ', '                ', '         ', '', '', 'm', '1981-05-03', 5, 'married');
INSERT INTO person VALUES (1218, 'Pedrop Ademir Silva', '2013-10-16 16:10:02', 1, 'sete de Setembro', '', 's/n   ', 1, '                ', '                ', '         ', '', '', 'm', '1968-11-11', 1, 'single');
INSERT INTO person VALUES (1219, 'Paulo Roberto Shen', '2013-10-16 16:10:31', 1, 'Ataide Ferreira', '', '8     ', 1, '                ', '                ', '         ', '', '', 'm', '1969-06-30', 7, 'single');
INSERT INTO person VALUES (1220, 'Paulo Cesaer Santos', '2013-10-16 16:10:41', 1, 'Jose Miara', '', '27    ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-16', 24, '');
INSERT INTO person VALUES (1221, 'Moacir dos Santos', '2013-10-21 08:10:12', 1, 'Marques de Sapucai', '', '501   ', 1, '                ', '                ', '         ', '', '', 'm', '1966-09-01', 32, 'single');
INSERT INTO person VALUES (1222, 'Marcelo Evandro de Lima', '2013-10-21 08:10:44', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1976-07-03', NULL, 'married');
INSERT INTO person VALUES (1223, 'Monica dos Santos Gonçalves', '2013-10-21 09:10:19', 1, 'Salvador Mendonça', '', '386   ', 1, '                ', '                ', '         ', '', '', 'm', '1994-11-12', 22, 'single');
INSERT INTO person VALUES (1224, 'Marcia Adriana de Vila', '2013-10-21 09:10:27', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1977-03-29', NULL, 'single');
INSERT INTO person VALUES (1225, 'Marco Aurelio de Oliveira', '2013-10-21 09:10:29', 1, 'Sabaldia', '', '645   ', 1, '                ', '                ', '         ', '', '', 'm', '1971-05-29', 31, 'single');
INSERT INTO person VALUES (1226, 'Marla Marli Costa Sigueira', '2013-10-21 09:10:11', 1, 'rua Londrina', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1948-10-10', 32, 'single');
INSERT INTO person VALUES (1227, 'Michele Caaroline de Oliveira', '2013-10-21 09:10:28', 1, 'rua Prai bom Jesus', '', 'l 02  ', 1, '                ', '                ', '         ', '', '', 'm', '2006-11-16', 21, 'single');
INSERT INTO person VALUES (1228, 'Monique dos Santos  Gonçalves', '2013-10-21 09:10:36', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1998-09-25', NULL, 'single');
INSERT INTO person VALUES (1229, 'Mauro Vicente de Matos', '2013-10-21 09:10:25', 1, 'Cruz de Souza', '', '279   ', 1, '                ', '                ', '         ', '', '', 'm', '1961-01-19', 4, 'separated');
INSERT INTO person VALUES (1230, 'Marco Davi de Jesus Lemes', '2013-10-21 09:10:44', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2006-07-28', NULL, 'single');
INSERT INTO person VALUES (1231, 'Macelo da Luz Pinto', '2013-10-21 09:10:59', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1980-02-22', NULL, 'single');
INSERT INTO person VALUES (1232, 'Marli Aparecida dos Santops', '2013-10-21 09:10:51', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1966-08-22', NULL, 'single');
INSERT INTO person VALUES (1233, 'Marcio Eliezer Just', '2013-10-21 09:10:57', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1974-10-15', NULL, 'single');
INSERT INTO person VALUES (1234, 'Evadio Joaquim Ferreira  da Silva', '2013-10-21 09:10:26', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1957-09-02', NULL, 'single');
INSERT INTO person VALUES (1198, 'Marco Antonio Gonçalves', '2013-10-16 11:10:22', 1, 'Alvaro Avim', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1967-07-12', 23, 'single');
INSERT INTO person VALUES (1210, 'Alaf Adriano Sampaio', '2013-10-16 11:10:53', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1991-02-06', NULL, 'married');
INSERT INTO person VALUES (1201, 'Arcisio Veiga', '2013-10-16 11:10:08', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1952-10-11', NULL, 'single');
INSERT INTO person VALUES (1235, 'Andersom Linhares de Abreu', '2013-10-21 09:10:09', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1973-05-28', NULL, 'single');
INSERT INTO person VALUES (1236, 'Welitom Aparecido Ternoski', '2013-10-25 08:10:42', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1999-01-01', NULL, '');
INSERT INTO person VALUES (1237, 'Wilsom Nunes da Silva', '2013-10-25 09:10:42', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1963-03-25', NULL, 'single');
INSERT INTO person VALUES (1238, 'Yoshio Matsuk', '2013-10-25 09:10:15', 1, 'Sete de Setenbro', '', '1512  ', 1, '                ', '                ', '         ', '', '', 'm', '1950-11-07', 1, 'married');
INSERT INTO person VALUES (1239, 'Washington Luiz', '2013-10-25 09:10:16', 1, '', '', '      ', 1, '                ', '(42)32261682    ', '         ', '', '', 'm', '1977-06-14', NULL, 'single');
INSERT INTO person VALUES (1240, 'Yago Matheus Ribeiro dos Santos', '2013-10-25 09:10:02', 1, 'Hunberto de Canpos', '', '757   ', 1, '                ', '                ', '         ', '', '', 'm', '1996-10-01', 5, 'single');
INSERT INTO person VALUES (1241, 'Rodrigo Martins Oliveira Silva', '2013-11-14 13:11:40', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1986-05-13', 1, 'single');
INSERT INTO person VALUES (1270, 'Wiliam Vinicius de Oliveira', '2013-11-20 14:11:54', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2006-03-08', NULL, 'single');
INSERT INTO person VALUES (1243, 'Leandro Ribeiro Coutinho', '2013-11-14 13:11:26', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1993-07-21', NULL, 'single');
INSERT INTO person VALUES (1244, 'Jair de Jesus', '2013-11-14 13:11:55', 1, 'Ermelino de Leao', '', '914   ', 1, '                ', '                ', '         ', '', '', 'm', '1960-12-28', 1, 'single');
INSERT INTO person VALUES (1245, 'Danilo da Rocha Paulino', '2013-11-14 13:11:33', 1, 'Paia', '', '193   ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-14', 33, 'single');
INSERT INTO person VALUES (1246, 'Hebrom Skolut', '2013-11-14 13:11:41', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1992-10-15', NULL, 'single');
INSERT INTO person VALUES (1248, 'Ludimila sIliva Pezzoti', '2013-11-14 13:11:42', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1982-05-25', NULL, 'married');
INSERT INTO person VALUES (1249, 'Israel do Prado', '2013-11-14 13:11:18', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1991-05-06', NULL, 'single');
INSERT INTO person VALUES (1276, 'Welingtom da Silva Ferreira', '2013-11-20 15:11:58', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1995-04-28', NULL, 'single');
INSERT INTO person VALUES (1250, 'Homero Antonio Medeiros', '2013-11-14 13:11:49', 1, 'Nogueira', '', '845   ', 1, '(42)99384336    ', '(42)32277891    ', '         ', '', '', 'm', '1963-04-01', 21, 'single');
INSERT INTO person VALUES (1251, 'Claudio Jose Ferreira', '2013-11-14 14:11:17', 1, 'Amadeu Magi', '', 's/n   ', 1, '(42)98171098    ', '(42)32314531    ', '         ', '', '', 'm', '2013-01-14', 24, 'single');
INSERT INTO person VALUES (1252, 'Rodrigo Maciel Honorio', '2013-11-14 14:11:53', 1, '', '', '      ', 8, '                ', '                ', '         ', '', '', 'm', '1990-11-18', NULL, 'single');
INSERT INTO person VALUES (1253, 'José Valdori Lopes', '2013-11-14 14:11:02', 1, 'Dominicio da Gama', '', '56    ', 1, '                ', '                ', '         ', '', '', 'm', '1991-01-04', 33, 'single');
INSERT INTO person VALUES (1254, 'Samuel de Sousa Ramos', '2013-11-14 14:11:10', 1, 'Avenida tubarão', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1993-11-15', NULL, 'single');
INSERT INTO person VALUES (1255, 'Nilsom Ferreiras PINTO', '2013-11-14 14:11:21', 1, '', '', '      ', 22, '                ', '                ', '         ', '', '', 'm', '1985-05-28', NULL, 'single');
INSERT INTO person VALUES (1256, 'Luiz Henrique Chamoski', '2013-11-14 14:11:15', 1, 'Ipanema', '', '270   ', 1, '(42)98145900    ', '(42)32296984    ', '         ', '', '', 'm', '1994-05-13', 41, 'single');
INSERT INTO person VALUES (1257, 'Odair Joaquim Gomes', '2013-11-14 14:11:02', 1, 'Avelino Pereira Canpos', '', '149   ', 1, '(42)99343282    ', '(42)32366154    ', '         ', '', '', 'm', '1969-04-23', 16, 'single');
INSERT INTO person VALUES (1258, 'Elisabethe Dabrowoski', '2013-11-14 14:11:18', 1, '', '', '      ', 1, '                ', '(42)32267867    ', '         ', '', '', 'm', '1971-08-14', NULL, 'single');
INSERT INTO person VALUES (1260, 'Anilda de Jesus Camargo de Camargo', '2013-11-14 15:11:03', 1, '', '', '      ', 1, '                ', '(42)32365696    ', '         ', '', '', 'f', '1942-08-06', NULL, 'single');
INSERT INTO person VALUES (1261, 'Clicel Faria', '2013-11-14 15:11:46', 1, 'Dom geraldo Pelanda', '', '1066  ', 1, '(42)88206541    ', '                ', '         ', '', '', 'm', '1981-03-08', 5, 'single');
INSERT INTO person VALUES (1262, 'Yago Mateus dos Santos', '2013-11-14 15:11:41', 1, 'Hunberto de canpos', '', '7757  ', 1, '                ', '                ', '         ', '', '', 'm', '1996-10-01', 5, 'single');
INSERT INTO person VALUES (1263, 'Waschingtom Luiz Costa', '2013-11-14 15:11:39', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1977-06-14', NULL, 'single');
INSERT INTO person VALUES (1264, 'Wlanir paschoal Gomes', '2013-11-14 15:11:36', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1970-04-14', NULL, 'single');
INSERT INTO person VALUES (1265, 'Marcelo da Silva', '2013-11-19 17:11:05', 1, 'Haroldo Schenberg', '', '82    ', 1, '                ', '                ', '         ', '', '', 'm', '1999-08-22', 1, 'single');
INSERT INTO person VALUES (1266, 'Rogério Rodrigues', '2013-11-19 17:11:27', 1, 'Prof. Balbina Branco', '', '138   ', 1, '                ', '                ', '         ', '', '', 'm', '1963-09-07', 42, 'single');
INSERT INTO person VALUES (1267, 'Carlos Eduardo de Siqueira', '2013-11-19 17:11:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-06-29', NULL, 'single');
INSERT INTO person VALUES (1268, 'Antonio Elizeu Martins', '2013-11-19 17:11:13', 1, 'Alvorada do Sul', '', '1113  ', 1, '(42)99409214    ', '(42)32275119    ', '         ', '', '', 'm', '1967-02-05', 16, 'single');
INSERT INTO person VALUES (1269, 'Wlanir Paschoal Gomes', '2013-11-20 14:11:09', 1, 'Paulo de Frontim', '', '680   ', 1, '                ', '                ', '         ', '', '', 'm', '1970-04-14', 33, 'married');
INSERT INTO person VALUES (1271, 'illiam Ricardo Candido', '2013-11-20 14:11:51', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1986-11-02', NULL, 'single');
INSERT INTO person VALUES (1272, 'Wilsom Grzieebelucka', '2013-11-20 14:11:47', 1, 'Francisco Ribas', '', '1125  ', 1, '(42)99715959    ', '(42)32369867    ', '         ', '', '', 'm', '1960-07-30', 1, 'single');
INSERT INTO person VALUES (1273, 'Valdomiro de Oliveira', '2013-11-20 15:11:39', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1960-09-20', NULL, 'single');
INSERT INTO person VALUES (1275, 'Walter José Perreira', '2013-11-20 15:11:23', 1, 'Mato Grosso', '', '410   ', 1, '                ', '                ', '         ', '', '', 'm', '1958-03-18', 5, 'single');
INSERT INTO person VALUES (1277, 'William Fabio Gonçalves', '2013-11-20 15:11:04', 1, 'Anita Garibaldi', '', '3001  ', 1, '                ', '                ', '         ', '', '', 'm', '1987-05-01', 24, 'single');
INSERT INTO person VALUES (1279, 'Wilsom Luiz da Silva', '2013-11-20 15:11:58', 1, 'rua 07', '', '459   ', 1, '                ', '                ', '         ', '', '', 'm', '1959-10-24', 13, 'single');
INSERT INTO person VALUES (1280, 'Cleversom Luiz Ferreira', '2013-12-16 13:12:22', 1, 'Republica do Paraná', '', '745   ', 1, '                ', '                ', '         ', '', '', 'm', '1989-10-17', 20, 'single');
INSERT INTO person VALUES (1281, 'Sérgio Renato Nima', '2013-12-16 13:12:08', 1, 'Jaguariaiva', '', '127   ', 1, '(42)99403802    ', '                ', '         ', '', '', 'm', '1963-05-09', 5, 'married');
INSERT INTO person VALUES (1282, 'Fabio Barom', '2013-12-16 13:12:33', 1, 'Pref. Brasilio Lilas', '', '350   ', 1, '(42)99217614    ', '(42)32293514    ', '         ', '', '', 'm', '1975-11-29', 27, 'single');
INSERT INTO person VALUES (1283, 'Aroldo Leite', '2013-12-16 14:12:33', 1, 'Antonio Wiliam Santos', '', '50    ', 1, '                ', '                ', '         ', '', '', 'm', '1965-08-28', 30, 'single');
INSERT INTO person VALUES (1242, 'Jose Roberto Marcondes dos Santos', '2013-11-14 13:11:29', 1, 'Capital Rocha', '', '3700  ', 20, '(42)99856891    ', '(42)88767650    ', '         ', '', '', 'm', '1991-02-28', NULL, 'single');
INSERT INTO person VALUES (1274, 'William Marques Pinheiro', '2013-11-20 15:11:16', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2009-05-04', NULL, 'single');
INSERT INTO person VALUES (1278, 'William Lincon da Silva', '2013-11-20 15:11:52', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1986-03-23', NULL, 'single');
INSERT INTO person VALUES (1259, 'Emanoel do Carmo Lima', '2013-11-14 14:11:08', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1964-02-19', NULL, 'single');
INSERT INTO person VALUES (1286, 'John Maico Franco', '2013-12-18 13:12:29', 1, 'Herculano de Freitas', '', '751   ', 1, '(42)99507920    ', '(42)99944199    ', '84015105 ', '', 'johnfranco22@gmail.com', 'm', '1996-03-14', 4, 'single');
INSERT INTO person VALUES (1284, 'Wagner Marques de Miranda Urbam', '2013-12-16 14:12:28', 1, 'Aleluia', '', '41    ', 1, '(42)98062023    ', '                ', '         ', '', 'wagnerurban@gmail.com', 'm', '1987-02-07', 21, 'single');
INSERT INTO person VALUES (1289, 'Domingos Sidney Pedroso', '2014-01-21 15:01:31', 1, '', '', '      ', 16, '                ', '                ', '         ', '', '', 'm', '2014-01-21', NULL, '');
INSERT INTO person VALUES (1290, 'Cleversson Luiz Ferreira', '2014-01-21 15:01:05', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2014-01-21', NULL, '');
INSERT INTO person VALUES (1291, 'Jhonatan Felipe Rodrigues', '2014-01-21 15:01:21', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2014-01-21', NULL, '');
INSERT INTO person VALUES (1292, 'Fabio Baron', '2014-01-21 15:01:05', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2014-01-21', NULL, '');
INSERT INTO person VALUES (1294, 'Alberi Wolffman', '2014-01-21 16:01:14', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1970-07-13', NULL, '');
INSERT INTO person VALUES (1295, 'Paulo Cesar Stanquiewiecks', '2014-01-21 16:01:07', 1, 'Rua Castanheira', '', '656   ', 1, '                ', '(42) 9851-7974  ', '84061370 ', '', '', 'm', '1972-02-21', 21, 'single');
INSERT INTO person VALUES (1296, 'Marcelo Baron', '2014-01-21 16:01:57', 1, 'Rua Ararúna', '', '470   ', 1, '(42) 99228087   ', '                ', '         ', '', '', 'm', '1970-07-17', 4, 'single');
INSERT INTO person VALUES (1297, 'Reinaldo Biano  de Sousa', '2014-01-21 16:01:35', 1, '', '', '      ', 23, '                ', '(61)95405233    ', '         ', '', '', 'm', '1975-08-12', NULL, 'single');
INSERT INTO person VALUES (1288, 'Oseias Felix de Oliveira', '2014-01-21 15:01:50', 1, '', '', '      ', 11, '                ', '(11)954348927   ', '         ', '', '', 'm', '2014-01-21', NULL, 'single');
INSERT INTO person VALUES (1298, 'Luiz Fernando dos Santos', '2014-01-21 16:01:56', 1, 'Rua Pandia Calígenes', '', '504   ', 1, '                ', '                ', '         ', '', '', 'm', '1978-05-25', 5, 'separated');
INSERT INTO person VALUES (1299, 'Paulo Vanderlei Pereira', '2014-01-21 16:01:52', 1, 'Rua Cesário Ahin', '', '500   ', 1, '(42) 9935-1982  ', '(42) 32223848   ', '         ', '', '', 'm', '1966-01-26', 33, 'stable union');
INSERT INTO person VALUES (1300, 'José Carlos de Oliveira', '2014-01-21 16:01:58', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1973-02-08', NULL, 'single');
INSERT INTO person VALUES (1301, 'Volni Nilsen', '2014-01-21 16:01:57', 1, 'Borrachão', '', '870   ', 1, '                ', '                ', '         ', '', '', 'm', '1982-09-30', 14, 'stable union');
INSERT INTO person VALUES (1302, 'Paulo Cesar Pontes', '2014-01-21 16:01:40', 1, '', '', '      ', 25, '(45)99086991    ', '                ', '         ', '', '', 'm', '1976-01-01', 14, 'single');
INSERT INTO person VALUES (1303, 'Jonatam Felipe Bilek', '2014-01-21 17:01:54', 1, 'Alberto Jose Mesomo', '', '190   ', 25, '                ', '(42)32260450    ', '         ', '', '', 'm', '1991-04-06', 5, 'single');
INSERT INTO person VALUES (1304, 'Osvaldo Vagner', '2014-01-21 17:01:44', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1960-10-10', NULL, 'separated');
INSERT INTO person VALUES (1305, 'Magno Xavier da Silva', '2014-01-22 15:01:20', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1990-06-01', 4, 'single');
INSERT INTO person VALUES (1306, 'Peterson Ferreira Brasil', '2014-01-22 15:01:03', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1978-10-17', 4, 'single');
INSERT INTO person VALUES (1159, 'Carlos Alberto Vida', '2013-10-14 16:10:45', 1, '', '', '      ', 5, '                ', '                ', '         ', '', '', 'm', '1973-11-08', NULL, 'single');
INSERT INTO person VALUES (1307, 'Tiago Bueno Franco', '2014-01-22 15:01:50', 1, 'Rua Matil de Bueno', '', '76    ', 1, '42 - 9822 2043  ', '42 - 3227 1453  ', '         ', '', '', 'm', '1988-03-12', 43, 'single');
INSERT INTO person VALUES (1287, 'peterson Terezio Vieira', '2014-01-21 14:01:04', 1, 'Chavier Pinheiro', '', '185   ', 1, '(42)99554904    ', '                ', '84030150 ', '', '', 'm', '2014-01-21', 5, 'stable union');
INSERT INTO person VALUES (1308, 'Tiago Ruiz Ribeiro', '2014-01-22 15:01:31', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1991-11-25', 4, 'single');
INSERT INTO person VALUES (1309, 'Alisson Aparecido de Paulo', '2014-01-30 11:01:17', 1, 'Rua Visconde de Jaguari', '', '103   ', 25, '                ', '(42)32277009    ', '         ', '', '', 'm', '1990-03-23', 14, 'single');
INSERT INTO person VALUES (1310, 'Fernando Stefaniak', '2014-02-03 15:02:09', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1979-06-13', NULL, 'single');
INSERT INTO person VALUES (1285, 'João Maria Pires', '2013-12-16 14:12:42', 1, '', '', '      ', 1, '(42)98383722    ', '                ', '         ', '', '', 'm', '1967-05-20', NULL, 'single');
INSERT INTO person VALUES (1311, 'Antonio Eliseu Martins', '2014-02-03 16:02:02', 1, 'Alvorada do Sul', '', '1113  ', 25, '(42)9940-9214   ', '(42)3227-5119   ', '         ', '', '', 'm', '1967-02-05', 16, 'single');
INSERT INTO person VALUES (1247, 'Paulo Cesar de oIiveira', '2013-11-14 13:11:57', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1978-02-19', NULL, 'single');
INSERT INTO person VALUES (566, 'Jonathan Cristovão Kogut Batista', '2013-09-05 10:09:25', 1, 'Homa', '', '132   ', 1, '                ', '                ', '         ', '', '', 'm', '1988-05-01', 7, 'single');
INSERT INTO person VALUES (1313, 'Jucelino da Silva Lemes', '2014-02-04 13:02:38', 1, 'Arenitos', '', '111   ', 1, '(42)99294138    ', '                ', '         ', '', '', 'm', '1976-05-03', 4, 'separated');
INSERT INTO person VALUES (1314, 'Anderson Aparecido de Anunciação', '2014-02-04 17:02:09', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1985-05-24', 4, 'single');
INSERT INTO person VALUES (1315, 'Clebson Silva Moura', '2014-02-05 13:02:02', 1, '', '', '      ', 7, '                ', '                ', '         ', '', '', 'm', '1992-04-23', NULL, 'single');
INSERT INTO person VALUES (476, 'Adriano Costa Fortes', '2013-08-30 11:08:07', 1, '', '', '      ', 5, '                ', '                ', '         ', '', '', 'm', '1981-09-25', NULL, 'single');
INSERT INTO person VALUES (200, 'Alam dos Santos Correia', '2013-08-22 13:08:38', 1, 'Armon', 'Prox ao mercado Prado', '217   ', 1, '(42)            ', '                ', '         ', '', '', 'm', '2013-01-22', NULL, '');
INSERT INTO person VALUES (426, 'Edgar Blanc Gonçalves', '2013-08-29 11:08:48', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1957-10-03', NULL, 'single');
INSERT INTO person VALUES (977, 'Edsom Luiz Eleuterio', '2013-10-04 15:10:08', 1, '15 de Novenbro', '', '977   ', 1, '                ', '                ', '         ', '', '', 'm', '2013-01-04', 1, 'single');
INSERT INTO person VALUES (1316, 'Alcione Silveira de Lima', '2014-02-05 16:02:42', 1, 'Joaquim Martins', '', '15    ', 1, '(42)99027354    ', '(42)99027354    ', '84052496 ', '', '', 'm', '1982-03-15', 21, 'single');
INSERT INTO person VALUES (1213, 'Adriam Henrique dos Santos', '2013-10-16 16:10:45', 1, 'Theodoro Cluppel Neto', '', '400   ', 1, '                ', '                ', '         ', '', '', 'm', '1997-09-24', 33, 'single');
INSERT INTO person VALUES (1293, 'Anderson Machado dos Santos', '2014-01-21 15:01:12', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1979-11-19', NULL, 'single');
INSERT INTO person VALUES (493, 'Paulo Henrique Floriano dos Santos', '2013-08-30 15:08:46', 1, '', '', '      ', 1, '(41)98784733    ', '                ', '         ', '', '', 'm', '1992-04-12', NULL, 'single');
INSERT INTO person VALUES (526, 'Olavo Brandt Guimarães', '2013-09-03 09:09:03', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1959-11-20', NULL, '');
INSERT INTO person VALUES (1317, 'Romualdo de Almeida', '2014-02-10 15:02:13', 1, 'Humberto de Campos', '', '1000  ', 1, '                ', '                ', '         ', '', '', 'm', '1946-09-19', NULL, 'stable union');
INSERT INTO person VALUES (1318, 'Juliano Domingos da Silva', '2014-02-10 15:02:14', 1, 'Julio Perneta', '', '620   ', 1, '                ', '                ', '         ', '', '', 'm', '1983-02-28', 23, 'stable union');
INSERT INTO person VALUES (1319, 'Divanir Aparecida Canetti', '2014-02-10 15:02:47', 1, 'rua arappostgresas', '', '697   ', 1, '                ', '                ', '         ', '', '', 'm', '1945-11-18', 31, 'widow(er)');
INSERT INTO person VALUES (1320, 'Paulo Cesar Padilha dos Santos', '2014-02-10 15:02:05', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1960-08-08', NULL, 'single');
INSERT INTO person VALUES (1312, 'Abel Gomes Muniz', '2014-02-03 17:02:11', 1, 'Herculano de Freitas', '', '751   ', 1, '                ', '(42)32239414    ', '         ', '', '', 'm', '1959-03-22', 4, 'single');
INSERT INTO person VALUES (1321, 'Edison Alves da Silva', '2014-02-10 15:02:02', 1, 'rua Bolivia', '', '500   ', 25, '                ', '                ', '         ', '', '', 'm', '1985-12-11', NULL, 'married');
INSERT INTO person VALUES (1322, 'Paulo Roberto Nascimento', '2014-02-10 17:02:41', 1, 'João Ceci Filho', '', '1055  ', 1, '                ', '                ', '         ', '', '', 'm', '1955-04-23', NULL, 'separated');
INSERT INTO person VALUES (805, 'Rodrigo Carneiro Vargas', '2013-09-19 09:09:49', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1988-11-08', NULL, 'single');
INSERT INTO person VALUES (1323, 'Gilmar Elias dos Santos', '2014-02-27 11:02:00', 1, 'cesinha matos de souza', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1968-10-22', 35, 'stable union');
INSERT INTO person VALUES (1325, 'Marcos Roberto Rodrigues', '2014-02-27 11:02:49', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1973-07-04', NULL, 'single');
INSERT INTO person VALUES (1108, 'Rogerio de Camargo', '2013-10-14 10:10:34', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1985-01-11', NULL, '');
INSERT INTO person VALUES (1326, 'Daniel dos Santos', '2014-02-27 16:02:19', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1970-09-27', NULL, 'widow(er)');
INSERT INTO person VALUES (1327, 'Willian Thiago de Oliveira', '2014-02-27 16:02:44', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1988-11-13', NULL, 'single');
INSERT INTO person VALUES (1328, 'Celso da Luz de Lima', '2014-02-27 16:02:13', 1, 'República do Panamá', '', '891   ', 1, '8405-6112       ', '                ', '         ', '', '', 'm', '1978-08-11', 20, 'stable union');
INSERT INTO person VALUES (1329, 'Divanci dos Santos Pinto', '2014-03-05 10:03:18', 1, 'Dayli  Luiz Wanbier', '', '3087  ', 1, '(42)99616245    ', '(42)99616245    ', '84015010 ', '', '', 'f', '1951-10-26', 24, 'married');
INSERT INTO person VALUES (1330, 'Indianara Schuinki', '2014-03-05 10:03:54', 1, 'av Visconde de Taunay', '', '1202  ', 1, '(42)99766863    ', '                ', '         ', '', '', 'f', '1990-11-09', NULL, 'single');
INSERT INTO person VALUES (1331, 'Cleverson Luiz Ferreira', '2014-03-05 11:03:03', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1989-10-17', NULL, 'single');
INSERT INTO person VALUES (1332, 'Emerson José de Araújo Campos', '2014-03-05 11:03:51', 1, 'Frei Caneca', '', '23    ', 1, '                ', '(42)32235907    ', '         ', '', '', 'f', '1975-05-22', 1, 'widow(er)');
INSERT INTO person VALUES (1333, 'Claudecir Bento', '2014-03-05 11:03:56', 1, 'Durval Wollf', '', '638   ', 1, '(42)98233746    ', '                ', '         ', '', '', 'f', '1975-03-29', 16, 'married');
INSERT INTO person VALUES (1334, 'Allan Dionei Marques', '2014-03-05 11:03:39', 1, '', '', '      ', 12, '                ', '                ', '         ', '', '', 'f', '1981-10-28', NULL, 'single');
INSERT INTO person VALUES (1335, 'Andersom Luiz Westphal', '2014-03-05 13:03:28', 1, 'Maringá', '', '576   ', 1, '(47)96600730    ', '(42)32364530    ', '         ', '', '', 'f', '1979-01-01', 31, 'single');
INSERT INTO person VALUES (1336, 'Alexandre Souza Clemente', '2014-03-05 13:03:54', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1979-05-28', NULL, 'single');
INSERT INTO person VALUES (1337, 'Nilson Rosa dos Santos', '2014-03-06 12:03:09', 1, 'Rua Candido Borsato', '', '405   ', 1, '99335785        ', '                ', '         ', '', '', 'm', '1969-04-25', 5, 'single');
INSERT INTO person VALUES (1338, 'Ana Carolina Reis', '2014-03-06 13:03:02', 1, 'Rua Admar Horn', '12', '406   ', 1, '9154-1713       ', '(42) 3027-5047  ', '         ', '', 'sr.anacarolina@gmail.com', 'f', '1979-09-15', 24, 'married');
INSERT INTO person VALUES (1339, 'Indianara Schuinki', '2014-03-07 10:03:54', 1, 'Viscinde de Tunay', '', '1202  ', 1, '(42)9976-6863   ', '(42)3222-3326   ', '         ', '', '', 'f', '2013-09-03', 1, 'single');
INSERT INTO person VALUES (1340, 'Jair Ubirajara Solonski', '2014-03-10 07:03:46', 1, 'Gregorio da Fonseca', '', '145   ', 1, '                ', '                ', '         ', '', '', 'm', '1962-01-01', NULL, 'married');
INSERT INTO person VALUES (709, 'Gilson Gonçalves da silva', '2013-09-16 11:09:46', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1975-07-08', NULL, 'single');
INSERT INTO person VALUES (1341, 'João Alberto Bahr Cordeiro', '2014-03-10 11:03:57', 1, 'Paul Haris', '', '271   ', 1, '                ', '                ', '         ', '', '', 'm', '1966-06-19', 16, 'single');
INSERT INTO person VALUES (1342, 'Anderson Soares', '2014-03-10 11:03:15', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1981-10-20', NULL, 'single');
INSERT INTO person VALUES (1343, 'Jorge Roberto Silveira', '2014-03-10 11:03:16', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1960-12-03', NULL, 'separated');
INSERT INTO person VALUES (1344, 'Jose Lourival Lopes', '2014-03-10 11:03:07', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1963-11-08', NULL, 'single');
INSERT INTO person VALUES (1324, 'Rodrigo Ribeiro', '2014-02-27 11:02:22', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1987-08-04', NULL, 'single');
INSERT INTO person VALUES (218, 'Antonio Pereira de Brito', '2013-08-23 08:08:28', 1, 'Sampaio Bitencourt', '', '201   ', 1, '                ', '                ', '         ', '', '', 'm', '1940-11-24', NULL, 'single');
INSERT INTO person VALUES (1345, 'Antonio Medeiros da Silva', '2014-03-11 08:03:03', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1955-08-08', NULL, 'single');
INSERT INTO person VALUES (1346, 'Luiz Fabio de Lara', '2014-03-11 09:03:40', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1980-12-01', NULL, 'single');
INSERT INTO person VALUES (1347, 'Celso Andre de Souza', '2014-03-11 09:03:01', 1, 'Abilio Rosman', '', '366   ', 1, '                ', '                ', '         ', '', '', 'f', '1984-11-19', 25, 'single');
INSERT INTO person VALUES (1348, 'Jorge Luiz dos Santos', '2014-03-11 09:03:04', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'f', '1982-01-21', NULL, 'single');
INSERT INTO person VALUES (1349, 'Douglas Ribeiro Batista', '2014-03-11 09:03:06', 1, 'Beira rio', '', '50    ', 1, '                ', '                ', '         ', '', '', 'f', '2005-09-07', 24, 'single');
INSERT INTO person VALUES (1350, 'Adriano Patricio', '2014-03-11 10:03:27', 1, '', '', '      ', 1, '(42)98243373    ', '                ', '         ', '', '', 'f', '1987-02-22', NULL, 'single');
INSERT INTO person VALUES (1351, 'Miroslau Dias Rosas', '2014-03-11 11:03:14', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '2014-03-11', NULL, '');
INSERT INTO person VALUES (1352, 'Paulo Rodrigues Pereira', '2014-03-11 11:03:00', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1972-09-01', NULL, 'single');
INSERT INTO person VALUES (1353, 'Jose Antonio Cardoso', '2014-03-11 11:03:26', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1952-12-22', NULL, 'married');
INSERT INTO person VALUES (1354, 'Carlos Rodrigues de Oliveira', '2014-04-14 09:04:56', 1, 'Washington Luis', 'quadra L', '66    ', 1, '                ', '                ', '         ', '', '', 'm', '1965-12-01', 11, 'married');
INSERT INTO person VALUES (1355, 'João Augusto da Veiga', '2014-04-14 10:04:02', 1, 'Orlando Henenberg', '', '494   ', 1, '                ', '                ', '         ', '', '', 'm', '1957-09-16', 35, 'married');
INSERT INTO person VALUES (1356, 'Graucilene do Rocio de Andrade', '2014-04-14 11:04:18', 1, 'Centenario do Sul', '', '47    ', 1, '                ', '                ', '         ', '', '', 'f', '1970-03-17', 31, 'stable union');
INSERT INTO person VALUES (1357, 'Clair do Rocio Galvão Kiel de Lara', '2014-04-15 12:04:55', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1962-02-05', 23, 'married');
INSERT INTO person VALUES (1358, 'Alessandro Augusto Danilow', '2014-04-22 10:04:39', 1, '', '', '      ', 10, '(42)99342830    ', '                ', '         ', '', '', 'm', '1984-12-18', NULL, 'single');
INSERT INTO person VALUES (1359, 'Graucilene do Rocio Andrade', '2014-04-23 10:04:11', 1, 'Centenário do sul', '', '47    ', 1, '(42)84086757    ', '                ', '         ', '', '', 'f', '1970-03-17', 31, 'stable union');
INSERT INTO person VALUES (208, 'Adilson Cabral', '2013-08-22 15:08:24', 1, 'Cirio libanes (marquise)', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1975-08-21', 1, 'single');
INSERT INTO person VALUES (1360, 'Ana Carolina Reis', '2014-04-24 12:04:34', 1, '', '', '      ', 1, '91541713        ', '                ', '         ', '', '', 'f', '1979-09-15', 4, 'married');
INSERT INTO person VALUES (1361, 'Leandro Santos Costa', '2014-04-29 08:04:02', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1991-10-28', NULL, 'single');
INSERT INTO person VALUES (1362, 'Adilsom Correia da Luz', '2014-04-29 09:04:17', 1, 'Gralha Azul', '', '151   ', 1, '(42)99563060    ', '                ', '         ', '', '', 'm', '1981-03-18', NULL, 'single');
INSERT INTO person VALUES (1363, 'Flavio William Sousa Santos', '2014-04-29 09:04:38', 1, 'Canyon Guartela', '', '151   ', 1, '(42)99563060    ', '(42)82958261    ', '         ', '', '', 'm', '1989-02-08', NULL, 'single');
INSERT INTO person VALUES (1364, 'Carlos Rodrigues de Oliveira', '2014-04-29 09:04:23', 1, '31 de Março', '', '66    ', 1, '                ', '                ', '         ', '', '', 'm', '1965-12-01', 11, 'single');
INSERT INTO person VALUES (1365, 'Vanderlei Rosa', '2014-04-29 09:04:14', 1, '', '', '      ', 1, '                ', '(42)98013118    ', '         ', '', '', 'm', '1978-07-13', NULL, 'single');
INSERT INTO person VALUES (1366, 'Joelma Tais Pereira', '2014-04-29 10:04:07', 1, 'Mauricio de Nassau', '', '2615  ', 1, '(42)99986922    ', '(42)32368227    ', '         ', '', '', 'f', '1992-01-03', 31, 'single');
INSERT INTO person VALUES (1367, 'Ana dos Santos Gonçalves', '2014-04-29 10:04:11', 1, 'Apucarana', '', '43    ', 1, '(42)99937091    ', '                ', '         ', '', '', 'f', '1962-01-30', 31, 'single');
INSERT INTO person VALUES (1368, 'Marilda de Mattos', '2014-04-29 10:04:07', 1, 'Antonio Antunes de Nascimento', '', '16    ', 1, '                ', '                ', '         ', '', '', 'f', '1959-07-04', 11, 'widow(er)');
INSERT INTO person VALUES (1369, 'Michel Alceu', '2014-04-29 10:04:03', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1987-06-29', NULL, 'single');
INSERT INTO person VALUES (1370, 'Jurema Gonçalves dos Santos', '2014-04-29 10:04:05', 1, 'Pauliia de Oliveira Gomes  (jd Amalia )', '', 'LT9   ', 1, '(42)98211730    ', '                ', '         ', '', '', 'f', '1972-06-19', 4, 'single');
INSERT INTO person VALUES (1371, 'Marcelo Miranda Silva', '2014-04-29 11:04:16', 1, 'Emiliano Moreira de Almeida', '', '09    ', 3, '                ', '                ', '         ', '', '', 'm', '1977-11-01', NULL, 'single');
INSERT INTO person VALUES (1372, 'Daniel Pires Padilha', '2014-04-29 13:04:26', 1, 'Antunes nascimento', '', '164   ', 1, '                ', '                ', '         ', '', '', 'm', '1981-09-10', 45, 'single');
INSERT INTO person VALUES (1373, 'Airtom do carmo', '2014-04-29 14:04:31', 1, 'Galo da Campina', '', '91    ', 1, '                ', '(42)84077726    ', '         ', '', '', 'm', '1965-07-16', 14, 'married');
INSERT INTO person VALUES (1374, 'marcel', '2014-04-29 17:04:04', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ' ', NULL, NULL, NULL);
INSERT INTO person VALUES (1375, 'Matilde da Luz de Lima', '2014-04-30 09:04:01', 1, 'Centenário do sul', '', '47    ', 1, '                ', '                ', '         ', '', '', 'f', '1958-06-15', 31, 'single');
INSERT INTO person VALUES (1376, 'Edgard de Lima', '2014-04-30 09:04:36', 1, 'Centenario do Sul', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1956-09-29', 31, 'single');
INSERT INTO person VALUES (1377, 'Gledson William kwiatkowski', '2014-04-30 09:04:24', 1, 'Patativa', '', '654   ', 1, '(42)99965273    ', '(42)32367556    ', '         ', '', '', 'm', '1993-11-18', 24, 'single');
INSERT INTO person VALUES (1378, 'Vanessa Gonçalves Choma', '2014-04-30 09:04:58', 1, 'Mauricio e Nassau', '', '1934  ', 1, '(42)99249080    ', '                ', '         ', '', '', 'f', '1993-11-19', 22, 'married');
INSERT INTO person VALUES (1379, 'Luiz Rogerio de Jesus', '2014-04-30 09:04:03', 1, 'Paulo Frontim', '', '1250  ', 1, '                ', '(42)30861547    ', '         ', '', '', 'm', '1985-09-04', 24, '');
INSERT INTO person VALUES (1380, 'Sandrine Adrian Coito', '2014-04-30 09:04:16', 1, 'NSI', '', '01    ', 1, '(42)84086751    ', '                ', '         ', '', '', 'f', '1985-08-19', 20, 'stable union');
INSERT INTO person VALUES (1381, 'Jeniffer Amada de Lima', '2014-04-30 09:04:36', 1, 'Batuira', '', '406   ', 1, '(42)99327440    ', '(42)30875874    ', '         ', '', '', 'm', '1991-11-11', 36, 'single');
INSERT INTO person VALUES (1382, 'Allam Diego do Carmo Kloster', '2014-05-05 10:05:11', 1, 'Monte Alverne', '', '762   ', 1, '(42)9957-4547   ', '(42)3238-2804   ', '         ', '', '', 'm', '1995-11-19', 4, 'single');
INSERT INTO person VALUES (1383, 'Fabricio da Silva Rosa', '2014-05-05 10:05:22', 1, 'Graviola (Bairro Aroeira)', '', '139   ', 1, '(42)99037008    ', '(42)32263615    ', '         ', '', '', 'm', '1987-08-24', NULL, 'single');
INSERT INTO person VALUES (1384, 'Isaac Dona De Lara', '2014-05-05 10:05:31', 1, '', '', '      ', 1, '(42)88896923    ', '                ', '         ', '', '', 'm', '1984-08-16', NULL, 'single');
INSERT INTO person VALUES (1385, 'Celso Alaor Cardoso', '2014-05-05 10:05:36', 1, 'Florianopolis', '', '216   ', 1, '(42)9834-9825   ', '                ', '         ', '', '', 'm', '1993-02-07', 3, 'single');
INSERT INTO person VALUES (1386, 'Felipe Cruz Oliveira', '2014-05-06 13:05:33', 1, 'Capitão Fedrio Afonço', '', '82    ', 1, '(42)99228054    ', '(42)32233674    ', '         ', '', '', 'm', '1994-06-29', 20, 'single');
INSERT INTO person VALUES (1387, 'Tarik Sander de Mello', '2014-05-06 14:05:02', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1989-10-14', NULL, 'single');
INSERT INTO person VALUES (1388, 'Izaque de Assis', '2014-05-06 14:05:19', 1, 'Decio Vargani', '', '07    ', 1, '(42)98038215    ', '                ', '         ', '', '', 'm', '1985-05-18', 5, 'married');
INSERT INTO person VALUES (1389, 'Andersom Domingues da Rosa', '2014-05-06 14:05:31', 1, 'Basilio da Gama', '', '40    ', 1, '(42)99819024    ', '                ', '         ', '', '', 'm', '1984-10-27', 16, 'single');
INSERT INTO person VALUES (1390, 'Charles Oliveira da Silva', '2014-05-06 14:05:03', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1984-12-25', NULL, 'single');
INSERT INTO person VALUES (1391, 'José Smak Sobrinho', '2014-05-06 14:05:35', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1963-01-15', NULL, 'single');
INSERT INTO person VALUES (1392, 'Jeferson de Jesus Rodrigues Freitas', '2014-05-06 14:05:25', 1, 'Ana Clara Gomes Correia', '', '17    ', 1, '(42)99625474    ', '                ', '         ', '', '', 'm', '1992-03-17', 18, 'single');
INSERT INTO person VALUES (1393, 'Nelsom de Lima', '2014-05-06 15:05:08', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1951-06-22', NULL, 'single');
INSERT INTO person VALUES (1394, 'Luiza Aparecida Ferreira Pinheiro', '2014-05-14 11:05:56', 1, 'Chopinzinho', '', '144   ', 1, '                ', '                ', '         ', '', '', 'm', '1974-07-30', 20, 'separated');
INSERT INTO person VALUES (1395, 'Adriano Aparecido Ramos Ferreira', '2014-05-14 13:05:47', 1, 'Irmã Noeli Maria e Silva', '', '53    ', 1, '(42)84077645    ', '                ', '         ', '', '', 'm', '1972-04-25', 31, 'married');
INSERT INTO person VALUES (1396, 'Silvio Cesar Galvão Carneiro', '2014-05-14 13:05:32', 1, 'Francisco Fajardo', '', '112   ', 1, '(42)99262238    ', '                ', '         ', '', '', 'm', '1973-05-05', 33, 'married');
INSERT INTO person VALUES (1397, 'Eliane Hosana Antunes dos Santos', '2014-05-14 13:05:29', 1, 'Luiz Oliveira Silva', '', '212   ', 25, '(42)99501631    ', '                ', '         ', '', '', 'm', '1987-10-30', 35, 'married');
INSERT INTO person VALUES (1398, 'Rodolfo José Rothestem', '2014-05-14 14:05:24', 1, 'Frei Leão do Sacramento', '', '874   ', 1, '(42)99551252    ', '                ', '         ', '', '', 'm', '1974-09-04', 20, 'single');
INSERT INTO person VALUES (1399, 'Jose Ferreira de Lara', '2014-05-14 14:05:13', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1963-07-13', 23, 'married');
INSERT INTO person VALUES (1400, 'Andersom Luiz Nascimento', '2014-05-16 08:05:28', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1980-02-05', NULL, 'single');
INSERT INTO person VALUES (1401, 'Sebastiana de Lurdes  Oliveira', '2014-05-16 09:05:43', 1, 'Acacio Gomes Martins     Bairro Hatenas', '', '77    ', 1, '(42)99089222    ', '                ', '         ', '', '', 'm', '1954-04-02', NULL, 'married');
INSERT INTO person VALUES (1402, 'Cristiane de Fatima  Dobiniki', '2014-05-16 10:05:06', 1, 'Francisco Frajardo', '', '885   ', 1, '(42)98200596    ', '                ', '84035050 ', '', '', 'm', '1991-09-01', 33, 'single');
INSERT INTO person VALUES (1403, 'Pedro Alves Gonçalves', '2014-05-16 10:05:46', 1, 'Mandaguari', '', '452   ', 1, '                ', '                ', '         ', '', '', 'm', '1968-12-23', 5, 'married');
INSERT INTO person VALUES (1404, 'Renato Fernando Fernandes', '2014-05-16 10:05:01', 1, 'Mendes Timoteo', '', '7     ', 1, '                ', '(42)98431936    ', '         ', '', '', 'm', '2014-05-16', 20, 'separated');
INSERT INTO person VALUES (1405, 'Joao Algusto da Veiga', '2014-05-16 11:05:37', 1, 'Orlando Enenberg', '', '494   ', 1, '(42)98372482    ', '                ', '         ', '', '', 'm', '1957-09-16', 35, 'married');
INSERT INTO person VALUES (1406, 'Giam Lucas da Silva', '2014-05-16 14:05:27', 1, 'Zeus', '', '367   ', 1, '(42)99964544    ', '                ', '         ', '', '', 'm', '1994-04-09', 16, 'single');
INSERT INTO person VALUES (1407, 'Pedro Estevão de Camargo', '2014-05-16 14:05:25', 1, 'Paulo Grotte  bairro  (St Lucia )', '', '16    ', 1, '                ', '                ', '         ', '', '', 'm', '1954-07-28', 15, 'single');
INSERT INTO person VALUES (1408, 'Antonio dos Santos', '2014-05-16 14:05:23', 1, 'Walter Fernandes  (Jardim Maracanã)', '', '345   ', 1, '                ', '                ', '         ', '', '', 'm', '1952-02-03', 4, 'separated');
INSERT INTO person VALUES (1409, 'Jose Nelsom Dos Santos', '2014-05-16 14:05:55', 1, 'Leandro Rocha Wender', '', '09    ', 1, '(42)99443223    ', '                ', '         ', '', '', 'm', '1971-04-09', 4, 'stable union');
INSERT INTO person VALUES (1410, 'Fabricio Ricardo de Souza', '2014-05-16 14:05:40', 1, 'Evaldo Braga', '', '42    ', 1, '(42)98136934    ', '                ', '         ', '', '', 'm', '1991-08-30', 20, 'single');
INSERT INTO person VALUES (1411, 'Nivom dos Santos', '2014-05-16 14:05:04', 1, 'Jacobs Nadal (vila Nadal)', '', '10    ', 1, '                ', '                ', '         ', '', '', 'm', '1954-11-05', NULL, 'single');
INSERT INTO person VALUES (1412, 'Jonathan Assunção Taques Marcelino', '2014-05-16 14:05:32', 1, 'Maciel', '', '8     ', 1, '                ', '(42)3229-2877   ', '         ', '', '', 'm', '1988-12-28', 14, 'married');
INSERT INTO person VALUES (1413, 'Maria Neuza Vaz', '2014-05-22 08:05:51', 1, 'Pedro Francisco Buss', '', '94    ', 1, '                ', '(42)32239003    ', '         ', '', '', 'f', '1980-09-23', 35, 'single');
INSERT INTO person VALUES (1414, 'Jocelene Charles Vaz', '2014-05-22 08:05:00', 1, 'Nestor Vitor', '', '60    ', 1, '(42)99885642    ', '                ', '         ', '', '', 'f', '1974-11-06', 20, 'single');
INSERT INTO person VALUES (1415, 'Bruno Gonçalves da Rosa', '2014-05-22 09:05:57', 1, '', '', '      ', 1, '(42)99104912    ', '                ', '         ', '', '', 'm', '1997-12-15', 35, 'single');
INSERT INTO person VALUES (1416, 'Bruno Gonçalves da Rosa', '2014-05-22 13:05:48', 1, '', '', '      ', 1, '(42)99104912    ', '                ', '         ', '', '', 'm', '1997-12-15', NULL, 'single');
INSERT INTO person VALUES (1417, 'Jorge Luiz Lemes da Luz', '2014-05-22 13:05:49', 1, '', '', '      ', 1, '(42)9800-8968   ', '                ', '         ', '', '', 'm', '1954-06-29', NULL, 'single');
INSERT INTO person VALUES (1418, 'Sidnei José Sperandio', '2014-05-22 13:05:35', 1, '', '', '      ', 4, '                ', '                ', '         ', '', '', 'm', '1971-10-03', NULL, 'single');
INSERT INTO person VALUES (1419, 'Leandro Pereira', '2014-05-22 13:05:48', 1, 'Mauricio de Nassau', '', '2513  ', 1, '(42)99852501    ', '                ', '         ', '', '', 'm', '1983-12-29', 31, 'separated');
INSERT INTO person VALUES (1420, 'Nelci de Lurdes Braga', '2014-05-22 13:05:17', 1, 'Itaciano Teixeira de Freitas', '', '845   ', 1, '(42)9801-4520   ', '                ', '         ', '', '', 'f', '1961-12-25', 35, 'stable union');
INSERT INTO person VALUES (1421, 'Luciane dos Santos Treder', '2014-05-22 13:05:02', 1, 'Cilas Salem', '', '556   ', 1, '(42)98022460    ', '                ', '         ', '', '', 'f', '1976-02-12', 18, 'married');
INSERT INTO person VALUES (1422, 'Gilberto Antonio Fogaça', '2014-05-22 14:05:29', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1967-03-07', NULL, 'single');
INSERT INTO person VALUES (1168, 'Alessandro de almeida', '2013-10-14 16:10:02', 1, 'Bitencurte sanpaio', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1999-09-02', 22, 'single');
INSERT INTO person VALUES (188, 'Amiltom Cesar Barbosa', '2013-08-22 11:08:05', 1, 'Elizandra Alves', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1974-11-11', 21, 'single');
INSERT INTO person VALUES (1423, 'Rogério Peixoto', '2014-05-29 10:05:32', 1, '', '', '      ', 1, '(42)99724000    ', '                ', '         ', '', '', 'm', '1973-03-12', NULL, 'single');
INSERT INTO person VALUES (1424, 'Michele Daiane Rosa', '2014-05-29 10:05:34', 1, 'Santo Flavio', '', '398   ', 1, '                ', '(42)3087-0509   ', '         ', '', '', 'm', '1987-06-28', 16, 'single');
INSERT INTO person VALUES (1425, 'Elias Forte da Silva', '2014-05-29 10:05:05', 1, '', '', '      ', 1, '                ', '(41)3047-1315   ', '         ', '', '', 'm', '1982-10-16', NULL, 'single');
INSERT INTO person VALUES (1426, 'Raquel do Prado', '2014-05-29 10:05:30', 1, 'Eugenio José Boch', '', '220   ', 1, '(42)98395524    ', '                ', '         ', '', '', 'f', '1983-05-12', 7, 'single');
INSERT INTO person VALUES (1427, 'Angela Maria Fagundes', '2014-05-29 10:05:03', 1, 'Sousa Franco', '', '508   ', 21, '(41)9711-1691   ', '                ', '         ', '', '', 'f', '1979-04-22', 4, 'single');
INSERT INTO person VALUES (1428, 'Francieli Ramos Ferreira', '2014-05-29 10:05:56', 1, 'Irmã Noeli', '', '53    ', 1, '(42)84077645    ', '                ', '         ', '', '', 'f', '1989-07-26', 31, 'single');
INSERT INTO person VALUES (1429, 'José Edinaldo Gonçalves', '2014-05-29 11:05:14', 1, 'Francisco Valenga  (Jd Viviane )', '', '29    ', 1, '(42)9107-3357   ', '                ', '         ', '', '', 'm', '1956-10-30', NULL, 'single');
INSERT INTO person VALUES (1430, 'Alessandro Rodrigo Vaz', '2014-05-29 11:05:42', 1, 'Ivo São Lourenço', '', '19    ', 1, '                ', '                ', '         ', '', '', 'm', '1980-11-06', 43, 'single');
INSERT INTO person VALUES (1431, 'Jorge Dias da Luz', '2014-05-29 11:05:12', 1, '', '', '      ', 1, '(42)9974-6598   ', '                ', '         ', '', '', 'm', '1980-07-28', NULL, '');
INSERT INTO person VALUES (1432, 'Luiz Fabiano  Oliveira dos Santos', '2014-05-29 11:05:32', 1, '', '', '      ', 1, '(42)99932778    ', '                ', '         ', '', '', 'm', '2014-05-29', NULL, '');
INSERT INTO person VALUES (1433, 'Claudinei Cesar do Rosario', '2014-05-29 11:05:01', 1, '', '', '      ', 1, '                ', '                ', '         ', '', '', 'm', '1971-01-14', NULL, 'single');
INSERT INTO person VALUES (735, 'Helio Furquim de Camargo''', '2013-09-17 10:09:29', 1, 'Rua 1,', '', '192   ', 1, '                ', '                ', '         ', '', '', 'm', '1973-08-12', 21, 'married');


--
-- TOC entry 2129 (class 0 OID 49838)
-- Dependencies: 164
-- Data for Name: person_docs; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO person_docs VALUES (20, '4.424.682-1', '427.413.279-04', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (29, '', '089.930.289-07', '', '207.63241.42.8', '', '', '', '');
INSERT INTO person_docs VALUES (37, '57233842', '02135631930', '', '', '02617166899', '64431720604', '', '');
INSERT INTO person_docs VALUES (38, '81699542', '05098323932', '25392', '64892500001', '05265507176', '078199840604', '81699542', '');
INSERT INTO person_docs VALUES (6, '13.375.707-4', '103.079.529-08', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (44, '8.136.705-1', '058.709.659-42', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (45, '13.044.920-4', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (46, '29.317.090-3', '170.360.598-50', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (35, '13.699.563-4', '012.513.759-10', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (47, '4.612.999-4', '319.764.658-42', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (62, '812.801-4', '', '', '', '', '007924400620', '', '');
INSERT INTO person_docs VALUES (97, '12333455-8', '088993839-36', '', '14238866270', '', '', '', '');
INSERT INTO person_docs VALUES (104, '39315017', '44236271915', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (54, '136995634', '01251375910', '', '', '', '105291010639', '151832930870', '');
INSERT INTO person_docs VALUES (103, '48193786', '40465569862', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (105, '95479480', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (106, '', '', '', '', '', '007924400620', '', '');
INSERT INTO person_docs VALUES (108, '18577476', '10982885644', '', '', '', '172867640299', '', '');
INSERT INTO person_docs VALUES (109, '293170903', '17036059850', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (116, '66782158', '56214286920', '', '00440975001', '', '', '', '');
INSERT INTO person_docs VALUES (117, '70202123', '04900630985', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (58, '53894992', '70256934991', '', '3719219', '', '031514720639', '', '');
INSERT INTO person_docs VALUES (88, '084517015519801', '', '', '00011030000488676', '', '', '', '');
INSERT INTO person_docs VALUES (79, '99064080', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (80, '77297405', '01046759930', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (76, '88639626', '', '', '3838670', '', '', '', '');
INSERT INTO person_docs VALUES (73, '107944877', '07602223985', '', '16631407401', '', '91855660671', '', '');
INSERT INTO person_docs VALUES (42, '54545592', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (121, '84958409', '04872570901', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (60, '138413856', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (123, '', '', '104584', '', '', '', '', '');
INSERT INTO person_docs VALUES (124, '', '', '38409378', '', '', '', '', '');
INSERT INTO person_docs VALUES (126, '', '', '032655', '', '', '', '', '');
INSERT INTO person_docs VALUES (127, '', '', '4249223', '', '', '', '', '');
INSERT INTO person_docs VALUES (128, '', '', '1562867', '', '', '', '', '');
INSERT INTO person_docs VALUES (129, '', '', '468004031', '', '', '', '', '');
INSERT INTO person_docs VALUES (130, '', '', '30517083061', '', '', '', '', '');
INSERT INTO person_docs VALUES (131, '', '', '15301067', '', '', '', '', '');
INSERT INTO person_docs VALUES (133, '46129994', '31976465842', '', '933931284 sp', '', '', '', '');
INSERT INTO person_docs VALUES (134, '101867676', '07275779994', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (135, '105714963', '74181955915', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (136, '394042529', '02730703985', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (138, '', '06418709900', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (139, '70878623', '00411056999', '', '22641', '', '', '', '8980011222788268');
INSERT INTO person_docs VALUES (140, '51041410', '', '', '', '', '45214400698', '', '');
INSERT INTO person_docs VALUES (143, '82931112', '', '', '', '', '', '151832592886', '');
INSERT INTO person_docs VALUES (144, '78520370', '02307207902', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (147, '95513743', '01115996959', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (152, '88317041', '03892558906', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (154, '1233945433', '01243858931', '', '3477668', '', '', '', '');
INSERT INTO person_docs VALUES (158, '83164310', '88273326934', '', '2416595040', '', '', '', '');
INSERT INTO person_docs VALUES (160, '78286866', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (161, '93237773', '06174727939', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (163, '59201980', '05439848932', '', '12341172646', '', '057135780698', '438189', '');
INSERT INTO person_docs VALUES (164, '80686870', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (165, '132583013', '09191613914', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (167, '80099231', '02589715927', '', '88659', '', '', '', '');
INSERT INTO person_docs VALUES (170, '57753250', '88318621972', '', '', '01071186621', '', '', '');
INSERT INTO person_docs VALUES (171, '96765886', '06457367917', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (172, '100138700', '06328089937', '', '', '', '085526150623', '', '');
INSERT INTO person_docs VALUES (173, '35165150', '47979712900', '', '', '', '043948790604', '', '');
INSERT INTO person_docs VALUES (175, '', '', '127584', '', '', '', '', '');
INSERT INTO person_docs VALUES (178, '22396110', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (181, '6902294', '41128419904', '', '', '', '007818400680', '', '');
INSERT INTO person_docs VALUES (183, '6145311 (sp)', '02927521999 (sp)', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (186, '', '06283027970', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (187, '54137699', '80135595991', '', '123308888122', '', '', '', '');
INSERT INTO person_docs VALUES (189, '96954670', '05712013932', '', '', '', '0085534970680', '151832686951', '');
INSERT INTO person_docs VALUES (190, '', '', '', '8361432', '', '', '', '');
INSERT INTO person_docs VALUES (196, '18723344', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (197, '109719951', '07460993980', '', '0683422', '', '096757000604', '151832733589', '');
INSERT INTO person_docs VALUES (198, '126059469', '08814753946', '', '', '', '091781262055', '151832820782', '');
INSERT INTO person_docs VALUES (199, '127881988', '08720364997', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (200, '133700200', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (201, '3316066900', '43477585968', '', '1870043', '', '', '', '');
INSERT INTO person_docs VALUES (204, '9240823', '05999156920', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (205, '41568496', '', '', '27177', '', '', '', '');
INSERT INTO person_docs VALUES (207, '4r2864086', '72941502904', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (208, '62052554', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (209, '109853941', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (210, '81555397', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (212, '54137699', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (220, '9404663-7', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (222, '15443618', '24443620982', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (223, '123366417', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (224, '78361360', '02651799980', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (225, '10779012', '03813889645', '', '', '757340100', '', '150022105608', '');
INSERT INTO person_docs VALUES (227, '126893132', '08143948927', '', '', '', '096285470680', '', '');
INSERT INTO person_docs VALUES (230, '105193319', '', '', '', '', '', '698944', '');
INSERT INTO person_docs VALUES (231, '31994101', '50078151953', '', '10822026055', '', '07575080647', '', '');
INSERT INTO person_docs VALUES (232, '0000160587930', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (234, '82115161', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (235, '135712817', '', '', '22160180030', '', '', '', '');
INSERT INTO person_docs VALUES (236, '105043872', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (237, '97281939', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (238, '133705759', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (239, '8735806', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (240, '36933054', '92594026972', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (241, '5381097', '', '', '88878', '', '', '', '');
INSERT INTO person_docs VALUES (242, '65865823', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (243, '36933054', '92594026972', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (244, '07329730904', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (247, '132727791', '29579070890', '', '0675556', '', '', '', '');
INSERT INTO person_docs VALUES (248, '63239941', '82038325987', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (250, '35452729', '32116500915', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (251, '39028379', '52013340915', '', '29220370030', '', '008067310671', '', '');
INSERT INTO person_docs VALUES (252, '52435', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (253, '36281251', '', '', '7644906', '', '0037861450604', '309916', '');
INSERT INTO person_docs VALUES (256, '14060060', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (257, '95731066', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (258, '97358060', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (262, '9312070', '04991250960', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (268, '78361395', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (269, '82792350', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (272, '58447404', '00988482916', '', '12491215243', '', '048289160671', '', '');
INSERT INTO person_docs VALUES (273, '76146214', '00409353965', '', '', '', '064433370647', '', '');
INSERT INTO person_docs VALUES (275, '31824486', '37490591953', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (276, '75613221', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (277, '104415334', '06833947970', '', '8967463', '', '', '', '');
INSERT INTO person_docs VALUES (278, '', '78336252991', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (281, '4998963', '04308933960', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (283, '32065970', '37165330925', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (286, '24523543', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (115, '86234742', '01120168988', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (290, '191677150', '07480527985', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (292, '019672', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (293, '2r3215995', '79309950978', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (296, '18188988', '46516573972', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (304, '52623987', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (305, '60861528', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (310, '32885764', '', '', '', '', '007580290604', '', '');
INSERT INTO person_docs VALUES (311, '90655272', '06434530919', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (312, '15965', '05732417915', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (318, '93442326', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (319, '70738465', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (322, '104366155', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (325, '073893', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (326, '128359508', '08811411947', '', '1849992', '', '', '', '');
INSERT INTO person_docs VALUES (329, '632267856', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (335, '102223578', '07937754931', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (339, '107233504', '07513791902', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (341, '100466309', '05815286974', '', '', '', '062851380612', '', '');
INSERT INTO person_docs VALUES (348, '83126760', '02266817930', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (350, '89756265', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (361, '128322850', '08793584911', '', '', '', '097806690620', '', '');
INSERT INTO person_docs VALUES (364, '90650882', '04395505996', '', '', '', '075228520612', '', '');
INSERT INTO person_docs VALUES (367, '125919324', '08394716962', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (375, '', '', '', '14020961278', '', '09782750671', '', '');
INSERT INTO person_docs VALUES (376, '103019370', '08849542933', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (378, '130302319', '09080121959', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (398, '57877243', '70107904934', '', '', '', '05342090663', '', '');
INSERT INTO person_docs VALUES (399, '126863420', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (401, '61590846', '03903525944', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (402, '37004952', '70510911900', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (407, '88662949', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (408, '132891893', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (409, '60493430', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (410, '98886214', '05514417980', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (413, '821756', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (416, '', '05286636900', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (417, '23838427', '00580672999', '', '42627745030', '', '', '', '');
INSERT INTO person_docs VALUES (420, '57881356', '44098359987', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (421, '62681144', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (424, '55824819', '95798390934', '', '', '', '05551460671', '616090052', '');
INSERT INTO person_docs VALUES (426, '33160356', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (428, '81979629', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (432, '82848053', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (433, '', '01243823984', '', '12609799537', '', '', '', '');
INSERT INTO person_docs VALUES (436, '80843682', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (438, '1082836898', '07379354990', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (440, '0826810612', '05724454904', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (443, '109806415', '07903573993', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (445, '73886457', '70833010930', '', '', '', '043856730604', '', '');
INSERT INTO person_docs VALUES (447, '39430770', '60922699968', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (449, '102241563', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (452, '61366792', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (457, '73846650', '03586350988', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (462, '850999370', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (464, '81312818', '04076523962', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (465, '127884277', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (468, '32981992', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (470, '950210890', '05519242925', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (471, '88808223', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (473, '69046681', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (474, '3939009', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (477, '87235270', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (478, '69465186', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (481, '107944877', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (485, '42412003', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (486, '76207585', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (489, '61442243', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (490, '24/30/5279', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (491, '67582608', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (494, '87678288', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (496, '60493270', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (501, '59189280', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (502, '35653830', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (503, '0329342320079', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (504, '127885354', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (505, '96723288', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (506, '97488193', '01197249958', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (507, '38778188', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (508, '', '', '5183', '', '', '', '', '');
INSERT INTO person_docs VALUES (510, '32026923', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (511, '52572371', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (517, '1707217', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (519, '100388050', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (521, '105048254', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (522, '102953363', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (531, '568501688', '41991027877', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (535, '2584585', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (536, '129040173', '08562793906', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (537, '185072', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (541, '94441277', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (545, '72225341', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (546, '41514850', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (550, '', '', '', '10582007485', '', '', '', '');
INSERT INTO person_docs VALUES (552, '103315950', '06675381946', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (554, '90626841', '64502333972', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (556, '130202535', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (558, '72225821', '02518255907', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (559, '2003010018447', '02773395379', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (560, '10514507', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (561, '', '', '', '12967641490', '', '', '', '');
INSERT INTO person_docs VALUES (564, '87381994', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (565, '110729618', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (568, '128075224', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (572, '99445580', '07834737961', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (574, '19913180', '09946786907', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (576, '81925488', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (577, '52232821', '67005292987', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (118, '64505181', '04476551912', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (585, '96143630', '00982221983', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (587, '', '', '113514', '', '', '', '', '');
INSERT INTO person_docs VALUES (591, '100137658', '66604397904', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (597, '47485614', '67004130959', '', '3024602', '', '', '', '');
INSERT INTO person_docs VALUES (598, '89618380', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (600, '65476983', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (601, '1964490', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (604, '73444314', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (605, '257911571', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (606, '20846127', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (608, '79340774', '02592044981', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (610, '85574710', '88266400920', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (612, '105585357', '07726501871', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (614, '83817348', '03733709977', '', '0173811', '', '', '', '');
INSERT INTO person_docs VALUES (615, '113421', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (616, '30537968263', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (621, '80742096', '07250846930', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (622, '64192892', '00407797939', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (623, '233175349', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (624, '', '04177542997', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (625, '', '10052309940', '', '', '', '21065267047', '', '');
INSERT INTO person_docs VALUES (626, '103291879', '01204392986', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (627, '103291879', '', '', '', '', '101791550604', '', '');
INSERT INTO person_docs VALUES (628, '105627300', '07343251937', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (629, '60064741', '44167326949', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (630, '81383154', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (633, '129937556', '01226462901', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (644, '90722131', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (439, '10046634-1', '71522891900', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (646, '105048289', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (648, '132594988', '09698539980', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (650, '56238511', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (654, '122071123', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (657, '83822311', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (658, '32885764', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (660, '73059097', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (663, '128589490', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (666, '67451635', '91194709915', '', '55462100038', '', '5191933506147', '151812048628', '');
INSERT INTO person_docs VALUES (667, '401350915', '22248720890', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (669, '124335698', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (670, '', '07154230967', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (671, '98992499', '09081149903', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (674, '48373305', '25338196204', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (677, '1317335', '33984727968', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (678, '124764394', '08362147903', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (679, '125146775', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (680, '127886075', '08754378931', '', '079750261', '', '', '', '');
INSERT INTO person_docs VALUES (682, '76487286', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (683, '6036399', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (688, '83291672', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (689, '84137057', '67871836900', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (691, '99244810', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (693, '99183306', '05498919948', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (694, '10792672', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (697, '401433572', '70866414991', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (698, '81489890', '', '', '', '', '069710080620', '', '');
INSERT INTO person_docs VALUES (699, '11449077', '33851840968', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (701, '32607', '47283009949', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (702, '327779483', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (704, '16279927', '10023704934', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (706, '57916060', '95791612915', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (710, '00298758490', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (712, '0200210520025', '04195600332', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (713, '24549100', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (714, '58625647', '28730712904', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (717, '66782867', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (719, '129668202', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (722, '23182882', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (723, '52028809', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (724, '3334196474', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (727, '295433486', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (732, '8904444', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (734, '1208816', '83480684904', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (736, '12507', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (738, '80312253', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (739, '81861773', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (740, '84039977', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (749, '99316535', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (750, '96143397', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (751, '99551113', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (752, '104972098', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (755, '77788078100', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (758, '131342209', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (762, '41976918', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (764, '72468805', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (765, '70570882', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (766, '14044175', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (767, '72585143', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (768, '33135076', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (774, '252692123', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (775, '123854330', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (777, '44956101', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (779, '99474327', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (781, '133741380', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (782, '89340411', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (783, '0242171762', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (784, '105626827', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (785, '95524802', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (786, '81497885', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (789, '83203676', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (790, '33983883', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (793, '53937756', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (794, '88699149', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (795, '0061337060', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (796, '430266819', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (797, '12341683497', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (798, '131609825', '09692736903', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (800, '948576', '60160446520', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (803, '', '', '31271', '', '', '', '', '');
INSERT INTO person_docs VALUES (804, '88512430', '02710055996', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (818, '80272405', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (820, '41366280', '60105615900', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (822, '131965125', '09572268961', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (838, '13252696', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (843, '50242080', '75584921904', '', '', '00349199733', '', '', '');
INSERT INTO person_docs VALUES (850, '33061730', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (858, '', '02448643903', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (859, '84645850', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (875, '64516892', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (877, '211725869', '08762075810', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (895, '81364940', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (897, '53333230', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (898, '101518499', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (903, '44597713', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (912, '51458575', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (914, '47226112', '58314202991', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (916, '31223369', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (917, '370158271', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (954, '45780704', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (974, '', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (976, '125404944', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (977, '43689991', '62271903904', '', '756693250010', '', '', '', '');
INSERT INTO person_docs VALUES (978, '66777024', '76121186968', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (990, '63828629', '97346039904', '', '', '', '64779600620', '151832301577', '');
INSERT INTO person_docs VALUES (991, '80850239', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (995, '239793493', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1004, '60264740', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1025, '105056605', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1039, '41911123', '64560759987', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (70, '87104230', '04430214905', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (100, '51149416', '76121437987', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (67, '138247740', '40921077220', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (71, '7054', '78336252991', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (98, '71683079', '00427653908', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (72, '73483336', '04518073916', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (753, '84958409', '04872570901', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1047, '81367051', '05870965942', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1101, '9096019493', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1103, '30951093', '39652734934', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1106, '679951104', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1124, '20115265', '10253450888', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1141, '42153451', '40996441972', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1158, '75888830', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1175, '75540752', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1185, '40822909', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1202, '4r2864086', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1220, '42639931', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1226, '83076283', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1238, '5247281', '66529204849', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1243, '139342712', '08311582980', '', '1635700531', '', '1971775480213', '', '');
INSERT INTO person_docs VALUES (1247, '73393086', '97981893968', '', '', '', '604066206139', '', '');
INSERT INTO person_docs VALUES (1249, '127780840', '', '', '16235757388', '', '', '', '');
INSERT INTO person_docs VALUES (1252, '471012671', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1253, '65684608', '00071720952', '', '', '', '5149553058080', '', '');
INSERT INTO person_docs VALUES (1254, '129249897', '09056127950', '', '4262501', '', '', '', '');
INSERT INTO person_docs VALUES (1255, '88178106', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (709, '68849110', '04769113978', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1261, '362731500', '04223423940', '', '62177450030', '', '', '', '');
INSERT INTO person_docs VALUES (1265, '84745693', '01109915918', '', '', '', '', '151832458161', '');
INSERT INTO person_docs VALUES (1267, '103613426', '06670157959', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1268, '44832577', '63868466991', '', '', '03069384722', '', '', '');
INSERT INTO person_docs VALUES (1269, '45460145', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1271, '85668757', '06742313927', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1272, '33061730', '39581926968', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1275, '20163119', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1277, '99906766', '05716191932', '', '', '', '085553810663', '151832694260', '');
INSERT INTO person_docs VALUES (1278, '100048531', '06650399990', '', '', '', '0085543380612', '', '');
INSERT INTO person_docs VALUES (1279, '21495166', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1280, '99909145', '06225135910', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1282, '69262023', '88309878915', '10998121138', '', '', '', '', '');
INSERT INTO person_docs VALUES (1283, '46565339', '65409590953', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1284, '83296437', '04405291900', '', '16555695707', '', '0086434120680', '', '');
INSERT INTO person_docs VALUES (1286, '', '', '25293/f.82/l.30a', '7300818', '', '', '', '');
INSERT INTO person_docs VALUES (1295, '5,828,5188', '92670032915', '', '12470959529', '', '', '', '');
INSERT INTO person_docs VALUES (1296, '66570118', '01998945901', '', '', '', '644304006155', '', '');
INSERT INTO person_docs VALUES (1297, '1510117', '77011660178', '', '', '012977280998', '030012001066', '', '');
INSERT INTO person_docs VALUES (1288, '304703874', '22005507822', '', '', '', '273380430159', '', '');
INSERT INTO person_docs VALUES (1299, '38885227', '46516301972', '14481,223A,F.93', '35018-00009PR', '', '', '', '');
INSERT INTO person_docs VALUES (1302, '591612202', '021864229-64', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1303, '108493526', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1304, '38778188', '46514775934', '', '10877068930', '', '037992230663', '', '');
INSERT INTO person_docs VALUES (1305, '109176354', '07707810988', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1306, '347473933', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1307, '102865561 SSP PR', '06182664967', '', '20964055040', '', '08553586069852142139', '', '898003419544415');
INSERT INTO person_docs VALUES (1287, '84156426', '', '', '3718577', '', '', '', '127225775280004');
INSERT INTO person_docs VALUES (1308, '124516234', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1309, '98810650', '08169668930', '', '13058770498', '', '096874590671', '', '');
INSERT INTO person_docs VALUES (1310, '87381994', '009192019-11', '', '', '', '068265340647', '', '');
INSERT INTO person_docs VALUES (1311, '44832577', '63868466991', '', '', '03069384722', '', '', '');
INSERT INTO person_docs VALUES (1242, '128589490', '07216080947', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (566, '10439595', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1313, '127886075', '08754378931', '', '075975/0261- 5P', '', '', '', '');
INSERT INTO person_docs VALUES (75, '89622689', '', '', '1366420/S.001 - PR', '', '', '', '');
INSERT INTO person_docs VALUES (1315, '18577476', '10982885644', '', '', '', '172867640299', '', '');
INSERT INTO person_docs VALUES (1316, '99928034', '05839701920', '', '12859106539', '', '', '', '128591065390000');
INSERT INTO person_docs VALUES (1319, '1666023-0', '718550509-78', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1320, '5458377-0', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1321, '16017210-0', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1322, '6214854-3', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1326, '58366870', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1327, '9685079-4', '060491579-95', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1328, '7738836-2', '041820939-17', '', '1281293749-3', '', '', '', '');
INSERT INTO person_docs VALUES (1329, '7523525-9', '06819597975', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1331, '99909145', '', '', '', '', '096278600698', '', '');
INSERT INTO person_docs VALUES (1335, '76173508', '03103018908', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1337, '52572371', '74178024949', '', '12353224670', '05542374400', '', '', '');
INSERT INTO person_docs VALUES (1338, '67104269', '03238163981', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1340, '33923635', '441.711.109-04', '', '12095301651', '', '', '', '');
INSERT INTO person_docs VALUES (1323, '', '', '', '120.45509.31-3', '', '', '', '');
INSERT INTO person_docs VALUES (1341, '', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1342, '9.448.713-7', '046.982.549-90', '', '128.67636.53-3', '', '', '', '');
INSERT INTO person_docs VALUES (641, '9697118-4', '051415159-58', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1343, '40.043.048.-2', '411.590.989-72', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1317, '533614-7', '007.365.699-28', '', '127.15170.53-1', '', '', '', '');
INSERT INTO person_docs VALUES (1318, '1107380-48', '078036159-88', '', '140.61787.27-2', '', '', '', '');
INSERT INTO person_docs VALUES (1344, '36326069', '795.209.609-53', '', '121.29346.04-0', '', '', '', '');
INSERT INTO person_docs VALUES (218, '10956407-9', '674676878-34', '', '10406593482', '', '', '', '');
INSERT INTO person_docs VALUES (524, '9044828-5', '044175879-73', '', '127.91648.52-8', '', '', '', '');
INSERT INTO person_docs VALUES (1345, '', '', '', '1207319248-5', '', '008424750663', '', '');
INSERT INTO person_docs VALUES (1346, '92723933', '', '', '12832185500', '', '', '', '');
INSERT INTO person_docs VALUES (1347, '98280987', '', '', '12828224505', '', '', '', '');
INSERT INTO person_docs VALUES (1348, '77556729', '03891568924', '', '12592699513', '', '', '', '');
INSERT INTO person_docs VALUES (1350, '93794699', '', '', '', '04338681290', '', '', '');
INSERT INTO person_docs VALUES (1351, '', '', '', '10582843992', '', '', '', '');
INSERT INTO person_docs VALUES (1352, '', '', '', '12436232565', '', '', '', '');
INSERT INTO person_docs VALUES (1353, '1681124-6', '254493709-20', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (444, '234393212', '744.634.469-53', '', '1232033818-9', '', '', '', '');
INSERT INTO person_docs VALUES (664, '51458575', '93164700997', '', '12320326237', '', '', '', '');
INSERT INTO person_docs VALUES (1354, '4424769-0', '631102109-91', '', '1214368536-1', '', '', '', '');
INSERT INTO person_docs VALUES (1355, '1788758', '341163549-53', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1356, '5452085-9', '001778159-06', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1357, '94129060', '046251289-43', '', '1642790638-1', '', '', '', '');
INSERT INTO person_docs VALUES (1358, '123201096', '78846730968', '', '52457950040', '', '', '15152209865', '704206248922484');
INSERT INTO person_docs VALUES (1359, '54520859', '00177815906', '705172', '00166500040', '', '58259930671', '', '12336503887700551');
INSERT INTO person_docs VALUES (1361, '475932900', '40602526892', '', '20710251593', '', '', '', '');
INSERT INTO person_docs VALUES (1362, '76642109', '03806415935', '', '1308800053', '', '078150470671', '', '');
INSERT INTO person_docs VALUES (1363, '020250982002', '02958729346', '', '053448-00040/MA', '', '', '', '');
INSERT INTO person_docs VALUES (1364, '44247690', '63110210991', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1365, '82527605', '03071388950', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1366, '11003718', '09174116924', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1367, '84548480', '00619334908', '', '', '', '', '0092733920612', '');
INSERT INTO person_docs VALUES (1368, '561020235', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1370, '105172923', '85606561972', '', '', '', '519241306171', '', '');
INSERT INTO person_docs VALUES (1371, '73243335', '02286958998', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1372, '88720725', '03632096970', '', '128356517', '', '077352780655', '', '');
INSERT INTO person_docs VALUES (1373, '77360050', '02453329952', '', '12129828754', '', '', '', '');
INSERT INTO person_docs VALUES (1375, '17418360', '34091491987', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1376, '49753616', '41005090904', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1377, '383414', '', '', '', '', '105570850604', '', '801434119737999');
INSERT INTO person_docs VALUES (1378, '133311157', '09319714975', '', '86136580030', '', '104232660680', '', '');
INSERT INTO person_docs VALUES (1379, '99094249', '05637991960', '', '', '', '087345130671', '', '');
INSERT INTO person_docs VALUES (1380, '131516665', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1381, '126389400', '08682018985', '', '', '', '100507720671', '', '');
INSERT INTO person_docs VALUES (1382, '12.732.238-4', '085.948.089-50', '', '7918595-0030', '', '', '', '');
INSERT INTO person_docs VALUES (1383, '124519683', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1384, '128010548', '10118379941', '', '8770786', '', '', '', '');
INSERT INTO person_docs VALUES (1385, '131716621', '10004197976', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1386, '134573511', '10093166990', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (809, '87206939', '03841099939', '', '', '', '069548060647', '', '');
INSERT INTO person_docs VALUES (1387, '9811815', '07968563976', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1389, '86150735', '05480136917', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1388, '97080950', '05693724964', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1391, '46014049', '83696024953', '', '12276449073', '', '', '', '');
INSERT INTO person_docs VALUES (1393, '25753924972', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1392, '108476168', '08333617913', '', '426130250030', '', '09753370060421395248', '151832858667', '');
INSERT INTO person_docs VALUES (1394, '98224785', '05525358930', '', '050735400639', '', '', '', '');
INSERT INTO person_docs VALUES (1395, '53955355', '80879926953', '', '5958900029', '', '', '', '');
INSERT INTO person_docs VALUES (1397, '102206550', '06444620945', '', '', '', '0090660680647', '', '');
INSERT INTO person_docs VALUES (1398, '53636063', '75686643920', '', '021219034', '', '', '', '');
INSERT INTO person_docs VALUES (1400, '71278271', '02927769931', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1402, '1244885779', '08165421980', '', '52174760030 pr', '', '054063440922', '', '20319378211001');
INSERT INTO person_docs VALUES (1403, '51912020', '70252254953', '', '17002753183', '', '', '', '');
INSERT INTO person_docs VALUES (1404, '52414628', '72639237934', '', '12463344336', '', '', '', '');
INSERT INTO person_docs VALUES (1405, '1788758', '34116354953', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1406, '', '07938439959', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1407, '139043251', '', '', '37525', '', '0514940604', '', '');
INSERT INTO person_docs VALUES (1408, '21508853', '28789717953', '', '10263575516', '', '', '', '');
INSERT INTO person_docs VALUES (1409, '60303215', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1411, '32026923', '40970302991', '', '10760945745', '', '', '', '');
INSERT INTO person_docs VALUES (1412, '105472197', '07195353958', '', '26750609676', '', '', '', '');
INSERT INTO person_docs VALUES (1413, '105585446', '', '', '16831511733', '', '', '', '');
INSERT INTO person_docs VALUES (1414, '94646790', '06695376913', '', '8965833001-0 PR', '', '00906215106-47', '', '');
INSERT INTO person_docs VALUES (1416, '140841536', '11278661921', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1417, '97241627', '708.62370949', '', '12137783764', '', '', '151832075106', '');
INSERT INTO person_docs VALUES (1419, '83894857', '05142627962', '', '2415257-0040-PR', '0505482441790', '081878770604', '1513325744', '898003706784647');
INSERT INTO person_docs VALUES (1420, '34779457', '', '', '2883900223/SP', '', '007998550647', '', '');
INSERT INTO person_docs VALUES (1421, '60012105', '', '', '', '02494398916', '', '', '');
INSERT INTO person_docs VALUES (1422, '3992 1820', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1423, '57245972', '95794697920', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1424, '91319446', '06389515936', '', '76518950010', '', '', '', '');
INSERT INTO person_docs VALUES (1426, '', '06698596990', '', '6343642-00401', '', '', '', '');
INSERT INTO person_docs VALUES (1427, '', '', '', '1281840850-6', '', '', '', '');
INSERT INTO person_docs VALUES (1428, '110304420', '07744670965', '', '3723976002-0', '', '', '', '');
INSERT INTO person_docs VALUES (1429, '13085021', '40507823915', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1430, '8034351-5', '02609556985', '', '4914000054', '', '', '15183246313', '705402490094299');
INSERT INTO person_docs VALUES (1431, '', '', '', '12771113505', '', '', '', '');
INSERT INTO person_docs VALUES (1432, '132067864', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1433, '100839555', '', '', '', '', '', '', '');
INSERT INTO person_docs VALUES (1312, '222', '', '', '', '', '', '', '');


--
-- TOC entry 2130 (class 0 OID 49841)
-- Dependencies: 165
-- Data for Name: person_helped; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO person_helped VALUES (62, 'Cristão', 'desempregado', 'músico, percussão, carteiro.', false, 'aluguel', '2012-01-05', 1, 17, 'urbano', 'tijolo', 9, NULL, NULL);
INSERT INTO person_helped VALUES (95, 'Crente', 'desempregado', 'Servente de pedreiro', false, 'cedida', '2012-03-07', 1, 17, 'urbano', 'madeira', 5, NULL, NULL);
INSERT INTO person_helped VALUES (97, 'Evangélico', 'desempregado', 'HortiFruti granjeiro', false, 'Acolhido em Associação', '2013-09-08', 1, 17, 'urbano', 'tijolo', 15, NULL, NULL);
INSERT INTO person_helped VALUES (109, 'evangelico', 'trabalhador urbano', 'cozinheiro', false, 'cedida', '2013-01-08', 8, 26, 'boa', 'tijolo', 15, 12.00, NULL);
INSERT INTO person_helped VALUES (115, 'evangelico', 'desempregado', 'colheita de fumo', false, 'cedida', '2011-02-03', 1, 17, 'urbana', 'tijolo', 1, NULL, NULL);
INSERT INTO person_helped VALUES (134, 'catolico', 'trabalhador rural', 'rural', false, 'proprietário', '2012-10-07', 9, 17, 'urbano', 'tijolo', 6, NULL, NULL);
INSERT INTO person_helped VALUES (170, 'evangelico', 'desempregado', '', true, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 3, NULL, '2012-02-11');
INSERT INTO person_helped VALUES (189, 'catolico', 'desempregado', 'aux geral', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, NULL, '2012-11-21');
INSERT INTO person_helped VALUES (190, 'evangelico', 'desempregado', '', false, 'aluguel', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, 300.00, '2008-05-18');
INSERT INTO person_helped VALUES (199, 'avavngelico', 'desempregado', '', false, 'proprietário', '1970-01-01', 15, 17, 'urbano', 'tijolo', 2, NULL, '20011-09-21');
INSERT INTO person_helped VALUES (201, 'nao tem', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, NULL, '2012-04-24');
INSERT INTO person_helped VALUES (222, 'evangelico', 'desempregado', 'soldador', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, NULL, '2013-01-23');
INSERT INTO person_helped VALUES (262, 'evangelico', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, NULL, '2013-01-23');
INSERT INTO person_helped VALUES (266, 'Catolico', 'autonomo', 'autonomo', false, 'aluguel', '1970-01-01', 1, 17, 'urbano', 'tijolo', 6, 150.00, '2008-05-31');
INSERT INTO person_helped VALUES (268, 'evangelico', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 3, NULL, '2010-05-22');
INSERT INTO person_helped VALUES (273, 'catolico', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, NULL, '2008-05-18');
INSERT INTO person_helped VALUES (277, 'catolico', 'desempregado', 'servente de pedreiro', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, NULL, '2011-05-04');
INSERT INTO person_helped VALUES (281, 'catolico', 'desempregado', 'marceneiro', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 3, NULL, '2010-12-11');
INSERT INTO person_helped VALUES (296, 'evengelico', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, NULL, '2011-05-26');
INSERT INTO person_helped VALUES (317, 'catolica', 'desempregado', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, NULL, '2012-03-14');
INSERT INTO person_helped VALUES (318, 'evangelica', 'desempregado', 'reciclagem', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, NULL, '2010-07-31');
INSERT INTO person_helped VALUES (320, 'evangelica', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, NULL, '2007-03-27');
INSERT INTO person_helped VALUES (321, 'evangelica', 'desempregado', 'do lar', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 6, NULL, '2008-05-31');
INSERT INTO person_helped VALUES (328, 'evangelica', 'estudante', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, NULL, '2010-05-22');
INSERT INTO person_helped VALUES (353, 'evengelica ', 'desempregado', 'catadora', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 6, NULL, '2008-05-31');
INSERT INTO person_helped VALUES (357, 'evangelico', 'trabalhador urbano', '', false, 'proprietário', '1970-01-15', 1, 17, 'urbano', 'tijolo', 2, NULL, '2010-03-20');
INSERT INTO person_helped VALUES (358, 'catolica', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 7, NULL, '2012-09-28');
INSERT INTO person_helped VALUES (359, 'evangelica', 'estudante', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'madeira', 2, NULL, '2010-07-03');
INSERT INTO person_helped VALUES (361, 'evangelico', 'desempregado', '', false, 'cedida', '1970-01-01', 11, 26, 'urbano', 'tijolo', 3, NULL, '2012-04-09');
INSERT INTO person_helped VALUES (364, 'evangelico', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'ilha', 'tijolo', 8, NULL, '2011-08-11');
INSERT INTO person_helped VALUES (376, 'catolica', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'madeira', 4, NULL, '2012-05-29');
INSERT INTO person_helped VALUES (1306, 'Evangélico', 'desempregado', '', false, 'proprietário', '1970-01-01', 28, 26, 'urbano', 'tijolo', 2, NULL, '2014-01-22');
INSERT INTO person_helped VALUES (198, 'evangelico', 'desempregado', '', false, 'aluguel', '1970-01-01', 14, 22, 'urbano', 'tijolo', 8, 250.00, '2012-10-22');
INSERT INTO person_helped VALUES (556, 'evangelico', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 7, NULL, '2012-12-03');
INSERT INTO person_helped VALUES (559, 'evangelico', 'desempregado', '', false, 'cedida', '1970-01-01', 13, 6, 'urbano', 'tijolo', 5, NULL, '2013-01-05');
INSERT INTO person_helped VALUES (613, 'evangélica', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 16, 'urbano', 'tijolo', 3, NULL, '2009-08-15');
INSERT INTO person_helped VALUES (623, 'sem', 'trabalhador urbano', 'Atendente de Idosos', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, NULL, '2009-08-15');
INSERT INTO person_helped VALUES (630, 'catolica', 'trabalhador urbano', 'Professora( MAGISTÉRIO )', true, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 8, NULL, '2010-01-25');
INSERT INTO person_helped VALUES (636, 'sem', 'estudante', '', false, 'aluguel', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, 130.00, '2009-12-12');
INSERT INTO person_helped VALUES (641, 'evangelica', 'aposentado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 3, NULL, '2008-05-17');
INSERT INTO person_helped VALUES (827, 'catolica', 'grafica', 'copy disigner', false, 'aluguel', '1970-01-01', 2, 17, 'urbano', 'tijolo', 8, 150.00, '2008-03-01');
INSERT INTO person_helped VALUES (834, 'catolico', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, NULL, '2009-11-21');
INSERT INTO person_helped VALUES (841, 'catolico', 'aposentado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, NULL, '2010-05-22');
INSERT INTO person_helped VALUES (1241, 'cristao', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 2, NULL, '2013-11-12');
INSERT INTO person_helped VALUES (845, 'Cristão', 'desempregado', '', false, 'cedida', '1970-01-01', 8, 1, 'indígena', 'madeira', 0, NULL, '2013-12-19');
INSERT INTO person_helped VALUES (1287, 'catolico', 'desempregado', '', true, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 1, NULL, '2014-01-21');
INSERT INTO person_helped VALUES (1288, 'Evangélico', 'trabalhador urbano', '', false, 'proprietário', '1970-01-01', 3, 17, 'urbano', 'tijolo', 1, NULL, '2013-11-20');
INSERT INTO person_helped VALUES (1289, 'Católico', 'desempregado', '', false, 'proprietário', '1970-01-01', 16, 17, 'urbano', 'tijolo', 3, NULL, '2013-12-13');
INSERT INTO person_helped VALUES (247, 'Evangélico', 'trabalhador urbano', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 3, NULL, '2013-12-13');
INSERT INTO person_helped VALUES (991, 'EVANGELICO', 'aposentado', '', true, 'proprietário', '1970-01-01', 21, 17, 'urbano', 'tijolo', 2, NULL, '2014-01-21');
INSERT INTO person_helped VALUES (1243, 'Evangélico', 'trabalhador rural', '', false, 'proprietário', '1970-01-01', 1, 17, 'rural', 'madeira', 2, NULL, '2013-12-17');
INSERT INTO person_helped VALUES (1290, 'Evangélico', 'desempregado', '', false, 'proprietário', '1970-01-01', 1, 16, 'urbano', 'tijolo', 2, NULL, '2014-01-21');
INSERT INTO person_helped VALUES (1291, 'Evangélico', 'trabalhador urbano', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 2, NULL, '2013-12-12');
INSERT INTO person_helped VALUES (1292, 'Evangélico', 'trabalhador urbano', '', false, 'proprietário', '1970-01-01', 2, 17, 'urbano', 'tijolo', 3, NULL, '2014-01-21');
INSERT INTO person_helped VALUES (1293, 'Evangélico', 'trabalhador urbano', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 2, NULL, '2014-01-21');
INSERT INTO person_helped VALUES (1295, 'Evangélico', 'aposentado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 2, NULL, '2013-12-23');
INSERT INTO person_helped VALUES (1296, 'Evangélico', 'aposentado', '', false, 'casa da mãe', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, NULL, '2013-01-10');
INSERT INTO person_helped VALUES (1298, 'Evangélico', 'aposentado', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, NULL, '2013-01-09');
INSERT INTO person_helped VALUES (1299, 'Evangélico', 'trabalhador urbano', '', false, 'proprietário', '1970-01-01', 24, 22, 'urbano', 'madeira', 4, NULL, '2013-12-19');
INSERT INTO person_helped VALUES (1300, 'evangelico', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, NULL, '2013-12-17');
INSERT INTO person_helped VALUES (116, 'catolico', 'aposentado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 6, NULL, '2014-01-16');
INSERT INTO person_helped VALUES (1301, 'Evangélico', 'desempregado', '', false, 'proprietário', '1970-01-01', 26, 29, 'urbano', 'tijolo', 3, NULL, '2014-01-21');
INSERT INTO person_helped VALUES (1304, 'Evangélico', 'trabalhador urbano', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 1, NULL, '2013-01-03');
INSERT INTO person_helped VALUES (1305, 'Evangélico', 'desempregado', '', true, 'cedida', '1970-01-01', 27, 26, 'urbano', 'tijolo', 4, NULL, '2014-01-22');
INSERT INTO person_helped VALUES (1307, 'Evangélico', 'desempregado', '', true, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, NULL, '2013-12-23');
INSERT INTO person_helped VALUES (1308, 'Evangélico', 'desempregado', '', false, 'proprietário', '1970-01-01', 15, 17, 'urbano', 'tijolo', 1, NULL, '2013-11-17');
INSERT INTO person_helped VALUES (1309, 'evengélico', 'desempregado', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 6, NULL, '2013-09-10');
INSERT INTO person_helped VALUES (1310, 'não tem', 'trabalhador urbano', 'construção civil', false, 'situação de rua', '1970-01-01', 30, 17, 'urbano', 'rua', 0, NULL, '2013-07-11');
INSERT INTO person_helped VALUES (1281, 'católico', 'desempregado', 'pedreiro,servente,vendedor', true, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 6, NULL, '2013-12-04');
INSERT INTO person_helped VALUES (1285, 'não tem', 'desempregado', '', false, 'situação de rua', '1970-01-01', 31, 17, 'urbano', 'rua', 0, NULL, '2013-11-25');
INSERT INTO person_helped VALUES (1282, 'não tem', 'desempregado', '', false, 'situação de rua ', '1970-01-01', 1, 17, 'urbano', 'Rua', 0, NULL, '2013-12-09');
INSERT INTO person_helped VALUES (1265, 'não tem', 'desempregado', 'jardineiro', true, 'dos pais', '1970-01-01', 1, 17, 'urbano', 'madeira', 4, NULL, '2013-11-14');
INSERT INTO person_helped VALUES (1267, 'não tem', 'desempregado', '', false, 'cedida', '1970-01-01', 32, 17, 'urbano', 'madeira', 0, NULL, '2013-11-14');
INSERT INTO person_helped VALUES (1311, 'não tem ', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 6, NULL, '2013-11-18');
INSERT INTO person_helped VALUES (98, 'não tem', 'trabalhador urbano', 'Soldador', false, 'Rua', '1970-01-01', 1, 17, 'urbano', 'Rua', 0, NULL, '2013-08-12');
INSERT INTO person_helped VALUES (1247, 'Não tem', 'trabalhador rural', 'Chacreiro', false, 'cedida', '1970-01-01', 33, 17, 'urbano', 'tijolo', 3, NULL, '2013-11-11');
INSERT INTO person_helped VALUES (1242, 'Não tem ', 'trabalhador rural', 'colhedor de maçã', false, 'rua', '1970-01-01', 20, 17, 'urbano', 'rua', 0, NULL, '2013-12-07');
INSERT INTO person_helped VALUES (1245, 'não tem', 'desempregado', '', false, 'rua', '1970-01-01', 1, 17, 'urbano', 'rua', 0, NULL, '2013-11-01');
INSERT INTO person_helped VALUES (1258, 'Não tem ', 'desempregado', '', false, 'Situação de rua', '1970-01-01', 1, 17, 'urbano', 'rua', 0, NULL, '2013-10-15');
INSERT INTO person_helped VALUES (1253, 'Não tem ', 'desempregado', '', false, 'cituaçao de rua', '1970-01-01', 1, 17, 'urbano', 'rua', 0, NULL, '2013-10-14');
INSERT INTO person_helped VALUES (1252, 'catolico', 'desempregado', '', false, 'cedida', '1970-01-01', 8, 26, 'urbano', 'tijolo', 3, NULL, '2113-10-10');
INSERT INTO person_helped VALUES (566, 'Não tem', 'desempregado', '', false, 'cituação de rua ', '1970-01-01', 1, 17, 'urbano', 'rua', 0, NULL, '2013-10-11');
INSERT INTO person_helped VALUES (1313, 'Evangélico', 'trabalhador urbano', '', false, 'proprietário', '1970-01-01', 27, 26, 'rural', 'tijolo', 5, NULL, '2012-07-31');
INSERT INTO person_helped VALUES (75, 'Evangélico', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'adobe', 1, NULL, '2013-05-10');
INSERT INTO person_helped VALUES (974, 'Evangélico', 'desempregado', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, NULL, '2013-09-01');
INSERT INTO person_helped VALUES (83, 'evangélico', 'desempregado', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, NULL, '2013-09-09');
INSERT INTO person_helped VALUES (576, 'evangélico', 'desempregado', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'madeira', 3, NULL, '2013-09-29');
INSERT INTO person_helped VALUES (575, 'evangélico', 'trabalhador urbano', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, NULL, '2013-09-01');
INSERT INTO person_helped VALUES (1314, 'cristã', 'trabalhador urbano', '', false, 'cedida', '1970-01-01', 12, 17, 'urbano', 'tijolo', 5, NULL, '2013-06-24');
INSERT INTO person_helped VALUES (1315, 'Evangélico', 'desempregado', 'Armador', false, 'cedida', '1970-01-01', 7, 5, 'urbano', 'tijolo', 15, NULL, '2014-02-05');
INSERT INTO person_helped VALUES (567, 'nao tem ', 'desempregado', '', false, 'situaçao de rua ', '1970-01-01', 1, 17, 'urbano', 'rua', 0, NULL, '2013-02-05');
INSERT INTO person_helped VALUES (565, 'nao tem ', 'trabalhador urbano', 'metalurgico', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 3, NULL, '2013-07-09');
INSERT INTO person_helped VALUES (102, 'não tem ', 'situaçao de rua ', 'pedreiro', false, 'situaçãod e', '1970-01-01', 6, 29, 'urbano', 'adobe', 0, NULL, '2013-08-08');
INSERT INTO person_helped VALUES (103, 'não tem', 'desempregado', 'servente de pedreiro', false, 'rua', '1970-01-01', 34, 26, 'urbano', 'rua', 0, NULL, '2013-07-08');
INSERT INTO person_helped VALUES (1278, 'evangelico', 'trabalhador urbano', 'auxiliar de produção', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 6, NULL, '2011-10-12');
INSERT INTO person_helped VALUES (87, 'evangélico', 'Vendedor', '', false, 'situação de rua ', '1970-01-01', 11, 26, 'urbano', 'rua', 0, NULL, '2013-06-03');
INSERT INTO person_helped VALUES (160, 'Não tem ', 'Pintor proficional', 'Pintor proficional', false, 'rua', '1970-01-01', 1, 17, 'urbano', 'rua', 0, NULL, '2013-03-07');
INSERT INTO person_helped VALUES (64, 'evangelico', 'desempregado', '', false, 'cedida', '1970-01-01', 3, 17, 'urbano', 'madeira', 5, NULL, '2013-05-15');
INSERT INTO person_helped VALUES (1316, 'nao tem ', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 3, NULL, '2013-10-21');
INSERT INTO person_helped VALUES (760, 'nao tem ', 'desempregado', '', false, 'RUA', '1970-01-01', 1, 17, 'urbano', 'RUA', 0, NULL, '2013-07-05');
INSERT INTO person_helped VALUES (82, 'Não tem ', 'desempregado', '', false, 'rua', '1970-01-01', 1, 17, 'urbano', 'tijolo', 0, NULL, '2014-02-05');
INSERT INTO person_helped VALUES (695, 'evangelico', 'desempregado', '', false, 'rua', '1970-01-01', 25, 16, 'rua', 'tijolo', 0, NULL, '2011-01-20');
INSERT INTO person_helped VALUES (73, 'não tem', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'madeira', 3, NULL, '2011-07-28');
INSERT INTO person_helped VALUES (251, 'não tem', 'trabalhador urbano', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'madeira', 4, NULL, '2013-03-20');
INSERT INTO person_helped VALUES (457, 'não tem', 'desempregado', 'pintura automotiva, industrial', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'madeira', 3, NULL, '2013-03-19');
INSERT INTO person_helped VALUES (42, 'catolico', 'desempregado', 'construção civil', false, 'cedida', '1970-01-01', 36, 17, 'urbano', 'madeira', 4, NULL, '2013-05-28');
INSERT INTO person_helped VALUES (89, 'n tem', 'desempregado', 'pintor, eletricista, torneiro mecanico', false, 'rua', '1970-01-01', 32, 17, 'urbano', 'rua', 0, NULL, '2013-11-03');
INSERT INTO person_helped VALUES (731, 'n tem', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'madeira', 0, NULL, '2013-03-11');
INSERT INTO person_helped VALUES (94, 'n tem', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'madeira', 4, NULL, '2013-03-05');
INSERT INTO person_helped VALUES (45, 'n tem', 'desempregado', '', false, 'rua', '1970-01-01', 1, 17, 'urbano', 'rua', 0, NULL, '2011-06-06');
INSERT INTO person_helped VALUES (341, 'n tem', 'desempregado', 'chapa', false, 'rua', '1970-01-01', 1, 17, 'urbano', 'rua', 0, NULL, '2013-02-07');
INSERT INTO person_helped VALUES (234, 'n tem', 'desempregado', '', false, 'rua', '1970-01-01', 9, 17, 'urbano', 'rua', 0, NULL, '2012-04-26');
INSERT INTO person_helped VALUES (786, 'n tem', 'desempregado', '', false, 'rua', '1970-01-01', 1, 17, 'urbano', 'rua', 0, NULL, '2012-10-08');
INSERT INTO person_helped VALUES (740, 'evangélico', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 6, NULL, '2011-02-08');
INSERT INTO person_helped VALUES (227, 'não tem ', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 3, NULL, '2103-01-23');
INSERT INTO person_helped VALUES (311, 'evangélico', 'desempregado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, NULL, '1023-02-18');
INSERT INTO person_helped VALUES (703, 'evangélico', 'desempregado', '', false, 'aluguel', '1970-01-01', 1, 17, 'urbano', 'madeira', 5, 250.00, '2013-01-16');
INSERT INTO person_helped VALUES (301, 'não tem ', 'trabalhador urbano', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'madeira', 6, NULL, '2013-01-14');
INSERT INTO person_helped VALUES (1326, 'n tem', 'desempregado', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'madeira', 4, NULL, '2014-02-27');
INSERT INTO person_helped VALUES (1327, 'n tem', 'desempregado', '', false, 'rua', '1970-01-01', 3, 17, 'urbano', 'rua', 0, NULL, '2014-02-25');
INSERT INTO person_helped VALUES (1329, 'Não tem', 'Bico', 'Pintor', true, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 6, NULL, '2014-02-26');
INSERT INTO person_helped VALUES (1328, 'não tem ', 'trabalhador urbano', 'Servente', true, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, NULL, '2014-02-25');
INSERT INTO person_helped VALUES (1331, 'Não tem ', 'desempregado', '', false, 'Situação de rua', '1970-01-01', 1, 17, 'urbano', 'Rua', 0, NULL, '2014-02-19');
INSERT INTO person_helped VALUES (1332, 'não tem', 'desempregado', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 6, NULL, '2014-02-15');
INSERT INTO person_helped VALUES (1333, 'não tem', 'desempregado', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, NULL, '2014-02-11');
INSERT INTO person_helped VALUES (1334, 'Evangelico', 'aposentado', '', false, 'rua', '1970-01-01', 12, 17, 'urbano', 'rua', 0, NULL, '2014-02-11');
INSERT INTO person_helped VALUES (1336, 'nao tem ', 'artesão', 'artesão', false, 'situação de rua ', '1970-01-01', 1, 17, 'urbano', 'rua', 0, NULL, '2014-02-06');
INSERT INTO person_helped VALUES (1337, 'Evangelico', 'Desempregado', 'Empacotador
Auxiliar de Serviços Gerais', false, 'aluguel', '2013-12-06', 1, 17, 'urbano', 'madeira', 6, 250.00, '2004-03-20');
INSERT INTO person_helped VALUES (1350, 'nao tem ', 'desempregado', 'Operador de Maquinas', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, NULL, '2014-02-27');
INSERT INTO person_helped VALUES (1312, 'nãõ tem ', 'desempregado', '', false, 'rua', '1970-01-01', 1, 17, 'urbano', 'rua', 0, NULL, '2013-10-29');
INSERT INTO person_helped VALUES (1362, 'Sem detalhes', 'trabalhador urbano', 'Aux de Cosinha', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, NULL, '2014-04-22');
INSERT INTO person_helped VALUES (1363, 'Não especificado', 'Não especificado', 'Não especificado', false, 'Não especificado', '1970-01-01', 1, 17, 'Não especificado', 'Não especificado', 0, NULL, '2014-04-22');
INSERT INTO person_helped VALUES (1364, 'Não relatado pelo assistido', 'aposentado', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'Não relatado pelo assistido', 5, NULL, '2014-03-25');
INSERT INTO person_helped VALUES (1365, 'Não especificado pelo assistido', 'trabalhador urbano', 'construção civil', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, NULL, '2014-04-28');
INSERT INTO person_helped VALUES (1366, 'evangelico', 'aux de produção', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 6, NULL, '2014-04-03');
INSERT INTO person_helped VALUES (1367, 'Não tem ', 'desempregado', '', false, 'aluguel', '1970-01-01', 1, 17, 'urbano', 'tijolo', 3, 200.00, '2014-04-14');
INSERT INTO person_helped VALUES (1368, 'não tem ', 'trabalhador urbano', 'Diarista', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 3, NULL, '2004-03-24');
INSERT INTO person_helped VALUES (1370, 'não tem ', 'trabalhador urbano', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 5, NULL, '2014-03-31');
INSERT INTO person_helped VALUES (1375, 'não tem ', 'aposentado', '', false, 'aluguel', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, 300.00, '2014-04-14');
INSERT INTO person_helped VALUES (1382, 'Não tem', 'trabalhador urbano', 'Funileiro', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 12, NULL, '2014-03-24');
INSERT INTO person_helped VALUES (1395, 'Não tem ', 'trabalhador urbano', 'carpinteiro', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 2, NULL, '2014-04-14');
INSERT INTO person_helped VALUES (1396, 'não tem ', 'trabalhador urbano', 'ZELADORA', false, 'aluguel', '1970-01-01', 1, 17, 'urbano', 'tijolo', 3, 200.00, '2014-04-15');
INSERT INTO person_helped VALUES (1397, 'não tem', 'trabalhador urbano', '', false, 'cedida', '1970-01-01', 1, 17, 'urbano', 'tijolo', 3, NULL, '2014-04-07');
INSERT INTO person_helped VALUES (1398, 'Noã tem', 'trabalhador urbano', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, NULL, '2014-04-04');
INSERT INTO person_helped VALUES (1413, 'Não Tem', 'aposentado', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'tijolo', 4, NULL, '2014-05-02');
INSERT INTO person_helped VALUES (1419, 'Não tem ', 'trabalhador urbano', '', false, 'aluguel', '1970-01-01', 1, 17, 'urbano', 'tijolo', 2, 200.00, '2014-05-08');
INSERT INTO person_helped VALUES (1421, 'Não tem', 'desempregado', '', false, 'proprietário', '1970-01-01', 1, 17, 'urbano', 'madeira', 7, NULL, '2013-05-20');
INSERT INTO person_helped VALUES (137, 'Católico', 'aposentado', '', false, 'hipoteca', '1970-01-01', 26, 1, 'rural', 'adobe', 1, NULL, '2014-07-01');
INSERT INTO person_helped VALUES (682, 'www', 'desempregado', '', false, 'cedida', '1970-01-01', 26, 1, 'indígena', 'madeira', 3, NULL, '2014-07-13');


--
-- TOC entry 2131 (class 0 OID 49847)
-- Dependencies: 166
-- Data for Name: person_helped_project; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO person_helped_project VALUES (3, 109, '2012-07-07', '2012-07-15');
INSERT INTO person_helped_project VALUES (3, 95, '2014-09-01', NULL);
INSERT INTO person_helped_project VALUES (3, 97, '2013-12-01', '2014-01-25');
INSERT INTO person_helped_project VALUES (3, 991, '2013-10-09', '2014-01-24');
INSERT INTO person_helped_project VALUES (3, 1296, '2014-10-01', '2014-01-05');
INSERT INTO person_helped_project VALUES (5, 1304, '2014-03-01', '2014-01-13');
INSERT INTO person_helped_project VALUES (3, 1309, '2013-10-09', '2013-10-14');
INSERT INTO person_helped_project VALUES (3, 1310, '2013-12-07', '2013-12-10');
INSERT INTO person_helped_project VALUES (8, 1293, '2013-02-12', NULL);
INSERT INTO person_helped_project VALUES (4, 1281, '2013-04-12', NULL);
INSERT INTO person_helped_project VALUES (4, 1287, '2014-03-02', NULL);
INSERT INTO person_helped_project VALUES (9, 1282, '2013-03-02', NULL);
INSERT INTO person_helped_project VALUES (8, 1291, '2013-12-12', NULL);
INSERT INTO person_helped_project VALUES (3, 247, '2013-03-02', '2014-02-10');
INSERT INTO person_helped_project VALUES (4, 1267, '2013-11-18', NULL);
INSERT INTO person_helped_project VALUES (3, 1265, '2013-11-14', NULL);
INSERT INTO person_helped_project VALUES (3, 1290, '2013-12-13', NULL);
INSERT INTO person_helped_project VALUES (3, 1285, '2013-11-25', '2013-11-28');
INSERT INTO person_helped_project VALUES (6, 1311, '2013-11-18', NULL);
INSERT INTO person_helped_project VALUES (3, 1288, '2013-12-20', NULL);
INSERT INTO person_helped_project VALUES (5, 1243, '2013-12-17', NULL);
INSERT INTO person_helped_project VALUES (3, 98, '2013-11-13', '2014-02-06');
INSERT INTO person_helped_project VALUES (5, 1247, '2013-11-11', NULL);
INSERT INTO person_helped_project VALUES (5, 1242, '2013-11-05', NULL);
INSERT INTO person_helped_project VALUES (4, 1245, '2013-01-11', NULL);
INSERT INTO person_helped_project VALUES (3, 1312, '2013-10-29', '2014-02-10');
INSERT INTO person_helped_project VALUES (3, 296, '2013-10-22', '2014-02-10');
INSERT INTO person_helped_project VALUES (3, 1258, '2013-10-15', '2014-02-07');
INSERT INTO person_helped_project VALUES (3, 1253, '2013-10-14', '2014-02-07');
INSERT INTO person_helped_project VALUES (3, 1252, '2013-10-10', '2014-02-07');
INSERT INTO person_helped_project VALUES (4, 566, '2013-10-11', NULL);
INSERT INTO person_helped_project VALUES (3, 1313, '2013-10-08', '2014-02-07');
INSERT INTO person_helped_project VALUES (3, 75, '2013-09-20', '2014-02-07');
INSERT INTO person_helped_project VALUES (3, 974, '2013-09-13', '2014-02-07');
INSERT INTO person_helped_project VALUES (5, 83, '2013-09-13', '2014-02-07');
INSERT INTO person_helped_project VALUES (9, 991, '2013-09-09', '2013-10-14');
INSERT INTO person_helped_project VALUES (8, 576, '2013-09-03', '2014-02-07');
INSERT INTO person_helped_project VALUES (8, 575, '2013-09-03', '2014-02-07');
INSERT INTO person_helped_project VALUES (3, 1314, '2013-08-27', '2014-02-07');
INSERT INTO person_helped_project VALUES (9, 1315, '2013-09-09', NULL);
INSERT INTO person_helped_project VALUES (9, 567, '2013-08-08', NULL);
INSERT INTO person_helped_project VALUES (3, 565, '2013-07-30', '2014-02-10');
INSERT INTO person_helped_project VALUES (3, 102, '2013-07-07', NULL);
INSERT INTO person_helped_project VALUES (3, 1278, '2013-10-01', NULL);
INSERT INTO person_helped_project VALUES (3, 87, '2013-06-03', '2014-02-10');
INSERT INTO person_helped_project VALUES (3, 160, '2013-06-03', '2013-06-07');
INSERT INTO person_helped_project VALUES (7, 160, '2013-06-07', NULL);
INSERT INTO person_helped_project VALUES (3, 64, '2013-05-15', '2013-05-20');
INSERT INTO person_helped_project VALUES (3, 1316, '2013-09-15', '2013-10-19');
INSERT INTO person_helped_project VALUES (9, 760, '2013-05-07', NULL);
INSERT INTO person_helped_project VALUES (3, 82, '2013-05-06', '2013-05-09');
INSERT INTO person_helped_project VALUES (3, 695, '2013-03-05', '2013-04-08');
INSERT INTO person_helped_project VALUES (3, 73, '2013-05-04', '2013-04-06');
INSERT INTO person_helped_project VALUES (3, 1293, '2013-03-21', NULL);
INSERT INTO person_helped_project VALUES (3, 251, '2013-03-20', '2013-03-23');
INSERT INTO person_helped_project VALUES (3, 457, '2013-03-19', '2013-03-22');
INSERT INTO person_helped_project VALUES (8, 42, '2013-03-18', NULL);
INSERT INTO person_helped_project VALUES (3, 89, '2013-03-11', NULL);
INSERT INTO person_helped_project VALUES (9, 731, '2013-11-03', NULL);
INSERT INTO person_helped_project VALUES (3, 160, '2013-03-07', NULL);
INSERT INTO person_helped_project VALUES (3, 94, '2013-03-05', NULL);
INSERT INTO person_helped_project VALUES (3, 45, '2013-02-19', NULL);
INSERT INTO person_helped_project VALUES (3, 1289, '2013-02-08', '2013-02-08');
INSERT INTO person_helped_project VALUES (3, 1289, '2013-03-12', '2013-03-15');
INSERT INTO person_helped_project VALUES (8, 341, '2013-02-08', NULL);
INSERT INTO person_helped_project VALUES (3, 234, '2013-02-06', '2013-02-11');
INSERT INTO person_helped_project VALUES (11, 786, '2013-02-05', NULL);
INSERT INTO person_helped_project VALUES (9, 740, '2013-01-28', NULL);
INSERT INTO person_helped_project VALUES (3, 227, '2013-01-23', '2013-02-06');
INSERT INTO person_helped_project VALUES (3, 311, '2013-01-18', '2013-01-21');
INSERT INTO person_helped_project VALUES (9, 703, '2013-01-16', NULL);
INSERT INTO person_helped_project VALUES (3, 301, '2013-01-14', '2013-01-17');
INSERT INTO person_helped_project VALUES (3, 1327, '2014-02-25', '2014-02-28');
INSERT INTO person_helped_project VALUES (8, 1329, '2014-02-28', NULL);
INSERT INTO person_helped_project VALUES (8, 1328, '2014-02-25', NULL);
INSERT INTO person_helped_project VALUES (3, 1334, '2014-02-11', '2014-02-16');
INSERT INTO person_helped_project VALUES (3, 1336, '2014-02-06', NULL);
INSERT INTO person_helped_project VALUES (4, 1350, '2014-02-27', NULL);
INSERT INTO person_helped_project VALUES (8, 1362, '2014-04-22', NULL);
INSERT INTO person_helped_project VALUES (8, 1363, '2014-04-22', NULL);
INSERT INTO person_helped_project VALUES (8, 1366, '2014-04-03', NULL);
INSERT INTO person_helped_project VALUES (8, 1370, '2014-03-31', NULL);
INSERT INTO person_helped_project VALUES (4, 1382, '2014-03-27', NULL);
INSERT INTO person_helped_project VALUES (14, 1421, '2014-05-21', NULL);


--
-- TOC entry 2132 (class 0 OID 49852)
-- Dependencies: 168
-- Data for Name: person_media; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO person_media VALUES (6, 1);
INSERT INTO person_media VALUES (20, 2);
INSERT INTO person_media VALUES (25, 3);
INSERT INTO person_media VALUES (5, 4);
INSERT INTO person_media VALUES (13, 5);
INSERT INTO person_media VALUES (14, 6);
INSERT INTO person_media VALUES (15, 7);
INSERT INTO person_media VALUES (17, 8);
INSERT INTO person_media VALUES (3, 9);
INSERT INTO person_media VALUES (37, 10);
INSERT INTO person_media VALUES (38, 11);
INSERT INTO person_media VALUES (97, 12);
INSERT INTO person_media VALUES (48, 13);
INSERT INTO person_media VALUES (115, 14);
INSERT INTO person_media VALUES (109, 15);
INSERT INTO person_media VALUES (70, 16);
INSERT INTO person_media VALUES (67, 17);
INSERT INTO person_media VALUES (974, 18);
INSERT INTO person_media VALUES (71, 19);
INSERT INTO person_media VALUES (54, 20);
INSERT INTO person_media VALUES (128, 21);
INSERT INTO person_media VALUES (127, 22);
INSERT INTO person_media VALUES (574, 23);
INSERT INTO person_media VALUES (103, 24);
INSERT INTO person_media VALUES (117, 25);
INSERT INTO person_media VALUES (98, 26);
INSERT INTO person_media VALUES (72, 27);
INSERT INTO person_media VALUES (753, 28);
INSERT INTO person_media VALUES (118, 29);
INSERT INTO person_media VALUES (978, 30);
INSERT INTO person_media VALUES (60, 31);
INSERT INTO person_media VALUES (122, 32);
INSERT INTO person_media VALUES (126, 33);
INSERT INTO person_media VALUES (124, 34);
INSERT INTO person_media VALUES (132, 35);
INSERT INTO person_media VALUES (1047, 36);
INSERT INTO person_media VALUES (46, 37);
INSERT INTO person_media VALUES (1337, 38);
INSERT INTO person_media VALUES (1338, 39);
INSERT INTO person_media VALUES (62, 40);


--
-- TOC entry 2133 (class 0 OID 49855)
-- Dependencies: 169
-- Data for Name: person_programa_federal_social; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO person_programa_federal_social VALUES (845, 5, '10101010101');
INSERT INTO person_programa_federal_social VALUES (1370, 5, '16235902701');
INSERT INTO person_programa_federal_social VALUES (1312, 5, '333');
INSERT INTO person_programa_federal_social VALUES (1312, 3, '333');


--
-- TOC entry 2134 (class 0 OID 49860)
-- Dependencies: 171
-- Data for Name: programa_federal_social; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO programa_federal_social VALUES (1, 'Programa de Integração Social', 'PIS  ');
INSERT INTO programa_federal_social VALUES (2, 'Progr.Formação Patrimônio do Servidor', 'PASEP');
INSERT INTO programa_federal_social VALUES (3, 'Número de Identificação Social', 'NIS  ');
INSERT INTO programa_federal_social VALUES (4, 'Número de Identificação do Trabalhador', 'NIT  ');
INSERT INTO programa_federal_social VALUES (5, 'Bolsa Família', 'BF   ');
INSERT INTO programa_federal_social VALUES (6, 'Pronatec', 'PRONA');
INSERT INTO programa_federal_social VALUES (7, 'Pró-Jovem', 'PROJ ');


--
-- TOC entry 2135 (class 0 OID 49864)
-- Dependencies: 172
-- Data for Name: project; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO project VALUES (5, 'CREAS/ SUAS', NULL, 'Encaminhamento de pesoas ao centro de referencia de assistencia social, para  regressão a cidade natal.', '', 1, '2013-01-01', NULL, NULL, 1);
INSERT INTO project VALUES (4, 'Comunidade  terapêutica Vale da Esperança', NULL, 'Publico encaminhado para tratamento em Comunidade Terapeutica.', '', 1, '2013-01-01', NULL, NULL, 1);
INSERT INTO project VALUES (6, 'Ministério Melhor Viver - República de apoio', NULL, 'Ingresso voluntário de pessoas na condição de ex-moradores de rua com finalidade de participar do programa de atendimento visando reinserção integral.', '', 1, '2004-12-14', NULL, NULL, 1);
INSERT INTO project VALUES (7, 'Ministério Melhor Viver - Unidade de Acolhimento', NULL, 'Ingresso de pessoas encaminhadas pelo CAP''s AD com finalidade de participar do programa de atendimento visando reinserção integral.', '', 1, NULL, NULL, NULL, 1);
INSERT INTO project VALUES (8, 'SINE/AGÊNCIA DO TRABALHADOR', NULL, 'Ecaminhamento para a inclusão no mercado de trabalho', '', 1, '2013-12-02', NULL, NULL, 1);
INSERT INTO project VALUES (9, 'CAP''S AD', NULL, 'centro de atenção psico-social. Encaminhamento de trabalhos e serviços para tratamento e reinserção social de ex-dependentes químicos.', '', 1, NULL, NULL, NULL, 1);
INSERT INTO project VALUES (10, 'Cartório Sant''ana', NULL, 'Solicitar isenção na taxa de confecção de segunda via de certidão de nascimento.', '', 1, '2013-02-20', NULL, NULL, 1);
INSERT INTO project VALUES (11, 'Instituto de Identificação do Paraná', NULL, 'Solicitar gratuitamente ou a isenção da taxa de confecção da segunda via do R.G', '', 1, NULL, NULL, NULL, 1);
INSERT INTO project VALUES (3, 'Casa da Acolhida', NULL, 'Pernoites', '', 1, '2013-12-19', NULL, NULL, 1);
INSERT INTO project VALUES (13, 'Centro de Atendimento', NULL, 'Este projeto visa disponibilizar atendimento socioassistencial, espaço de convivência, contra turno social e educacional, atendimento às necessidades básicas, fortalecimento de vínculos familiares e comunitários, oportunizando a construção de projetos de vida às pessoas em situação de rua, de risco e vulnerabilidade social e suas famílias.', '<p class="MsoNormal" style="margin-top: 6.0pt; margin-right: 0cm; margin-bottom: 6.0pt; margin-left: 0cm; text-align: justify; text-indent: 27.0pt; line-height: 150%; mso-hyphenate: none;"><span style="font-size: 11pt; line-height: 150%; font-family: Arial, sans-serif;">A Associa&ccedil;&atilde;o Minist&eacute;rio Melhor Viver &eacute; uma organiza&ccedil;&atilde;o socioassistencial, sem fins lucrativos, formalmente estabelecida em Ponta Grossa desde 2005, com a vis&atilde;o de ser um caminho de aux&iacute;lio para a emancipa&ccedil;&atilde;o do p&uacute;blico atendido. Desde ent&atilde;o vem desenvolvendo v&aacute;rios projetos de prote&ccedil;&atilde;o social </span><span style="font-size: 11.0pt; line-height: 150%; font-family: ''Arial'',''sans-serif'';">b&aacute;sica</span><span style="font-size: 12pt; line-height: 150%; font-family: Arial, sans-serif;"> e fortalecimento de v&iacute;nculos do p&uacute;blico assistido</span><span style="font-size: 11.0pt; line-height: 150%; font-family: ''Arial'',''sans-serif'';">. Atualmente comp&otilde;e tamb&eacute;m a rede socioassistencial de prote&ccedil;&atilde;o especial, de m&eacute;dia e alta complexidade, com a presta&ccedil;&atilde;o de <em>servi&ccedil;os abordagem e de acolhimento em rep&uacute;blica</em> para adultos em processo de sa&iacute;da das ruas.</span></p>
<p class="MsoNormal" style="margin-top: 6.0pt; margin-right: 0cm; margin-bottom: 6.0pt; margin-left: 0cm; text-align: justify; text-indent: 27.0pt; line-height: 150%; mso-hyphenate: none;"><span style="font-size: 11.0pt; line-height: 150%; font-family: ''Arial'',''sans-serif'';">A miss&atilde;o da organiza&ccedil;&atilde;o &eacute; prestar atendimento de qualidade a pessoas e fam&iacute;lias em situa&ccedil;&atilde;o de vulnerabilidade ou risco social e pessoal, sobretudo os que se encontram em situa&ccedil;&atilde;o de rua, oportunizando-lhes desenvolvimento <em>integral</em>, na perspectiva da retomada de seus projetos de vida.</span></p>
<p class="MsoNormal" style="margin-top: 6.0pt; margin-right: 0cm; margin-bottom: 6.0pt; margin-left: 0cm; text-align: justify; text-indent: 27.0pt; line-height: 150%; mso-hyphenate: none;"><span style="font-size: 11.0pt; line-height: 150%; font-family: ''Arial'',''sans-serif'';">Este projeto visa disponibilizar atendimento socioassistencial, espa&ccedil;o de conviv&ecirc;ncia, contra turno social e educacional, atendimento &agrave;s necessidades b&aacute;sicas, fortalecimento de v&iacute;nculos familiares e comunit&aacute;rios, oportunizando a constru&ccedil;&atilde;o de projetos de vida &agrave;s pessoas em situa&ccedil;&atilde;o de rua, de risco e vulnerabilidade social e suas fam&iacute;lias.</span></p>
<p class="MsoNormal" style="margin-top: 6.0pt; margin-right: 0cm; margin-bottom: 6.0pt; margin-left: 0cm; text-align: justify; text-indent: 26.95pt; line-height: 140%; mso-hyphenate: none;"><span style="font-size: 11.0pt; line-height: 140%; font-family: ''Arial'',''sans-serif'';">A entidade possui equipe t&eacute;cnica necess&aacute;ria para o desenvolvimento de seus projetos atualmente em execu&ccedil;&atilde;o e dezenas de volunt&aacute;rios, pessoas motivadas e alinhadas com a miss&atilde;o e vis&atilde;o da organiza&ccedil;&atilde;o, das mais diversas &aacute;reas de atua&ccedil;&atilde;o profissional. </span></p>
<p class="MsoNormal" style="margin-top: 6.0pt; margin-right: 0cm; margin-bottom: 6.0pt; margin-left: 0cm; text-align: justify; text-indent: 26.95pt; line-height: 140%; mso-hyphenate: none;"><span style="font-size: 11.0pt; line-height: 140%; font-family: ''Arial'',''sans-serif'';">O Programa de Atendimento da organiza&ccedil;&atilde;o &eacute; comporto por v&aacute;rios projetos: Agordagem Soical, Centro de Atendimento, Servi&ccedil;o de Acolhimento em Rep&uacute;blica, Grupos de Apoio, Caf&eacute; com Amor, Sopa com Amor, Alfabetiza&ccedil;&atilde;o de Adultos, e projetos de gera&ccedil;&atilde;o de renda, prepara&ccedil;&atilde;o e inclus&atilde;o no mercado de trabalho. </span><span style="font-size: 10.5pt; line-height: 140%; font-family: Arial, sans-serif;">Tamb&eacute;m s&atilde;o desenvolvidos projetos na &aacute;rea da sa&uacute;de (<em>Portarias MS 121/2012 &ndash; unidade de acolhimento e Comunidade Terap&ecirc;utica para adolescentes, em parceria com o Minist&eacute;rio da Sa&uacute;de e a Secretaria Municipal de Sa&uacute;de, respectivamente</em>).</span></p>
<p>&nbsp;</p>
<p class="MsoNormal" style="margin-top: 6.0pt; margin-right: 0cm; margin-bottom: 6.0pt; margin-left: 0cm; text-align: justify; text-indent: 27.0pt; line-height: 150%; mso-hyphenate: none;"><span style="font-size: 11.0pt; line-height: 150%; font-family: ''Arial'',''sans-serif'';">Espera-se obter, como resultados: a satisfa&ccedil;&atilde;o das necessidades b&aacute;sicas, a cria&ccedil;&atilde;o e o fortalecimento de v&iacute;nculos familiares e comunit&aacute;rios, o resgate da dignidade, da autoestima e da esperan&ccedil;a de futuro, a redu&ccedil;&atilde;o das viola&ccedil;&otilde;es dos direitos socioassistenciais, seus agravamentos ou reincid&ecirc;ncia, a prote&ccedil;&atilde;o social a fam&iacute;lias e indiv&iacute;duos, a redu&ccedil;&atilde;o de danos provocados por situa&ccedil;&otilde;es violadoras de direitos e a constru&ccedil;&atilde;o de novos projetos de vida.</span></p>', 1, '2011-01-10', NULL, NULL, 1);
INSERT INTO project VALUES (14, 'Rosa Mistica', NULL, 'Acolhe mulheres para tratamento de Comunidade Terapeutica', '', 1, '2014-01-01', NULL, NULL, 1);
INSERT INTO project VALUES (12, 'PROLAR', NULL, 'Efetuar cadastro junto a PROLAR', '', 1, NULL, NULL, NULL, 2);


--
-- TOC entry 2146 (class 0 OID 50177)
-- Dependencies: 190
-- Data for Name: project_media; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 2136 (class 0 OID 49873)
-- Dependencies: 174
-- Data for Name: state; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO state VALUES (1, 'Acre', 1, 'AC');
INSERT INTO state VALUES (2, 'Alagoas', 1, 'AL');
INSERT INTO state VALUES (3, 'Amapá', 1, 'AP');
INSERT INTO state VALUES (4, 'Amazonas', 1, 'AM');
INSERT INTO state VALUES (5, 'Bahia', 1, 'BA');
INSERT INTO state VALUES (6, 'Ceará', 1, 'CE');
INSERT INTO state VALUES (7, 'Distrito Federal', 1, 'DF');
INSERT INTO state VALUES (8, 'Espírito Santo', 1, 'ES');
INSERT INTO state VALUES (9, 'Goiás', 1, 'GO');
INSERT INTO state VALUES (10, 'Maranhão', 1, 'MA');
INSERT INTO state VALUES (11, 'Mato Grosso', 1, 'MT');
INSERT INTO state VALUES (12, 'Mato Grosso do Sul', 1, 'MS');
INSERT INTO state VALUES (14, 'Pará', 1, 'PA');
INSERT INTO state VALUES (16, 'Paraíba', 1, 'PB');
INSERT INTO state VALUES (17, 'Paraná', 1, 'PR');
INSERT INTO state VALUES (18, 'Pernambuco', 1, 'PE');
INSERT INTO state VALUES (19, 'Piauí', 1, 'PI');
INSERT INTO state VALUES (20, 'Rio de Janeiro', 1, 'RJ');
INSERT INTO state VALUES (21, 'Rio Grande do Norte', 1, 'RN');
INSERT INTO state VALUES (22, 'Rio Grande do Sul', 1, 'RS');
INSERT INTO state VALUES (23, 'Rondônia', 1, 'RO');
INSERT INTO state VALUES (24, 'Roraima', 1, 'RR');
INSERT INTO state VALUES (25, 'Santa Catarina', 1, 'SC');
INSERT INTO state VALUES (26, 'São Paulo', 1, 'SP');
INSERT INTO state VALUES (27, 'Sergipe', 1, 'SE');
INSERT INTO state VALUES (28, 'Tocantins', 1, 'TO');
INSERT INTO state VALUES (29, 'Minas Gerais', 1, 'MG');


--
-- TOC entry 2137 (class 0 OID 49878)
-- Dependencies: 176
-- Data for Name: task_type; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO task_type VALUES (1, 'Atendimento Social', '', NULL, 1);
INSERT INTO task_type VALUES (2, 'Casa da Acolhida', '', 1, 1);
INSERT INTO task_type VALUES (3, 'Conselho Tutelar', '', 1, 1);
INSERT INTO task_type VALUES (4, 'CREAS', '', 1, 1);
INSERT INTO task_type VALUES (5, 'CRAS', '', 1, 1);
INSERT INTO task_type VALUES (6, 'Encaminhamento Júridico', '', 1, 1);
INSERT INTO task_type VALUES (7, 'Visita Social', '', 1, 1);
INSERT INTO task_type VALUES (8, 'Auxilio Documentação', '', 1, 1);
INSERT INTO task_type VALUES (9, 'Encaminhamento Emprego', '', 1, 1);
INSERT INTO task_type VALUES (10, 'Saúde', '', NULL, 1);
INSERT INTO task_type VALUES (11, 'Doação de Medicamentos', '', 10, 1);
INSERT INTO task_type VALUES (12, 'Pronto Socorro', '', 10, 1);
INSERT INTO task_type VALUES (13, 'Odontologia', '', 10, 1);
INSERT INTO task_type VALUES (14, 'Consulta Médica', '', 10, 1);
INSERT INTO task_type VALUES (15, 'Exame de Laboratório', '', 10, 1);
INSERT INTO task_type VALUES (16, 'Casa de recuperação', '', 10, 1);
INSERT INTO task_type VALUES (17, 'Psicologia-CRA', '', 10, 1);
INSERT INTO task_type VALUES (18, 'Alimentação', '', NULL, 1);
INSERT INTO task_type VALUES (19, 'Café da manhã', '', 18, 1);
INSERT INTO task_type VALUES (20, 'Almoço', '', 18, 1);
INSERT INTO task_type VALUES (21, 'Lanche da Tarde', '', 18, 1);
INSERT INTO task_type VALUES (22, 'Jantar', '', 18, 1);
INSERT INTO task_type VALUES (23, 'Doações', '', NULL, 1);
INSERT INTO task_type VALUES (24, 'Doação de Brinquedos', '', 23, 1);
INSERT INTO task_type VALUES (25, 'Doação de Cesta Básica', '', 23, 1);
INSERT INTO task_type VALUES (26, 'Doação de Comida Caseira', '', 23, 1);
INSERT INTO task_type VALUES (27, 'Doação de Calçado', '', 23, 1);
INSERT INTO task_type VALUES (28, 'Doação de Roupa', '', 23, 1);
INSERT INTO task_type VALUES (29, 'Doação de Coberta', '', 23, 1);
INSERT INTO task_type VALUES (30, 'Higiene', '', NULL, 1);
INSERT INTO task_type VALUES (31, 'Lavagem de Roupas', '', 30, 1);
INSERT INTO task_type VALUES (32, 'Escovação de dentes', '', 30, 1);
INSERT INTO task_type VALUES (33, 'Banho', '', 30, 1);
INSERT INTO task_type VALUES (34, 'Corte de Cabelo', '', 30, 1);
INSERT INTO task_type VALUES (35, 'Corte de Barba', '', 30, 1);
INSERT INTO task_type VALUES (36, 'Corte de Unhas', '', 30, 1);
INSERT INTO task_type VALUES (37, 'Eventos e Recreação', '', NULL, 1);
INSERT INTO task_type VALUES (38, 'Tênis de Mesa', '', 37, 1);
INSERT INTO task_type VALUES (39, 'Atletismo', '', 37, 1);
INSERT INTO task_type VALUES (40, 'Basquete', '', 37, 1);
INSERT INTO task_type VALUES (41, 'Futebol', '', 37, 1);
INSERT INTO task_type VALUES (42, 'Recreação', '', 37, 1);
INSERT INTO task_type VALUES (43, 'Festa do Natal', '', 37, 1);
INSERT INTO task_type VALUES (44, 'Dia das crianças', '', 37, 1);
INSERT INTO task_type VALUES (45, 'Estudo', '', NULL, 1);
INSERT INTO task_type VALUES (46, 'Culinária', '', 45, 1);
INSERT INTO task_type VALUES (47, 'Babá', '', 45, 1);
INSERT INTO task_type VALUES (48, 'Assistente do Lar', '', 45, 1);
INSERT INTO task_type VALUES (49, 'Informática', '', 45, 1);
INSERT INTO task_type VALUES (50, 'Reciclagem', '', 45, 1);
INSERT INTO task_type VALUES (51, 'Jardinagem', '', 45, 1);
INSERT INTO task_type VALUES (52, 'Criação de aves', '', 45, 1);
INSERT INTO task_type VALUES (53, 'Fruticultura', '', 45, 1);
INSERT INTO task_type VALUES (54, 'Pano de Prato', '', 45, 1);
INSERT INTO task_type VALUES (55, 'Mulher Virtuosa', '', 45, 1);
INSERT INTO task_type VALUES (56, 'Pró Jovem', '', 45, 1);
INSERT INTO task_type VALUES (57, 'Paraná Alfabetizado', '', 45, 1);
INSERT INTO task_type VALUES (58, 'Religião e Moral', '', 45, 1);


--
-- TOC entry 2138 (class 0 OID 49886)
-- Dependencies: 178
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO "user" VALUES (3, 'silvana', 'silvanammoro@hotmail.com', '19b9089c92c4fc62e3bac528182127c8', '2012-12-19 13:12:53', '2012-12-19 13:59:28', 1, '367cd6eaeadf455090096b2fddcb7de1', 3, 1, 3);
INSERT INTO "user" VALUES (5, 'carolina', 'carolruiva21@hotmail.com', '52ace7cff7c215d0f17e202c55f23f5d', '2012-12-19 14:12:55', '2012-12-19 14:03:46', 1, '1e83fb4a9ab15ec09526c10406623bda', 5, 1, 3);
INSERT INTO "user" VALUES (2, 'pastorjoao', 'jeliseumontes@hotmail.com', '9358e17f7e785a2d15ec86d3b20fbd9d', '2012-12-19 13:12:35', '2013-01-02 14:35:56', 1, '4190e00a26f5cc292c0c9509030e1041', 2, 1, 2);
INSERT INTO "user" VALUES (7, 'John Lenon Costa Sagais', 'johnsagais@outlook.com', 'dd7bed55926844926c9c37706e0fc5e8', '2013-08-30 16:08:36', '2014-04-24 13:41:21', 1, 'c57bd1407356938791ef3a3826060c6a', 97, 1, 4);
INSERT INTO "user" VALUES (8, 'marcel', 'mdegeus13@hotmail.com', 'c6940d5b1f3f8ff68921e057e931f34d', '2014-04-29 17:04:04', '2014-06-03 07:12:24', 1, '279eb60b21f1547e457b77ea2241b5ad', 1374, 1, 4);
INSERT INTO "user" VALUES (6, 'manu', 'emanuelypitome@hotmail.com', '095a146ba4da9ef153ae4967979216a3', '2012-12-19 14:12:41', '2014-06-12 08:34:59', 1, 'c22c4fcf4ddc55198d72b23c27824223', 6, 1, 3);
INSERT INTO "user" VALUES (1, 'superadmin', 'ademir@winponta.com.br', 'c748e2bd0fa8787f20751da29aa4b14a', '2012-12-18 16:12:04', '2014-10-13 10:48:03', 1, 'cdb8e86d07375cc2d71e1751d5a88977', 1, 1, 1);


--
-- TOC entry 2139 (class 0 OID 49896)
-- Dependencies: 181
-- Data for Name: volunteer; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO volunteer VALUES (6);
INSERT INTO volunteer VALUES (3);
INSERT INTO volunteer VALUES (19);
INSERT INTO volunteer VALUES (97);
INSERT INTO volunteer VALUES (755);
INSERT INTO volunteer VALUES (1338);


--
-- TOC entry 2140 (class 0 OID 49908)
-- Dependencies: 183
-- Data for Name: volunteer_expertise_area; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO volunteer_expertise_area VALUES (6, 3);
INSERT INTO volunteer_expertise_area VALUES (6, 2);
INSERT INTO volunteer_expertise_area VALUES (3, 5);
INSERT INTO volunteer_expertise_area VALUES (19, 4);
INSERT INTO volunteer_expertise_area VALUES (97, 6);
INSERT INTO volunteer_expertise_area VALUES (755, 5);
INSERT INTO volunteer_expertise_area VALUES (1338, 5);


--
-- TOC entry 1994 (class 2606 OID 49927)
-- Dependencies: 142 142
-- Name: acl_role_permission_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_role_permission
    ADD CONSTRAINT acl_role_permission_pk PRIMARY KEY (id);


--
-- TOC entry 1992 (class 2606 OID 49929)
-- Dependencies: 140 140
-- Name: acl_role_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY acl_role
    ADD CONSTRAINT acl_role_pk PRIMARY KEY (id);


--
-- TOC entry 1997 (class 2606 OID 49931)
-- Dependencies: 144 144
-- Name: appaccount_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY appaccount
    ADD CONSTRAINT appaccount_pk PRIMARY KEY (id);


--
-- TOC entry 1999 (class 2606 OID 49933)
-- Dependencies: 146 146
-- Name: audit_trail_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY audit_trail
    ADD CONSTRAINT audit_trail_pk PRIMARY KEY (id);


--
-- TOC entry 2003 (class 2606 OID 49935)
-- Dependencies: 148 148
-- Name: busunit_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY busunit
    ADD CONSTRAINT busunit_pk PRIMARY KEY (id);


--
-- TOC entry 2005 (class 2606 OID 49937)
-- Dependencies: 150 150
-- Name: city_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY city
    ADD CONSTRAINT city_pk PRIMARY KEY (id);


--
-- TOC entry 2007 (class 2606 OID 49939)
-- Dependencies: 153 153
-- Name: city_region_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY city_region
    ADD CONSTRAINT city_region_pk PRIMARY KEY (id);


--
-- TOC entry 2009 (class 2606 OID 49941)
-- Dependencies: 154 154
-- Name: country_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY country
    ADD CONSTRAINT country_pk PRIMARY KEY (id);


--
-- TOC entry 2011 (class 2606 OID 49943)
-- Dependencies: 156 156
-- Name: employee_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY employee
    ADD CONSTRAINT employee_pk PRIMARY KEY (id);


--
-- TOC entry 2014 (class 2606 OID 49945)
-- Dependencies: 157 157
-- Name: expertise_area_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY expertise_area
    ADD CONSTRAINT expertise_area_pk PRIMARY KEY (id);


--
-- TOC entry 2016 (class 2606 OID 49947)
-- Dependencies: 159 159
-- Name: job_function_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY job_function
    ADD CONSTRAINT job_function_pk PRIMARY KEY (id);


--
-- TOC entry 2018 (class 2606 OID 49949)
-- Dependencies: 161 161
-- Name: media_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY media
    ADD CONSTRAINT media_pk PRIMARY KEY (id);


--
-- TOC entry 2025 (class 2606 OID 49951)
-- Dependencies: 164 164
-- Name: person_docs_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY person_docs
    ADD CONSTRAINT person_docs_pk PRIMARY KEY (id);


--
-- TOC entry 2031 (class 2606 OID 49953)
-- Dependencies: 168 168 168
-- Name: person_media_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY person_media
    ADD CONSTRAINT person_media_pk PRIMARY KEY (person_id, media_id);


--
-- TOC entry 2023 (class 2606 OID 49955)
-- Dependencies: 163 163
-- Name: person_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY person
    ADD CONSTRAINT person_pk PRIMARY KEY (id);


--
-- TOC entry 2052 (class 2606 OID 50151)
-- Dependencies: 185 185 185
-- Name: pkappaccount_media; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY appaccount_media
    ADD CONSTRAINT pkappaccount_media PRIMARY KEY (appaccount_id, media_id);


--
-- TOC entry 2054 (class 2606 OID 50161)
-- Dependencies: 186 186
-- Name: pkatividade_assistencia; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT pkatividade_assistencia PRIMARY KEY (id);


--
-- TOC entry 2056 (class 2606 OID 50166)
-- Dependencies: 187 187
-- Name: pkcategory; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY category
    ADD CONSTRAINT pkcategory PRIMARY KEY (id);


--
-- TOC entry 2058 (class 2606 OID 50171)
-- Dependencies: 188 188
-- Name: pkcategory_group; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY category_group
    ADD CONSTRAINT pkcategory_group PRIMARY KEY (id);


--
-- TOC entry 2061 (class 2606 OID 50176)
-- Dependencies: 189 189
-- Name: pkevento_assistencia; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY evento_assistencia
    ADD CONSTRAINT pkevento_assistencia PRIMARY KEY (id);


--
-- TOC entry 2065 (class 2606 OID 94766)
-- Dependencies: 192 192 192
-- Name: pkfingerprint; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY fingerprint
    ADD CONSTRAINT pkfingerprint PRIMARY KEY (person_id, finger_number);


--
-- TOC entry 2027 (class 2606 OID 49957)
-- Dependencies: 165 165
-- Name: pkperson_helped; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY person_helped
    ADD CONSTRAINT pkperson_helped PRIMARY KEY (id);


--
-- TOC entry 2029 (class 2606 OID 49959)
-- Dependencies: 166 166 166 166
-- Name: pkperson_helped_project; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY person_helped_project
    ADD CONSTRAINT pkperson_helped_project PRIMARY KEY (project_id, person_id, date_in);


--
-- TOC entry 2033 (class 2606 OID 49961)
-- Dependencies: 169 169 169
-- Name: pkperson_programa_federal_social; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY person_programa_federal_social
    ADD CONSTRAINT pkperson_programa_federal_social PRIMARY KEY (person_id, pfs_id);


--
-- TOC entry 2035 (class 2606 OID 49963)
-- Dependencies: 171 171
-- Name: pkprograma_federal_social; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY programa_federal_social
    ADD CONSTRAINT pkprograma_federal_social PRIMARY KEY (id);


--
-- TOC entry 2063 (class 2606 OID 50181)
-- Dependencies: 190 190 190
-- Name: pkproject_media; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY project_media
    ADD CONSTRAINT pkproject_media PRIMARY KEY (project_id, media_id);


--
-- TOC entry 2037 (class 2606 OID 49965)
-- Dependencies: 172 172
-- Name: project_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY project
    ADD CONSTRAINT project_pk PRIMARY KEY (id);


--
-- TOC entry 2039 (class 2606 OID 49967)
-- Dependencies: 174 174
-- Name: state_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY state
    ADD CONSTRAINT state_pk PRIMARY KEY (id);


--
-- TOC entry 2042 (class 2606 OID 49969)
-- Dependencies: 176 176
-- Name: task_type_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY task_type
    ADD CONSTRAINT task_type_pk PRIMARY KEY (id);


--
-- TOC entry 2046 (class 2606 OID 49971)
-- Dependencies: 178 178
-- Name: user_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pk PRIMARY KEY (id);


--
-- TOC entry 2050 (class 2606 OID 49973)
-- Dependencies: 183 183 183
-- Name: volunteer_expertise_area_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY volunteer_expertise_area
    ADD CONSTRAINT volunteer_expertise_area_pk PRIMARY KEY (volunteer_id, expertise_area_id);


--
-- TOC entry 2048 (class 2606 OID 49975)
-- Dependencies: 181 181
-- Name: volunteer_pk; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY volunteer
    ADD CONSTRAINT volunteer_pk PRIMARY KEY (id);


--
-- TOC entry 1990 (class 1259 OID 49976)
-- Dependencies: 140 140
-- Name: acl_role_name_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE UNIQUE INDEX acl_role_name_idx ON acl_role USING btree (name, appaccount_id);


--
-- TOC entry 1995 (class 1259 OID 49977)
-- Dependencies: 144
-- Name: appaccount_idx_name; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE UNIQUE INDEX appaccount_idx_name ON appaccount USING btree (name);


--
-- TOC entry 2000 (class 1259 OID 49978)
-- Dependencies: 148
-- Name: busunit_appaccount_fk; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX busunit_appaccount_fk ON busunit USING btree (appaccount_id);


--
-- TOC entry 2001 (class 1259 OID 49979)
-- Dependencies: 148
-- Name: busunit_idx_name; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE UNIQUE INDEX busunit_idx_name ON busunit USING btree (name);


--
-- TOC entry 2012 (class 1259 OID 49980)
-- Dependencies: 156 156
-- Name: employee_registration_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE UNIQUE INDEX employee_registration_idx ON employee USING btree (registration_number, busunit_id);


--
-- TOC entry 2059 (class 1259 OID 78374)
-- Dependencies: 189
-- Name: evento_assistencia_event_date_Idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX "evento_assistencia_event_date_Idx" ON evento_assistencia USING btree (event_date);


--
-- TOC entry 2019 (class 1259 OID 49981)
-- Dependencies: 163
-- Name: person_name_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX person_name_idx ON person USING btree (name);


--
-- TOC entry 2020 (class 1259 OID 49982)
-- Dependencies: 163
-- Name: person_name_like_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX person_name_like_idx ON person USING btree (name varchar_pattern_ops);


--
-- TOC entry 2021 (class 1259 OID 49983)
-- Dependencies: 163
-- Name: person_name_pattern_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX person_name_pattern_idx ON person USING btree (name text_pattern_ops);


--
-- TOC entry 2040 (class 1259 OID 49984)
-- Dependencies: 174 174
-- Name: state_unq_country_abbreviation; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE UNIQUE INDEX state_unq_country_abbreviation ON state USING btree (abbreviation, country_id);


--
-- TOC entry 2043 (class 1259 OID 49985)
-- Dependencies: 178
-- Name: user_idx_email; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE UNIQUE INDEX user_idx_email ON "user" USING btree (email);


--
-- TOC entry 2044 (class 1259 OID 49986)
-- Dependencies: 178
-- Name: user_idx_name; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE UNIQUE INDEX user_idx_name ON "user" USING btree (name);


--
-- TOC entry 2067 (class 2606 OID 49987)
-- Dependencies: 140 1991 142
-- Name: acl_role_acl_role_permission_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_role_permission
    ADD CONSTRAINT acl_role_acl_role_permission_fk FOREIGN KEY (acl_role_id) REFERENCES acl_role(id) ON DELETE CASCADE;


--
-- TOC entry 2092 (class 2606 OID 49992)
-- Dependencies: 1991 178 140
-- Name: acl_role_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT acl_role_user_fk FOREIGN KEY (acl_role_id) REFERENCES acl_role(id) ON DELETE RESTRICT;


--
-- TOC entry 2066 (class 2606 OID 49997)
-- Dependencies: 1996 140 144
-- Name: appaccount_acl_role_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY acl_role
    ADD CONSTRAINT appaccount_acl_role_fk FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON DELETE RESTRICT;


--
-- TOC entry 2068 (class 2606 OID 50002)
-- Dependencies: 1996 148 144
-- Name: appaccount_busunit_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY busunit
    ADD CONSTRAINT appaccount_busunit_fk FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON DELETE RESTRICT;


--
-- TOC entry 2076 (class 2606 OID 50007)
-- Dependencies: 163 144 1996
-- Name: appaccount_person_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY person
    ADD CONSTRAINT appaccount_person_fk FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON DELETE CASCADE;


--
-- TOC entry 2093 (class 2606 OID 50012)
-- Dependencies: 1996 178 144
-- Name: appaccount_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT appaccount_user_fk FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON DELETE RESTRICT;


--
-- TOC entry 2073 (class 2606 OID 50017)
-- Dependencies: 156 2002 148
-- Name: busunit_employee_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY employee
    ADD CONSTRAINT busunit_employee_fk FOREIGN KEY (busunit_id) REFERENCES busunit(id) ON DELETE RESTRICT;


--
-- TOC entry 2071 (class 2606 OID 50022)
-- Dependencies: 150 2004 153
-- Name: city_city_region_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY city_region
    ADD CONSTRAINT city_city_region_fk FOREIGN KEY (city_id) REFERENCES city(id) ON DELETE RESTRICT;


--
-- TOC entry 2069 (class 2606 OID 50027)
-- Dependencies: 2004 148 150
-- Name: city_organization_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY busunit
    ADD CONSTRAINT city_organization_fk FOREIGN KEY (city_id) REFERENCES city(id) ON DELETE RESTRICT;


--
-- TOC entry 2077 (class 2606 OID 50032)
-- Dependencies: 163 150 2004
-- Name: city_person_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY person
    ADD CONSTRAINT city_person_fk FOREIGN KEY (city_id) REFERENCES city(id) ON DELETE RESTRICT;


--
-- TOC entry 2078 (class 2606 OID 50037)
-- Dependencies: 163 153 2006
-- Name: city_region_person_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY person
    ADD CONSTRAINT city_region_person_fk FOREIGN KEY (city_region_id) REFERENCES city_region(id) ON DELETE RESTRICT;


--
-- TOC entry 2090 (class 2606 OID 50042)
-- Dependencies: 154 174 2008
-- Name: country_state_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY state
    ADD CONSTRAINT country_state_fk FOREIGN KEY (country_id) REFERENCES country(id) ON DELETE RESTRICT;


--
-- TOC entry 2096 (class 2606 OID 50047)
-- Dependencies: 183 2013 157
-- Name: expertise_area_volunteer_expertise_area_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY volunteer_expertise_area
    ADD CONSTRAINT expertise_area_volunteer_expertise_area_fk FOREIGN KEY (expertise_area_id) REFERENCES expertise_area(id) ON DELETE RESTRICT;


--
-- TOC entry 2098 (class 2606 OID 50198)
-- Dependencies: 144 185 1996
-- Name: fk_appaccount_media_appaccount; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY appaccount_media
    ADD CONSTRAINT fk_appaccount_media_appaccount FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2099 (class 2606 OID 50203)
-- Dependencies: 2017 185 161
-- Name: fk_appaccount_media_media; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY appaccount_media
    ADD CONSTRAINT fk_appaccount_media_media FOREIGN KEY (media_id) REFERENCES media(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2106 (class 2606 OID 86688)
-- Dependencies: 186 1996 144
-- Name: fk_atividade_assistencia_appaccount; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT fk_atividade_assistencia_appaccount FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2100 (class 2606 OID 50208)
-- Dependencies: 2060 186 189
-- Name: fk_atividade_assistencia_evento_assistencia; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT fk_atividade_assistencia_evento_assistencia FOREIGN KEY (event_id) REFERENCES evento_assistencia(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2101 (class 2606 OID 50213)
-- Dependencies: 2022 186 163
-- Name: fk_atividade_assistencia_person; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT fk_atividade_assistencia_person FOREIGN KEY (person_recorded_id) REFERENCES person(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2102 (class 2606 OID 50218)
-- Dependencies: 163 186 2022
-- Name: fk_atividade_assistencia_person_helped; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT fk_atividade_assistencia_person_helped FOREIGN KEY (person_helped_id) REFERENCES person(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2103 (class 2606 OID 50223)
-- Dependencies: 186 2022 163
-- Name: fk_atividade_assistencia_person_performed; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT fk_atividade_assistencia_person_performed FOREIGN KEY (person_performed_id) REFERENCES person(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2104 (class 2606 OID 50228)
-- Dependencies: 172 186 2036
-- Name: fk_atividade_assistencia_project; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT fk_atividade_assistencia_project FOREIGN KEY (project_id) REFERENCES project(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2105 (class 2606 OID 50233)
-- Dependencies: 2041 186 176
-- Name: fk_atividade_assistencia_task_type; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT fk_atividade_assistencia_task_type FOREIGN KEY (task_type_id) REFERENCES task_type(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2107 (class 2606 OID 50238)
-- Dependencies: 187 2055 187
-- Name: fk_category_category; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY category
    ADD CONSTRAINT fk_category_category FOREIGN KEY (parent_id) REFERENCES category(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2108 (class 2606 OID 50243)
-- Dependencies: 187 2057 188
-- Name: fk_category_category_group; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY category
    ADD CONSTRAINT fk_category_category_group FOREIGN KEY (category_group_id) REFERENCES category_group(id);


--
-- TOC entry 2109 (class 2606 OID 50248)
-- Dependencies: 187 188 2057
-- Name: fk_category_category_group_id; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY category
    ADD CONSTRAINT fk_category_category_group_id FOREIGN KEY (category_group_id) REFERENCES category_group(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2112 (class 2606 OID 86655)
-- Dependencies: 1996 144 189
-- Name: fk_evento_assistencia_appaccount; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY evento_assistencia
    ADD CONSTRAINT fk_evento_assistencia_appaccount FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2110 (class 2606 OID 78390)
-- Dependencies: 172 2036 189
-- Name: fk_evento_assistencia_project; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY evento_assistencia
    ADD CONSTRAINT fk_evento_assistencia_project FOREIGN KEY (project_id) REFERENCES project(id) ON DELETE RESTRICT;


--
-- TOC entry 2111 (class 2606 OID 78395)
-- Dependencies: 176 189 2041
-- Name: fk_evento_assistencia_task_type; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY evento_assistencia
    ADD CONSTRAINT fk_evento_assistencia_task_type FOREIGN KEY (task_type_id) REFERENCES task_type(id) ON DELETE RESTRICT;


--
-- TOC entry 2115 (class 2606 OID 94781)
-- Dependencies: 2022 163 192
-- Name: fk_fingerprint_person; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY fingerprint
    ADD CONSTRAINT fk_fingerprint_person FOREIGN KEY (person_id) REFERENCES person(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2080 (class 2606 OID 50052)
-- Dependencies: 165 2004 150
-- Name: fk_person_helped_city; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY person_helped
    ADD CONSTRAINT fk_person_helped_city FOREIGN KEY (born_city_id) REFERENCES city(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2081 (class 2606 OID 50057)
-- Dependencies: 2022 163 165
-- Name: fk_person_helped_person; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY person_helped
    ADD CONSTRAINT fk_person_helped_person FOREIGN KEY (id) REFERENCES person(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2082 (class 2606 OID 50062)
-- Dependencies: 165 174 2038
-- Name: fk_person_helped_state; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY person_helped
    ADD CONSTRAINT fk_person_helped_state FOREIGN KEY (born_state_id) REFERENCES state(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2087 (class 2606 OID 50067)
-- Dependencies: 169 2022 163
-- Name: fk_person_programa_federal_social_person; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY person_programa_federal_social
    ADD CONSTRAINT fk_person_programa_federal_social_person FOREIGN KEY (person_id) REFERENCES person(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2088 (class 2606 OID 50072)
-- Dependencies: 171 169 2034
-- Name: fk_person_programa_federal_social_programa_federal_social; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY person_programa_federal_social
    ADD CONSTRAINT fk_person_programa_federal_social_programa_federal_social FOREIGN KEY (pfs_id) REFERENCES programa_federal_social(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2089 (class 2606 OID 86580)
-- Dependencies: 144 172 1996
-- Name: fk_project_appaccount; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY project
    ADD CONSTRAINT fk_project_appaccount FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2113 (class 2606 OID 50253)
-- Dependencies: 161 2017 190
-- Name: fk_project_media_media; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY project_media
    ADD CONSTRAINT fk_project_media_media FOREIGN KEY (media_id) REFERENCES media(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2114 (class 2606 OID 50258)
-- Dependencies: 2036 172 190
-- Name: fk_project_media_project; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY project_media
    ADD CONSTRAINT fk_project_media_project FOREIGN KEY (project_id) REFERENCES project(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2083 (class 2606 OID 50077)
-- Dependencies: 166 165 2026
-- Name: fk_project_person_helped_person_helped; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY person_helped_project
    ADD CONSTRAINT fk_project_person_helped_person_helped FOREIGN KEY (person_id) REFERENCES person_helped(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2084 (class 2606 OID 50082)
-- Dependencies: 166 172 2036
-- Name: fk_project_person_helped_project; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY person_helped_project
    ADD CONSTRAINT fk_project_person_helped_project FOREIGN KEY (project_id) REFERENCES project(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2074 (class 2606 OID 50087)
-- Dependencies: 156 159 2015
-- Name: job_function_employee_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY employee
    ADD CONSTRAINT job_function_employee_fk FOREIGN KEY (job_function_id) REFERENCES job_function(id) ON DELETE RESTRICT;


--
-- TOC entry 2085 (class 2606 OID 50092)
-- Dependencies: 2017 161 168
-- Name: media_person_media_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY person_media
    ADD CONSTRAINT media_person_media_fk FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE RESTRICT;


--
-- TOC entry 2072 (class 2606 OID 50097)
-- Dependencies: 153 153 2006
-- Name: parent_city_region_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY city_region
    ADD CONSTRAINT parent_city_region_fk FOREIGN KEY (parent_id) REFERENCES city_region(id) ON DELETE RESTRICT;


--
-- TOC entry 2075 (class 2606 OID 50102)
-- Dependencies: 156 2022 163
-- Name: person_employee_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY employee
    ADD CONSTRAINT person_employee_fk FOREIGN KEY (id) REFERENCES person(id);


--
-- TOC entry 2079 (class 2606 OID 50107)
-- Dependencies: 163 164 2022
-- Name: person_person_docs_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY person_docs
    ADD CONSTRAINT person_person_docs_fk FOREIGN KEY (id) REFERENCES person(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2086 (class 2606 OID 50112)
-- Dependencies: 168 2022 163
-- Name: person_person_media_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY person_media
    ADD CONSTRAINT person_person_media_fk FOREIGN KEY (person_id) REFERENCES person(id) ON DELETE CASCADE;


--
-- TOC entry 2094 (class 2606 OID 50117)
-- Dependencies: 178 163 2022
-- Name: person_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT person_user_fk FOREIGN KEY (person_id) REFERENCES person(id) ON DELETE RESTRICT;


--
-- TOC entry 2095 (class 2606 OID 50122)
-- Dependencies: 163 2022 181
-- Name: person_volunteer_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY volunteer
    ADD CONSTRAINT person_volunteer_fk FOREIGN KEY (id) REFERENCES person(id) ON DELETE RESTRICT;


--
-- TOC entry 2070 (class 2606 OID 50127)
-- Dependencies: 150 174 2038
-- Name: state_city_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY city
    ADD CONSTRAINT state_city_fk FOREIGN KEY (state_id) REFERENCES state(id) ON DELETE RESTRICT;


--
-- TOC entry 2091 (class 2606 OID 50132)
-- Dependencies: 176 176 2041
-- Name: task_type_parent_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY task_type
    ADD CONSTRAINT task_type_parent_fk FOREIGN KEY (parent_id) REFERENCES task_type(id) ON DELETE RESTRICT;


--
-- TOC entry 2097 (class 2606 OID 50137)
-- Dependencies: 183 181 2047
-- Name: volunteer_volunteer_expertise_area_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY volunteer_expertise_area
    ADD CONSTRAINT volunteer_volunteer_expertise_area_fk FOREIGN KEY (volunteer_id) REFERENCES volunteer(id) ON DELETE CASCADE;


-- Completed on 2014-10-14 07:56:05 BRT

--
-- PostgreSQL database dump complete
--

