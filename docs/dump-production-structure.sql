--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

--
-- Name: unaccented(text); Type: FUNCTION; Schema: public; Owner: ong
--

CREATE FUNCTION unaccented(text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
    SELECT translate($1,'ÀÁÂÃÄÅĀĂĄÈÉÊËĒĔĖĘĚÌÍÎÏĨĪĮİÒÓÔÕÖØŌŎŐÙÚÛÜŨŪŬŮŰŲàáâãäåāăąèéêëēĕėęěìíîïĩīĭįòóôõöøōŏőùúûüũūŭůųÇçÑñÝýÿĆćĈĉĊċČčĎďĐđĜĝĞğĠġĢģĤĥĦħ',
'AAAAAAAAAEEEEEEEEEIIIIIIIIOOOOOOOOOUUUUUUUUUUaaaaaaaaaeeeeeeeeeiiiiiiiiooooooooouuuuuuuuuCcNnYyyCcCcCcCcDdDdGgGgGgGgHhHh');
$_$;


ALTER FUNCTION public.unaccented(text) OWNER TO ong;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: acl_role; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE acl_role (
    id integer NOT NULL,
    name character varying(50) NOT NULL,
    appaccount_id bigint NOT NULL
);


ALTER TABLE public.acl_role OWNER TO ong;

--
-- Name: acl_role_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE acl_role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.acl_role_id_seq OWNER TO ong;

--
-- Name: acl_role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ong
--

ALTER SEQUENCE acl_role_id_seq OWNED BY acl_role.id;


--
-- Name: acl_role_permission; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE acl_role_permission (
    id bigint NOT NULL,
    resource character varying(30) NOT NULL,
    privilege character varying(30) NOT NULL,
    acl_role_id integer NOT NULL
);


ALTER TABLE public.acl_role_permission OWNER TO ong;

--
-- Name: acl_role_permission_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE acl_role_permission_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.acl_role_permission_id_seq OWNER TO ong;

--
-- Name: acl_role_permission_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ong
--

ALTER SEQUENCE acl_role_permission_id_seq OWNED BY acl_role_permission.id;


--
-- Name: appaccount; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE appaccount (
    id bigint NOT NULL,
    name character varying(120) NOT NULL,
    email character varying(255) NOT NULL,
    created timestamp without time zone NOT NULL
);


ALTER TABLE public.appaccount OWNER TO ong;

--
-- Name: TABLE appaccount; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON TABLE appaccount IS 'The owners of accounts in the system';


--
-- Name: appaccount_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE appaccount_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.appaccount_id_seq OWNER TO ong;

--
-- Name: appaccount_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ong
--

ALTER SEQUENCE appaccount_id_seq OWNED BY appaccount.id;


--
-- Name: appaccount_media; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE appaccount_media (
    appaccount_id bigint NOT NULL,
    media_id bigint NOT NULL
);


ALTER TABLE public.appaccount_media OWNER TO ong;

--
-- Name: atividade_assistencia_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE atividade_assistencia_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.atividade_assistencia_id_seq OWNER TO ong;

--
-- Name: atividade_assistencia; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
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
    appaccount_id bigint
);


ALTER TABLE public.atividade_assistencia OWNER TO ong;

--
-- Name: TABLE atividade_assistencia; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON TABLE atividade_assistencia IS 'Atvidades de assistências realizadas, podendo ou não estar ligadas à um projeto, porém sempre ligadas à um Task Type (Tipo de Atividade)';


--
-- Name: COLUMN atividade_assistencia.person_recorded_id; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN atividade_assistencia.person_recorded_id IS 'Pessoa que realizou o lançamento do r';


--
-- Name: audit_trail; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
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


ALTER TABLE public.audit_trail OWNER TO ong;

--
-- Name: COLUMN audit_trail.eventtype; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN audit_trail.eventtype IS 'INS, UPD, DEL';


--
-- Name: COLUMN audit_trail.fieldtexttype; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN audit_trail.fieldtexttype IS 'Y or N';


--
-- Name: audit_trail_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE audit_trail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.audit_trail_id_seq OWNER TO ong;

--
-- Name: audit_trail_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ong
--

ALTER SEQUENCE audit_trail_id_seq OWNED BY audit_trail.id;


--
-- Name: busunit; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
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


ALTER TABLE public.busunit OWNER TO ong;

--
-- Name: TABLE busunit; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON TABLE busunit IS 'Headquarter / Branch / Head Office
Only one "main" unit may exist, this will have a relation with appaccount, all other will be child of it';


--
-- Name: COLUMN busunit.doctaxnumber; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN busunit.doctaxnumber IS 'This is the document id - Tax Number (USA), CNPJ (Brasil), CPF (Brasil Pessoa Física)';


--
-- Name: COLUMN busunit.website; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN busunit.website IS 'This is the main url to access in web';


--
-- Name: COLUMN busunit.head; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN busunit.head IS 'Indicates the Headquarter or Head office unit of the app account. Only one is allowed for app account';


--
-- Name: busunit_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE busunit_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.busunit_id_seq OWNER TO ong;

--
-- Name: busunit_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ong
--

ALTER SEQUENCE busunit_id_seq OWNED BY busunit.id;


--
-- Name: category; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE category (
    id integer NOT NULL,
    parent_id integer,
    name character varying(80) NOT NULL,
    category_group_id smallint NOT NULL
);


ALTER TABLE public.category OWNER TO ong;

--
-- Name: TABLE category; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON TABLE category IS 'Terms in a taxonomy, category group';


--
-- Name: category_group; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE category_group (
    id smallint NOT NULL,
    name character varying(60) NOT NULL
);


ALTER TABLE public.category_group OWNER TO ong;

--
-- Name: TABLE category_group; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON TABLE category_group IS 'Name of categories groups or vacabularies or taxonomies';


--
-- Name: city; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE city (
    id integer NOT NULL,
    name character varying(70) NOT NULL,
    state_id integer NOT NULL
);


ALTER TABLE public.city OWNER TO ong;

--
-- Name: city_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE city_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.city_id_seq OWNER TO ong;

--
-- Name: city_region_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE city_region_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.city_region_id_seq OWNER TO ong;

--
-- Name: city_region; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE city_region (
    id bigint DEFAULT nextval('city_region_id_seq'::regclass) NOT NULL,
    name character varying(50) NOT NULL,
    city_id integer NOT NULL,
    parent_id bigint
);


ALTER TABLE public.city_region OWNER TO ong;

--
-- Name: country; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE country (
    id smallint NOT NULL,
    name character varying(50) NOT NULL
);


ALTER TABLE public.country OWNER TO ong;

--
-- Name: country_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE country_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.country_id_seq OWNER TO ong;

--
-- Name: country_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ong
--

ALTER SEQUENCE country_id_seq OWNED BY country.id;


--
-- Name: employee; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE employee (
    id bigint NOT NULL,
    registration_number character varying(20),
    busunit_id integer NOT NULL,
    job_function_id smallint NOT NULL
);


ALTER TABLE public.employee OWNER TO ong;

--
-- Name: evento_assistencia_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE evento_assistencia_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.evento_assistencia_id_seq OWNER TO ong;

--
-- Name: evento_assistencia; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE evento_assistencia (
    id bigint DEFAULT nextval('evento_assistencia_id_seq'::regclass) NOT NULL,
    event_date date NOT NULL,
    task_type_id integer NOT NULL,
    project_id bigint,
    appaccount_id bigint NOT NULL
);


ALTER TABLE public.evento_assistencia OWNER TO ong;

--
-- Name: TABLE evento_assistencia; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON TABLE evento_assistencia IS 'Agrupador de atividades de assistencia';


--
-- Name: expertise_area; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE expertise_area (
    id integer NOT NULL,
    name character varying(50) NOT NULL,
    description character varying(400) NOT NULL,
    appaccount_id bigint NOT NULL
);


ALTER TABLE public.expertise_area OWNER TO ong;

--
-- Name: TABLE expertise_area; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON TABLE expertise_area IS 'Expertise, knowledge, specialization area';


--
-- Name: expertise_area_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE expertise_area_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.expertise_area_id_seq OWNER TO ong;

--
-- Name: expertise_area_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ong
--

ALTER SEQUENCE expertise_area_id_seq OWNED BY expertise_area.id;


--
-- Name: fingerprint; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE fingerprint (
    person_id bigint NOT NULL,
    finger_number smallint DEFAULT 1 NOT NULL,
    text_hash text NOT NULL
);


ALTER TABLE public.fingerprint OWNER TO ong;

--
-- Name: COLUMN fingerprint.finger_number; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN fingerprint.finger_number IS 'Mão direita a partir do polegar 1=pol, 2=indicador, etc ... segue mão esquerda 6=pol, etc';


--
-- Name: COLUMN fingerprint.text_hash; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN fingerprint.text_hash IS 'Hash em texto gerado pelo leitor';


--
-- Name: job_function; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE job_function (
    id smallint NOT NULL,
    name character varying(50) NOT NULL,
    description character varying(400),
    appaccount_id bigint NOT NULL
);


ALTER TABLE public.job_function OWNER TO ong;

--
-- Name: TABLE job_function; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON TABLE job_function IS 'Describe the job function in a company for persons';


--
-- Name: job_function_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE job_function_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.job_function_id_seq OWNER TO ong;

--
-- Name: job_function_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ong
--

ALTER SEQUENCE job_function_id_seq OWNED BY job_function.id;


--
-- Name: media; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE media (
    id bigint NOT NULL,
    title character varying(140) DEFAULT 'No title specified'::character varying NOT NULL,
    file character varying(140) NOT NULL,
    filesize bigint NOT NULL,
    mimetype character varying(50) NOT NULL
);


ALTER TABLE public.media OWNER TO ong;

--
-- Name: COLUMN media.file; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN media.file IS 'The name and extension of the file: user-1.png';


--
-- Name: COLUMN media.filesize; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN media.filesize IS 'The size in bytes of the file';


--
-- Name: media_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE media_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.media_id_seq OWNER TO ong;

--
-- Name: media_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ong
--

ALTER SEQUENCE media_id_seq OWNED BY media.id;


--
-- Name: person; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
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


ALTER TABLE public.person OWNER TO ong;

--
-- Name: TABLE person; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON TABLE person IS 'The Person (customer, client, vendor, fabricant, employe, student, user) basic data.
It''s tight related to user table';


--
-- Name: COLUMN person.marital_status; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person.marital_status IS 'single, married, widow(er), separeted, stable union';


--
-- Name: person_docs; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
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


ALTER TABLE public.person_docs OWNER TO ong;

--
-- Name: COLUMN person_docs.identitycard; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person_docs.identitycard IS 'RG - Brasil';


--
-- Name: COLUMN person_docs.individualdoctaxnumber; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person_docs.individualdoctaxnumber IS 'CPF - Brasil';


--
-- Name: COLUMN person_docs.birthcertificate; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person_docs.birthcertificate IS 'Certificado de Nascimento - Brasil';


--
-- Name: COLUMN person_docs.professionalcard; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person_docs.professionalcard IS 'Carteira Profissional - Brasil';


--
-- Name: COLUMN person_docs.driverslicense; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person_docs.driverslicense IS 'Carteira de Motorista - Brasil';


--
-- Name: COLUMN person_docs.voterregistration; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person_docs.voterregistration IS 'Título de Eleitor - Brasil';


--
-- Name: COLUMN person_docs.militaryregistration; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person_docs.militaryregistration IS 'Carteira de Reservista - Brasil';


--
-- Name: COLUMN person_docs.healthsystemcard; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person_docs.healthsystemcard IS 'Cartão do SUS - Brasil';


--
-- Name: person_helped; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
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


ALTER TABLE public.person_helped OWNER TO ong;

--
-- Name: TABLE person_helped; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON TABLE person_helped IS 'Data of person helped by non profit org';


--
-- Name: COLUMN person_helped.id; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person_helped.id IS 'Person id';


--
-- Name: COLUMN person_helped.professional_occupation; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person_helped.professional_occupation IS 'Seted by app as: Retired, Rural Worker, Unemployed, City Worker, Another (described)';


--
-- Name: COLUMN person_helped.home_situation; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person_helped.home_situation IS 'Specified in app as: Owner, Rent, Mortgage, Present, Invasion, Other(describe)';


--
-- Name: COLUMN person_helped.home_area; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person_helped.home_area IS 'Described in app as: Urban, Rural, Island, Quilombo, Indian';


--
-- Name: COLUMN person_helped.home_type; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person_helped.home_type IS 'Spcifeid in app as: Brick, Adobe, Wood, Another(describe)';


--
-- Name: person_helped_project; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE person_helped_project (
    project_id bigint NOT NULL,
    person_id bigint NOT NULL,
    date_in date NOT NULL,
    date_out date
);


ALTER TABLE public.person_helped_project OWNER TO ong;

--
-- Name: TABLE person_helped_project; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON TABLE person_helped_project IS 'Persons helped on projects';


--
-- Name: COLUMN person_helped_project.date_in; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person_helped_project.date_in IS 'Date that the person got in the project';


--
-- Name: COLUMN person_helped_project.date_out; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN person_helped_project.date_out IS 'Date the person got out';


--
-- Name: person_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE person_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.person_id_seq OWNER TO ong;

--
-- Name: person_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ong
--

ALTER SEQUENCE person_id_seq OWNED BY person.id;


--
-- Name: person_media; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE person_media (
    person_id bigint NOT NULL,
    media_id bigint NOT NULL
);


ALTER TABLE public.person_media OWNER TO ong;

--
-- Name: person_programa_federal_social; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE person_programa_federal_social (
    person_id bigint NOT NULL,
    pfs_id integer NOT NULL,
    numero character varying(20) NOT NULL
);


ALTER TABLE public.person_programa_federal_social OWNER TO ong;

--
-- Name: programa_federal_social_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE programa_federal_social_id_seq
    START WITH 16
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.programa_federal_social_id_seq OWNER TO ong;

--
-- Name: programa_federal_social; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE programa_federal_social (
    id integer DEFAULT nextval('programa_federal_social_id_seq'::regclass) NOT NULL,
    nome character varying(40) NOT NULL,
    sigla character(5) NOT NULL
);


ALTER TABLE public.programa_federal_social OWNER TO ong;

--
-- Name: TABLE programa_federal_social; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON TABLE programa_federal_social IS 'Programas federais sociais como Bolsa Família, Pró-jovem, NIS, NIT, PASEP, PIS, etc';


--
-- Name: project; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
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


ALTER TABLE public.project OWNER TO ong;

--
-- Name: COLUMN project.status; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN project.status IS '0 = Draft; 1 = Active; 2 = Paused; 3 = Finished; 4 = Closed';


--
-- Name: project_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE project_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.project_id_seq OWNER TO ong;

--
-- Name: project_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ong
--

ALTER SEQUENCE project_id_seq OWNED BY project.id;


--
-- Name: project_media; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE project_media (
    project_id bigint NOT NULL,
    media_id bigint NOT NULL
);


ALTER TABLE public.project_media OWNER TO ong;

--
-- Name: state; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE state (
    id integer NOT NULL,
    name character varying(50) NOT NULL,
    country_id smallint NOT NULL,
    abbreviation character(2) NOT NULL
);


ALTER TABLE public.state OWNER TO ong;

--
-- Name: TABLE state; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON TABLE state IS 'State of a Country';


--
-- Name: state_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE state_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.state_id_seq OWNER TO ong;

--
-- Name: state_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ong
--

ALTER SEQUENCE state_id_seq OWNED BY state.id;


--
-- Name: task_type; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE task_type (
    id integer NOT NULL,
    name character varying(120) NOT NULL,
    description character varying(1200),
    parent_id integer,
    appaccount_id bigint NOT NULL
);


ALTER TABLE public.task_type OWNER TO ong;

--
-- Name: task_type_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE task_type_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.task_type_id_seq OWNER TO ong;

--
-- Name: task_type_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ong
--

ALTER SEQUENCE task_type_id_seq OWNED BY task_type.id;


--
-- Name: user; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
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


ALTER TABLE public."user" OWNER TO ong;

--
-- Name: TABLE "user"; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON TABLE "user" IS 'User of the system';


--
-- Name: COLUMN "user".status; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN "user".status IS 'Status of the user account. 

-1 	= Blocked
0 	= Not yet activated
1	= Active';


--
-- Name: COLUMN "user".rnd_salt; Type: COMMENT; Schema: public; Owner: ong
--

COMMENT ON COLUMN "user".rnd_salt IS 'Randomic salt to generate the encripted password with MD5';


--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: ong
--

CREATE SEQUENCE user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.user_id_seq OWNER TO ong;

--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: ong
--

ALTER SEQUENCE user_id_seq OWNED BY "user".id;


--
-- Name: v_Employee; Type: VIEW; Schema: public; Owner: ong
--

CREATE VIEW "v_Employee" AS
    SELECT p.id, p.name, p.created, p.appaccount_id, p.address, p.addressdetails, p.addressnumber, p.city_id, p.mobilephone, p.phone, p.postalcode, p.website, p.email, p.gender, p.birthdate, p.city_region_id, e.busunit_id, e.registration_number, e.job_function_id FROM (person p JOIN employee e ON ((p.id = e.id)));


ALTER TABLE public."v_Employee" OWNER TO ong;

--
-- Name: volunteer; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE volunteer (
    id bigint NOT NULL
);


ALTER TABLE public.volunteer OWNER TO ong;

--
-- Name: v_Volunteer; Type: VIEW; Schema: public; Owner: ong
--

CREATE VIEW "v_Volunteer" AS
    SELECT p.id, p.name, p.created, p.appaccount_id, p.address, p.addressdetails, p.addressnumber, p.city_id, p.mobilephone, p.phone, p.postalcode, p.website, p.email, p.gender, p.birthdate, p.city_region_id FROM (person p JOIN volunteer v ON ((p.id = v.id)));


ALTER TABLE public."v_Volunteer" OWNER TO ong;

--
-- Name: v_person_helped; Type: VIEW; Schema: public; Owner: ong
--

CREATE VIEW v_person_helped AS
    SELECT p.id, p.name, p.created, p.appaccount_id, p.address, p.addressdetails, p.addressnumber, p.city_id, p.mobilephone, p.phone, p.postalcode, p.website, p.email, p.gender, p.birthdate, p.city_region_id, p.marital_status, ph.religion, ph.professional_occupation, ph.professional_experience, ph.live_with_family, ph.home_situation, ph.home_since, ph.born_city_id, ph.born_state_id, ph.home_area, ph.home_type, ph.home_pieces_number, ph.rent_value, ph.first_help_date FROM (person p JOIN person_helped ph ON ((p.id = ph.id)));


ALTER TABLE public.v_person_helped OWNER TO ong;

--
-- Name: v_person_helped_by_project; Type: VIEW; Schema: public; Owner: ong
--

CREATE VIEW v_person_helped_by_project AS
    SELECT prj.name AS project_name, php.project_id, php.person_id, php.date_in, php.date_out, p.name AS person_name FROM ((project prj LEFT JOIN person_helped_project php ON ((prj.id = php.project_id))) LEFT JOIN person p ON ((php.person_id = p.id))) ORDER BY prj.name, p.name;


ALTER TABLE public.v_person_helped_by_project OWNER TO ong;

--
-- Name: v_person_helped_programa_federal_social; Type: VIEW; Schema: public; Owner: ong
--

CREATE VIEW v_person_helped_programa_federal_social AS
    SELECT ph.id AS person_id, pfs.id AS pfs_id, pfs.nome AS pfs_nome, pfs.sigla AS pgs_sigla FROM ((person_helped ph JOIN person_programa_federal_social ppfs ON ((ph.id = ppfs.person_id))) JOIN programa_federal_social pfs ON ((ppfs.pfs_id = pfs.id)));


ALTER TABLE public.v_person_helped_programa_federal_social OWNER TO ong;

--
-- Name: volunteer_expertise_area; Type: TABLE; Schema: public; Owner: ong; Tablespace: 
--

CREATE TABLE volunteer_expertise_area (
    volunteer_id bigint NOT NULL,
    expertise_area_id integer NOT NULL
);


ALTER TABLE public.volunteer_expertise_area OWNER TO ong;

--
-- Name: id; Type: DEFAULT; Schema: public; Owner: ong
--

ALTER TABLE ONLY acl_role ALTER COLUMN id SET DEFAULT nextval('acl_role_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: ong
--

ALTER TABLE ONLY acl_role_permission ALTER COLUMN id SET DEFAULT nextval('acl_role_permission_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: ong
--

ALTER TABLE ONLY appaccount ALTER COLUMN id SET DEFAULT nextval('appaccount_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: ong
--

ALTER TABLE ONLY audit_trail ALTER COLUMN id SET DEFAULT nextval('audit_trail_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: ong
--

ALTER TABLE ONLY busunit ALTER COLUMN id SET DEFAULT nextval('busunit_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: ong
--

ALTER TABLE ONLY country ALTER COLUMN id SET DEFAULT nextval('country_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: ong
--

ALTER TABLE ONLY expertise_area ALTER COLUMN id SET DEFAULT nextval('expertise_area_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: ong
--

ALTER TABLE ONLY job_function ALTER COLUMN id SET DEFAULT nextval('job_function_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: ong
--

ALTER TABLE ONLY media ALTER COLUMN id SET DEFAULT nextval('media_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: ong
--

ALTER TABLE ONLY person ALTER COLUMN id SET DEFAULT nextval('person_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: ong
--

ALTER TABLE ONLY project ALTER COLUMN id SET DEFAULT nextval('project_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: ong
--

ALTER TABLE ONLY state ALTER COLUMN id SET DEFAULT nextval('state_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: ong
--

ALTER TABLE ONLY task_type ALTER COLUMN id SET DEFAULT nextval('task_type_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: ong
--

ALTER TABLE ONLY "user" ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


--
-- Name: acl_role_permission_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY acl_role_permission
    ADD CONSTRAINT acl_role_permission_pk PRIMARY KEY (id);


--
-- Name: acl_role_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY acl_role
    ADD CONSTRAINT acl_role_pk PRIMARY KEY (id);


--
-- Name: appaccount_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY appaccount
    ADD CONSTRAINT appaccount_pk PRIMARY KEY (id);


--
-- Name: audit_trail_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY audit_trail
    ADD CONSTRAINT audit_trail_pk PRIMARY KEY (id);


--
-- Name: busunit_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY busunit
    ADD CONSTRAINT busunit_pk PRIMARY KEY (id);


--
-- Name: city_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY city
    ADD CONSTRAINT city_pk PRIMARY KEY (id);


--
-- Name: city_region_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY city_region
    ADD CONSTRAINT city_region_pk PRIMARY KEY (id);


--
-- Name: country_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY country
    ADD CONSTRAINT country_pk PRIMARY KEY (id);


--
-- Name: employee_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY employee
    ADD CONSTRAINT employee_pk PRIMARY KEY (id);


--
-- Name: expertise_area_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY expertise_area
    ADD CONSTRAINT expertise_area_pk PRIMARY KEY (id);


--
-- Name: job_function_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY job_function
    ADD CONSTRAINT job_function_pk PRIMARY KEY (id);


--
-- Name: media_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY media
    ADD CONSTRAINT media_pk PRIMARY KEY (id);


--
-- Name: person_docs_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY person_docs
    ADD CONSTRAINT person_docs_pk PRIMARY KEY (id);


--
-- Name: person_media_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY person_media
    ADD CONSTRAINT person_media_pk PRIMARY KEY (person_id, media_id);


--
-- Name: person_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY person
    ADD CONSTRAINT person_pk PRIMARY KEY (id);


--
-- Name: pkappaccount_media; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY appaccount_media
    ADD CONSTRAINT pkappaccount_media PRIMARY KEY (appaccount_id, media_id);


--
-- Name: pkatividade_assistencia; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT pkatividade_assistencia PRIMARY KEY (id);


--
-- Name: pkcategory; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY category
    ADD CONSTRAINT pkcategory PRIMARY KEY (id);


--
-- Name: pkcategory_group; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY category_group
    ADD CONSTRAINT pkcategory_group PRIMARY KEY (id);


--
-- Name: pkevento_assistencia; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY evento_assistencia
    ADD CONSTRAINT pkevento_assistencia PRIMARY KEY (id);


--
-- Name: pkfingerprint; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY fingerprint
    ADD CONSTRAINT pkfingerprint PRIMARY KEY (person_id, finger_number);


--
-- Name: pkperson_helped; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY person_helped
    ADD CONSTRAINT pkperson_helped PRIMARY KEY (id);


--
-- Name: pkperson_helped_project; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY person_helped_project
    ADD CONSTRAINT pkperson_helped_project PRIMARY KEY (project_id, person_id, date_in);


--
-- Name: pkperson_programa_federal_social; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY person_programa_federal_social
    ADD CONSTRAINT pkperson_programa_federal_social PRIMARY KEY (person_id, pfs_id);


--
-- Name: pkprograma_federal_social; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY programa_federal_social
    ADD CONSTRAINT pkprograma_federal_social PRIMARY KEY (id);


--
-- Name: pkproject_media; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY project_media
    ADD CONSTRAINT pkproject_media PRIMARY KEY (project_id, media_id);


--
-- Name: project_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY project
    ADD CONSTRAINT project_pk PRIMARY KEY (id);


--
-- Name: state_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY state
    ADD CONSTRAINT state_pk PRIMARY KEY (id);


--
-- Name: task_type_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY task_type
    ADD CONSTRAINT task_type_pk PRIMARY KEY (id);


--
-- Name: user_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pk PRIMARY KEY (id);


--
-- Name: volunteer_expertise_area_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY volunteer_expertise_area
    ADD CONSTRAINT volunteer_expertise_area_pk PRIMARY KEY (volunteer_id, expertise_area_id);


--
-- Name: volunteer_pk; Type: CONSTRAINT; Schema: public; Owner: ong; Tablespace: 
--

ALTER TABLE ONLY volunteer
    ADD CONSTRAINT volunteer_pk PRIMARY KEY (id);


--
-- Name: acl_role_name_idx; Type: INDEX; Schema: public; Owner: ong; Tablespace: 
--

CREATE UNIQUE INDEX acl_role_name_idx ON acl_role USING btree (name, appaccount_id);


--
-- Name: appaccount_idx_name; Type: INDEX; Schema: public; Owner: ong; Tablespace: 
--

CREATE UNIQUE INDEX appaccount_idx_name ON appaccount USING btree (name);


--
-- Name: busunit_appaccount_fk; Type: INDEX; Schema: public; Owner: ong; Tablespace: 
--

CREATE INDEX busunit_appaccount_fk ON busunit USING btree (appaccount_id);


--
-- Name: busunit_idx_name; Type: INDEX; Schema: public; Owner: ong; Tablespace: 
--

CREATE UNIQUE INDEX busunit_idx_name ON busunit USING btree (name);


--
-- Name: employee_registration_idx; Type: INDEX; Schema: public; Owner: ong; Tablespace: 
--

CREATE UNIQUE INDEX employee_registration_idx ON employee USING btree (registration_number, busunit_id);


--
-- Name: evento_assistencia_event_date_Idx; Type: INDEX; Schema: public; Owner: ong; Tablespace: 
--

CREATE INDEX "evento_assistencia_event_date_Idx" ON evento_assistencia USING btree (event_date);


--
-- Name: person_name_idx; Type: INDEX; Schema: public; Owner: ong; Tablespace: 
--

CREATE INDEX person_name_idx ON person USING btree (name);


--
-- Name: person_name_like_idx; Type: INDEX; Schema: public; Owner: ong; Tablespace: 
--

CREATE INDEX person_name_like_idx ON person USING btree (name varchar_pattern_ops);


--
-- Name: person_name_pattern_idx; Type: INDEX; Schema: public; Owner: ong; Tablespace: 
--

CREATE INDEX person_name_pattern_idx ON person USING btree (name text_pattern_ops);


--
-- Name: state_unq_country_abbreviation; Type: INDEX; Schema: public; Owner: ong; Tablespace: 
--

CREATE UNIQUE INDEX state_unq_country_abbreviation ON state USING btree (abbreviation, country_id);


--
-- Name: user_idx_email; Type: INDEX; Schema: public; Owner: ong; Tablespace: 
--

CREATE UNIQUE INDEX user_idx_email ON "user" USING btree (email);


--
-- Name: user_idx_name; Type: INDEX; Schema: public; Owner: ong; Tablespace: 
--

CREATE UNIQUE INDEX user_idx_name ON "user" USING btree (name);


--
-- Name: acl_role_acl_role_permission_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY acl_role_permission
    ADD CONSTRAINT acl_role_acl_role_permission_fk FOREIGN KEY (acl_role_id) REFERENCES acl_role(id) ON DELETE CASCADE;


--
-- Name: acl_role_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT acl_role_user_fk FOREIGN KEY (acl_role_id) REFERENCES acl_role(id) ON DELETE RESTRICT;


--
-- Name: appaccount_acl_role_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY acl_role
    ADD CONSTRAINT appaccount_acl_role_fk FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON DELETE RESTRICT;


--
-- Name: appaccount_busunit_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY busunit
    ADD CONSTRAINT appaccount_busunit_fk FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON DELETE RESTRICT;


--
-- Name: appaccount_person_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY person
    ADD CONSTRAINT appaccount_person_fk FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON DELETE CASCADE;


--
-- Name: appaccount_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT appaccount_user_fk FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON DELETE RESTRICT;


--
-- Name: busunit_employee_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY employee
    ADD CONSTRAINT busunit_employee_fk FOREIGN KEY (busunit_id) REFERENCES busunit(id) ON DELETE RESTRICT;


--
-- Name: city_city_region_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY city_region
    ADD CONSTRAINT city_city_region_fk FOREIGN KEY (city_id) REFERENCES city(id) ON DELETE RESTRICT;


--
-- Name: city_organization_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY busunit
    ADD CONSTRAINT city_organization_fk FOREIGN KEY (city_id) REFERENCES city(id) ON DELETE RESTRICT;


--
-- Name: city_person_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY person
    ADD CONSTRAINT city_person_fk FOREIGN KEY (city_id) REFERENCES city(id) ON DELETE RESTRICT;


--
-- Name: city_region_person_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY person
    ADD CONSTRAINT city_region_person_fk FOREIGN KEY (city_region_id) REFERENCES city_region(id) ON DELETE RESTRICT;


--
-- Name: country_state_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY state
    ADD CONSTRAINT country_state_fk FOREIGN KEY (country_id) REFERENCES country(id) ON DELETE RESTRICT;


--
-- Name: expertise_area_volunteer_expertise_area_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY volunteer_expertise_area
    ADD CONSTRAINT expertise_area_volunteer_expertise_area_fk FOREIGN KEY (expertise_area_id) REFERENCES expertise_area(id) ON DELETE RESTRICT;


--
-- Name: fk_appaccount_media_appaccount; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY appaccount_media
    ADD CONSTRAINT fk_appaccount_media_appaccount FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_appaccount_media_media; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY appaccount_media
    ADD CONSTRAINT fk_appaccount_media_media FOREIGN KEY (media_id) REFERENCES media(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_atividade_assistencia_appaccount; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT fk_atividade_assistencia_appaccount FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_atividade_assistencia_evento_assistencia; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT fk_atividade_assistencia_evento_assistencia FOREIGN KEY (event_id) REFERENCES evento_assistencia(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_atividade_assistencia_person; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT fk_atividade_assistencia_person FOREIGN KEY (person_recorded_id) REFERENCES person(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_atividade_assistencia_person_helped; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT fk_atividade_assistencia_person_helped FOREIGN KEY (person_helped_id) REFERENCES person(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_atividade_assistencia_person_performed; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT fk_atividade_assistencia_person_performed FOREIGN KEY (person_performed_id) REFERENCES person(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_atividade_assistencia_project; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT fk_atividade_assistencia_project FOREIGN KEY (project_id) REFERENCES project(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_atividade_assistencia_task_type; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY atividade_assistencia
    ADD CONSTRAINT fk_atividade_assistencia_task_type FOREIGN KEY (task_type_id) REFERENCES task_type(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_category_category; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY category
    ADD CONSTRAINT fk_category_category FOREIGN KEY (parent_id) REFERENCES category(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: fk_category_category_group; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY category
    ADD CONSTRAINT fk_category_category_group FOREIGN KEY (category_group_id) REFERENCES category_group(id);


--
-- Name: fk_category_category_group_id; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY category
    ADD CONSTRAINT fk_category_category_group_id FOREIGN KEY (category_group_id) REFERENCES category_group(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_evento_assistencia_appaccount; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY evento_assistencia
    ADD CONSTRAINT fk_evento_assistencia_appaccount FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_evento_assistencia_project; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY evento_assistencia
    ADD CONSTRAINT fk_evento_assistencia_project FOREIGN KEY (project_id) REFERENCES project(id) ON DELETE RESTRICT;


--
-- Name: fk_evento_assistencia_task_type; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY evento_assistencia
    ADD CONSTRAINT fk_evento_assistencia_task_type FOREIGN KEY (task_type_id) REFERENCES task_type(id) ON DELETE RESTRICT;


--
-- Name: fk_fingerprint_person; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY fingerprint
    ADD CONSTRAINT fk_fingerprint_person FOREIGN KEY (person_id) REFERENCES person(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_person_helped_city; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY person_helped
    ADD CONSTRAINT fk_person_helped_city FOREIGN KEY (born_city_id) REFERENCES city(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_person_helped_person; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY person_helped
    ADD CONSTRAINT fk_person_helped_person FOREIGN KEY (id) REFERENCES person(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_person_helped_state; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY person_helped
    ADD CONSTRAINT fk_person_helped_state FOREIGN KEY (born_state_id) REFERENCES state(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_person_programa_federal_social_person; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY person_programa_federal_social
    ADD CONSTRAINT fk_person_programa_federal_social_person FOREIGN KEY (person_id) REFERENCES person(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_person_programa_federal_social_programa_federal_social; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY person_programa_federal_social
    ADD CONSTRAINT fk_person_programa_federal_social_programa_federal_social FOREIGN KEY (pfs_id) REFERENCES programa_federal_social(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: fk_project_appaccount; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY project
    ADD CONSTRAINT fk_project_appaccount FOREIGN KEY (appaccount_id) REFERENCES appaccount(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_project_media_media; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY project_media
    ADD CONSTRAINT fk_project_media_media FOREIGN KEY (media_id) REFERENCES media(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_project_media_project; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY project_media
    ADD CONSTRAINT fk_project_media_project FOREIGN KEY (project_id) REFERENCES project(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_project_person_helped_person_helped; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY person_helped_project
    ADD CONSTRAINT fk_project_person_helped_person_helped FOREIGN KEY (person_id) REFERENCES person_helped(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_project_person_helped_project; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY person_helped_project
    ADD CONSTRAINT fk_project_person_helped_project FOREIGN KEY (project_id) REFERENCES project(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: job_function_employee_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY employee
    ADD CONSTRAINT job_function_employee_fk FOREIGN KEY (job_function_id) REFERENCES job_function(id) ON DELETE RESTRICT;


--
-- Name: media_person_media_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY person_media
    ADD CONSTRAINT media_person_media_fk FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE RESTRICT;


--
-- Name: parent_city_region_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY city_region
    ADD CONSTRAINT parent_city_region_fk FOREIGN KEY (parent_id) REFERENCES city_region(id) ON DELETE RESTRICT;


--
-- Name: person_employee_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY employee
    ADD CONSTRAINT person_employee_fk FOREIGN KEY (id) REFERENCES person(id);


--
-- Name: person_person_docs_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY person_docs
    ADD CONSTRAINT person_person_docs_fk FOREIGN KEY (id) REFERENCES person(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: person_person_media_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY person_media
    ADD CONSTRAINT person_person_media_fk FOREIGN KEY (person_id) REFERENCES person(id) ON DELETE CASCADE;


--
-- Name: person_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT person_user_fk FOREIGN KEY (person_id) REFERENCES person(id) ON DELETE RESTRICT;


--
-- Name: person_volunteer_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY volunteer
    ADD CONSTRAINT person_volunteer_fk FOREIGN KEY (id) REFERENCES person(id) ON DELETE RESTRICT;


--
-- Name: state_city_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY city
    ADD CONSTRAINT state_city_fk FOREIGN KEY (state_id) REFERENCES state(id) ON DELETE RESTRICT;


--
-- Name: task_type_parent_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY task_type
    ADD CONSTRAINT task_type_parent_fk FOREIGN KEY (parent_id) REFERENCES task_type(id) ON DELETE RESTRICT;


--
-- Name: volunteer_volunteer_expertise_area_fk; Type: FK CONSTRAINT; Schema: public; Owner: ong
--

ALTER TABLE ONLY volunteer_expertise_area
    ADD CONSTRAINT volunteer_volunteer_expertise_area_fk FOREIGN KEY (volunteer_id) REFERENCES volunteer(id) ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- Name: acl_role; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE acl_role FROM PUBLIC;
REVOKE ALL ON TABLE acl_role FROM ong;
GRANT ALL ON TABLE acl_role TO ong;


--
-- Name: acl_role_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE acl_role_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE acl_role_id_seq FROM ong;
GRANT ALL ON SEQUENCE acl_role_id_seq TO ong;


--
-- Name: acl_role_permission; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE acl_role_permission FROM PUBLIC;
REVOKE ALL ON TABLE acl_role_permission FROM ong;
GRANT ALL ON TABLE acl_role_permission TO ong;


--
-- Name: acl_role_permission_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE acl_role_permission_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE acl_role_permission_id_seq FROM ong;
GRANT ALL ON SEQUENCE acl_role_permission_id_seq TO ong;


--
-- Name: appaccount; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE appaccount FROM PUBLIC;
REVOKE ALL ON TABLE appaccount FROM ong;
GRANT ALL ON TABLE appaccount TO ong;


--
-- Name: appaccount_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE appaccount_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE appaccount_id_seq FROM ong;
GRANT ALL ON SEQUENCE appaccount_id_seq TO ong;


--
-- Name: audit_trail; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE audit_trail FROM PUBLIC;
REVOKE ALL ON TABLE audit_trail FROM ong;
GRANT ALL ON TABLE audit_trail TO ong;


--
-- Name: audit_trail_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE audit_trail_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE audit_trail_id_seq FROM ong;
GRANT ALL ON SEQUENCE audit_trail_id_seq TO ong;


--
-- Name: busunit; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE busunit FROM PUBLIC;
REVOKE ALL ON TABLE busunit FROM ong;
GRANT ALL ON TABLE busunit TO ong;


--
-- Name: busunit_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE busunit_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE busunit_id_seq FROM ong;
GRANT ALL ON SEQUENCE busunit_id_seq TO ong;


--
-- Name: city; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE city FROM PUBLIC;
REVOKE ALL ON TABLE city FROM ong;
GRANT ALL ON TABLE city TO ong;


--
-- Name: city_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE city_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE city_id_seq FROM ong;
GRANT ALL ON SEQUENCE city_id_seq TO ong;


--
-- Name: city_region_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE city_region_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE city_region_id_seq FROM ong;
GRANT ALL ON SEQUENCE city_region_id_seq TO ong;


--
-- Name: city_region; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE city_region FROM PUBLIC;
REVOKE ALL ON TABLE city_region FROM ong;
GRANT ALL ON TABLE city_region TO ong;


--
-- Name: country; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE country FROM PUBLIC;
REVOKE ALL ON TABLE country FROM ong;
GRANT ALL ON TABLE country TO ong;


--
-- Name: country_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE country_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE country_id_seq FROM ong;
GRANT ALL ON SEQUENCE country_id_seq TO ong;


--
-- Name: employee; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE employee FROM PUBLIC;
REVOKE ALL ON TABLE employee FROM ong;
GRANT ALL ON TABLE employee TO ong;


--
-- Name: expertise_area; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE expertise_area FROM PUBLIC;
REVOKE ALL ON TABLE expertise_area FROM ong;
GRANT ALL ON TABLE expertise_area TO ong;


--
-- Name: expertise_area_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE expertise_area_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE expertise_area_id_seq FROM ong;
GRANT ALL ON SEQUENCE expertise_area_id_seq TO ong;


--
-- Name: job_function; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE job_function FROM PUBLIC;
REVOKE ALL ON TABLE job_function FROM ong;
GRANT ALL ON TABLE job_function TO ong;


--
-- Name: job_function_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE job_function_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE job_function_id_seq FROM ong;
GRANT ALL ON SEQUENCE job_function_id_seq TO ong;


--
-- Name: media; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE media FROM PUBLIC;
REVOKE ALL ON TABLE media FROM ong;
GRANT ALL ON TABLE media TO ong;


--
-- Name: media_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE media_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE media_id_seq FROM ong;
GRANT ALL ON SEQUENCE media_id_seq TO ong;


--
-- Name: person; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE person FROM PUBLIC;
REVOKE ALL ON TABLE person FROM ong;
GRANT ALL ON TABLE person TO ong;


--
-- Name: person_docs; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE person_docs FROM PUBLIC;
REVOKE ALL ON TABLE person_docs FROM ong;
GRANT ALL ON TABLE person_docs TO ong;


--
-- Name: person_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE person_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE person_id_seq FROM ong;
GRANT ALL ON SEQUENCE person_id_seq TO ong;


--
-- Name: person_media; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE person_media FROM PUBLIC;
REVOKE ALL ON TABLE person_media FROM ong;
GRANT ALL ON TABLE person_media TO ong;


--
-- Name: project; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE project FROM PUBLIC;
REVOKE ALL ON TABLE project FROM ong;
GRANT ALL ON TABLE project TO ong;


--
-- Name: project_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE project_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE project_id_seq FROM ong;
GRANT ALL ON SEQUENCE project_id_seq TO ong;


--
-- Name: state; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE state FROM PUBLIC;
REVOKE ALL ON TABLE state FROM ong;
GRANT ALL ON TABLE state TO ong;


--
-- Name: state_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE state_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE state_id_seq FROM ong;
GRANT ALL ON SEQUENCE state_id_seq TO ong;


--
-- Name: task_type; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE task_type FROM PUBLIC;
REVOKE ALL ON TABLE task_type FROM ong;
GRANT ALL ON TABLE task_type TO ong;


--
-- Name: task_type_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE task_type_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE task_type_id_seq FROM ong;
GRANT ALL ON SEQUENCE task_type_id_seq TO ong;


--
-- Name: user_id_seq; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON SEQUENCE user_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE user_id_seq FROM ong;
GRANT ALL ON SEQUENCE user_id_seq TO ong;


--
-- Name: volunteer; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE volunteer FROM PUBLIC;
REVOKE ALL ON TABLE volunteer FROM ong;
GRANT ALL ON TABLE volunteer TO ong;


--
-- Name: volunteer_expertise_area; Type: ACL; Schema: public; Owner: ong
--

REVOKE ALL ON TABLE volunteer_expertise_area FROM PUBLIC;
REVOKE ALL ON TABLE volunteer_expertise_area FROM ong;
GRANT ALL ON TABLE volunteer_expertise_area TO ong;


--
-- PostgreSQL database dump complete
--

